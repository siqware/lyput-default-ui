@extends('dashboard.layout')
@section('page-title')
    Blank
@stop
@section('page-header')
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">ចំណូលចំណាយ</span>
                </h4>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('budget.index')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>
                        ចំណូលចំណាយ</a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-content')
    <!-- Form layouts -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">ចំណូលចំណាយ</h5>
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
                    <form class="col-md-5" method="post" {{request()->is('budget')? 'action='.route('budget.store').'':'action='.route('budget.update',$budget->id).''}}>
                        @csrf
                        @if(request()->is('budget/*/edit'))
                            <input type="hidden" name="_method" value="put">
                        @endif
                        <fieldset>
                            <legend class="font-weight-semibold"><i class="icon-cash mr-2"></i>
                                @if(request()->is('budget'))
                                    បន្ថែមចំណូល ឬចំណាយ
                                @else
                                    កែប្រែចំណូល ឬចំណាយ
                                @endif
                            </legend>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                        <tr>
                                            <th>ប្រភេទ</th>
                                            <th>ពិពណ៌នា</th>
                                            <th>តម្លៃ</th>
                                        </tr>
                                        </thead>
                                        <tbody class="budget-input-list">
                                        <tr>
                                            <td>
                                                <select name="budget[0][type]" class="form-control">
                                                    <option value="inc">ចំណូល</option>
                                                    <option value="exp">ចំណាយ</option>
                                                </select>
                                            </td>
                                            <td>
                                                @if(request()->is('budget'))
                                                    <input type="text" required name="budget[0][desc]" placeholder="ពិពណ៌នា" class="form-control ac-basic">
                                                @else
                                                    <input type="text" required name="budget[0][desc]" value="{{$budget->desc}}" placeholder="ពិពណ៌នា" class="form-control ac-basic">
                                                @endif
                                            </td>
                                            <td>
                                                @if(request()->is('budget'))
                                                    <input type="number" required min="0" step="any" name="budget[0][amount]" placeholder="តម្លៃ" class="form-control">
                                                @else
                                                    <input type="number" value="{{$budget->amount}}" required min="0" step="any" name="budget[0][amount]" placeholder="តម្លៃ" class="form-control">
                                                @endif
                                            </td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td colspan="2" class="text-right">
                                                <button type="button" class="btn btn-info btn-add-more"><i class="icon-add mr-2"></i> បន្ថែម</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="pl-0">
                                                <button type="submit" class="btn btn-success"><i class="icon-floppy-disk mr-2"></i> រក្សារទុក</button>
                                            </td>
                                            <td></td>
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
                                    <th>ពិពណ៌នា</th>
                                    <th>ចំណាយ</th>
                                    <th>ប្រភេទ</th>
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
    <script src="{{asset('js/pages/budget/index.js')}}"></script>
@endpush