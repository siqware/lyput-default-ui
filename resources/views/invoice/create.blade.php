@extends('dashboard.layout')
@section('page-title')
    Blank
@stop
@section('page-header')
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">វិក័យប័ត្រ</span> - កត់វិក័យប័ត្រ
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
                    </ul>
                </div>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('product.index')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>
                        វិក័យប័ត្រ</a>
                    <span class="breadcrumb-item active">កត់វិក័យប័ត្រ</span>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-content')
    <!-- New Bulk Product -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">កត់វិក័យប័ត្រ</h5>
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
        <form method="post" action="{{route('invoice.store')}}" class="table-responsive">
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
                        <select data-placeholder="កត់ទំនិញចូល" name="product[0][id]" class="form-control form-control-select2" data-fouc></select>
                    </td>
                    <td>
                        <input name="product[0][qty]" id="qty" value="1" type="number" min="1" step="any" class="form-control" placeholder="ចំនួន">
                    </td>
                    <td>
                        <input name="product[0][pur_price]" readonly id="purchase" value="1" type="number" min="1" step="any" class="form-control" placeholder="តម្លៃទិញ">
                    </td>
                    <td>
                        <input name="product[0][sell_price]" id="sell" value="1" type="number" min="1" step="any" class="form-control" placeholder="តម្លៃលក់">
                    </td>
                    <td>
                        <input name="product[0][amount]" readonly id="amount" value="1" type="number" min="1" step="any" class="form-control" placeholder="សរុប">
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
                        ថ្លៃឈ្នួល
                    </td>
                    <td>
                        <input name="income_note" id="amount" value="0" type="number" min="1" step="any" class="form-control" placeholder="សរុប">
                    </td>
                    <td>
                        <button type="button" id="btn-add-more" class="btn btn-info"><i class="icon-add"></i> បន្ថែម</button>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">
                        សរុប
                    </td>
                    <td>
                        <input name="total" id="total" readonly type="number" min="1" step="any" class="form-control" placeholder="សរុប">
                    </td>
                    <td>
                    </td>
                </tr>
                </tfoot>
            </table>
            <button type="submit" disabled id="btn-submit" class="btn btn-success m-2"><i class="icon-add-to-list"></i> បន្ថែទំនិញ</button>
        </form>
    </div>
    <!-- /New Bulk Product -->
@stop
@section('page-script')
    @routes
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
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