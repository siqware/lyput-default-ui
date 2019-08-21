<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BudgetController extends Controller
{
    /*budget auto complete*/
    public function budget_autocomplete(Request $request)
    {
//        $inputTerm = $request->_term;
        $inputTerm = $request->_term;
        $results = Budget::groupBy('desc')->having('desc','like',"%$inputTerm%")->get();
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
    /*budget list*/
    public function budget_list(){
        $budget = Budget::all();
        return DataTables::of($budget)
            ->editColumn('created_at',function ($created_at){
                return Carbon::parse($created_at->created_at)->format('d-m-Y');
            })
            ->editColumn('amount',function ($amount){
                return money_format('$%i', $amount->amount);
            })
            ->editColumn('type',function ($type){
                return $type->type=='inc'?'<span class="badge bg-success-400">ចំណូល</span>':'<span class="badge bg-warning-400">ចំណាយ</span>';
            })
            ->addColumn('action',function ($action){
                return '<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>
											<form class="dropdown-menu dropdown-menu-right" method="post" action="'.route('budget.destroy',$action->id).'">
											'.csrf_field().'
											<input type="hidden" name="_method" value="delete">
												<a href="'.route('budget.edit',$action->id).'" class="dropdown-item text-success"><i class="icon-database-edit2"></i> កែប្រែ</a>
												<button type="submit" class="dropdown-item text-warning"><i class="icon-database-remove"></i> លុប</button>
											</form>
										</div>
									</div>';
            })
            ->rawColumns(['action','type'])
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('budget.index');
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
            'budget.*.desc'=>'required',
            'budget.*.type'=>'required',
            'budget.*.amount'=>'required',
        ]);
        $budget_data = [];
        foreach ($input['budget'] as $value){
            $budget_data[] = [
                'desc'=>$value['desc'],
                'type'=>$value['type'],
                'amount'=>$value['amount'],
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ];
        }
        $budget = Budget::insert($budget_data);
        if ($budget){
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Budget  $budgetNote
     * @return \Illuminate\Http\Response
     */
    public function show(Budget $budgetNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Budget  $budgetNote
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $budget = Budget::findOrFail($id);
        return view('budget.index',compact('budget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Budget  $budgetNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        /*validate*/
        $request->validate([
            'budget.0.desc'=>'required',
            'budget.0.amount'=>'required',
        ]);
        $budget = Budget::findOrFail($id);
        $budget->desc = $input['budget'][0]['desc'];
        $budget->amount = $input['budget'][0]['amount'];
        $budget->save();
        if ($budget){
            return redirect(route('budget.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Budget  $budgetNote
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $budget = Budget::findOrFail($id)->delete();
        if ($budget){
            return redirect(route('budget.index'));
        }
    }
}
