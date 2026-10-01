@extends('layouts.app')

@section('content')
<div class="container my-4">
    <section class="tienda-seccion">
        <!-- Bloque 1: Ropa -->
        <div class="tienda-card" style="background-image: url('{{ asset('img/ropa-bg.webp') }}');">
            <div class="tienda-overlay">
                <h2 class="tienda-titulo">Ropa</h2>
                <a href="{{ url('/ropa') }}" class="btn-tienda">Comprar</a>
            </div>
        </div>

        <!-- Bloque 2: Calzado -->
        <div class="tienda-card" style="background-image: url('{{ asset('img/calzado-bg.webp') }}');">
            <div class="tienda-overlay">
                <h2 class="tienda-titulo">Calzado</h2>
                <a href="{{ url('/calzado') }}" class="btn-tienda">Comprar</a>
            </div>
        </div>

        <!-- Bloque 3: Accesorios-->
        <div class="tienda-card" style="background-image: url('{{ asset('img/accesorios-bg.jpg') }}');">
            <div class="tienda-overlay">
                <h2 class="tienda-titulo">Accesorios</h2>
                <a href="{{ url('/accesorios') }}" class="btn-tienda">Comprar</a>
            </div>
        </div>
    </section>
</div>
@endsection