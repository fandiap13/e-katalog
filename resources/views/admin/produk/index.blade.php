@extends('template.layout_admin')

@push('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title">
                            <a class="btn btn-default" href="{{ route('admin.produk.index') }}"><i
                                    class="fa fa-sync-alt"></i> Refresh</a>
                        </h5>

                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item mr-2">
                                    <a class="btn btn-primary" href="{{ route('admin.produk.create') }}"><i
                                            class="fa fa-plus"></i>
                                        Tambah</a>
                                </li>
                                <li class="nav-item mr-2">
                                    <button class="btn btn-warning" type="button" onclick="showFilterModal()"><i
                                            class="fa fa-filter"></i>
                                        Filter Produk
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-danger" href="{{ url('admin/produk') }}"><i
                                            class="fa fa-sync-alt"></i>
                                        Clear Filter
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px">No</th>
                                        <th class="text-center">Gambar</th>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        @if ($search == true)
                                            <th>Persentase</th>
                                        @endif
                                        <th class="text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) == 0)
                                        <tr>
                                            <td colspan="6" class="text-center">Data kosong...</td>
                                        </tr>
                                    @endif

                                    @foreach ($data as $key => $row)
                                        @php
                                            $img = $row->gambar
                                                ? asset($row->gambar)
                                                : asset('assets/img/no-image.png');
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center">
                                                <a href="{{ $img }}" target="_blank">
                                                    <img style="width: 120px; height: 120px; object-fit: contain;background-color: lightgray"
                                                        src="{{ $img }}" alt="Gambar Produk">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ url('/produk/' . $row->id) }}" target="_blank">
                                                    <h6 class="font-weight-bold">{{ $row->nama }}</h6>
                                                </a>
                                                <div class="row">
                                                    <ul>
                                                        <li><strong>Kategori:
                                                            </strong>
                                                            {{ $row->kategori->parent_id ? $row->kategori->parentKategori->nama . '->' . $row->kategori->nama : $row->kategori->nama }}
                                                        </li>
                                                        {{-- <li><strong>Brand: </strong>{{ $row->brand->nama }}</li> --}}
                                                    </ul>
                                                </div>
                                            </td>
                                            <td class="text-right">Rp {{ number_format($row->harga, 0, ',', '.') }}</td>
                                            @if ($search == true)
                                                @php
                                                    $formatted_similarity = number_format($row->similarity, 2); // 0.12
                                                    $rounded_similarity = ceil($formatted_similarity * 100) / 100; // 0.13
                                                @endphp
                                                <td class="text-right">{{ $rounded_similarity }} %</td>
                                            @endif
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ url('admin/produk/' . $row->id . '/edit') }}"
                                                        class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                    <button onclick="destroy('{{ $row->id }}')"
                                                        class="btn btn-sm btn-danger"><i
                                                            class="fa fa-trash-alt"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="d-flex mt-3 justify-content-end">
                                {{ $data->links() }}
                            </div>
                        </div>
                    </div>
                    <div class="overlay d-none">
                        <i class="fa fa-2x fa-sync-alt fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->

    <!-- Modal Kategori -->
    <div class="modal fade" id="modal-filter" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Filter Produk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="GET">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" placeholder="Masukkan nama" class="form-control"
                                        value="{{ $nama }}">
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" name="keterangan" placeholder="Masukkan keterangan"
                                        class="form-control" value="{{ $keterangan }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- <div class="form-group">
                                    <label for="brand_id" class="form-label">Brand Produk</label>
                                    <select class="form-control select2" name="brand_id" id="brand_id">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($brand as $b)
                                            <option value="{{ $b->id }}"
                                                {{ $brand_id == $b->id ? 'selected' : '' }}>
                                                {{ $b->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="number" name="harga" placeholder="Masukkan harga"
                                        class="form-control" value="{{ $harga }}">
                                </div>

                                <div class="form-group">
                                    <label for="kategori_id" class="form-label">kategori Produk</label>
                                    <select class="form-control select2" name="kategori_id" id="kategori_id">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($kategori as $b)
                                            <option value="{{ $b->id }}"
                                                {{ $kategori_id == $b->id ? 'selected' : '' }}>
                                                {{ $b->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        function showFilterModal() {
            $('#modal-filter').modal('show');
        }

        function destroy(id) {
            bootbox.confirm({
                buttons: {
                    confirm: {
                        label: '<i class="fa fa-check"></i>',
                        className: 'btn-danger'
                    },
                    cancel: {
                        label: '<i class="fa fa-undo"></i>',
                        className: 'btn-default'
                    },
                },
                title: "Yakin ingin menghapus data produk?",
                message: "Data produk yang dihapus tidak dapat dikembalikan!",
                callback: function(result) {
                    if (result) {
                        var data = {
                            _token: "{{ csrf_token() }}",
                        };
                        $.ajax({
                            url: "{{ url('admin/produk') }}/" + id,
                            dataType: 'json',
                            data: data,
                            type: 'DELETE',
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
                        })
                    }
                }
            });
        }

        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endpush
