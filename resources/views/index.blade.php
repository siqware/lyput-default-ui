@extends('dashboard.layout')
@section('page-title')
    ផ្ទាំងដើម
@stop
@section('page-header')
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">ផ្ទាំងដើម</span></h4>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> ផ្ទាំងដើម</a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-content')
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">សរុបទំនិញទិញចូល</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <!-- Members online -->
                            <div class="card bg-teal-300">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0 totalRecord">0</h3>
                                    </div>

                                    <div>
                                       សរុបមុខទំនិញក្នុងស្តុក
                                    </div>
                                </div>

                                <div class="container-fluid">
                                    <div id="members-online"></div>
                                </div>
                            </div>
                            <!-- /members online -->

                        </div>
                        <div class="col-md-4">
                            <!-- Members online -->
                            <div class="card bg-teal-300">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0 totalCount">0</h3>
                                    </div>

                                    <div>
                                        សរុបចំនួនទំនិញក្នុងស្តុក
                                    </div>
                                </div>

                                <div class="container-fluid">
                                    <div id="members-online"></div>
                                </div>
                            </div>
                            <!-- /members online -->

                        </div>
                        <div class="col-md-4">
                            <!-- Members online -->
                            <div class="card bg-pink-300">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0 totalAmount">$0.00</h3>
                                    </div>

                                    <div>
                                        តម្លៃលក់សរុប
                                    </div>
                                </div>

                                <div class="container-fluid">
                                    <div id="members-online"></div>
                                </div>
                            </div>
                            <!-- /members online -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">សរុបទំនិញលក់ចេញ</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <!-- Members online -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0 sell_stock_qty"></h3>
                                    </div>

                                    <div>
                                        សរុបមុខទំនិញលក់
                                    </div>
                                </div>

                                <div class="container-fluid">
                                    <div id="members-online"></div>
                                </div>
                            </div>
                            <!-- /members online -->

                        </div>
                        <div class="col-md-3">
                            <!-- Members online -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0 sellTotalCount"></h3>
                                    </div>

                                    <div>
                                        សរុបចំនួនទំនិញលក់
                                    </div>
                                </div>

                                <div class="container-fluid">
                                    <div id="members-online"></div>
                                </div>
                            </div>
                            <!-- /members online -->

                        </div>
                        <div class="col-md-3">
                            <!-- Members online -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0 sellTotalAmount"></h3>
                                    </div>

                                    <div>
                                        តម្លៃលក់សរុប
                                    </div>
                                </div>

                                <div class="container-fluid">
                                    <div id="members-online"></div>
                                </div>
                            </div>
                            <!-- /members online -->

                        </div>
                        <div class="col-md-3">
                            <!-- Members online -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0 sellTotalIncomeAmount"></h3>
                                    </div>

                                    <div>
                                        ចំណេញពីការលក់សរុប
                                    </div>
                                </div>

                                <div class="container-fluid">
                                    <div id="members-online"></div>
                                </div>
                            </div>
                            <!-- /members online -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic columns -->
    {{--<div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Basic columns</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload"></a>
                    <a class="list-icons-item" data-action="remove"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="chart-container">
                <div class="chart has-fixed-height" id="columns_basic"></div>
            </div>
        </div>
    </div>--}}
    <!-- /basic columns -->
@stop
@section('page-script')
    @routes
    <script>
        console.log('app started')
    </script>
@stop
@section('page-style')
    <style>
        body{
            /*color: red;*/
        }
    </style>
@stop
@push('page-js')
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/visualization/echarts/echarts.min.js')}}"></script>
    <script src="{{asset('js/pages/dashboard/index.js')}}"></script>
@endpush
