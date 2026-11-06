@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Encabezado de la Sección Accesorios -->
    <div class="text-center mb-5">
        <h1 class="font-weight-bold text-uppercase" style="letter-spacing: 2px;">Accesorios</h1>
        <p class="text-muted">Complementa tu estilo con nuestra colección de accesorios exclusivos</p>
        <div style="width: 60px; height: 3px; background-color: #e53637; margin: 10px auto 0;"></div>
    </div>

    <!-- Alerta de Éxito -->
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
                    <span><i class="fa fa-plus-circle mr-2"></i> Panel de Admin: Agregar Nuevo Accesorio</span>
                    <span class="badge badge-light text-danger">Exclusivo Admin</span>
                </div>
                <div class="card-body bg-light">
                    <form action="{{ url('/productos') }}" method="POST">
                        @csrf
                        
                        <!-- Campo oculto para definir la categoría -->
                        <input type="hidden" name="categoria" value="accesorios">
                        
                        <!-- Nombre, Precio, Imagen -->
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold text-dark small">Nombre del Accesorio:</label>
                                <input type="text" name="nombre" class="form-control rounded-0" placeholder="Ej. Llavero Anime / Cartera Coraline" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-bold text-dark small">Precio ($ MXN):</label>
                                <input type="number" step="0.01" name="precio" class="form-control rounded-0" placeholder="299.00" required>
                            </div>
                            <div class="form-group col-md-5">
                                <label class="font-weight-bold text-dark small">URL de la Imagen:</label>
                                <input type="text" name="imagen" class="form-control rounded-0" placeholder="https://enlace-de-imagen.com/foto.jpg" required>
                            </div>
                        </div>

                        <!-- Inventario General -->
                        <div class="form-row mt-2">
                            <div class="col-12 mb-2">
                                <label class="font-weight-bold text-dark small">Stock / Piezas Disponibles:</label>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="number" name="stock" class="form-control rounded-0" min="0" value="10" required>
                            </div>
                        </div>

                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-danger rounded-0 text-uppercase font-weight-bold px-4" style="font-size: 12px; letter-spacing: 1px;">
                                Guardar Accesorio en Catálogo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endauth

    <!-- Catálogo de Productos -->
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

    <!-- Grid de Catálogo -->
    <div class="row">
        @forelse($productos as $item)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="card h-100 border-0 shadow-sm rounded-0 product-card">
                    <a href="{{ url('/productos/' . $item->id) }}" class="position-relative overflow-hidden d-block">
                        <img src="{{ $item->imagen }}" class="card-img-top rounded-0" alt="{{ $item->nombre }}" style="height: 280px; object-fit: cover;">
                    </a>

                    <div class="card-body text-center d-flex flex-column justify-content-between p-3">
                        <div>
                            <a href="{{ url('/productos/' . $item->id) }}" class="text-dark text-decoration-none">
                                <h6 class="font-weight-bold mb-1 text-dark">{{ $item->nombre }}</h6>
                            </a>
                            <p class="font-weight-bold text-danger mb-2">${{ number_format($item->precio, 2) }} MXN</p>
                            
                            <div class="mb-2">
                                <span class="badge badge-light border text-muted">Disponible</span>
                            </div>
                        </div>

                        <a href="{{ url('/productos/' . $item->id) }}" class="btn btn-dark btn-block rounded-0 text-uppercase font-weight-bold" style="font-size: 11px; letter-spacing: 1px;">
                            <i class="fa fa-eye mr-1"></i> Ver Detalle
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">No hay accesorios registrados en el catálogo todavía.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection