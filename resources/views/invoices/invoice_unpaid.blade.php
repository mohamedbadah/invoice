@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
<style>
    .dropdown .del,
    .dropdown .up,
    .dropdown .updateState {
        text-align: center;
    }

    .dropdown .up:hover {
        background-color: rgb(48, 166, 221);
        color: #Fff;
        text-align: center;
    }

    .dropdown .del:hover {
        background-color: rgb(243, 49, 49);
        color: #Fff;
        text-align: center;
    }

    .dropdown .updateState:hover {
        background-color: rgb(94, 243, 35);
        color: #Fff;
        text-align: center;
    }

</style>
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمة الفواتير الغير مدفوعة</h4>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            @if (session()->has('delete'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session()->get('delete') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="col-xl-12">
                @if (session()->has('update_status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session()->get('update_status') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <a class="btn btn-primary" href="{{ route('user.invoices.create') }}">اضافة</a>
                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Bordered Table</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                        </div>
                        <p class="tx-12 tx-gray-500 mb-2">Example of Valex Bordered Table.. <a href="">Learn more</a></p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table key-buttons text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>رقم الفاتورة</th>
                                        <th>تاريخ الفاتورة</th>
                                        <th>تاريخ الاستحقاق</th>
                                        <th>المنتج</th>
                                        <th>القسم</th>
                                        <th>الخصم</th>
                                        <th>نسبة الضريبة</th>
                                        <th>قيمة الضريبة</th>
                                        <th>الاجمالي</th>
                                        <th>الحالة</th>
                                        <th>ملاحظات</th>
                                        <th>العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td>{{ 5 * $current + $c }}</td>
                                            <td>{{ $invoice->invoice_nubmer }}</td>
                                            <td>{{ $invoice->invoice_Date }}</td>
                                            <td>{{ $invoice->due_date }}</td>
                                            <td>{{ $invoice->product }}</td>
                                            {{-- {{ route('user.section.show', $invoice->section_id) }} --}}
                                            {{-- {{ route('user.invoices.show', $invoice->id) }} --}}
                                            <td><a
                                                    href="{{ route('user.invoices.show', $invoice->id) }}">{{ $invoice->section->section_name }}</a>
                                            </td>
                                            <td>{{ $invoice->discount }}</td>
                                            <td>{{ $invoice->rate_vat }}</td>
                                            <td>{{ $invoice->value_vat }}</td>
                                            <td>{{ $invoice->total }}</td>
                                            <td>
                                                @if ($invoice->value_status == 0)
                                                    <span class="text-danger">{{ $invoice->status }}</span>
                                                @elseif ($invoice->value_status == 1)
                                                    <span class="text-success">{{ $invoice->status }}</span>
                                                @else
                                                    <span class="text-warning">{{ $invoice->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ substr($invoice->note, 0, 6) }}...</td>
                                            <td>
                                                <div class="dropdown dop">
                                                    <button aria-expanded="false" aria-haspopup="true"
                                                        class="btn ripple btn-primary" data-toggle="dropdown"
                                                        id="dropdownMenuButton" type="button">العمليات<i
                                                            class="fas fa-caret-down ml-1"></i></button>
                                                    <div class="dropdown-menu tx-13">
                                                        <a href="{{ route('user.invoices.edit', $invoice->id) }}"
                                                            class="btn btn-info dropdown-item up">تحديث</a>
                                                        <button type="button" class=" del dropdown-item" data-toggle="modal"
                                                            data-target="#delete" id="del"
                                                            data-invoice_id="{{ $invoice->id }}">
                                                            حذف
                                                        </button>
                                                        <a class="updateState dropdown-item"
                                                            href="{{ route('user.edit_status', $invoice->id) }}" }> تحديث
                                                            حالة
                                                            الدفع</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <?php $c++; ?>
                                            <div class="modal fade" id="delete" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Modal title
                                                            </h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('user.invoices.destroy', 'mohamed') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal-body">
                                                                {{-- هل متاكد من الحذف{{ $invoice->id }} --}}
                                                                <input type=text name="invoice_id" id="invoice_id"
                                                                    value=" ">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">تاكيد
                                                                    الحذف</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $invoices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script>
        $('#delete').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        });
    </script>
@endsection
