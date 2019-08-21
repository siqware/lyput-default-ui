@extends('dashboard.layout')
@section('page-title')
    Blank
@stop
@section('page-header')
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">វិក័យប័ត្រ</span> - កែប្រែ
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
                    <span class="breadcrumb-item active">កែប្រែ</span>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-content')
    <!-- New Bulk Product -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">កែប្រែតម្លៃលក់</h5>
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
        <form method="post" action="{{route('invoice.update',$invoice_detail[0]->id)}}" class="table-responsive">
            @csrf
            <input type="hidden" name="_method" value="put">
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
                        <input type="text" class="form-control" readonly value="{{$invoice_detail[0]->stock_detail->product->desc}}">
                    </td>
                    <td>
                        <input name="qty" id="qty" readonly value="{{$invoice_detail[0]->qty}}" type="number" min="0" step="any" class="form-control" placeholder="ចំនួន">
                    </td>
                    <td>
                        <input readonly id="purchase" value="{{$invoice_detail[0]->stock_detail->pur_price}}" type="number" min="0" step="any" class="form-control" placeholder="តម្លៃទិញ">
                    </td>
                    <td>
                        <input id="sell" value="{{$invoice_detail[0]->amount/$invoice_detail[0]->qty}}" type="number" min="0" step="any" class="form-control" placeholder="តម្លៃលក់">
                    </td>
                    <td>
                        <input name="amount" readonly id="amount" value="{{$invoice_detail[0]->amount}}" type="number" min="0" step="any" class="form-control" placeholder="សរុប">
                    </td>
                    <td>
                    </td>
                </tr>
                </tbody>
            </table>
            <button type="submit" disabled id="btn-submit" class="btn btn-success m-2"><i class="icon-sync"></i> កែប្រែ</button>
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
    <script src="{{asset('js/pages/product/invoice.js')}}"></script>
@endpush