@extends('template.layout_home')

@section('main')
    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="" method="GET">
                                <input type="hidden" name="harga_awal" value="{{ $harga_awal }}">
                                <input type="hidden" name="harga_akhir" value="{{ $harga_akhir }}">
                                <input type="hidden" name="pengurutan" value="{{ $pengurutan }}">
                                <input type="hidden" name="kategori" value="{{ $kategori_id }}">
                                <input type="hidden" name="brand" value="{{ $brand_id }}">

                                <input type="text" name="search" placeholder="Search..." value="{{ $search }}">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseOne">Categories</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul class="nice-scroll">
                                                    @foreach ($kategori as $k)
                                                        <?php $total_produk = count($k->produk); ?>
                                                        @foreach ($k->subkategori as $sub)
                                                            <?php
                                                            $total_produk += intval(count($sub->produk));
                                                            ?>
                                                        @endforeach

                                                        @if ($k->parent_id == null || $k->parent_id == '')
                                                            <li>
                                                                <form action="" method="GET">
                                                                    <input type="hidden" name="kategori"
                                                                        value="{{ $k->id }}">
                                                                    <input type="hidden" name="search"
                                                                        value="{{ $search }}">
                                                                    <input type="hidden" name="harga_awal"
                                                                        value="{{ $harga_awal }}">
                                                                    <input type="hidden" name="harga_akhir"
                                                                        value="{{ $harga_akhir }}">
                                                                    <input type="hidden" name="pengurutan"
                                                                        value="{{ $pengurutan }}">
                                                                    <input type="hidden" name="brand"
                                                                        value="{{ $brand_id }}">
                                                                    <button type="submit"
                                                                        class="btn btn-link p-0 {{ $k->id == $kategori_id ? 'font-weight-bold' : '' }}"
                                                                        style="text-decoration: none; color: #4f4f4f;">
                                                                        {{ $k->nama }} ({{ $total_produk }})
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            @foreach ($k->subkategori as $sub)
                                                                <li style="margin-left: 10px">
                                                                    <form action="" method="GET">
                                                                        <input type="hidden" name="kategori"
                                                                            value="{{ $sub->id }}">
                                                                        <input type="hidden" name="search"
                                                                            value="{{ $search }}">
                                                                        <input type="hidden" name="harga_awal"
                                                                            value="{{ $harga_awal }}">
                                                                        <input type="hidden" name="harga_akhir"
                                                                            value="{{ $harga_akhir }}">
                                                                        <input type="hidden" name="pengurutan"
                                                                            value="{{ $pengurutan }}">
                                                                        <input type="hidden" name="brand"
                                                                            value="{{ $brand_id }}">
                                                                        <button type="submit"
                                                                            class="btn btn-link p-0 {{ $sub->id == $kategori_id ? 'font-weight-bold' : '' }}"
                                                                            style="text-decoration: none; color: #4f4f4f;">
                                                                            {{ $sub->nama }}
                                                                            ({{ count($sub->produk) }})
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseTwo">Branding</a>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__brand">
                                                <ul>
                                                    @foreach ($brand as $b)
                                                        <li>
                                                            <form action="" method="GET">
                                                                <input type="hidden" name="search"
                                                                    value="{{ $search }}">
                                                                <input type="hidden" name="harga_awal"
                                                                    value="{{ $harga_awal }}">
                                                                <input type="hidden" name="harga_akhir"
                                                                    value="{{ $harga_akhir }}">
                                                                <input type="hidden" name="pengurutan"
                                                                    value="{{ $pengurutan }}">
                                                                <input type="hidden" name="kategori"
                                                                    value="{{ $kategori_id }}">

                                                                <input type="hidden" name="brand"
                                                                    value="{{ $b->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-link p-0 {{ $b->id == $brand_id ? 'font-weight-bold' : '' }}"
                                                                    style="text-decoration: none; color: #4f4f4f;">
                                                                    {{ $b->nama }}
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseThree2">Filter Harga</a>
                                    </div>
                                    <div id="collapseThree2" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="row">
                                                <form action="" method="GET">
                                                    <input type="hidden" name="search" value="{{ $search }}">
                                                    <input type="hidden" name="pengurutan" value="{{ $pengurutan }}">
                                                    <input type="hidden" name="kategori" value="{{ $kategori_id }}">
                                                    <input type="hidden" name="brand" value="{{ $brand_id }}">

                                                    <div class="col-lg-12">
                                                        <input type="number" name="harga_awal" class="form-control"
                                                            value="{{ $harga_awal }}" placeholder="Harga Awal"
                                                            required>
                                                    </div>
                                                    <div class="col-lg-12 mt-2">
                                                        <input type="number" name="harga_akhir" class="form-control"
                                                            value="{{ $harga_akhir }}" placeholder="Harga Akhir"
                                                            required>
                                                    </div>
                                                    <div class="col-lg-12 mt-2">
                                                        <button class="btn btn-block btn-primary" type="submit"><i
                                                                class="fa fa-filter"></i> Filter</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <p>Menampilkan data {{ $data->firstItem() }} - {{ $data->lastItem() }} dari
                                        {{ $data->total() }} data</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <form action="" method="GET">
                                    <div class="shop__product__option__right">
                                        <p>Urutkan Berdasarkan:</p>
                                        <select name="pengurutan">
                                            <option value="">-- pilih --</option>
                                            <option value="termurah" {{ $pengurutan == 'termurah' ? 'selected' : '' }}>
                                                Termurah
                                            </option>
                                            <option value="termahal" {{ $pengurutan == 'termahal' ? 'selected' : '' }}>
                                                Termahal
                                            </option>
                                            <option value="terbaru" {{ $pengurutan == 'terbaru' ? 'selected' : '' }}>
                                                Terbaru
                                            </option>
                                            <option value="terdahulu" {{ $pengurutan == 'terdahulu' ? 'selected' : '' }}>
                                                Terdahulu
                                            </option>
                                        </select>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i>
                                            Filter</button>

                                        <a href="{{ url('produk') }}" class="btn btn-warning mt-3"><i
                                                class="fa fa-refresh"></i>
                                            Clear Filter</a>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if (count($data) == 0)
                            <h4 class="text-center">Produk kosong...</h4>
                        @endif

                        @foreach ($data as $row)
                            @php
                                $img = $row->gambar ? asset($row->gambar) : asset('assets/img/no-image.png');
                            @endphp
                            <div class="col-lg-4 col-md-6 col-sm-6">
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
                                                    <label style="background: {{ $warna->bg_color }}"
                                                        title="{{ $warna->warna }}">
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
                                {{ $data->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
    </section>
    <!-- Shop Section End -->
@endsection
