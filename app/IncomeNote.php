<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomeNote extends Model
{
    protected $fillable = ['invoice_id','amount'];
}
