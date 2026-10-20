@extends('layouts.app')

@section('content')
<div class="container my-5">
    
    <!-- Alertas de éxito -->
    @if(session('success'))
        <div class="alert alert-success rounded-0 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Migas de pan / Navegación rápida -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-dark">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/tienda') }}" class="text-dark">Tienda</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/ropa') }}" class="text-dark">Ropa</a></li>
            <li class="breadcrumb-item active text-danger" aria-current="page">{{ $producto->nombre }}</li>
        </ol>
    </nav>

    @php
        // Determinar la primera talla disponible como predeterminada
        $defaultTalla = 'S';
        if (($producto->stock_s ?? 0) > 0) { $defaultTalla = 'S'; }
        elseif (($producto->stock_m ?? 0) > 0) { $defaultTalla = 'M'; }
        elseif (($producto->stock_l ?? 0) > 0) { $defaultTalla = 'L'; }
        elseif (($producto->stock_xl ?? 0) > 0) { $defaultTalla = 'XL'; }
    @endphp

    <!-- DETALLE DEL PRODUCTO -->
    <div class="row bg-white p-4 shadow-sm border mb-5">
        
        <!-- LADO IZQUIERDO: Imagen Grande -->
        <div class="col-lg-6 mb-4 mb-lg-0 text-center">
            <div class="border p-2">
                <img src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}" class="img-fluid w-100" style="max-height: 500px; object-fit: cover;">
            </div>
        </div>

        <!-- LADO DERECHO: Información y Formulario -->
        <div class="col-lg-6 d-flex flex-column justify-content-between">
            <div>
                <h2 class="font-weight-bold text-dark mb-2">{{ $producto->nombre }}</h2>
                <h3 class="text-danger font-weight-bold mb-4">${{ number_format($producto->precio, 2) }} MXN</h3>
                <p class="text-muted small mb-4">Prenda confeccionada con materiales de alta calidad, perfecta para tu estilo diario.</p>

                <!-- SELECCIÓN DE TALLAS INTERACTIVA -->
                <div class="mb-4">
                    <label class="font-weight-bold text-dark d-block mb-2">Selecciona tu Talla:</label>
                    <div class="d-flex flex-wrap gap-2">
                        @if(($producto->stock_s ?? 0) > 0)
                            <button type="button" class="btn {{ $defaultTalla === 'S' ? 'btn-dark text-white' : 'btn-outline-dark' }} rounded-0 px-3 py-2 mr-2 talla-btn" data-talla="S">
                                S ({{ $producto->stock_s }} disp.)
                            </button>
                        @endif

                        @if(($producto->stock_m ?? 0) > 0)
                            <button type="button" class="btn {{ $defaultTalla === 'M' ? 'btn-dark text-white' : 'btn-outline-dark' }} rounded-0 px-3 py-2 mr-2 talla-btn" data-talla="M">
                                M ({{ $producto->stock_m }} disp.)
                            </button>
                        @endif

                        @if(($producto->stock_l ?? 0) > 0)
                            <button type="button" class="btn {{ $defaultTalla === 'L' ? 'btn-dark text-white' : 'btn-outline-dark' }} rounded-0 px-3 py-2 mr-2 talla-btn" data-talla="L">
                                L ({{ $producto->stock_l }} disp.)
                            </button>
                        @endif

                        @if(($producto->stock_xl ?? 0) > 0)
                            <button type="button" class="btn {{ $defaultTalla === 'XL' ? 'btn-dark text-white' : 'btn-outline-dark' }} rounded-0 px-3 py-2 mr-2 talla-btn" data-talla="XL">
                                XL ({{ $producto->stock_xl }} disp.)
                            </button>
                        @endif
                    </div>
                </div>

                <!-- FORMULARIO DE AGREGAR AL CARRITO -->
                <form action="{{ route('cart.add') }}" method="POST" id="formAgregarCarrito">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $producto->id }}">
                    <input type="hidden" name="talla" id="inputTallaSeleccionada" value="{{ $defaultTalla }}">

                    <div class="form-group style-quantity mb-4" style="max-width: 140px;">
                        <label class="font-weight-bold text-dark small">Cantidad:</label>
                        <input type="number" name="cantidad" class="form-control rounded-0 text-center" value="1" min="1" required>
                    </div>

                    <div class="d-flex align-items-center mt-3">
                        <button type="submit" class="btn btn-danger btn-lg rounded-0 text-uppercase font-weight-bold flex-grow-1 mr-2" style="font-size: 14px; letter-spacing: 1px;">
                            <i class="fa fa-shopping-bag mr-2"></i> Agregar al Carrito
                        </button>
                </form>

                <!-- BOTÓN AGREGAR A FAVORITOS -->
                <form action="{{ route('favorite.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $producto->id }}">
                    <button type="submit" class="btn btn-outline-danger btn-lg rounded-0 px-4" title="Guardar en Favoritos">
                        <i class="fa fa-heart"></i>
                    </button>
                </form>
                    </div>
            </div>
        </div>
    </div>

    <!-- PANEL DE ADMINISTRACIÓN: EDITAR / ELIMINAR PRENDA (SOLO ADMIN) -->
    @auth
        @if(Auth::user()->is_admin || Auth::user()->email === 'admin@gmail.com')
            <div class="card border-danger shadow-sm rounded-0 my-5">
                <div class="card-header bg-danger text-white font-weight-bold d-flex justify-content-between align-items-center">
                    <span><i class="fa fa-edit mr-2"></i> Panel de Admin: Editar Prenda</span>
                    <span class="badge badge-light text-danger">Exclusivo Admin</span>
                </div>
                <div class="card-body bg-light">
                    <!-- Formulario de Edición (PUT) -->
                    <form action="{{ url('/productos/' . $producto->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold text-dark small">Nombre:</label>
                                <input type="text" name="nombre" class="form-control rounded-0" value="{{ $producto->nombre }}" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-bold text-dark small">Precio ($ MXN):</label>
                                <input type="number" step="0.01" name="precio" class="form-control rounded-0" value="{{ $producto->precio }}" required>
                            </div>
                            <div class="form-group col-md-5">
                                <label class="font-weight-bold text-dark small">URL de Imagen:</label>
                                <input type="text" name="imagen" class="form-control rounded-0" value="{{ $producto->imagen }}" required>
                            </div>
                        </div>

                        <!-- Edición de Tallas -->
                        <div class="form-row mt-2">
                            <div class="col-12 mb-2">
                                <label class="font-weight-bold text-dark small">Modificar Inventario por Tallas:</label>
                            </div>
                            <div class="form-group col-3">
                                <span class="badge badge-danger">S</span>
                                <input type="number" name="stock_s" class="form-control rounded-0" value="{{ $producto->stock_s }}">
                            </div>
                            <div class="form-group col-3">
                                <span class="badge badge-danger">M</span>
                                <input type="number" name="stock_m" class="form-control rounded-0" value="{{ $producto->stock_m }}">
                            </div>
                            <div class="form-group col-3">
                                <span class="badge badge-danger">L</span>
                                <input type="number" name="stock_l" class="form-control rounded-0" value="{{ $producto->stock_l }}">
                            </div>
                            <div class="form-group col-3">
                                <span class="badge badge-danger">XL</span>
                                <input type="number" name="stock_xl" class="form-control rounded-0" value="{{ $producto->stock_xl }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button type="submit" class="btn btn-success rounded-0 text-uppercase font-weight-bold">
                                <i class="fa fa-save mr-1"></i> Guardar Cambios
                            </button>
                    </form>

                    <!-- Formulario de Eliminación (DELETE) -->
                    <form action="{{ url('/productos/' . $producto->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta prenda?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger rounded-0 text-uppercase font-weight-bold">
                            <i class="fa fa-trash mr-1"></i> Eliminar Prenda
                        </button>
                    </form>
                        </div>
                </div>
            </div>
        @endif
    @endauth

</div>

<!-- SCRIPT PARA SELECCIÓN DINÁMICA DE TALLAS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tallaBtns = document.querySelectorAll('.talla-btn');
        const hiddenInputTalla = document.getElementById('inputTallaSeleccionada');

        tallaBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                tallaBtns.forEach(b => {
                    b.classList.remove('btn-dark', 'text-white');
                    b.classList.add('btn-outline-dark');
                });
                this.classList.remove('btn-outline-dark');
                this.classList.add('btn-dark', 'text-white');
                hiddenInputTalla.value = this.getAttribute('data-talla');
            });
        });
    });
</script>
@endsection