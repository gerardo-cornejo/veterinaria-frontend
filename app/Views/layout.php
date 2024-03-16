<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.css" rel="stylesheet">
    <style>
        nav.navbar {
            background-color: #8c158c !important;
        }

        .font-size-xx-large{
            font-size: xx-large !important;
        }
    </style>
    <?= $this->renderSection('header') ?>
</head>

<body class="bg-secondary bg-opacity-10">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">
                <i class="fa fa-paw"></i> <?= NOMBRE_APP; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-basket-shopping"></i> Ventas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fa fa-money-bill-1-wave"></i> Hacer Venta</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa fa-list"></i> Listar Ventas</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fa fa-box-open"></i> Gestionar Productos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= base_url("/clientes"); ?>" role="button" aria-expanded="false">
                            <i class="fa fa-person"></i> Clientes
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-calendar-days"></i> Citas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fa fa-calendar-plus"></i> Nueva Cita</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa fa-calendar-week"></i> Listar Citas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-gear"></i> Sistema
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fa fa-user-doctor"></i> Veterinarios</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-syringe"></i> Vacunas</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fa fa-list-check"></i> Propiedades</a></li>
                        </ul>
                    </li>

                </ul>
                <div class="navbar-nav flex-row flex-wrap ms-md-auto">
                    <li class="nav-item dropdown">
                        <a id="ddUsuario" class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Hola, {{usuario }}!
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fa fa-id-card"></i> Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa fa-right-from-bracket"></i> Cerrar sesión</a></li>
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </nav>

    <?= $this->renderSection('content', true) ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script>
        let token = localStorage.getItem("token");
        let nombre = localStorage.getItem("nombre");

        if (token == null || nombre == null) {
            location.replace("<?= base_url("/usuario/login"); ?>");
        } else {
            $("#ddUsuario").html(`<i class="fa fa-user"></i> Bienvenido, ${nombre}`);
        }
    </script>
    <?= $this->renderSection('script') ?>
</body>

</html>