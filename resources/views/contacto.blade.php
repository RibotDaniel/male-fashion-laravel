<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Male Fashion</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Menú de navegación básico -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-black">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Male Fashion</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ url('/tienda') }}">Inicio</a>
                <a class="nav-link" href="{{ url('/tienda') }}">Tienda</a>
                <a class="nav-link active text-danger" href="{{ url('/contacto') }}">Contacto</a>
            </div>
        </div>
    </nav>

    <!-- Contenido de Contacto -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0 p-4 text-center">
                    <h2 class="mb-4 fw-bold">Contáctanos</h2>
                    <hr>
                    <div class="my-3">
                        <h5 class="text-muted">Nombre</h5>
                        <p class="fs-5 fw-semibold text-dark">Male Fashion Store</p>
                    </div>
                    <div class="my-3">
                        <h5 class="text-muted">Número Telefónico</h5>
                        <p class="fs-5 fw-semibold text-dark">+52 55 1234 5678</p>
                    </div>
                    <div class="my-3">
                        <h5 class="text-muted">Dirección</h5>
                        <p class="fs-5 fw-semibold text-dark">Av. de la Moda #123, Col. Centro, C.P. 01000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>