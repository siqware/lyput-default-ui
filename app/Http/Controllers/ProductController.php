<?php

namespace App\Http\Controllers;

use App\Product;
use App\Stock;
use App\StockDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /*import stock*/
    public function import_stock_index(){
        return view('product.import');
    }
    public function import_stock(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'product.*.*' => 'required',
        ]);
        /*Start stock Value*/
        $total_pur = 0;
        $total_sell = 0;
        $total_qty = 0;
        foreach ($input['product'] as $value) {
            $total_pur += $value['pur_price'] * $value['qty'];
            $total_sell += $value['sell_price'] * $value['qty'];
            $total_qty += $value['qty'];
        }
        $stock = Stock::create([
            'pur_price' => $total_pur,
            'sell_price' => $total_sell,
            'qty' => $total_qty,
        ]);
        /*end stock value*/
        /*start product value*/
        foreach ($input['product'] as $value) {
            /*start stock detail value base on product loop*/
            StockDetail::create([
                'stock_id' => $stock->id,
                'product_id' => $value['id'],
                'qty' => $value['qty'],
                'remain_qty' => $value['qty'],
                'pur_price' => $value['pur_price'],
                'sell_price' => $value['sell_price'],
            ]);
            $update_stock = StockDetail::findOrFail($value['stock_id']);
            $update_stock->is_stock = 1;
            $update_stock->save();
        }
        return redirect(route('product.index'));
    }
    /*end import stock*/
    /*check product index*/
    public function check()
    {
        return view('product.check');
    }

    /*search stock product*/
    public function search_stock(Request $request)
    {
        $inputTerm = $request->_term;
        $inputData = $request->_data;
        StockDetail::get_search($inputTerm);
        $results = StockDetail::with('product_stock_search')
            ->whereHas('product_stock_search')
            ->where('status','<>',0)
            ->whereNotIn('id', $inputData)
            ->where('remain_qty', '>=', 1)
            ->get();
        $data = [];
        foreach ($results as $result) {
            $data[] = [
                'id' => $result['id'],
                'text' => $result['product_stock_search']['desc'],
            ];
        }
        return response()->json(['results' => $data]);
    }
    //search out of stock
    public function search_out_stock(Request $request)
    {
        $inputTerm = $request->_term;
        $inputData = $request->_data;
        StockDetail::get_search($inputTerm);
        $results = StockDetail::with('product_stock_search')
            ->whereHas('product_stock_search')
            ->where('status','<>',0)
            ->where('is_stock','=',0)
            ->whereNotIn('id', $inputData)
            ->where('remain_qty', '=', 0)
            ->get();
        $data = [];
        foreach ($results as $result) {
            $data[] = [
                'id' => $result['id'],
                'pro_id' => $result['product_stock_search']['id'],
                'text' => $result['product_stock_search']['desc'],
            ];
        }
        return response()->json(['results' => $data]);
    }
    public function product_autocomplete(Request $request)
    {
//        $inputTerm = $request->_term;
        $inputTerm = $request->_term;
        $results = Product::groupBy('desc')->having('desc','like',"%$inputTerm%")->get();
        $data = [];
        foreach ($results as $result) {
            $data[] = [
                'id' => $result['id'],
                'label' => $result['desc'],
                'value' => $result['desc'],
            ];
        }
        return response()->json($data);
    }
    /*end search stock*/
    /*Product List*/
    public function product_stock_detail()
    {
        $product = StockDetail::with('product')
            ->where('status','<>',0)
            ->get();
        return DataTables::of($product)
            ->editColumn('created_at', function ($created_at) {
                return Carbon::parse($created_at->created_at)->format('d-m-Y h:m:s');
            })
            ->addColumn('sell_amount', function ($sell_amount) {
                return money_format('$%i', $sell_amount->qty * $sell_amount->sell_price);
            })
            ->addColumn('pur_amount', function ($pur_amount) {
                return money_format('$%i', $pur_amount->qty * $pur_amount->pur_price);
            })
            ->editColumn('pur_price', function ($pur_price) {
                return money_format('$%i', $pur_price->pur_price);
            })
            ->editColumn('sell_price', function ($sell_price) {
                return money_format('$%i', $sell_price->sell_price);
            })
            ->addColumn('action', function ($action) {
                return '<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>

											<div class="dropdown-menu dropdown-menu-right">
												<a href="' . route('product.edit', $action->id) . '" class="dropdown-item text-success"><i class="icon-database-edit2"></i> Edit</a>
											</div>
										</div>
									</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /*product check list*/
    public function check_list()
    {
        $product = StockDetail::with('product')->where('is_stock','=',0)->where('status','=',1)->get();
        return DataTables::of($product)
            ->editColumn('created_at', function ($created_at) {
                return Carbon::parse($created_at->created_at)->format('d-m-Y h:m:s');
            })
            ->editColumn('remain_qty', function ($remain_qty) {
                return $remain_qty->remain_qty <= 0 ? '<span class="text-warning">' . $remain_qty->remain_qty . '</span>' : '<span class="text-success">' . $remain_qty->remain_qty . '</span>';
            })
            ->editColumn('pur_price', function ($pur_price) {
                return money_format('$%i', $pur_price->pur_price);
            })
            ->editColumn('sell_price', function ($sell_price) {
                return money_format('$%i', $sell_price->sell_price);
            })
            ->rawColumns(['remain_qty'])
            ->make(true);
    }

    public function index()
    {
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /*store product and stock*/
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'product.*.*' => 'required',
        ]);
        /*Start stock Value*/
        $total_pur = 0;
        $total_sell = 0;
        $total_qty = 0;
        foreach ($input['product'] as $value) {
            $total_pur += $value['pur_price'] * $value['qty'];
            $total_sell += $value['sell_price'] * $value['qty'];
            $total_qty += $value['qty'];

        }
        $stock = Stock::create([
            'pur_price' => $total_pur,
            'sell_price' => $total_sell,
            'qty' => $total_qty,
        ]);
        /*end stock value*/
        /*start product value*/
        foreach ($input['product'] as $value) {
            $product = Product::create([
                'desc' => $value['desc']
            ]);
            /*start stock detail value base on product loop*/
            StockDetail::create([
                'stock_id' => $stock->id,
                'product_id' => $product->id,
                'qty' => $value['qty'],
                'remain_qty' => $value['qty'],
                'pur_price' => $value['pur_price'],
                'sell_price' => $value['sell_price'],
            ]);
        }
        return redirect(route('product.index'));
    }
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = StockDetail::with('product')->where('id', $id)->get();
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $product = Product::findOrFail($input['pro_id']);
        $product->desc = $input['desc'];
        $product->save();
        $stock = StockDetail::findOrFail($id);
        $stock->update([
            'qty' => $input['qty'],
            'remain_qty' => $input['qty'],
            'pur_price' => $input['pur_price'],
            'sell_price' => $input['sell_price'],
        ]);
        if ($stock) {
            return redirect(route('product.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = StockDetail::findOrFail($id);
        $product->status = 0;
        $product->save();
        if ($product) {
            return redirect(route('product.index'));
        }
    }
}
