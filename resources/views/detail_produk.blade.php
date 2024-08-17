@extends('template.layout_home')

@section('main')
    <!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="{{ url('/') }}">Home</a>
                            <a href="{{ url('/produk') }}">Produk</a>
                            <span>Detail Produk</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                                    <div class="product__thumb__pic set-bg"
                                        data-setbg="{{ $data->gambar != '' && $data->gambar != null ? asset($data->gambar) : asset('assets/img/no-image.png') }}">
                                    </div>
                                </a>
                            </li>
                            @if ($data->gambar_2 != '' && $data->gambar_2 != null)
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">
                                        <div class="product__thumb__pic set-bg" data-setbg="{{ asset($data->gambar_2) }}">
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if ($data->gambar_3 != '' && $data->gambar_3 != null)
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">
                                        <div class="product__thumb__pic set-bg" data-setbg="{{ asset($data->gambar_3) }}">
                                        </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img src="{{ $data->gambar != '' && $data->gambar != null ? asset($data->gambar) : asset('assets/img/no-image.png') }}"
                                        alt="">
                                </div>
                            </div>
                            @if ($data->gambar_2 != '' && $data->gambar_2 != null)
                                <div class="tab-pane" id="tabs-2" role="tabpanel">
                                    <div class="product__details__pic__item">
                                        <img src="{{ asset($data->gambar_2) }}" alt="">
                                    </div>
                                </div>
                            @endif
                            @if ($data->gambar_3 != '' && $data->gambar_3 != null)
                                <div class="tab-pane" id="tabs-3" role="tabpanel">
                                    <div class="product__details__pic__item">
                                        <img src="{{ asset($data->gambar_3) }}" alt="">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h4>{{ $data->nama }}</h4>
                            <h3>Rp. {{ number_format($data->harga, 0, ',', '.') }}</h3>
                            <p>{{ $data->keterangan }}</p>
                            @if (count($data->warna) > 0)
                                <div class="product__details__option">
                                    <div class="product__details__option__color">
                                        <span>Color:</span>
                                        @foreach ($data->warna as $warna)
                                            <label class="c-1" style="background: {{ $warna->bg_color }}"
                                                title="{{ $warna->warna }}">
                                                <input type="radio">
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1" id="product-quantity">
                                    </div>
                                </div>
                                <a href="#" onclick="pesansekarang()" id="whatsapp-link" target="_blank"
                                    class="btn btn-success"><i class="fa fa-whatsapp"></i>
                                    Pesan Sekarang</a>
                            </div>
                            <div class="product__details__last__option">
                                <ul>
                                    <li><span>Kategori:</span>
                                        {{ $data->kategori->parent_id ? $data->kategori->parentKategori->nama . ', ' . $data->kategori->nama : $data->kategori->nama }}
                                    </li>
                                    <li><span>Brand:</span> {{ $data->brand->nama }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Details Section End -->

    <!-- Related Section Begin -->
    <section class="related spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="related-title">Produk Terkait</h3>
                </div>
            </div>
            <div class="row">
                @if (count($produk_terkait) == 0)
                    <h4 class="text-center">Produk kosong...</h4>
                @endif

                @foreach ($produk_terkait as $row)
                    @php
                        $img = $row->gambar ? asset($row->gambar) : asset('assets/img/no-image.png');
                    @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new-arrivals">
                        <a href="{{ url('produk/' . $row->id) }}">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{ $img }}">
                                    {{-- <span class="label">New</span> --}}
                                </div>
                                <div class="product__item__text">
                                    <h6>{{ $row->nama }}</h6>
                                    <h6 class="mb-1 text-secondary">
                                        {{ $row->kategori->parent_id ? $row->kategori->parentKategori->nama . ', ' . $row->kategori->nama : $row->kategori->nama }}
                                    </h6>
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

                @if (count($produk_terkait) > 0)
                    <div class="w-100 d-flex justify-content-center">
                        <a href="{{ $link_produk_terkait }}" class="btn btn-primary text-center">Lihat Semua Produk <i
                                class="fa fa-arrow-right"></i></a>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Related Section End -->

    <script>
        function pesansekarang() {
            const quantity = document.getElementById('product-quantity').value;
            const productName = "{{ $data->nama }}";
            let message = `Halo, saya ingin memesan ${quantity} ${productName}`;
            const whatsappLink = `https://wa.me/628995226718?text=${encodeURIComponent(message)}.`;

            window.open(whatsappLink, '_blank');
        }
    </script>
@endsection
