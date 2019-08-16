<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('report.sell');})->name('dashboard');
Route::get('media', function () {return view('file-manager');})->name('media');

Auth::routes();
/*User*/
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/user', 'UserController');
Route::get('/user-json-list', 'UserController@user_json_list')->name('user.json.list');
/*Product*/
Route::resource('/product','ProductController');
Route::get('/product-stock-detail-list','ProductController@product_stock_detail')->name('product.stock.list');
Route::post('/search-product-stock','ProductController@search_stock')->name('product.search.stock');
Route::get('/product-check','ProductController@check')->name('product.check');
Route::get('/product-check-list','ProductController@check_list')->name('product.check.list');
/*Invoice Detail*/
Route::resource('/invoice','InvoiceController');
Route::get('/invoice-index','ProductController@invoicing_index')->name('product.invoice.index');
Route::get('/stock-detail-data/{id}','InvoiceController@get_stock_id')->name('stock.detail.data');
Route::get('/invoice-detail-list','InvoiceController@invoice_list')->name('invoice.detail.list');
/*Expense*/
Route::resource('budget','BudgetController');
Route::get('/budget-list','BudgetController@budget_list')->name('budget.list');
/*Report*/
Route::get('/report-buy-list','ReportController@buy_list')->name('buy.list');
Route::get('/report-buy','ReportController@buy')->name('buy');
Route::get('/report-sell','ReportController@sell')->name('sell');
Route::get('/report-sell-list','ReportController@sell_list')->name('sell.list');
Route::get('/report-income-expense','ReportController@exp_inc')->name('inc.exp');
Route::get('/report-income-expense-index','ReportController@exp_inc_index')->name('inc.exp.index');
Route::get('/report-budget-index','ReportController@budget_index')->name('report.budget.index');
Route::get('/report-budget','ReportController@budget_list')->name('report.budget.list');
