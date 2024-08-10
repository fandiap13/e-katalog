@extends('template.layout_admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
                            <a class="btn btn-default" href="{{ route('admin.kategori.index') }}"><i
                                    class="fa fa-sync-alt"></i> Refresh</a>
                        </h5>

                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <a class="btn btn-default" href="{{ url()->previous() }}"><i class="fa fa-undo"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Nama Kategori: </strong>{{ $kategori->nama }}</li>
                            <li class="list-group-item"><strong>Tipe:</strong>
                                {!! $kategori->parent_id
                                    ? '<span class="badge badge-secondary">Sub Kategori</span>'
                                    : '<span class="badge badge-primary">Parent Kategori</span>' !!}
                            </li>
                            <li class="list-group-item"><strong>Keterangan: </strong>{{ $kategori->keterangan ?? '-' }}
                            </li>
                        </ul>

                        @if (count($kategori->subkategori) > 0)
                            <hr>
                            <h4 class="mt-3">Sub Kategori</h4>
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered table-hover text-nowrap" id="datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 10%">No</th>
                                            <th>Nama Sub Kategori</th>
                                            <th class="text-center" style="width: 20%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kategori->subkategori as $key => $row)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td><a href="{{ url('admin/kategori/' . $row->id . '/edit') }}"
                                                        class="font-weight-bold">{{ $row->nama }}</a>
                                                </td>
                                                <td class="text-center"><button onclick="destroy('{{ $row->id }}')"
                                                        class="btn btn-sm btn-danger"><i
                                                            class="fa fa-trash-alt"></i></button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="overlay d-none">
                        <i class="fa fa-2x fa-sync-alt fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection

@push('scripts')
    <script src="{{ asset('adminlte') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('adminlte') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('adminlte') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('adminlte') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

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
                title: "Yakin ingin menghapus data kategori?",
                message: "Data kategori yang dihapus tidak dapat dikembalikan!",
                callback: function(result) {
                    if (result) {
                        var data = {
                            _token: "{{ csrf_token() }}",
                        };
                        $.ajax({
                            url: "{{ url('admin/kategori') }}/" + id,
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
    </script>
@endpush
