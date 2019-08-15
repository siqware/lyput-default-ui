@extends('dashboard.layout')
@section('page-title')
    Update | Delete User
@stop
@section('page-header')
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">អ្នកប្រើប្រាស់</span> - កែប្រែអ្នកប្រើប្រាស់
                </h4>
                <a href="#" class="ml-auto align-self-center text-default d-md-none" data-toggle="collapse"
                   data-target="#navbar-mobile-top-header"><i class="icon-more"></i></a>
            </div>

            <div class="navbar navbar-expand-md navbar-dark bg-teal-400">
                <div class="collapse navbar-collapse" id="navbar-mobile-top-header">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="{{route('user.index')}}"
                                                class="navbar-nav-link {{request()->is('user')? 'active':''}}"><i
                                        class="icon-list-numbered mr-2"></i> បញ្ជី</a></li>
                        <li class="nav-item"><a href="{{route('user.create')}}"
                                                class="navbar-nav-link {{request()->is('user/create')? 'active':''}}"><i
                                        class="icon-pencil mr-2"></i> បន្ថែម</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('user.index')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>
                        ប្រើប្រាស់</a>
                    <span class="breadcrumb-item active">កែប្រែអ្នកប្រើប្រាស់</span>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-content')
    <!-- Form layouts -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">កែប្រែអ្នកប្រើប្រាស់</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form id="form-edit" action="{{route('user.update',$userEdit->id)}}" method="post">
                @csrf
                <input type="hidden" name="_method" value="put">
                <div class="row">
                    <div class="col-md-8">
                        <fieldset>
                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> ពត៌មានអ្នកប្រើប្រាស់
                            </legend>
                            {{--Profile--}}
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Profile:</label>
                                <div class="col-lg-9" id="lfm" data-input="thumbnail" data-preview="holder">
                                    <img id="holder" class="rounded-circle shadow" src="{{asset($userEdit->picture)}}" style="margin-top:15px;max-height:100px;">
                                    <input id="thumbnail" value="{{asset($userEdit->picture)}}" type="hidden" name="picture">
                                </div>
                            </div>

                            {{--Name--}}
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Enter your name:</label>
                                <div class="col-lg-9">
                                    <input type="text" value="{{$userEdit->name}}" class="form-control" placeholder="Type your name" name="name">
                                </div>
                            </div>
                            {{--Gender--}}
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Your gender:</label>
                                <div class="col-lg-9">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input value="male" type="radio" class="form-check-input-styled" name="gender"
                                                   {{$userEdit->gender=='male' | $userEdit->gender=='unknown'?'checked':''}} data-fouc>
                                            Male
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input value="female" type="radio" class="form-check-input-styled" name="gender"
                                                   {{$userEdit->gender=='male' | $userEdit->gender=='unknown'?'':'checked'}} data-fouc>
                                            Female
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{--Email--}}
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Enter your email:</label>
                                <div class="col-lg-9">
                                    <input type="email" value="{{$userEdit->email}}" class="form-control" placeholder="Type your email" name="email">
                                </div>
                            </div>
                            {{--Password--}}
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Enter your password:</label>
                                <div class="col-lg-9">
                                    <input type="password" class="form-control" placeholder="Type your password" name="password">
                                </div>
                            </div>
                            {{--Role--}}
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Select your role:</label>
                                <div class="col-lg-9">
                                    <select class="form-control form-control-uniform" data-fouc name="role">
                                        <option value="user">Select role</option>
                                        <option {{$userEdit->role=='user'?'selected':''}} value="user">User</option>
                                        <option {{$userEdit->role=='admin'?'selected':''}} value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            {{--Status--}}
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Select your status:</label>
                                <div class="col-lg-9">
                                    <select class="form-control form-control-uniform" data-fouc name="status">
                                        <option {{$userEdit->status=='pending'?'selected':''}} value="pending">Select status</option>
                                        <option {{$userEdit->status=='active'?'selected':''}} value="active">Active</option>
                                        <option {{$userEdit->status=='pending'?'selected':''}} value="pending">Pending</option>
                                        <option {{$userEdit->status=='inactive'?'selected':''}} value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                        </fieldset>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-8">
                    <form id="form-delete" action="{{route('user.destroy',$userEdit->id)}}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="delete">
                    </form>
                    <div class="text-right">
                        <button onclick="document.getElementById('form-edit').submit();" class="btn btn-primary">កែប្រែ <i class="icon-sync ml-2"></i>
                        </button>
                        <button id="sweet_combine" class="btn btn-warning">លុប <i class="icon-database-remove ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /form layouts -->
@stop
@section('page-script')
    <script>
        console.log('app started')
    </script>
@stop
@section('page-style')
    <style>
        body {
            /*color: red;*/
        }
    </style>
@stop
@push('page-js')
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/notifications/sweet_alert.min.js')}}"></script>
    <script src="{{asset('vendor/laravel-filemanager/js/lfm.js')}}"></script>
    <script src="{{asset('js/pages/user/create.js')}}"></script>
    <script src="{{asset('js/pages/user/edit.js')}}"></script>
@endpush
