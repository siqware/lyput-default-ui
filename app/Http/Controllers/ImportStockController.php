<?php

namespace App\Http\Controllers;

use App\Product;
use App\Stock;
use App\StockDetail;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportStockController extends Controller
{
    /*Import from excel index*/
    public function excel_import_index(){
        return view('product.stock_import');
    }
    /*Import from excel*/
    public function excel_import(Request $request)
    {
        $path = $request->file('import_file')->getRealPath();
        $collection = (new FastExcel)->import($path);
        /*Start stock Value*/
        $total_pur = 0;
        $total_sell = 0;
        $total_qty = 0;
        foreach ($collection as $value) {
            $total_pur += $value['purchase'] * $value['qty'];
            $total_sell += $value['sell'] * $value['qty'];
            $total_qty += $value['qty'];

        }
        $stock = Stock::create([
            'pur_price' => $total_pur,
            'sell_price' => $total_sell,
            'qty' => $total_qty,
        ]);
        /*end stock value*/
        /*start product value*/
        foreach ($collection as $value) {
            $product = Product::create([
                'desc' => $value['desc']
            ]);
            /*start stock detail value base on product loop*/
            StockDetail::create([
                'stock_id' => $stock->id,
                'product_id' => $product->id,
                'qty' => $value['qty'],
                'remain_qty' => $value['qty'],
                'pur_price' => $value['purchase'],
                'sell_price' => $value['sell'],
            ]);
        }
        return redirect(route('product.index'));
    }
}
