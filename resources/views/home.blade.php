@extends('template.layout_home')

@section('main')
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg" data-setbg="{{ asset('assets/img/banner1.webp') }}">

            </div>
            <div class="hero__items set-bg" data-setbg="{{ asset('assets/img/banner2.webp') }}">

            </div>
            <div class="hero__items set-bg" data-setbg="{{ asset('assets/img/banner3.webp') }}">

            </div>
            <div class="hero__items set-bg" data-setbg="{{ asset('assets/img/banner4.webp') }}">

            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Product Section Begin -->
    <section class="product spad mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">Produk Terbaru</li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter">
                @if (count($data) == 0)
                    <h4 class="text-center">Produk kosong...</h4>
                @endif

                @foreach ($data as $row)
                    @php
                        $img = $row->gambar ? asset($row->gambar) : asset('assets/img/no-image.png');
                    @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new-arrivals">
                        <a href="{{ url('produk/' . $row->id) }}">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{ $img }}">
                                    <span class="label">New</span>
                                </div>
                                <div class="product__item__text">
                                    <h6>{{ $row->nama }}</h6>
                                    <h5>Rp. {{ number_format($row->harga, 0, ',', '.') }}</h5>
                                    @foreach ($row->warna as $warna)
                                        <div class="product__color__select">
                                            <label style="background: {{ $warna->bg_color }}" title="{{ $warna->warna }}">
                                                <input type="radio">
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

                @if (count($data) > 0)
                    <div class="w-100 d-flex justify-content-center">
                        <a href="{{ url('produk') }}" class="btn btn-primary text-center">Lihat Semua Produk <i
                                class="fa fa-arrow-right"></i></a>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection
