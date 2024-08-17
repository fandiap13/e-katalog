@extends('template.layout_home')

@section('main')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>{{ $title }}</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ url('/') }}">Home</a>
                            <span>{{ $title }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section Begin -->
    <section class="about spad">
        <div class="container" style="margin-top: -60px;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Pengembalian Produk</h3>
                            <p class="text-muted">Maksimal 3 hari setelah produk sampai. Pengembalian tidak berlaku jika
                                diklaim lebih dari 3 hari.</p>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Syarat-syarat Pengembalian Produk:</h5>
                            <ul class="list-group list-group-numbered"">
                                <li class="list-group-item">Silahkan menghubungi customer service pada nomor <a
                                        href="tel:087866123048">087866123048</a> atau <a href="#">klik pada link
                                        berikut</a>.</li>
                                <li class="list-group-item">Produk harus masih berlabel dan belum dicuci.</li>
                                <li class="list-group-item">Kirim video unboxing secara utuh tanpa terpotong.</li>
                                <li class="list-group-item">Silahkan mengirimkan produk yang ingin di retur.</li>
                                <li class="list-group-item">Konfirmasikan nomor resi pada cs terkait.</li>
                                <li class="list-group-item">Retur atau penukaran produk dilakukan setelah barang kami
                                    konfirmasi.</li>
                                <li class="list-group-item">Apabila stok kosong, dapat ditukar dengan produk lain atau
                                    pengembalian dana.</li>
                                <li class="list-group-item">Biaya pengiriman untuk penukaran produk oleh karena keinginan
                                    pembeli akan ditanggung oleh pembeli sepenuhnya.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h3>Pembelian Secara Offline</h3>
                            <p class="text-muted">Kami juga melayani pembelian secara offline di store kami di bawah ini:
                            </p>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Store Kami:</h5>
                            <ol class="list-group list-group-numbered">
                                <li class="list-group-item">
                                    <strong>Store Sumber</strong><br>
                                    Jl. Pakel No.51, Fajar Indah, Sumber, Kec. Banjarsari, Kota Surakarta, Jawa Tengah
                                    57138<br>
                                    <a href="#" class="text-primary">Link Maps</a>
                                </li>
                                <li class="list-group-item">
                                    <strong>Store Mojosongo</strong><br>
                                    Jl. Tangkuban Perahu, Mojosongo, Kec. Jebres, Kota Surakarta, Jawa Tengah 57127<br>
                                    <a href="#" class="text-primary">Link Maps</a>
                                </li>
                            </ol>
                            <h5 class="card-title mt-4">Toko Online Kami:</h5>
                            <ol class="list-group list-group-numbered">
                                <li class="list-group-item"><a href="#" class="text-primary">Shopee Kidsmate</a></li>
                                <li class="list-group-item"><a href="#" class="text-primary">Tiktok Kidsmate</a></li>
                                <li class="list-group-item"><a href="#" class="text-primary">Lazada Kidsmate</a></li>
                                <li class="list-group-item"><a href="#" class="text-primary">Tokopedia Kidsmate</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
@endsection
