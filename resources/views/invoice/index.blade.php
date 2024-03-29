@extends('dashboard.layout')
@section('page-title')
    Blank
@stop
@section('page-header')
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">វិក័យប័ត្រ</span> - បញ្ជីវិក័យប័ត្រ
                </h4>
                <a href="#" class="ml-auto align-self-center text-default d-md-none" data-toggle="collapse"
                   data-target="#navbar-mobile-top-header"><i class="icon-more"></i></a>
            </div>

            <div class="navbar navbar-expand-md navbar-dark bg-teal-400">
                <div class="collapse navbar-collapse" id="navbar-mobile-top-header">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="{{route('invoice.index')}}"
                                                class="navbar-nav-link {{request()->is('invoice')? 'active':''}}"><i
                                        class="icon-list-numbered mr-2"></i> បញ្ជី</a></li>
                        <li class="nav-item"><a href="{{route('invoice.create')}}"
                                                class="navbar-nav-link {{request()->is('invoice/create')? 'active':''}}"><i
                                        class="icon-pencil mr-2"></i> កត់វិក័យប័ត្រ</a></li>
                        <li class="nav-item"><a href="{{route('income.note.index')}}"
                                                class="navbar-nav-link {{request()->is('invoice-income-note*')? 'active':''}}"><i
                                        class="icon-pencil mr-2"></i> កត់ថ្លៃឈ្នួល</a></li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('product.index')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>
                        វិក័យប័ត្រ</a>
                    <span class="breadcrumb-item active">បញ្ជីវិក័យប័ត្រ</span>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-content')
    <!-- Scrollable datatable -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">បញ្ជីវិក័យប័ត្រ</h5>
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
                <th>ចំនួន</th>
                <th>តម្លៃលក់សរុប</th>
                <th>ថ្ងៃខែឆ្នាំ</th>
                <th></th>
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
    <script src="{{asset('js/pages/product/invoice_index.js')}}"></script>
@endpush