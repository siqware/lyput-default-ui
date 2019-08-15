@extends('dashboard.layout')
@section('page-title')
    Blank
@stop
@section('page-header')
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">ទំនិញ</span> - កែប្រែទំនិញ
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
                        <li class="nav-item"><a href="{{route('product.create')}}"
                                                class="navbar-nav-link {{request()->is('product/create')? 'active':''}}"><i
                                        class="icon-add mr-2"></i> បន្ថែមទំនិញ</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('product.index')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>
                        ទំនិញ</a>
                    <span class="breadcrumb-item active">កែប្រែទំនិញ</span>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-content')
    <!-- New Bulk Product -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">កែប្រែទំនិញ</h5>
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
        <form id="form-edit" method="post" action="{{route('product.update',$product[0]->id)}}" class="table-responsive">
            @csrf
            <input type="hidden" name="_method" value="put">
            <input type="hidden" name="pro_id" value="{{$product[0]->product->id}}">
            <table class="table table-bordered table-sm table-striped">
                <thead>
                <tr>
                    <th>ពិពណ៌នា</th>
                    <th>ចំនួន</th>
                    <th>តម្លៃទិញ</th>
                    <th>តម្លៃលក់</th>
                    <th>សរុប</th>
                </tr>
                </thead>
                <tbody id="pro-input-list">
                <tr>
                    <td>
                        <input name="desc" type="text" value="{{$product[0]->product->desc}}" class="form-control" placeholder="ពិពណ៌នា">
                    </td>
                    <td>
                        <input name="qty" id="qty" value="{{$product[0]->qty}}" type="number" min="1" step="any" class="form-control" placeholder="ចំនួន">
                    </td>
                    <td>
                        <input name="pur_price" id="purchase" value="{{$product[0]->pur_price}}" type="number" min="1" step="any" class="form-control" placeholder="តម្លៃទិញ">
                    </td>
                    <td>
                        <input name="sell_price" value="{{$product[0]->sell_price}}" id="sell" type="number" min="1" step="any" class="form-control" placeholder="តម្លៃលក់">
                    </td>
                    <td>
                        <input name="amount" readonly id="amount" type="number" min="1" step="any" class="form-control" placeholder="សរុប">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
        <form id="form-delete" class="row" method="post" action="{{route('product.destroy',$product[0]->id)}}">
            @csrf
            <input type="hidden" name="_method" value="delete">
            <div class="col-md-12">
                <button type="button" onclick="document.getElementById('form-edit').submit();" disabled id="btn-submit" class="btn btn-success m-2"><i class="icon-sync"></i> រក្សាទុក</button>
                <button id="sweet_combine" type="button" class="btn btn-warning"><i class="icon-database-remove ml-2"> លុប</i></button>
                <a href="{{route('product.index')}}" id="btn-submit" class="btn btn-info m-2"><i class="icon-backward"></i> ថយក្រោយ</a>
            </div>
        </form>
    </div>
    <!-- /New Bulk Product -->
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
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/notifications/sweet_alert.min.js')}}"></script>
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('js/pages/product/create.js')}}"></script>
    <script src="{{asset('js/pages/product/edit.js')}}"></script>
@endpush