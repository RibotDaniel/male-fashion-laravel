<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Male-Fashion | Tienda</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">

    <!-- Estilos para la sección Tienda del Wireframe -->
    <style>
        .tienda-seccion {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            max-width: 1170px;
            margin: 40px auto;
            padding: 0 15px;
        }

        .tienda-card {
            width: 100%;
            height: 220px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .tienda-overlay {
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 60px;
            box-sizing: border-box;
        }

        .tienda-titulo {
            color: #ffffff;
            font-size: 2.8rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
            letter-spacing: 1px;
        }

        .btn-tienda {
            display: inline-block;
            padding: 12px 35px;
            border: 2px solid #ffffff;
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 2px;
            transition: all 0.3s ease;
            background: transparent;
        }

        .btn-tienda:hover {
            background-color: #ffffff;
            color: #111111;
        }
    </style>
</head>

<body>
    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7">
                        <div class="header__top__left">
                            <p>Envío gratis en compras mayores a $999</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="header__top__right">
                            <div class="header__top__links">
                                @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/profile') }}">Mi Cuenta</a>
                                    @else
                                        <a href="{{ route('login') }}">Iniciar Sesión</a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}">Registrarse</a>
                                        @endif
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="header__logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="Logo"></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li><a href="{{ url('/') }}">Inicio</a></li>
                            <li><a href="{{ url('/tienda') }}">Tienda</a></li>
                            <li><a href="#">Contacto</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option">
                        <a href="#"><img src="{{ asset('img/icon/heart.png') }}" alt=""></a>
                        <a href="#"><img src="{{ asset('img/icon/cart.png') }}" alt=""> <span>0</span></a>
                        <div class="price">$0.00</div>
                    </div>
                </div>
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>
    <!-- Header Section End -->

    <main>
        @yield('content')
    </main>

    <!-- Js Plugins -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>