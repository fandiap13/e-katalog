@extends('template.layout_admin')

@push('styles')
    <link href="{{ asset('adminlte/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('adminlte/plugins/bootstrap-fileinput/themes/explorer-fas/theme.min.css') }}" rel="stylesheet">
@endpush

@section('header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection

@section('main')
    <div class="container-fluid">
        <form action="{{ route('admin.users.store') }}" method="POST" id="form" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">

                            </h5>

                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a class="btn btn-default" href="{{ url()->previous() }}"><i
                                                class="fa fa-undo"></i></a>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i></button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible mb-3">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">E-mail <b
                                        class="text-danger">*</b></label>
                                <div class="col-sm-6 controls">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="E-mail" value="{{ old('email') }}" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label">Password <b
                                        class="text-danger">*</b></label>
                                <div class="col-sm-6 controls">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="retype_password" class="col-sm-2 col-form-label">Retype Password <b
                                        class="text-danger">*</b></label>
                                <div class="col-sm-6 controls">
                                    <input type="password" class="form-control" id="retype_password" name="retype_password"
                                        placeholder="Retype password" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama <b
                                        class="text-danger">*</b></label>
                                <div class="col-sm-6 controls">
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Nama" value="{{ old('nama') }}" required />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </form>
    </div><!-- /.container-fluid -->
@endsection

@push('scripts')
    <script src="{{ asset('adminlte/plugins/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap-fileinput/themes/explorer-fas/theme.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#form').validate({
                rules: {
                    retype_password: {
                        equalTo: "#password"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    if (element.is(':file')) {
                        error.insertAfter(element.parent().parent().parent());
                    } else
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else
                    if (element.attr('type') == 'checkbox') {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    $("#form").find("button[type=submit]").attr('disabled', true).html(
                        "<i class='fa fa-spin fa-sync-alt'></i>");
                    form.submit();
                }
            });
        });
    </script>
@endpush
