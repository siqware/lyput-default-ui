<?php

namespace App\Http\Controllers;

use App\IncomeNote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IncomeNoteController extends Controller
{
    public function list(){
        $income_note = IncomeNote::where('invoice_id',0)->get();
        return DataTables::of($income_note)
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
											<form class="dropdown-menu dropdown-menu-right" method="post" action="'.route('income.note.destroy',$action->id).'">
											'.csrf_field().'
											<input type="hidden" name="_method" value="delete">
												<a href="'.route('income.note.edit',$action->id).'" class="dropdown-item text-success"><i class="icon-database-edit2"></i> កែប្រែ</a>
												<button type="submit" class="dropdown-item text-warning"><i class="icon-database-remove"></i> លុប</button>
											</form>
										</div>
									</div>';
            })
            ->make(true);
    }
    public function index()
    {
        return view('income-note.index');
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
       foreach ($input['income_note'] as $value){
           $insert = IncomeNote::create([
               'invoice_id'=>$value['invoice'],
               'amount'=>$value['amount']
           ]);
           if (!$insert){
               return redirect()->back();
           }
       }
       return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IncomeNote  $incomeNote
     * @return \Illuminate\Http\Response
     */
    public function show(IncomeNote $incomeNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IncomeNote  $incomeNote
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $income_note = IncomeNote::findOrFail($id);
        return view('income-note.index',compact('income_note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IncomeNote  $incomeNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $input = $request->all();
        $income_note = IncomeNote::findOrFail($id);
        $income_note->amount = $input['income_note'][0]['amount'];
        $income_note->save();
        if ($income_note){
            return redirect(route('income.note.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IncomeNote  $incomeNote
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $income_note = IncomeNote::findOrFail($id)->delete();
        if ($income_note){
            return redirect()->back();
        }
    }
}
