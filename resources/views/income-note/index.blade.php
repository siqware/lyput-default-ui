@extends('dashboard.layout')
@section('page-title')
    Blank
@stop
@section('page-header')
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">បន្ថែមថ្លៃឈ្នួល</span>
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
                    <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>
                        បន្ថែមថ្លៃឈ្នួល</a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-content')
    <!-- Form layouts -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">បន្ថែមថ្លៃឈ្នួល</h5>
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
                    <form class="col-md-5" method="post" {{request()->is('invoice-income-note-index')? 'action='.route('income.note.store').'':'action='.route('income.note.update',$income_note->id).''}}>
                        @csrf
                        @if(request()->is('invoice-income-note/*/edit'))
                            <input type="hidden" name="_method" value="put">
                        @endif
                        <fieldset>
                            <legend class="font-weight-semibold"><i class="icon-cash mr-2"></i>
                                @if(request()->is('invoice-income-note-index'))
                                    បន្ថែមថ្លៃឈ្នួល
                                @else
                                    កែប្រែថ្លៃឈ្នួល
                                @endif
                            </legend>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                        <tr>
                                            <th>វិក័យបត្រ</th>
                                            <th>តម្លៃ</th>
                                        </tr>
                                        </thead>
                                        <tbody class="budget-input-list">
                                        <tr>
                                            <td>
                                                <input readonly type="text" name="income_note[0][invoice]" class="form-control" value="0">
                                            </td>
                                            <td>
                                                @if(request()->is('invoice-income-note-index'))
                                                    <input type="number" required min="0" step="any" name="income_note[0][amount]" placeholder="តម្លៃ" class="form-control">
                                                @else
                                                    <input type="number" value="{{$income_note->amount}}" required min="0" step="any" name="income_note[0][amount]" placeholder="តម្លៃ" class="form-control">
                                                @endif
                                            </td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td></td>
                                            <td colspan="2" class="text-right">
                                                @if(!request()->is('invoice-income-note/*/edit'))
                                                <button type="button" class="btn btn-info btn-add-more"><i class="icon-add mr-2"></i> បន្ថែម</button>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="pl-0">
                                                <button type="submit" class="btn btn-success"><i class="icon-floppy-disk mr-2"></i> រក្សារទុក</button>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        </tfoot>
                                    </table>
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
                                    <th>តម្លៃ</th>
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
    <script src="{{asset('dashboard-ui/global_assets/js/plugins/extensions/jquery_ui/widgets.min.js')}}"></script>
    <script src="{{asset('js/pages/income-note/index.js')}}"></script>
@endpush