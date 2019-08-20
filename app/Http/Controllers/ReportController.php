<?php

namespace App\Http\Controllers;

use App\Budget;
use App\IncomeNote;
use App\InvoiceDetail;
use App\StockDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    /*close report*/
    //index
    public function close_report_index(){
        return view('report.close_report');
    }
    //calc
    public function close_report(Request $request){
        $input = $request->all();
        /*invoice*/
        $sell = InvoiceDetail::with('stock_detail_only')->whereBetween('created_at',[$input['start'],$input['end']])->get();
        /*income note-expense*/
        $income_note = IncomeNote::whereBetween('created_at',[$input['start'],$input['end']])->sum('amount');
        $budget_expense = Budget::whereBetween('created_at',[$input['start'],$input['end']])->where('type','exp')->sum('amount');
        /*end income note-expense*/
        /*budget income*/
        $budget_income = Budget::whereBetween('created_at',[$input['start'],$input['end']])->where('type','inc')->sum('amount');
        /*end budget income*/
        return response()->json(['sell'=>$sell,'income_note_remain'=>$income_note-$budget_expense,'budget_income'=>$budget_income]);
    }
    /*end close report*/
    /*budget list*/
    public function budget_list(Request $request){
        $input = $request->all();
        $budget = Budget::whereBetween('created_at',[$input['range']['start'],$input['range']['end']])->where('type','=',$input['range']['type'])->get();
        return DataTables::of($budget)
            ->editColumn('created_at',function ($created_at){
                return Carbon::parse($created_at->created_at)->format('d-m-Y');
            })
            ->editColumn('amount',function ($amount){
                return money_format('$%i', $amount->amount);
            })
            ->editColumn('type',function ($type){
                return $type->type=='inc'?'<span class="badge bg-success-400">ចំណូល</span>':'<span class="badge bg-warning-400">ចំណាយ</span>';
            })
            ->addColumn('action',function ($action){
                return '<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>
											<form class="dropdown-menu dropdown-menu-right" method="post" action="'.route('budget.destroy',$action->id).'">
											'.csrf_field().'
											<input type="hidden" name="_method" value="delete">
												<a href="'.route('budget.edit',$action->id).'" class="dropdown-item text-success"><i class="icon-database-edit2"></i> កែប្រែ</a>
												<button type="submit" class="dropdown-item text-warning"><i class="icon-database-remove"></i> លុប</button>
											</form>
										</div>
									</div>';
            })
            ->rawColumns(['action','type'])
            ->make(true);
    }
    public function budget_index(){
        return view('report.budget');
    }
    public function exp_inc_index(){
        return view('report.inc_exp');
    }
    /*salary budget and income note*/
    public function exp_inc(Request $request){
        $input = $request->all();
        $expenses = Budget::whereBetween('created_at',[$input['start'],$input['end']])->where('type','=','exp')->get();
        $incomes = IncomeNote::whereBetween('created_at',[$input['start'],$input['end']])->get();
        $total_expense = 0;
        $total_income = 0;
        foreach ($expenses as $values){
            $total_expense += $values['amount'];
        }
        foreach ($incomes as $values){
            $total_income += $values['amount'];
        }
        $remain = $total_income-$total_expense;
        return response()->json(['exp'=>money_format('$%i', $total_expense),'inc'=>money_format('$%i', $total_income),'remain'=>money_format('$%i', $remain)]);
    }
    /*sell*/
    public function sell_un_list(Request $request){
        $input = $request->all();
        $invoice_details = InvoiceDetail::with('stock_detail_only')
            ->whereBetween('created_at',[$input['start'],$input['end']])
            ->get();
        $total_qty = 0;
        $total_sell_amount = 0;
        $total_pur_of_sell = 0;
        foreach ($invoice_details as $invoice_detail){
            $total_qty +=$invoice_detail['qty'];
            $total_sell_amount +=$invoice_detail['amount'];
            $total_pur_of_sell +=$invoice_detail['qty']*$invoice_detail['stock_detail_only']['pur_price'];
        }
        return response()->json(['total_qty'=>$total_qty,'total_sell_amount'=>$total_sell_amount,'benifit_amount'=>$total_sell_amount-$total_pur_of_sell]);
    }
    /*sell unlist all*/
    public function sell_un_list_all(){
        $invoice_details = InvoiceDetail::with('stock_detail_only')->get();
        $total_qty = 0;
        $total_sell_amount = 0;
        $total_pur_of_sell = 0;
        foreach ($invoice_details as $invoice_detail){
            $total_qty +=$invoice_detail['qty'];
            $total_sell_amount +=$invoice_detail['amount'];
            $total_pur_of_sell +=$invoice_detail['qty']*$invoice_detail['stock_detail_only']['pur_price'];
        }
        return response()->json(['total_qty'=>$total_qty,'total_sell_amount'=>$total_sell_amount,'benifit_amount'=>$total_sell_amount-$total_pur_of_sell]);
    }
    public function sell_list(Request $request){
        $input = $request->all();
        $invoice_detail = InvoiceDetail::with('stock_detail')
            ->whereBetween('created_at',[$input['range']['start'],$input['range']['end']])
            ->get();
        return DataTables::of($invoice_detail)
            ->editColumn('created_at',function ($created_at){
                return Carbon::parse($created_at->created_at)->format('d-m-Y h:m:s');
            })
            ->editColumn('amount',function ($amount){
                return money_format('$%i', $amount->amount);
            })
            ->addColumn('action',function ($action){
                return '<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>

											<div class="dropdown-menu dropdown-menu-right">
												<a href="'.route('invoice.edit',$action->id).'" class="dropdown-item text-success"><i class="icon-database-edit2"></i> Edit</a>
											</div>
										</div>
									</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function sell(){
        return view('report.sell');
    }
    /*buy*/
    public function buy_un_list(Request $request){
        $input = $request->all();
        $products =  StockDetail::whereBetween('created_at',[$input['start'],$input['end']])
            ->where('status',1)
            ->get();
        $total_qty = 0;
        $total_purchase = 0;
        foreach ($products as $product){
            $total_qty+=$product['qty'];
            $total_purchase+=$product['qty']*$product['pur_price'];
        }
        return response()->json(['total_qty'=>$total_qty,'total_purchase'=>$total_purchase]);
    }
    /*buy unlist all*/
    public function buy_un_list_all(){
        $products =  StockDetail::where('status',1)->get();
        $total_qty = 0;
        $total_purchase = 0;
        foreach ($products as $product){
            $total_qty+=$product['qty'];
            $total_purchase+=$product['qty']*$product['pur_price'];
        }
        return response()->json(['total_qty'=>$total_qty,'total_purchase'=>$total_purchase]);
    }
    public function buy_list(Request $request){
        $input = $request->all();
        $product =  StockDetail::with('product')
            ->whereBetween('created_at',[$input['range']['start'],$input['range']['end']])
            ->where('status',1)
            ->get();
        return DataTables::of($product)
            ->editColumn('created_at',function ($created_at){
                return Carbon::parse($created_at->created_at)->format('d-m-Y h:m:s');
            })
            ->editColumn('pur_price',function ($pur_price){
                return money_format('$%i', $pur_price->pur_price);
            })
            ->editColumn('sell_price',function ($sell_price){
                return money_format('$%i', $sell_price->sell_price);
            })
            ->addColumn('sell_amount',function ($sell_amount){
                return money_format('$%i', $sell_amount->qty*$sell_amount->sell_price);
            })
            ->addColumn('pur_amount',function ($pur_amount){
                return money_format('$%i', $pur_amount->qty*$pur_amount->pur_price);
            })
            ->addColumn('action',function ($action){
                return '<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>

											<div class="dropdown-menu dropdown-menu-right">
												<a href="'.route('product.edit',$action->id).'" class="dropdown-item text-success"><i class="icon-database-edit2"></i> Edit</a>
											</div>
										</div>
									</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function buy(){
        return view('report.buy');
    }
    /*end buy*/
}
