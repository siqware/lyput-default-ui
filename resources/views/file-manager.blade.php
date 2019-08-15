@extends('dashboard.layout')
@section('page-title')
    File Manager
@stop
@section('page-header')
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - File Manager</h4>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">File Manager</span>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-content')
    <!-- Basic card -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">File Manager</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="embed-responsive embed-responsive-1by1">
                <iframe class="embed-responsive-item" src="laravel-filemanager"></iframe>
            </div>
        </div>
    </div>
    <!-- /basic card -->
@stop
@section('page-script')
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
