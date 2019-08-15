<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function user_json_list()
    {
        $user = User::all();
        return DataTables::of($user)
            ->editColumn('picture',function ($picture){
                return '<img src="'.asset($picture->picture).'" width="35" height="35" class="rounded-circle">';
            })
            ->editColumn('status',function ($status){
                return view('user.status',compact('status'));
            })
            ->editColumn('email',function ($email){
                return '<a href="mailto:'.$email->email.'">'.$email->email.'</a>';
            })
            ->editColumn('created_at',function ($date){
                return Carbon::parse($date->created_at)->format('d, m-M, Y');
            })
            ->addColumn('action',function ($action){
                return '<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>

											<div class="dropdown-menu dropdown-menu-right">
												<a href="'.route('user.edit',$action->id).'" class="dropdown-item text-success"><i class="icon-database-edit2"></i> Edit</a>
											</div>
										</div>
									</div>';
            })
            ->rawColumns(['picture','action','status','email'])
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
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
        $input['password'] = Hash::make($input['password']);
        $createUser = User::create($input);
        if ($createUser){
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userEdit = User::findOrFail($id);
        return view('user.edit',compact('userEdit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $userUpdate = User::findOrFail($id);
        if ($input['password']==null){
            $input['password']=$userUpdate->password;
        }
        $update = $userUpdate->update($input);
        if ($update){
            return redirect(route('user.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userDelete = User::findOrFail($id)->delete();
        if ($userDelete){
            return redirect(route('user.index'));
        }
    }
}
