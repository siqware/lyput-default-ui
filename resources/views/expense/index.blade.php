@extends('dashboard.layout')
@section('page-title')
    Blank
@stop
@section('page-header')
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">ចំណាយ</span> - បញ្ជីចំណាយ
                </h4>
                <a href="#" class="ml-auto align-self-center text-default d-md-none" data-toggle="collapse"
                   data-target="#navbar-mobile-top-header"><i class="icon-more"></i></a>
            </div>

            <div class="navbar navbar-expand-md navbar-dark bg-teal-400">
                <div class="collapse navbar-collapse" id="navbar-mobile-top-header">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="{{route('expense.index')}}"
                                                class="navbar-nav-link"><i
                                        class="icon-list-numbered mr-2"></i> បញ្ជីចំណាយ</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('expense.index')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>
                        ចំណាយ</a>
                    <span class="breadcrumb-item active">បញ្ជីចំណាយ</span>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-content')
    <!-- Form layouts -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">បញ្ជីចំណាយប្រចាំថ្ងៃ</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <form class="col-md-5"
                      method="post" {{request()->is('expense')? 'action='.route('expense.store').'':'action='.route('expense.update',$expense->id).''}}>
                    @csrf
                    @if(request()->is('expense/*/edit'))
                        <input type="hidden" name="_method" value="put">
                    @endif
                    <fieldset>
                        <legend class="font-weight-semibold"><i class="icon-cash mr-2"></i>
                            @if(request()->is('expense'))
                                បន្ថែមចំណាយ
                                @else
                                កែប្រែចំណាយ
                                @endif
                        </legend>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-5">
                                        @if(request()->is('expense'))
                                            <input type="text" required name="desc" placeholder="ពិពណ៌នា" class="form-control">
                                            @else
                                            <input type="text" required name="desc" value="{{$expense->desc}}" placeholder="ពិពណ៌នា" class="form-control">
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        @if(request()->is('expense'))
                                            <input type="number" required min="1" step="any" name="amount" placeholder="តម្លៃ" class="form-control">
                                        @else
                                            <input type="number" value="{{$expense->amount}}" required min="1" step="any" name="amount" placeholder="តម្លៃ" class="form-control">
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        @if(request()->is('expense'))
                                            <button type="submit" class="btn btn-primary">បន្ថែម <i
                                                        class="icon-floppy-disk ml-2"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-success">កែប្រែ <i
                                                        class="icon-sync ml-2"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>

                <div class="col-md-7">
                    <fieldset class="shadow px-2">
                        <table class="table table-bordered table-sm table-striped datatable-scroll-y" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>ពិពណ៌នា</th>
                                <th>ចំណាយ</th>
                                <th>កាលបរិច្ឆេទ</th>
                                <th></th>
                            </tr>
                            </thead>
                        </table>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <!-- /form layouts -->
@stop
@section('page-script')
    @routes
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
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/tables/datatables/extensions/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{asset('js/pages/expense/index.js')}}"></script>
@endpush