<?php

namespace App\Http\Controllers;

use App\ExpenseNote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExpenseNoteController extends Controller
{
    /*expense list*/
    public function expense_list(){
        $expense = ExpenseNote::all();
        return DataTables::of($expense)
            ->editColumn('created_at',function ($created_at){
                return Carbon::parse($created_at->created_at)->format('d-m-Y');
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

											<form class="dropdown-menu dropdown-menu-right" method="post" action="'.route('expense.destroy',$action->id).'">
											'.csrf_field().'
											<input type="hidden" name="_method" value="delete">
												<a href="'.route('expense.edit',$action->id).'" class="dropdown-item text-success"><i class="icon-database-edit2"></i> កែប្រែ</a>
												<button type="submit" class="dropdown-item text-warning"><i class="icon-database-remove"></i> លុប</button>
											</form>
										</div>
									</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('expense.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'desc'=>'required',
            'amount'=>'required',
        ]);
        $expense = new ExpenseNote();
        $expense->desc = $input['desc'];
        $expense->amount = $input['amount'];
        $expense->save();
        if ($expense){
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpenseNote  $expenseNote
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseNote $expenseNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExpenseNote  $expenseNote
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = ExpenseNote::findOrFail($id);
        return view('expense.index',compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpenseNote  $expenseNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        /*validate*/
        $request->validate([
            'desc'=>'required',
            'amount'=>'required',
        ]);
        $expense = ExpenseNote::findOrFail($id);
        $expense->desc = $input['desc'];
        $expense->amount = $input['amount'];
        $expense->save();
        if ($expense){
            return redirect(route('expense.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenseNote  $expenseNote
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = ExpenseNote::findOrFail($id)->delete();
        if ($expense){
            return redirect(route('expense.index'));
        }
    }
}
