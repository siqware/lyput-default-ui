@extends('dashboard.layout')
@section('page-title')
    Blank
@stop
@section('page-header')
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">ទំនិញ</span> - ពិនិត្យបញ្ជីទំនិញ
                </h4>
                <a href="#" class="ml-auto align-self-center text-default d-md-none" data-toggle="collapse"
                   data-target="#navbar-mobile-top-header"><i class="icon-more"></i></a>
            </div>
            <div class="navbar navbar-expand-md navbar-dark bg-teal-400">
                <div class="collapse navbar-collapse" id="navbar-mobile-top-header">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="{{route('product.index')}}"
                                                class="navbar-nav-link {{request()->is('product')? 'active':''}}"><i
                                        class="icon-list-numbered mr-2"></i> បញ្ជី</a></li>
                        <li class="nav-item"><a href="{{route('product.check')}}"
                                                class="navbar-nav-link {{request()->is('product-check')? 'active':''}}"><i
                                        class="icon-checkbox-checked mr-2"></i> ពិនិត្យទំនិញ</a></li>
                        <li class="nav-item"><a href="{{route('product.create')}}"
                                                class="navbar-nav-link {{request()->is('product/create')? 'active':''}}"><i
                                        class="icon-add mr-2"></i> បន្ថែមទំនិញ</a></li>
                        <li class="nav-item"><a href="{{route('stock.import.index')}}"
                                                class="navbar-nav-link {{request()->is('product-stock-import-index')? 'active':''}}"><i
                                        class="icon-add mr-2"></i> បន្ថែមស្តុក
                                <span class="badge badge-pill bg-warning ml-auto ml-md-0 stock-alert">0</span>
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('product.index')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>
                        ទំនិញ</a>
                    <span class="breadcrumb-item active">ពិនិត្យបញ្ជីទំនិញ</span>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-content')
    <!-- Scrollable datatable -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">បញ្ជីទំនិញ</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-sm table-striped datatable-scroll-y" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>ពិពណ៌នា</th>
                <th>ចំនួននៅសល់</th>
                <th>តម្លៃទិញ</th>
                <th>តម្លៃលក់</th>
                <th>ថ្ងៃខែឆ្នាំ</th>
            </tr>
            </thead>
        </table>
    </div>
    <!-- /scrollable datatable -->
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
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/tables/datatables/extensions/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{asset('js/pages/product/check.js')}}"></script>
@endpush