@extends('layouts.app')

@section('content')
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg" data-setbg="{{ asset('img/mi-fondo.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text" style="text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.85);">
                                <h6 style="color: #ff4d4d; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;">Colección de Verano</h6>
                                <h2 style="color: #ffffff; font-weight: 800; font-size: 48px; margin-top: 10px; line-height: 1.2;">Colección Otoño - Invierno 2026</h2>
                                <p style="color: #f1f1f1; font-size: 16px; margin-bottom: 25px; font-weight: 500;">Ropa de calidad superior hecha de forma ética y con atención al detalle.</p>
                                <a href="#" class="primary-btn">Comprar ahora <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <section class="banner spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 offset-lg-4">
                    <div class="banner__item">
                        <div class="banner__item__pic">
                            <img src="{{ asset('img/banner/banner-1.jpg') }}" alt="Colección de Ropa">
                        </div>
                        <div class="banner__item__text">
                            <h2>Colecciones de Ropa</h2>
                            <a href="#">Comprar ahora</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="banner__item banner__item--middle">
                        <div class="banner__item__pic">
                            <img src="{{ asset('img/banner/banner-2.jpg') }}" alt="Accesorios">
                        </div>
                        <div class="banner__item__text">
                            <h2>Accesorios</h2>
                            <a href="#">Comprar ahora</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="banner__item banner__item--last">
                        <div class="banner__item__pic">
                            <img src="{{ asset('img/banner/banner-3.jpg') }}" alt="Calzado">
                        </div>
                        <div class="banner__item__text">
                            <h2>Calzado</h2>
                            <a href="#">Comprar ahora</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->
@endsection