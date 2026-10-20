@extends('layouts.app')

@section('content')
<!-- Estilos explícitos para evitar que las tarjetas colapsen a 0px de altura -->
<style>
    .tienda-seccion {
        display: flex;
        flex-direction: column;
        gap: 25px;
        width: 100%;
        max-width: 1170px;
        margin: 40px auto;
        padding: 0 15px;
    }

    .tienda-card {
        width: 100%;
        height: 240px; /* Define la altura para que no quede invisible */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-color: #1a1a1a; /* Fondo oscuro de respaldo */
        position: relative;
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
    }

    .tienda-overlay {
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 60px;
        box-sizing: border-box;
    }

    .tienda-titulo {
        color: #ffffff !important;
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        text-transform: uppercase;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.8);
        letter-spacing: 2px;
    }

    .btn-tienda {
        display: inline-block;
        padding: 12px 35px;
        border: 2px solid #ffffff;
        color: #ffffff !important;
        text-decoration: none !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 2px;
        transition: all 0.3s ease;
        background: transparent;
    }

    .btn-tienda:hover {
        background-color: #ffffff;
        color: #111111 !important;
    }

    @media (max-width: 768px) {
        .tienda-overlay {
            padding: 0 25px;
        }
        .tienda-titulo {
            font-size: 1.8rem;
        }
        .btn-tienda {
            padding: 8px 20px;
            font-size: 0.75rem;
        }
    }
</style>

<div class="container my-5">
    <section class="tienda-seccion">
        <!-- Bloque 1: Ropa -->
        <div class="tienda-card" style="background-image: url('{{ asset('img/ropa-bg.webp') }}'), url('https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?q=80&w=1200&auto=format&fit=crop');">
            <div class="tienda-overlay">
                <h2 class="tienda-titulo">Ropa</h2>
                <a href="{{ url('/ropa') }}" class="btn-tienda">Comprar</a>
            </div>
        </div>

        <!-- Bloque 2: Calzado -->
        <div class="tienda-card" style="background-image: url('{{ asset('img/calzado-bg.webp') }}'), url('https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=1200&auto=format&fit=crop');">
            <div class="tienda-overlay">
                <h2 class="tienda-titulo">Calzado</h2>
                <a href="{{ url('/calzado') }}" class="btn-tienda">Comprar</a>
            </div>
        </div>

        <!-- Bloque 3: Accesorios -->
        <div class="tienda-card" style="background-image: url('{{ asset('img/accesorios-bg.jpg') }}'), url('https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=1200&auto=format&fit=crop');">
            <div class="tienda-overlay">
                <h2 class="tienda-titulo">Accesorios</h2>
                <a href="{{ url('/accesorios') }}" class="btn-tienda">Comprar</a>
            </div>
        </div>
    </section>
</div>
@endsection