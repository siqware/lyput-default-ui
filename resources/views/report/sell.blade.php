@extends('dashboard.layout')
@section('page-title')
    Blank
@stop
@section('page-header')
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">របាយការណ៍</span> - របាយការណ៍លក់
                </h4>
                <a href="#" class="ml-auto align-self-center text-default d-md-none" data-toggle="collapse"
                   data-target="#navbar-mobile-top-header"><i class="icon-more"></i></a>
            </div>

            <div class="navbar navbar-expand-md navbar-dark bg-teal-400">
                <div class="collapse navbar-collapse" id="navbar-mobile-top-header">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="{{route('buy')}}"
                                                class="navbar-nav-link {{request()->is('report-buy')? 'active':''}}"><i
                                        class="icon-graph mr-2"></i> ទិញ</a></li>
                        <li class="nav-item"><a href="{{route('sell')}}"
                                                class="navbar-nav-link {{request()->is('report-sell')? 'active':''}}"><i
                                        class="icon-graph mr-2"></i> លក់</a></li>
                        <li class="nav-item"><a href="{{route('inc.exp.index')}}"
                                                class="navbar-nav-link {{request()->is('report-income-expense-index')? 'active':''}}"><i
                                        class="icon-graph mr-2"></i> ថ្លៃឈ្នួល</a></li>
                        <li class="nav-item"><a href="{{route('report.budget.index')}}"
                                                class="navbar-nav-link {{request()->is('report-budget-index')? 'active':''}}"><i
                                        class="icon-graph mr-2"></i> ចំណូលចំណាយ</a></li>
                        <li class="nav-item"><a href="{{route('report.close.index')}}"
                                                class="navbar-nav-link {{request()->is('report-close-report-index')? 'active':''}}"><i
                                        class="icon-graph mr-2"></i> បិទបញ្ជី</a></li>


                    </ul>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('buy')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>
                        របាយការណ័</a>
                    <span class="breadcrumb-item active">របាយការណ៍លក់</span>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-content')
    <!-- Scrollable datatable -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">របាយការណ៍លក់</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{--btn toollbar--}}
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-toolbar">
                        <div class="btn-group mt-1">
                            <button id="btn-today" class="btn btn-light">ថ្ងៃនេះ</button>
                            <button id="btn-yesterday" class="btn btn-light">ម្សិលមិញ</button>
                            <button id="btn-last-7days" class="btn btn-light">ប្រាំពីថ្ងៃមុន</button>
                        </div>
                        <div class="btn-group mr-2 mt-1">
                            <button id="btn-last-30days" class="btn btn-light">សាមសិបថ្ងៃមុន</button>
                            <button id="btn-this-month" class="btn btn-light">ខែនេះ</button>
                            <button id="btn-last-month" class="btn btn-light">ខែមុន</button>
                        </div>
                        <div class="btn-group mt-1">
                            <button type="button" class="btn btn-light p-0">
                                <input type="date" id="start" class="form-control border-0">
                            </button>
                            <button type="button" class="btn btn-light p-0">
                                <input type="date" id="end" class="form-control border-0">
                            </button>
                            <button type="button" class="btn btn-success" id="btn-range">បង្ហាញ</button>
                        </div>
                    </div>
                </div>
            </div>
            {{--end btn toollbar--}}
            <div class="row mt-3">
                <div class="col-lg-3">
                    <!-- Members online -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <h3 class="font-weight-semibold mb-0 totalCount"></h3>
                            </div>

                            <div>
                                ចំនួនសរុប
                            </div>
                        </div>

                        <div class="container-fluid">
                            <div id="members-online"></div>
                        </div>
                    </div>
                    <!-- /members online -->

                </div>
                <div class="col-lg-3">
                    <!-- Members online -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <h3 class="font-weight-semibold mb-0 totalAmount"></h3>
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
                <div class="col-lg-3">
                    <!-- Members online -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <h3 class="font-weight-semibold mb-0 totalIncomeAmount"></h3>
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
        <table class="table table-bordered table-sm table-striped datatable-scroll-y" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>ពិពណ៌នា</th>
                <th>ចំនួន</th>
                <th>តម្លៃលក់សរុប</th>
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
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
    <script src="{{asset('js/pages/report/sell.js')}}"></script>
@endpush