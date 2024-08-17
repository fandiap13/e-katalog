@php
    $segment = Request::segment(1);
@endphp

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kidsmate | {{ $title }}</title>
    <link rel="icon" href="data:,">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">


    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('malefashion-master') }}/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('malefashion-master') }}/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('malefashion-master') }}/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('malefashion-master') }}/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('malefashion-master') }}/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('malefashion-master') }}/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('malefashion-master') }}/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('malefashion-master') }}/css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-3">
                    <div class="header__logo">
                        <a href=""><img style="width: 50px; height: 50px; object-fit: contain"
                                src="https://kidsmate.id/wp-content/uploads/2024/03/logo-kidsmate-hitam.png"
                                alt="Logo"></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="{{ $segment == '' ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="{{ $segment == 'produk' ? 'active' : '' }}"><a
                                    href="{{ url('produk') }}">Produk</a>
                            </li>
                            <li class="{{ $segment == 'faq' ? 'active' : '' }}"><a href="{{ url('faq') }}">FAQ</a>
                            </li>
                            <li class="{{ $segment == 'tentangkami' ? 'active' : '' }}"><a
                                    href="{{ url('tentangkami') }}">Tentang Kami</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option">
                        <a href="#" class="search-switch"><img
                                src="{{ asset('malefashion-master') }}/img/icon/search.png" alt=""></a>
                    </div>
                </div>
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>
    <!-- Header Section End -->

    @yield('main')

    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="#">
                                <img class="bg-white" style="width: 100px; height: 100px; object-fit: contain"
                                    src="https://kidsmate.id/wp-content/uploads/2024/03/logo-kidsmate-hitam.png"
                                    alt="Logo">
                            </a>
                        </div>
                        <p>Kidzmate Official Store.</p>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>Marketplace</h6>
                        <div class="footer__newslatter">
                            <a href="https://tokopedia.link/VZHAzvoxGHb" class="rt-img-list__item tokopedia"
                                target="_blank"><img
                                    src="https://kidsmate.id/wp-content/themes/saudagarwp/assets/img/marketplace-tokopedia.webp"
                                    alt="tokopedia" width="50" height="50"></a>

                            <a href="https://s.lazada.co.id/s.LMK64" class="rt-img-list__item lazada"
                                target="_blank"><img
                                    src="https://kidsmate.id/wp-content/themes/saudagarwp/assets/img/marketplace-lazada.webp"
                                    alt="lazada" width="50" height="50"></a>

                            <a href="https://shp.ee/6wjc84w" class="rt-img-list__item shopee" target="_blank"><img
                                    src="https://kidsmate.id/wp-content/themes/saudagarwp/assets/img/marketplace-shopee.webp"
                                    alt="shopee" width="50" height="50"></a>

                            <a href="https://www.tiktok.com/@kidsmate.official?_t=8kOG1yGFJYu&_r=1"
                                class="rt-img-list__item tiktok" target="_blank"><img
                                    src="https://kidsmate.id/wp-content/themes/saudagarwp/assets/img/marketplace-tiktok.webp"
                                    alt="shopee" width="50" height="50"></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="footer__copyright__text">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <p>Copyright ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            kidsmate All Rights Reserved
                        </p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

    <!-- Js Plugins -->
    <script src="{{ asset('malefashion-master') }}/js/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('malefashion-master') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('malefashion-master') }}/js/jquery.nice-select.min.js"></script>
    <script src="{{ asset('malefashion-master') }}/js/jquery.nicescroll.min.js"></script>
    <script src="{{ asset('malefashion-master') }}/js/jquery.magnific-popup.min.js"></script>
    <script src="{{ asset('malefashion-master') }}/js/jquery.countdown.min.js"></script>
    <script src="{{ asset('malefashion-master') }}/js/jquery.slicknav.js"></script>
    <script src="{{ asset('malefashion-master') }}/js/mixitup.min.js"></script>
    <script src="{{ asset('malefashion-master') }}/js/owl.carousel.min.js"></script>
    <script src="{{ asset('malefashion-master') }}/js/main.js"></script>
</body>

</html>
