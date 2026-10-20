@extends('layouts.app')

@section('content')
<div class="container my-5">
    
    <!-- Encabezado -->
    <div class="text-center mb-5">
        <h1 class="font-weight-bold text-uppercase" style="letter-spacing: 2px;">Finalizar Compra</h1>
        <p class="text-muted">Completa los datos de envío y selecciona tu método de pago</p>
        <div style="width: 60px; height: 3px; background-color: #e53637; margin: 10px auto 0;"></div>
    </div>

    <!-- ERRORES DE VALIDACIÓN -->
    @if($errors->any())
        <div class="alert alert-danger rounded-0 mb-4">
            <ul class="mb-0 pl-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="row">
            
            <!-- COLUMNA IZQUIERDA: DIRECCIÓN Y MÉTODO DE PAGO -->
            <div class="col-lg-7 mb-4">
                
                <!-- 1. Datos de Envío -->
                <div class="bg-white p-4 border shadow-sm mb-4">
                    <h5 class="font-weight-bold text-dark border-bottom pb-3 mb-4">
                        <i class="fa fa-map-marker text-danger mr-2"></i> 1. Dirección de Envío
                    </h5>
                    
                    <div class="form-group mb-3">
                        <label class="font-weight-bold small text-dark">Nombre Completo de quien recibe:</label>
                        <input type="text" name="nombre" class="form-control rounded-0" placeholder="Ej. Juan Pérez" value="{{ old('nombre', Auth::user()->name ?? '') }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold small text-dark">Calle, Número exterior e interior:</label>
                        <input type="text" name="direccion" class="form-control rounded-0" placeholder="Ej. Av. Reforma 123, Apt 4B" value="{{ old('direccion') }}" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-3">
                            <label class="font-weight-bold small text-dark">Ciudad / Municipio:</label>
                            <input type="text" name="ciudad" class="form-control rounded-0" placeholder="Ej. Guadalajara" value="{{ old('ciudad') }}" required>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label class="font-weight-bold small text-dark">Código Postal:</label>
                            <input type="text" name="codigo_postal" class="form-control rounded-0" placeholder="Ej. 44100" value="{{ old('codigo_postal') }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold small text-dark">Teléfono de contacto:</label>
                        <input type="tel" name="telefono" class="form-control rounded-0" placeholder="Ej. 3312345678" value="{{ old('telefono') }}" required>
                    </div>
                </div>

                <!-- 2. Selección de Método de Pago -->
                <div class="bg-white p-4 border shadow-sm">
                    <h5 class="font-weight-bold text-dark border-bottom pb-3 mb-4">
                        <i class="fa fa-credit-card text-danger mr-2"></i> 2. Método de Pago
                    </h5>

                    <div class="custom-control custom-radio mb-3">
                        <input type="radio" id="pagoTarjeta" name="metodo_pago" value="tarjeta" class="custom-control-input" checked>
                        <label class="custom-control-label font-weight-bold text-dark" for="pagoTarjeta">
                            Tarjeta de Crédito / Débito <i class="fa fa-cc-visa text-primary ml-2"></i> <i class="fa fa-cc-mastercard text-warning"></i>
                        </label>
                    </div>

                    <div class="custom-control custom-radio mb-3">
                        <input type="radio" id="pagoSpei" name="metodo_pago" value="spei" class="custom-control-input">
                        <label class="custom-control-label font-weight-bold text-dark" for="pagoSpei">
                            Transferencia Interbancaria (SPEI)
                        </label>
                    </div>

                    <div class="custom-control custom-radio mb-0">
                        <input type="radio" id="pagoEfectivo" name="metodo_pago" value="efectivo" class="custom-control-input">
                        <label class="custom-control-label font-weight-bold text-dark" for="pagoEfectivo">
                            Efectivo en OXXO / Conveniencia
                        </label>
                    </div>
                </div>

            </div>

            <!-- COLUMNA DERECHA: CUADRO DE PRODUCTOS Y TOTAL (Coincide con el recuadro "Productos" del boceto) -->
            <div class="col-lg-5">
                <div class="bg-white p-4 border shadow-sm sticky-top" style="top: 20px;">
                    <h5 class="font-weight-bold text-dark border-bottom pb-3 mb-4">
                        <i class="fa fa-shopping-bag text-danger mr-2"></i> Productos en tu Pedido
                    </h5>

                    <!-- Lista de Productos -->
                    <div class="mb-4" style="max-height: 300px; overflow-y: auto;">
                        @foreach($cart as $item)
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}" style="width: 60px; height: 60px; object-fit: cover;" class="border mr-3">
                                <div class="flex-grow-1">
                                    <h6 class="font-weight-bold mb-1 text-dark small">{{ $item['nombre'] }}</h6>
                                    <p class="mb-0 text-muted small">Talla: <span class="badge badge-danger">{{ $item['talla'] }}</span> | Cant: {{ $item['cantidad'] }}</p>
                                    <p class="font-weight-bold text-danger mb-0 small">${{ number_format($item['precio'] * $item['cantidad'], 2) }} MXN</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Resumen del Total -->
                    <div class="border-top pt-3 mb-4">
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Subtotal:</span>
                            <span>${{ number_format($cartTotal, 2) }} MXN</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted mb-3">
                            <span>Envío:</span>
                            <span class="text-success font-weight-bold">GRATIS</span>
                        </div>
                        <div class="d-flex justify-content-between font-weight-bold text-dark h4 mb-0">
                            <span>Total a Pagar:</span>
                            <span class="text-danger">${{ number_format($cartTotal, 2) }} MXN</span>
                        </div>
                    </div>

                    <!-- BOTÓN PAGAR -->
                    <button type="submit" class="btn btn-danger btn-block btn-lg rounded-0 text-uppercase font-weight-bold py-3" style="letter-spacing: 1px; font-size: 15px;">
                        <i class="fa fa-lock mr-2"></i> Pagar ${{ number_format($cartTotal, 2) }} MXN
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection