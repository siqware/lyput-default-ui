<?php

namespace App\Http\Controllers;

use App\IncomeNote;
use App\Invoice;
use App\InvoiceDetail;
use App\StockDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    /*update invoice detail*/
    public function update(Request $request,$id){
        $input = $request->all();
        $request->validate([
            'amount' => 'required',
            'qty' => 'required',
        ]);
        $invoice_detail = InvoiceDetail::findOrFail($id);
        $invoice_detail->amount = $input['amount'];
        $invoice_detail->qty = $input['qty'];
        $invoice_detail->save();
        if ($invoice_detail){
            return redirect(route('invoice.index'));
        }
    }
    /*edit invoicing*/
    public function edit($id){
        $invoice_detail = InvoiceDetail::with('stock_detail')->where('id',$id)->get();
        return view('invoice.edit',compact('invoice_detail'));
    }
    /*Invoicing*/
    public function create(){
        return view('invoice.create');
    }
    /*invoice list datatable*/
    public function invoice_list(){
        $invoice_detail = InvoiceDetail::with('stock_detail')->get();
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
    public function index(){
        return view('invoice.index');
    }
    /*Get stock detail data ajax*/
    public function get_stock_id($id){
        $stock = StockDetail::findOrFail($id);
        return response()->json($stock);
    }
    /*invoicing*/
    public function store(Request $request){
        $input = $request->all();
        $request->validate([
            'product.*.*' => 'required',
        ]);
        /*total qty and amount*/
        $qty = 0;
        $amount = 0;
        foreach ($input['product'] as $value){
            $qty+=$value['qty'];
            $amount+=$value['amount'];
        }
        /*create invoice*/
        $invoice = new Invoice();
        $invoice->amount = $amount;
        $invoice->qty = $qty;
        $invoice->save();
        /*create invoice detail*/
        $invoice_detail_data = [];
        foreach ($input['product'] as $value){
            $invoice_detail_data[]=[
                'invoice_id' => $invoice->id,
                'stock_detail_id' => $value['id'],
                'amount' => $value['amount'],
                'qty' => $value['qty'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        InvoiceDetail::insert($invoice_detail_data);
        /*income note*/
        $income_note = new IncomeNote();
        $income_note->invoice_id = $invoice->id;
        $income_note->amount = $input['income_note'];
        $income_note->save();
        /*decrease stock qty*/
        foreach ($input['product'] as $value){
            $stockDetail = StockDetail::findOrFail($value['id']);
            $stockDetail->remain_qty -= $value['qty'];
            $stockDetail->save();
        }
        if ($invoice){
            return redirect(route('invoice.index'));
        }

    }
}
