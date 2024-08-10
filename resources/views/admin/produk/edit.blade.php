@extends('template.layout_admin')

@push('styles')
    <link href="{{ asset('adminlte/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('adminlte/plugins/bootstrap-fileinput/themes/explorer-fas/theme.min.css') }}" rel="stylesheet">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <style>
        .image-preview {
            width: 100%;
            height: 200px;
            border: 2px solid #dddddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            color: #cccccc;
            margin-bottom: 10px;
        }

        .image-preview__image {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: contain;
        }

        .image-preview__default-text {
            display: none;
            font-size: 16px;
            color: #dddddd;
        }
    </style>
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

        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" id="form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">
                                Edit Data <strong>{{ $produk->nama }}</strong>
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
                                <label for="nama" class="col-sm-2 col-form-label">Nama Produk <b
                                        class="text-danger">*</b></label>
                                <div class="col-sm-6 controls">
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Nama" value="{{ old('nama', $produk->nama) }}" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="harga" class="col-sm-2 col-form-label">Harga Produk (Rp) <b
                                        class="text-danger">*</b></label>
                                <div class="col-sm-6 controls">
                                    <input type="number" class="form-control" id="harga" name="harga"
                                        placeholder="Harga" value="{{ old('harga', $produk->harga) }}" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="kategori" class="col-sm-2 col-form-label">Kategori Produk <b
                                        class="text-danger">*</b></label>
                                <div class="col-sm-6 controls">
                                    <button type="button" class="btn btn-sm btn-secondary"
                                        onclick="showModalKategori();">Pilih Kategori</button>
                                    <div><strong>Kategori dipilih:</strong> <span class="kategori_dipilih">
                                            @if ($produk->kategori->parent_id == null)
                                                {{ $produk->kategori_id ? $produk->kategori->nama : 'Belum dipilih' }}
                                            @else
                                                {{ $produk->kategori_id ? $produk->kategori->parentKategori->nama . '->' . $produk->kategori->nama : 'Belum dipilih' }}
                                            @endif
                                        </span>
                                    </div>
                                    <input type="hidden" class="form-control" id="kategori_id" name="kategori"
                                        value="{{ old('kategori', $produk->kategori_id) }}" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="brand" class="col-sm-2 col-form-label">Brand Produk <b
                                        class="text-danger">*</b></label>
                                <div class="col-sm-6 controls">
                                    <select class="form-control select2" name="brand_id" id="brand_id" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($brand as $b)
                                            <option value="{{ $b->id }}"
                                                {{ old('brand_id', $produk->brand_id) == $b->id ? 'selected' : '' }}>
                                                {{ $b->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="keterangan" class="col-sm-2 col-form-label">Deskripsi Produk <b
                                        class="text-danger">*</b></label>
                                <div class="col-sm-6 controls">
                                    <textarea class="form-control" rows="5" id="keterangan" name="keterangan" placeholder="Deskripsi Produk" required>{{ old('keterangan', $produk->keterangan) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.row -->

            <!-- /.col-md-6 -->
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title">
                            Kelola Variasi Produk <strong>{{ $produk->nama }}</strong>
                        </h5>
                    </div>
                    <div class="card-body">

                    </div>
                    <div class="overlay d-none">
                        <i class="fa fa-2x fa-sync-alt fa-spin"></i>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->

            <!-- /.col-md-6 -->
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title">
                            Kelola Gambar <strong>{{ $produk->nama }}</strong>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="gambar" class="col-sm-2 col-form-label">Gambar Utama</label>
                            <div class="col-sm-6">
                                <div class="image-preview" id="imagePreview1">
                                    <img src="{{ $produk->gambar ? asset($produk->gambar) : asset('assets/img/no-image.png') }}"
                                        alt="Preview" class="image-preview__image" />
                                    <span class="image-preview__default-text">Preview Gambar 1</span>
                                </div>
                                <input type="file" class="form-control-file" id="gambar" name="gambar"
                                    accept="image/*" onchange="previewImage(this, 'imagePreview1')" required>
                                {{-- <button type="button" class="btn btn-sm btn-danger mt-2"
                                        onclick="removeImage('gambar', 'imagePreview1')">Clear Preview</button> --}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gambar_2" class="col-sm-2 col-form-label">Gambar 2</label>
                            <div class="col-sm-6">
                                <div class="image-preview" id="imagePreview2">
                                    <img src="{{ $produk->gambar_2 ? asset($produk->gambar_2) : asset('assets/img/no-image.png') }}"
                                        alt="Preview" class="image-preview__image" />
                                    <span class="image-preview__default-text">Preview Gambar 2</span>
                                </div>
                                <input type="file" class="form-control-file" id="gambar_2" name="gambar_2"
                                    accept="image/*" onchange="previewImage(this, 'imagePreview2')" required>
                                {{-- <button type="button" class="btn btn-sm btn-danger mt-2"
                                        onclick="removeImage('gambar_2', 'imagePreview2')">Clear Preview</button> --}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gambar_3" class="col-sm-2 col-form-label">Gambar 3</label>
                            <div class="col-sm-6">
                                <div class="image-preview" id="imagePreview3">
                                    <img src="{{ $produk->gambar_3 ? asset($produk->gambar_3) : asset('assets/img/no-image.png') }}"
                                        alt="Preview" class="image-preview__image" />
                                    <span class="image-preview__default-text">Preview Gambar 3</span>
                                </div>
                                <input type="file" class="form-control-file" id="gambar_3" name="gambar_3"
                                    accept="image/*" onchange="previewImage(this, 'imagePreview3')" required>
                                {{-- <button type="button" class="btn btn-sm btn-danger mt-2"
                                        onclick="removeImage('gambar_3', 'imagePreview3')">Clear Preview</button> --}}
                            </div>
                        </div>

                    </div>
                    <div class="overlay d-none">
                        <i class="fa fa-2x fa-sync-alt fa-spin"></i>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
    </div><!-- /.container-fluid -->

    <!-- Modal Kategori -->
    <div class="modal fade" id="modal-kategori" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Kategori</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 border">
                            <ul style="list-style: none">
                                @foreach ($kategori as $k)
                                    <li class="my-2">
                                        <a href="#"
                                            onclick="handleShowChild('{{ $k->id }}','{{ $k->nama }}')"
                                            class="font-weight-bold text-dark">
                                            <div class="d-flex justify-content-start align-items-center"
                                                style="gap: 10px">
                                                <div>{{ $k->nama }}</div>
                                                <div>{!! count($k->subkategori) > 0 ? '<i class="fas fa-arrow-right"></i>' : '' !!}</div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-6 childkategori border"></div>
                    </div>

                    <hr>

                    <div>Kategori yang dipilih: <span
                            class="kategori_dipilih font-weight-bold mt-3">{{ $kategoriDipilih ?? '' }}</span></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('adminlte/plugins/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap-fileinput/themes/explorer-fas/theme.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        function previewImage(input, previewId) {
            const previewContainer = document.getElementById(previewId);
            const previewImage = previewContainer.querySelector('.image-preview__image');
            const previewDefaultText = previewContainer.querySelector('.image-preview__default-text');

            const file = input.files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function() {
                previewDefaultText.style.display = "none";
                previewImage.style.display = "block";
                previewImage.src = this.result;

                const the_type = input.name;

                const formData = new FormData();
                formData.append("gambar", file);
                formData.append("type", input.name);
                formData.append("produk_id", "{{ $produk->id }}");
                formData.append("_token", "{{ csrf_token() }}");

                $.ajax({
                    url: '{{ url('admin/produk/uploadgambar') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.overlay').removeClass('d-none');
                    }
                }).done(function(response) {
                    $('.overlay').addClass('d-none');
                    if (response.status) {
                        $.gritter.add({
                            title: 'Success!',
                            text: response.message,
                            class_name: 'gritter-success',
                            time: 5000,
                        });
                        location.reload();
                    } else {
                        $.gritter.add({
                            title: 'Warning!',
                            text: response.message,
                            class_name: 'gritter-warning',
                            time: 5000,
                        });
                    }
                }).fail(function(response) {
                    var response = response.responseJSON;
                    $('.overlay').addClass('d-none');
                    $.gritter.add({
                        title: 'Error!',
                        text: response.message ? response.message :
                            'Terdapat kesalahan pada sistem!',
                        class_name: 'gritter-error',
                        time: 5000,
                    });

                    // // Reset image preview
                    // previewImage.style.display = "none";
                    // previewDefaultText.style.display = "block";
                    let imagePath = `{{ asset('assets/img/no-image.png') }}`; // Default image

                    if (the_type === 'gambar') {
                        imagePath =
                            `{{ isset($produk->gambar) && $produk->gambar ? asset($produk->gambar) : asset('assets/img/no-image.png') }}`;
                    } else if (the_type === 'gambar_2') {
                        imagePath =
                            `{{ isset($produk->gambar_2) && $produk->gambar_2 ? asset($produk->gambar_2) : asset('assets/img/no-image.png') }}`;
                    } else if (the_type === 'gambar_3') {
                        imagePath =
                            `{{ isset($produk->gambar_3) && $produk->gambar_3 ? asset($produk->gambar_3) : asset('assets/img/no-image.png') }}`;
                    }

                    previewImage.src = imagePath;

                });
            });

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        function removeImage(inputId, previewId) {
            const input = document.getElementById(inputId);
            const previewContainer = document.getElementById(previewId);
            const previewImage = previewContainer.querySelector('.image-preview__image');
            const previewDefaultText = previewContainer.querySelector('.image-preview__default-text');

            // Reset the input field
            input.value = '';

            // Reset the preview
            previewImage.style.display = "none";
            previewImage.src = "";
            previewDefaultText.style.display = "block";
        }

        function showModalKategori() {
            $("#modal-kategori").modal("show");
        }

        function selectKategori(id, name) {
            $(".kategori_dipilih").html(name);
            $("#kategori_id").val(id);
        }

        function selectSubKategori(id, name) {
            $(".kategori_dipilih").append(`->${name}`);
            $("#kategori_id").val(id);
        }

        function handleShowChild(id, name) {
            $.ajax({
                type: "get",
                url: "{{ url('/admin/kategori/showsubkategori') }}/" + id,
                dataType: "json",
                success: function(response) {
                    if (response.data.length > 0) {
                        let showkategori = "";
                        response.data.forEach(element => {
                            showkategori += `<li class="my-2">
                                <a href="#" class="font-weight-bold text-dark" onClick='selectSubKategori("${element.id}","${element.nama}")'>
                                    <div class="d-flex justify-content-start align-items-center" style="gap: 10px">
                                        <div>${element.nama}</div>
                                    </div>
                                </a>
                            </li>`;
                        });
                        $(".childkategori").html(`<ul style="list-style: none">${showkategori}</ul>`);
                        // pilih kategori
                        selectKategori(id, name);
                    } else {
                        $(".childkategori").html("");
                        // pilih kategori
                        selectKategori(id, name);
                    }
                }
            });
        }

        $(document).ready(function() {
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            });

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
