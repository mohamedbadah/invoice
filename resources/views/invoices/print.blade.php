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
    @media print {
        #print_Button {
            display: none;
        }

    }

    .dropdown .del {
        text-align: center;
        background-color: rgb(243, 49, 49);
    }

    .dropdown .del:hover {
        background-color: rgb(243, 49, 49);
        color: #Fff;
        text-align: center;
    }

    .dropdown .archive {
        background-color: #00F;
        color: #Fff;
        text-align: center;
    }

</style>
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">طباعة فاتورة</h4>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-md-12" id="print">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 mg-t-20">
                            <h1 class="text-danger">فاتورة تحصيل</h1>
                        </div>
                        <div class="col-md-7 mg-t-20">
                            <h2 class="text-center text-success"> شركة بدح لتسديد الفواتير </h2>
                            <h4 class="text-danger">:تاريخ طباعة الفاتورة <?php echo date('l jS \of F Y h:i:s A'); ?></h4>
                            <p class="text-center">:من قام بطباعة الفاتورة <span
                                    class="text-primary">{{ $invoice->invoice_detail->user }}</span></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="text-danger">معلومات الفاتورة</h3>
                            <p>
                                <span style="margin-left:50%">رقم الفاتورة</span>
                                <span>{{ $invoice->invoice_nubmer }}</span>
                            </p>
                            <hr>
                            <p>
                                <span style="margin-left:50%">تاريخ الاصدار</span>
                                <span>{{ $invoice->invoice_Date }}</span>
                            </p>
                            <hr>
                            <p>
                                <span style="margin-left:50%">تاريخ الاستحقاق</span>
                                <span>{{ $invoice->due_date }}</span>
                            </p>
                            <hr>
                            <p>
                                <span style="margin-left:50%">القسم</span>
                                <span>{{ $invoice->section->section_name }}</span>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">#</th>
                                        <th class="wd-40p">المنتج</th>
                                        <th class="tx-center">مبلغ التحصيل</th>
                                        <th class="tx-right">مبلغ العمولة</th>
                                        <th class="tx-right">الاجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td class="tx-12">{{ $invoice->product }}</td>
                                        <td class="text-center">{{ number_format($invoice->Amount_collection, 2) }}
                                        </td>
                                        <td>{{ number_format($invoice->Amount_commission, 2) }}
                                        </td>
                                        <?php $total = $invoice->Amount_collection + $invoice->Amount_commission; ?>
                                        <td>
                                            {{ number_format($total, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" scope="row">2</th>
                                        <td>نسبة الضريبة ({{ $invoice->rate_vat }})</td>
                                        <td>{{ $invoice->value_vat }}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" scope="row">3</th>
                                        <td>قيمة الخصم</td>
                                        <td>{{ $invoice->discount }}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" scope="row">4</th>
                                        <td>الاجمالي شامل الضريبة</td>
                                        <td>{{ $invoice->total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button class="btn btn-danger  float-left mt-3 mr-2" id="print_Button" onclick="printDiv()"> <i
                            class="mdi mdi-printer ml-1"></i>طباعة</button>
                </div>
            </div>
        </div>
    </div>
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
@endsection
<script>
    function printDiv() {
        var prints = document.getElementById('print').innerHTML;
        document.body.innerHTML = prints;
        window.print();
    }
</script>
