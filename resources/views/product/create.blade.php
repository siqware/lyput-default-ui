@extends('dashboard.layout')
@section('page-title')
    Blank
@stop
@section('page-header')
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">ទំនិញ</span> - បន្ថែមទំនិញ
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
                    <span class="breadcrumb-item active">បន្ថែមទំនិញ</span>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-content')
    <!-- New Bulk Product -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">បន្ថែមទំនិញ</h5>
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
        </div>
        <form method="post" action="{{route('product.store')}}" class="table-responsive">
            @csrf
            <table class="table table-bordered table-sm table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>ពិពណ៌នា</th>
                    <th>ចំនួន</th>
                    <th>តម្លៃទិញ</th>
                    <th>តម្លៃលក់</th>
                    <th>សរុប</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="pro-input-list">
                <tr>
                    <td class="text-center">0</td>
                    <td>
                        <input type="text" placeholder="ពិពណ៌នា" name="product[0][desc]" class="form-control ac-basic">
                    </td>
                    <td>
                        <input name="product[0][qty]" id="qty" type="number" min="0" step="any" class="form-control" placeholder="ចំនួន">
                    </td>
                    <td>
                        <input name="product[0][pur_price]" id="purchase" type="number" min="0" step="any" class="form-control" placeholder="តម្លៃទិញ">
                    </td>
                    <td>
                        <input name="product[0][sell_price]" id="sell" type="number" min="0" step="any" class="form-control" placeholder="តម្លៃលក់">
                    </td>
                    <td>
                        <input name="product[0][amount]" readonly id="amount" type="number" min="0" step="any" class="form-control" placeholder="សរុប">
                    </td>
                    <td>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">
                        សរុប
                    </td>
                    <td>
                        <input name="total" id="total" readonly type="number" min="0" step="any" class="form-control" placeholder="សរុប">
                    </td>
                    <td>
                        <button type="button" id="btn-add-more" class="btn btn-info"><i class="icon-add"></i> បន្ថែម</button>
                    </td>
                </tr>
                </tfoot>
            </table>
            <button type="submit" disabled id="btn-submit" class="btn btn-success m-2"><i class="icon-floppy-disk mr-2"></i> រក្សាទុក</button>
        </form>
    </div>
    <!-- /New Bulk Product -->
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
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/extensions/jquery_ui/widgets.min.js')}}"></script>
    <script src="{{asset('js/pages/product/create.js')}}"></script>
@endpush