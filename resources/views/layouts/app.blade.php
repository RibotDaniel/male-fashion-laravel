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

    <!-- Estilos para los Paneles Sobrepuestos -->
    <style>
        .side-panel-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9998;
            display: none;
        }

        .side-panel {
            position: fixed;
            top: 0;
            right: -420px;
            width: 400px;
            max-width: 90vw;
            height: 100vh;
            background: #ffffff;
            z-index: 9999;
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.3);
            transition: right 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            display: flex;
            flex-direction: column;
        }

        .side-panel.active {
            right: 0;
        }

        .side-panel-header {
            padding: 20px;
            border-bottom: 1px solid #eeeeee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #111111;
            color: #ffffff;
        }

        .side-panel-body {
            padding: 20px;
            overflow-y: auto;
            flex-grow: 1;
        }

        .side-panel-footer {
            padding: 20px;
            border-top: 1px solid #eeeeee;
            background: #f9f9f9;
        }

        .panel-item {
            display: flex;
            gap: 15px;
            align-items: center;
            padding-bottom: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .panel-item img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border: 1px solid #ddd;
        }

        .btn-close-panel {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
        }
    </style>
</head>

<body>
    @php
        $cart = [];
        $cartTotal = 0;
        $cartCount = 0;

        if (Auth::check()) {
            // Cargar carrito del usuario autenticado desde la Base de Datos
            $dbCart = \App\Models\CartItem::with('product')->where('user_id', Auth::id())->get();
            foreach($dbCart as $item) {
                if ($item->product) {
                    $key = $item->product_id . '_' . $item->talla;
                    $cart[$key] = [
                        'cart_item_id' => $item->id,
                        'id'           => $item->product_id,
                        'nombre'       => $item->product->nombre,
                        'precio'       => $item->product->precio,
                        'imagen'       => $item->product->imagen,
                        'talla'        => $item->talla,
                        'cantidad'     => $item->cantidad,
                    ];
                }
            }
        } else {
            // Cargar carrito del invitado desde la Sesión
            $cart = session('cart', []);
        }

        $favorites = session('favorites', []);

        foreach($cart as $item) {
            $cartTotal += $item['precio'] * $item['cantidad'];
            $cartCount += $item['cantidad'];
        }
    @endphp

    <!-- FONDO DE BLOQUEO OSCURO -->
    <div id="sidePanelOverlay" class="side-panel-overlay" onclick="closePanels()"></div>

    <!-- 1. CABECERA / MENÚ SUPERIOR -->
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
                            <li><a href="{{ url('/contacto') }}">Contacto</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option d-flex align-items-center justify-content-end">
                        <!-- FAVORITOS -->
                        <a href="javascript:void(0)" onclick="openFavoritesPanel()" class="position-relative mr-4" title="Mis Favoritos">
                            <img src="{{ asset('img/icon/heart.png') }}" alt="Favoritos">
                            @if(count($favorites) > 0)
                                <span class="badge badge-danger rounded-circle position-absolute" style="top: -8px; right: -10px; font-size: 10px;">{{ count($favorites) }}</span>
                            @endif
                        </a>

                        <!-- CARRITO DE COMPRAS -->
                        <a href="javascript:void(0)" onclick="openCartPanel()" class="position-relative" title="Mi Carrito">
                            <img src="{{ asset('img/icon/cart.png') }}" alt="Carrito">
                            @if($cartCount > 0)
                                <span class="badge badge-danger rounded-circle position-absolute" style="top: -8px; right: -10px; font-size: 10px;">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>

    <!-- 2. CONTENIDO DINÁMICO -->
    <main>
        @yield('content')
    </main>

    <!-- PANEL SOBREPUESTO: CARRITO DE COMPRAS -->
    <div id="cartPanel" class="side-panel">
        <div class="side-panel-header">
            <h5 class="m-0 font-weight-bold text-white"><i class="fa fa-shopping-bag mr-2"></i> Mi Carrito</h5>
            <button class="btn-close-panel" onclick="closePanels()">&times;</button>
        </div>
        <div class="side-panel-body">
            @forelse($cart as $key => $item)
                <div class="panel-item">
                    <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}">
                    <div class="flex-grow-1">
                        <h6 class="font-weight-bold mb-1 text-dark">{{ $item['nombre'] }}</h6>
                        <p class="mb-0 text-muted small">Talla: <span class="badge badge-danger">{{ $item['talla'] }}</span> | Cant: {{ $item['cantidad'] }}</p>
                        <p class="font-weight-bold text-danger mb-0">${{ number_format($item['precio'] * $item['cantidad'], 2) }} MXN</p>
                    </div>
                    <!-- QUITAR DEL CARRITO (X) -->
                    <form action="{{ route('cart.remove') }}" method="POST">
                        @csrf
                        @if(isset($item['cart_item_id']))
                            <input type="hidden" name="cart_item_id" value="{{ $item['cart_item_id'] }}">
                        @else
                            <input type="hidden" name="item_key" value="{{ $key }}">
                        @endif
                        <button type="submit" class="btn btn-sm btn-outline-danger border-0 font-weight-bold" title="Quitar">
                            <i class="fa fa-times text-danger" style="font-size: 1.2rem;"></i>
                        </button>
                    </form>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="fa fa-shopping-basket fa-3x mb-3 text-light"></i>
                    <p>Tu carrito está vacío actualmente.</p>
                </div>
            @endforelse
        </div>
        @if(count($cart) > 0)
            <div class="side-panel-footer">
                <div class="d-flex justify-content-between font-weight-bold text-dark h5 mb-3">
                    <span>Total:</span>
                    <span class="text-danger">${{ number_format($cartTotal, 2) }} MXN</span>
                </div>
                <!-- ENLACE A CHECKOUT (PROTÉGIDO POR MIDDLEWARE AUTH) -->
                <a href="{{ route('checkout.index') }}" class="btn btn-danger btn-block rounded-0 text-uppercase font-weight-bold py-2 text-center text-white" style="text-decoration: none;">
                    Comprar / Finalizar Pedido
                </a>
            </div>
        @endif
    </div>

    <!-- PANEL SOBREPUESTO: FAVORITOS -->
    <div id="favoritesPanel" class="side-panel">
        <div class="side-panel-header">
            <h5 class="m-0 font-weight-bold text-white"><i class="fa fa-heart mr-2"></i> Mis Favoritos</h5>
            <button class="btn-close-panel" onclick="closePanels()">&times;</button>
        </div>
        <div class="side-panel-body">
            @forelse($favorites as $item)
                <div class="panel-item">
                    <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}">
                    <div class="flex-grow-1">
                        <h6 class="font-weight-bold mb-1 text-dark">{{ $item['nombre'] }}</h6>
                        <p class="font-weight-bold text-danger mb-0">${{ number_format($item['precio'], 2) }} MXN</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <!-- MOVER AL CARRITO (+ 🛒) -->
                        <form action="{{ route('favorite.toCart') }}" method="POST" class="mr-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                            <button type="submit" class="btn btn-sm btn-dark rounded-0" title="Agregar al Carrito">
                                <i class="fa fa-cart-plus"></i>
                            </button>
                        </form>

                        <!-- QUITAR DE FAVORITOS (♥) -->
                        <form action="{{ route('favorite.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-0" title="Quitar de Favoritos">
                                <i class="fa fa-heart"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="fa fa-heart-o fa-3x mb-3 text-light"></i>
                    <p>No tienes prendas guardadas en favoritos.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Plugins JS -->
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

    <!-- JS de control para paneles laterales -->
    <script>
        function openCartPanel() {
            closePanels();
            document.getElementById('sidePanelOverlay').style.display = 'block';
            document.getElementById('cartPanel').classList.add('active');
        }

        function openFavoritesPanel() {
            closePanels();
            document.getElementById('sidePanelOverlay').style.display = 'block';
            document.getElementById('favoritesPanel').classList.add('active');
        }

        function closePanels() {
            document.getElementById('sidePanelOverlay').style.display = 'none';
            document.getElementById('cartPanel').classList.remove('active');
            document.getElementById('favoritesPanel').classList.remove('active');
        }

        @if(session('open_cart'))
            openCartPanel();
        @endif

        @if(session('open_favorites'))
            openFavoritesPanel();
        @endif
    </script>
</body>

</html>