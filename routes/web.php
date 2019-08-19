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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware'=>['is.admin']], function () {
    Route::get('/', function () {
        return view('report.sell');
    })->name('dashboard');
    Route::get('media', function () {
        return view('file-manager');
    })->name('media');
    /*User*/
    Route::resource('/user', 'UserController');
    Route::get('/user-json-list', 'UserController@user_json_list')->name('user.json.list');
    /*Product*/
    Route::resource('/product', 'ProductController');
    Route::get('/product-stock-detail-list', 'ProductController@product_stock_detail')->name('product.stock.list');
    Route::get('/stock-excel-import-index', 'ImportStockController@excel_import_index')->name('stock.excel.import.index');
    Route::post('/stock-excel-import', 'ImportStockController@excel_import')->name('stock.excel.import');
//import stock
    Route::get('/product-stock-import-index', 'ProductController@import_stock_index')->name('stock.import.index');
    Route::post('/product-stock-import', 'ProductController@import_stock')->name('stock.import');
// end import stock
    Route::post('/search-product-stock', 'ProductController@search_stock')->name('product.search.stock');
    Route::post('/search-product-out-stock', 'ProductController@search_out_stock')->name('product.search.out.stock');
    Route::post('/search-product-autocomplete', 'ProductController@product_autocomplete')->name('product.search.autocomplete');
    Route::get('/product-check', 'ProductController@check')->name('product.check');
    Route::get('/product-check-list', 'ProductController@check_list')->name('product.check.list');
    /*Invoice Detail*/
    Route::resource('/invoice', 'InvoiceController');
    Route::get('/invoice-index', 'ProductController@invoicing_index')->name('product.invoice.index');
    Route::get('/stock-detail-data/{id}', 'InvoiceController@get_stock_id')->name('stock.detail.data');
    Route::get('/invoice-detail-list', 'InvoiceController@invoice_list')->name('invoice.detail.list');
    /*Budget*/
    Route::resource('budget', 'BudgetController');
    Route::get('/budget-list', 'BudgetController@budget_list')->name('budget.list');
    Route::post('/budget-autocomplete', 'BudgetController@budget_autocomplete')->name('budget.autocomplete');
    /*Report*/
    Route::get('/report-buy-list', 'ReportController@buy_list')->name('buy.list');
    Route::get('/report-buy', 'ReportController@buy')->name('buy');
    Route::get('/report-sell', 'ReportController@sell')->name('sell');
    Route::get('/report-sell-list', 'ReportController@sell_list')->name('sell.list');
    Route::get('/report-income-expense', 'ReportController@exp_inc')->name('inc.exp');
    Route::get('/report-income-expense-index', 'ReportController@exp_inc_index')->name('inc.exp.index');
    Route::get('/report-budget-index', 'ReportController@budget_index')->name('report.budget.index');
    Route::get('/report-budget', 'ReportController@budget_list')->name('report.budget.list');
    Route::get('/report-close-report-index', 'ReportController@close_report_index')->name('report.close.index');
    Route::get('/report-close-report', 'ReportController@close_report')->name('report.close');
});