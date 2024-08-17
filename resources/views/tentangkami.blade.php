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

    <section class="about spad">
        <div class="container" style="margin-top: -60px;">
            <div class="row">
                <div class="col-lg-12">
                    <p>Selamat datang di Kidsmate, toko yang menawarkan berbagai produk berkualitas untuk anak-anak. Kami
                        hadir dengan dedikasi untuk menyediakan produk terbaik yang sesuai dengan kebutuhan anak-anak Anda,
                        mulai dari pakaian, mainan, hingga kebutuhan lainnya.</p>

                    <p><strong>Kidsmate</strong> tidak hanya hadir secara online, tetapi juga memberikan pengalaman belanja
                        yang nyaman di toko offline kami yang tersebar di beberapa lokasi strategis di Kota Surakarta, Jawa
                        Tengah. Di store kami, Anda dapat melihat dan memilih produk secara langsung dengan layanan terbaik
                        dari tim kami.</p>

                    <h5 class="font-weight-bold mb-2">Store Kami:</h5>
                    <ol style="margin-left: 20px;">
                        <li>
                            <strong>Store Sumber</strong><br>
                            Alamat: Jl. Pakel No.51, Fajar Indah, Sumber, Kec. Banjarsari, Kota Surakarta, Jawa Tengah
                            57138<br>
                            <a href="#">Link Maps</a>
                        </li>
                        <li class="mt-3">
                            <strong>Store Mojosongo</strong><br>
                            Alamat: Jl. Tangkuban Perahu, Mojosongo, Kec. Jebres, Kota Surakarta, Jawa Tengah 57127<br>
                            <a href="#">Link Maps</a>
                        </li>
                    </ol>

                    <h5 class="mt-4 font-weight-bold mb-2">Toko Online Kami:</h5>
                    <ul style="margin-left: 20px;">
                        <li><a href="#">Shopee Kidsmate</a></li>
                        <li><a href="#">Tiktok Kidsmate</a></li>
                        <li><a href="#">Lazada Kidsmate</a></li>
                        <li><a href="#">Tokopedia Kidsmate</a></li>
                    </ul>

                    <p class="mt-4">Kami selalu berkomitmen untuk memberikan produk terbaik dengan pelayanan yang ramah
                        dan profesional. Kepuasan Anda adalah prioritas utama kami, dan kami siap membantu Anda dalam
                        memenuhi segala kebutuhan anak-anak Anda. Jangan ragu untuk menghubungi kami jika Anda memiliki
                        pertanyaan atau membutuhkan bantuan.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
