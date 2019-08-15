<?php

namespace App\Http\Controllers;

use App\ExpenseNote;
use App\IncomeNote;
use App\InvoiceDetail;
use App\StockDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    public function exp_inc_index(){
        return view('report.inc_exp');
    }
    /*salary expense and income note*/
    public function exp_inc(Request $request){
        $input = $request->all();
        $expenses = ExpenseNote::whereBetween('created_at',[$input['start'],$input['end']])->get();
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
    public function buy_list(Request $request){
        $input = $request->all();
        $product =  StockDetail::with('product')->whereBetween('created_at',[$input['range']['start'],$input['range']['end']])->get();
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
                return money_format('$%i', $sell_amount->qty*$sell_amount->qty);
            })
            ->addColumn('pur_amount',function ($pur_amount){
                return money_format('$%i', $pur_amount->qty*$pur_amount->qty);
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
}
