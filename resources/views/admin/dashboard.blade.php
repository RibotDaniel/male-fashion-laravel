<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Male-Fashion | Mi Cuenta</title>
    <!-- Bootstrap CSS y FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Nunito', sans-serif;
        }
        .header-top {
            background: #111111;
            color: #ffffff;
            padding: 10px 0;
            font-size: 13px;
        }
        .header-main {
            background: #ffffff;
            padding: 20px 0;
            border-bottom: 1px solid #e5e5e5;
        }
        .logo-text {
            font-size: 24px;
            font-weight: 800;
            color: #111111;
            text-transform: uppercase;
        }
        .logo-text span {
            color: #e53637;
        }
        .nav-link-custom {
            color: #111111;
            font-weight: 600;
            margin: 0 15px;
            text-decoration: none;
        }
        .nav-link-custom:hover {
            color: #e53637;
        }
    </style>
</head>
<body>

    <!-- Header / Menú Principal -->
    <div class="header-top">
        <div class="container d-flex justify-content-between">
            <span>Envío gratis en compras mayores a $999</span>
            <div>
                <a href="{{ url('/dashboard') }}" class="text-white text-uppercase" style="font-size: 12px; letter-spacing: 1px;">MI CUENTA</a>
            </div>
        </div>
    </div>

    <div class="header-main">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo-text">
                <a href="{{ url('/') }}" class="text-dark text-decoration-none">Male fashion<span>.</span></a>
            </div>
            <nav>
                <a href="{{ url('/') }}" class="nav-link-custom">Inicio</a>
                <a href="{{ url('/tienda') }}" class="nav-link-custom">Tienda</a>
                <a href="#" class="nav-link-custom">Contacto</a>
            </nav>
            <div>
                <i class="fa fa-heart-o mr-3"></i>
                <i class="fa fa-shopping-bag"></i> <strong>$0.00</strong>
            </div>
        </div>
    </div>

    <!-- Contenido del Dashboard -->
    <div class="container my-5">
        <div class="row mb-4 align-items-center">
            <div class="col-md-8">
                <h2 class="font-weight-bold text-dark">Mi Cuenta</h2>
                <p class="text-muted">Bienvenido de nuevo, <strong>{{ Auth::check() ? Auth::user()->name : 'Usuario' }}</strong></p>
            </div>
            <div class="col-md-4 text-right">
                @if(Auth::check())
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fa fa-sign-out"></i> Cerrar Sesión
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-dark btn-sm">Iniciar Sesión</a>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- Formulario de Edición de Perfil -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 rounded-0">
                    <div class="card-header bg-dark text-white p-3 border-0">
                        <h5 class="m-0 font-weight-bold text-white"><i class="fa fa-user-circle mr-2"></i> Datos Personales</h5>
                    </div>
                    <div class="card-body p-4 bg-white">

                        @if (session('status') === 'profile-updated')
                            <div class="alert alert-success">
                                ¡Información actualizada correctamente!
                            </div>
                        @endif

                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="form-group mb-3">
                                <label for="name" class="font-weight-bold text-dark">Nombre:</label>
                                <input id="name" name="name" type="text" class="form-control rounded-0" 
                                       value="{{ Auth::check() ? old('name', Auth::user()->name) : '' }}" required 
                                       onkeypress="return soloLetras(event)" oninput="limpiarNumeros(this)">
                            </div>

                            <div class="form-group mb-4">
                                <label for="email" class="font-weight-bold text-dark">Correo Electrónico:</label>
                                <input id="email" name="email" type="email" class="form-control rounded-0" 
                                       value="{{ Auth::check() ? old('email', Auth::user()->email) : '' }}" required>
                            </div>

                            <button type="submit" class="btn btn-dark rounded-0 px-4 text-uppercase font-weight-bold" style="letter-spacing: 1px;">
                                Guardar Cambios
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Tabla de Pedidos -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 rounded-0">
                    <div class="card-header bg-dark text-white p-3 border-0">
                        <h5 class="m-0 font-weight-bold text-white"><i class="fa fa-shopping-bag mr-2"></i> Mis Pedidos</h5>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <div class="table-responsive">
                            <table class="table table-hover border">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Orden</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">#ORD-1001</td>
                                        <td>21/09/2026</td>
                                        <td>$899.00</td>
                                        <td><span class="badge badge-success">Completado</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">#ORD-1002</td>
                                        <td>21/09/2026</td>
                                        <td>$1,450.00</td>
                                        <td><span class="badge badge-warning">En camino</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de Validación para evitar números -->
    <script>
        function soloLetras(e) {
            let key = e.keyCode || e.which;
            let tecla = String.fromCharCode(key);
            let regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
            if (!regex.test(tecla)) {
                return false;
            }
        }

        function limpiarNumeros(input) {
            input.value = input.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        }
    </script>
</body>
</html>