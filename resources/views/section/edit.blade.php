@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-12" style="margin-top:200px">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('user.section.update', $data->id) }}" method="POST" )>
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <input type="text" name="name_update" class="form-control" value="{{ $data->section_name }}">
                    </div>
                    {{-- <div class="form-group">
                        <input type="text" name="disc" class="form-control" value="{{ $data->description }}">
                    </div> --}}
                    <div class="form-group">
                        <textarea placeholder="أدخل ملاحظات" class="form-control"
                            name="disc">{{ $data->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="update" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
@endsection
