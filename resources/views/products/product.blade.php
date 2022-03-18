@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    المنتجات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        @if (session()->has('update'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('update') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('addProduct'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('addProduct') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="col-xl-12">
            <a class="btn ripple btn-primary" data-target="#modaldemo1" data-toggle="modal" href="">اضافة منتج</a>
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
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">اسم المنتج</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->section->section_name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#update">
                                                تحديث
                                            </button>
                                            <button class="btn btn-danger"
                                                onclick="confirmDestroy({{ $product->id }},this)">حذف</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="modaldemo1">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Basic Modal</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <h6>اضافة قسم</h6>
                        <form action="{{ route('user.product.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="name_product" placeholder="ادخل اسم المنتج" class="form-control">
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="section_id">
                                    <option value="" seclected disabled>حد اسم القسم</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <textarea rows="4" placeholder="أدخل ملاحظات" class="form-control" cols="60"
                                    name="description"></textarea>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">Save changes</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form>
                        <div style="padding:10px" class="form-group">
                            <h2 style="padding: 10px;">تحديث البيانات</h2>
                        </div>
                        <div style="padding:10px" class="form-group">
                            <input value="{{ $product->product_name }}" id="product_update" type="text"
                                class="form-control" placeholder="عدل اسم المنتج">
                        </div>
                        <div class="form-group">
                            <select id="section_update" class="mr-10" style="padding:10px">
                                <option disabled>حدد القسم</option>
                                @foreach ($sections as $section)
                                    <option @if ($product->section_id == $section->id) selected @endif class="form-group"
                                        value="{{ $section->id }}">
                                        {{ $section->section_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input value="{{ $product->description }}" id="desc_update" type="text"
                                class="form-control" placeholder="تعديل الملاحظات">
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" onclick="update({{ $product->id }})" class="btn btn-primary">Save
                            changes</button>
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
        axios.delete('/user/product/' + id)
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

    function update(id) {
        axios.put('/user/product/' + id, {
                product_update: document.getElementById('product_update').value,
                section_update: document.getElementById('section_update').value,
                desc_update: document.getElementById('desc_update').value
            })
            .then(function(response) {
                console.log(response.data.message);
                window.location = "/user/product/"
            })
            .catch(function(error) {
                // handle error
                console.log(error);
                alert('فشل في التحديث')
            })
            .then(function() {
                // always executed
            });

    }
</script>
