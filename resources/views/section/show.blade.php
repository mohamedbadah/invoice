@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="col-xl-12">
        <a class="btn ripple btn-primary" data-target="#modaldemo1" data-toggle="modal" href="">View Demo</a>
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">SIMPLE TABLE</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <p class="tx-12 tx-gray-500 mb-2">Example of Valex Simple Table. <a href="">Learn more</a></p>
            </div>

            <div class=" tab-menu-heading" style="padding: 10px">
                <div class="tabs-menu1">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs main-nav-line">
                        <li><a href="#tab1" class="nav-link active" data-toggle="tab">القسم</a></li>
                        <li><a href="#tab2" class="nav-link" data-toggle="tab">تفاصيل الفاتورة</a></li>
                        <li><a href="#tab3" class="nav-link" data-toggle="tab">المرفقات</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body tabs-menu-body main-content-body-right border">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-md-nowrap" id="example1">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">#</th>
                                            <th class="wd-15p border-bottom-0">اسم القسم</th>
                                            <th class="wd-20p border-bottom-0">الوصف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $section->id }}</td>
                                            <td>{{ $section->section_name }}</td>
                                            <td>{{ $section->description }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-md-nowrap" id="example1">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">#</th>
                                            <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                            <th class="wd-20p border-bottom-0">المنتج</th>
                                            <th class="wd-20p border-bottom-0">الحالة</th>
                                            <th>مرفق</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($section->invoice_detail as $item)
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->invoice_number }}</td>
                                                <td>{{ $item->product }}</td>
                                                <td
                                                    class=" @if ($item->value_status == 0) text-success @else text-danger @endif ">
                                                    {{ $item->status }}</td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-md-nowrap" id="example1">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">#</th>
                                            <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                            <th class="wd-20p border-bottom-0">مدخل البيانات</th>
                                            <th class="wd-20p border-bottom-0">مرفق</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($section->attach as $item)
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->invoice_number }}</td>
                                                <td>{{ $item->created_by }}</td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
