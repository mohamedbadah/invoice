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
        @if (session()->has('delete'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('delete') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
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
                                <table style="width: 1000px" class="table text-md-nowrap" id="example1">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">#</th>
                                            <th class="wd-15p border-bottom-0">اسم القسم</th>
                                            <th class="wd-20p border-bottom-0">الوصف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $invoice->section->id }}</td>
                                            <td>{{ $invoice->section->section_name }}</td>
                                            <td>{{ $invoice->section->description }}</td>
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
                                            <th class="wd-20p border-bottom-0">اسم القسم</th>
                                            <th class="wd-20p border-bottom-0">الحالة</th>
                                            <th class="wd-20p border-bottom-0">الحالة</th>
                                            <th class="wd-20p border-bottom-0">تاريخ الاضافة</th>
                                            <th class="wd-20p border-bottom-0">ملاحظات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice_details as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->invoice_number }}</td>
                                                <td>{{ $item->product }}</td>
                                                <td>{{ $invoice->section->section_name }}</td>
                                                <td
                                                    class=" @if ($item->value_status == 0) text-danger @else text-success @endif ">
                                                    {{ $item->status }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->note }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session()->get('success') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#attach">
                            اضافة مرفق
                        </button>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-md-nowrap" id="example1">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">#</th>
                                            <th class="wd-15p border-bottom-0">اسم الملف</th>
                                            <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                            <th class="wd-20p border-bottom-0">مدخل البيانات</th>
                                            <th class="wd-20p border-bottom-0">التاريخ</th>
                                            <th class="wd-20p border-bottom-0">action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attach as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td id='file'>{{ $item->file_name }}</td>
                                                <td>{{ $item->invoice_number }}</td>
                                                <td>{{ $item->created_by }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td><a href="{{ route('user.view', $item->file_name) }}"
                                                        class="btn btn-outline-success btn-sm"> <i
                                                            class="fas fa-eye"></i></a>
                                                    <a href="{{ route('user.download', $item->file_name) }}"
                                                        class="btn btn-outline-info btn-sm"> <i
                                                            class="fas fa-download"></i></a>
                                                    <button type="button" class="btn btn-outline-info btn-sm"
                                                        onclick="confirmDestroy({{ $item->id }},this)">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="attach" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Modal
                                                                title</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('user.attach.store') }}" method="POST"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="col-sm-12 col-md-12">
                                                                    <input type="file" name="pic" class="dropify"
                                                                        accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                                        data-height="70" />
                                                                </div>
                                                                <input type="hidden" name="invoice_number2"
                                                                    value="{{ $item->invoice_number }}">
                                                                <input type="hidden" name="invoice_id2"
                                                                    value="{{ $item->invoice_id }}">
                                                                <div class="d-flex justify-content-center">
                                                                    <button type="submit" class="btn btn-primary">حفظ
                                                                        البيانات</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->
        <!-- Modal -->
    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDestroy(id, ref) {
        console.log(id);
        Swal.fire({
            title: 'هل متاكد من الحذف',
            text: "لن تتمكن من التراجع عن هذا!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                isDeleted(id, ref)
            }
        })
    }

    function isDeleted(id, ref) {
        axios.delete('/user/attach/' + id, {
                file: document.getElementById('file').value
            })
            .then(function(response) {
                showMessage(response.data);
                ref.closest('tr').remove();
                console.log(response);
            })
            .catch(function(error) {
                // handle error
                console.log(error);
            })
            .then(function() {
                // always executed
            });

    }

    function showMessage(data) {
        Swal.fire({
            title: data.title,
            icon: data.icon,
            text: data.text,
            showConfirmButton: false,
            timer: 1500
        })
    }
</script>
