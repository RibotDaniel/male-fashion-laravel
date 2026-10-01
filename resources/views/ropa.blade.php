@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Encabezado de la Sección Ropa -->
    <div class="text-center mb-5">
        <h1 class="font-weight-bold text-uppercase" style="letter-spacing: 2px;">Ropa</h1>
        <p class="text-muted">Descubre nuestra colección exclusiva de prendas masculinas</p>
        <div style="width: 60px; height: 3px; background-color: #e53637; margin: 10px auto 0;"></div>
    </div>

    <!-- Alerta de Éxito al agregar producto -->
    @if(session('success'))
        <div class="alert alert-success rounded-0 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Panel de Administración (SOLO VISIBLE PARA ADMINISTRADORES) -->
    @auth
        @if(Auth::user()->is_admin || Auth::user()->email === 'admin@gmail.com')
            <div class="card border-danger mb-5 shadow-sm rounded-0">
                <div class="card-header bg-danger text-white font-weight-bold d-flex justify-content-between align-items-center">
                    <span><i class="fa fa-plus-circle mr-2"></i> Panel de Admin: Agregar Nueva Prenda</span>
                    <span class="badge badge-light text-danger">Exclusivo Admin</span>
                </div>
                <div class="card-body bg-light">
                    <form action="{{ url('/productos') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold text-dark small">Nombre de la Prenda:</label>
                                <input type="text" name="nombre" class="form-control rounded-0" placeholder="Ej. Playera Resident Evil 2 XXL" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-bold text-dark small">Precio ($ MXN):</label>
                                <input type="number" step="0.01" name="precio" class="form-control rounded-0" placeholder="499.00" required>
                            </div>
                            <div class="form-group col-md-5">
                                <label class="font-weight-bold text-dark small">URL de la Imagen:</label>
                                <input type="text" name="imagen" class="form-control rounded-0" placeholder="https://enlace-de-imagen.com/foto.jpg" required>
                            </div>
                        </div>
                        <div class="text-right mt-2">
                            <button type="submit" class="btn btn-danger rounded-0 text-uppercase font-weight-bold px-4" style="font-size: 12px; letter-spacing: 1px;">
                                Guardar Prenda en Catálogo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endauth

    <!-- Filtros / Contador de Productos -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <span class="text-muted">Mostrando catálogo disponible ({{ count($productos) }} productos)</span>
        <div>
            <select class="custom-select custom-select-sm rounded-0" style="width: 180px;">
                <option selected>Ordenar por: Novedades</option>
                <option value="1">Precio: Menor a Mayor</option>
                <option value="2">Precio: Mayor a Menor</option>
            </select>
        </div>
    </div>

    <!-- Grid Adaptativo con Datos de la Base de Datos -->
    <div class="row">
        @forelse($productos as $item)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="card h-100 border-0 shadow-sm rounded-0 product-card">
                    <div class="position-relative overflow-hidden">
                        <img src="{{ $item->imagen }}" class="card-img-top rounded-0" alt="{{ $item->nombre }}" style="height: 280px; object-fit: cover;">
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-between p-3">
                        <div>
                            <h6 class="font-weight-bold mb-1 text-dark">{{ $item->nombre }}</h6>
                            <p class="font-weight-bold text-danger mb-2">${{ number_format($item->precio, 2) }} MXN</p>
                        </div>
                        <button class="btn btn-dark btn-block rounded-0 text-uppercase font-weight-bold" style="font-size: 11px; letter-spacing: 1px;">
                            <i class="fa fa-shopping-cart mr-1"></i> Agregar al carrito
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">No hay prendas registradas en el catálogo todavía.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection