<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $fillable = ['invoice_id', 'stock_detail_id', 'amount', 'qty'];
    public function stock_detail(){
        return $this->belongsTo(StockDetail::class)->with('product');
    }
    public function stock_detail_only(){
        return $this->belongsTo(StockDetail::class,'stock_detail_id','id');
    }
}
