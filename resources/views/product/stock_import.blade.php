@extends('dashboard.layout')
@section('page-title')
    Blank
@stop
@section('page-header')
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">សិស្ស</span> - បញ្ជីសិស្ស
                </h4>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('product.index')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>
                        សិស្ស</a>
                    <span class="breadcrumb-item active">បញ្ជីសិស្ស</span>
                </div>
                <a href="#" class="ml-auto align-self-center text-default d-md-none" data-toggle="collapse"
                   data-target="#navbar-mobile-header"><i class="icon-more"></i></a>
            </div>

            <div class="navbar navbar-expand-md navbar-light header-elements">
                <div class="collapse navbar-collapse" id="navbar-mobile-header">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href=""
                               class="navbar-nav-link {{request()->is('student-higher-bulk-upgrade')? 'active':''}}">
                                <i class="icon-move-up"></i>
                                <span class="ml-2">តម្លើងឆ្នាំសិក្សាតាមថ្នាក់</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-list"></i>
                                <span class="ml-2">បង្ហាញតាមឆ្នាំសិក្សា</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pt-0">
                                <a class="dropdown-item">ថ្នាក់ធំ</a>
                                <div class="dropdown-divider m-0"></div>
                                <a href="#" class="dropdown-item" id="btn_by_year" data-id="1">២០១៨-២០១៩</a>
                                <a href="#" class="dropdown-item" id="btn_by_year" data-id="2">២០១៩-២០២០</a>
                                <div class="dropdown-divider m-0"></div>
                                <a class="dropdown-item m-0">ថ្នាក់តូច</a>
                                <div class="dropdown-divider m-0"></div>
                                <a href="#" class="dropdown-item" id="btn_by_year" data-id="1">២០១៨-២០១៩</a>
                                <a href="#" class="dropdown-item" id="btn_by_year" data-id="2">២០១៩-២០២០</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-content')
    <!-- Form layouts -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Multiple columns</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload"></a>
                    <a class="list-icons-item" data-action="remove"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{route('stock.excel.import')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <fieldset>
                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Personal details
                            </legend>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Attach screenshot:</label>
                                <div class="col-lg-9">
                                    <input type="file" name="import_file" class="form-input-styled" data-fouc>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i>
                    </button>
                </div>
            </form>
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
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('js/pages/blank/index.js')}}"></script>
@endpush