<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://getbootstrap.com/docs/5.3/examples/sign-in/sign-in.css">
    <title>Iniciar sesión - SisVet</title>
    <style>
        .body-bg {
            background-color: #ffd1ff !important;
        }
    </style>

</head>

<body class="py-5 bg-body-tertiary body-bg">

    <div class="container">
        <div class="row">
            <div class="col-12">
                <main class="form-signin w-100 m-auto bg-white rounded-3">
                    <form>
                        <?php
                        if (isset($_GET["mensaje"])) {
                        ?>
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>Mensaje:</strong> <?= $_GET["mensaje"] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="text-center">
                            <img class="mb-4" src="<?= base_url("images/huellas.jpg"); ?>" alt="" height="57">
                            <h1 class="h3 mb-3 fw-normal ">Bienvenid@ a SisVet</h1>
                        </div>

                        <div class="form-floating">
                            <input type="text" class="form-control" id="txtUsuario" placeholder="Usuario" autocomplete="off">
                            <label for="txtUsuario">Usuario</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="txtClave" placeholder="Contraseña" autocomplete="off">
                            <label for="txtClave">Contraseña</label>
                        </div>

                        <button class="btn btn-primary w-100 py-2" onclick="login();" type="button">Iniciar sesión</button>
                        <div class="form-floating text-center mt-3">
                            <a class="text-muted" href="#">¿Olvidaste tu contraseña?</a>
                        </div>

                    </form>
                </main>
            </div>

        </div>
    </div>


    <footer class="footer mt-auto bg-light position-fixed bottom-0 w-100 text-center pt-3">
        <p class="text-decoration-none">Hecho con 💖 por <a class="text-muted" href="https://innite.net">Innite Solutions Perú</a></p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function checkRedirect() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const redirect = urlParams.has('redirect');
            if (!redirect) {
                location.href = location.href + "?redirect=<?= $redirect; ?>"
            }

        }


        function login() {
            let usuario = $("#txtUsuario").val();
            let clave = $("#txtClave").val();
            if (usuario.length == 0 || clave.length == 0) {
                Swal.fire({
                    title: "Datos incorrectos",
                    text: "Debe ingresar usuario y clave",
                    icon: "error"
                });

            } else {
                $.ajax({
                    method: "POST",
                    url: "https://innite-users-dev.innite.net/usuario/login",
                    data: {
                        usuario: usuario,
                        clave: clave
                    },
                    beforeSend: () => {
                        Swal.fire({
                            title: "Iniciando sesión.",
                            text: "Por favor, espere.",
                            showCloseButton: false
                        });
                        Swal.showLoading();

                    },
                    success: (data) => {
                        localStorage.setItem("token", data.token);

                        //let timerInterval;
                        Swal.fire({
                            icon: "success",
                            title: "Inicio de sesión exitoso",
                            html: data.message + "<br>Serás redirigido automáticamente...", //<b></b> para mostrar los milisegundos.
                            timer: 1500,
                            timerProgressBar: true,
                            showCancelButton: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                /* Swal.showLoading();

                                 const timer = Swal.getPopup().querySelector("b");
                                 timerInterval = setInterval(() => {
                                     timer.textContent = `${Swal.getTimerLeft()}`;
                                 }, 100);*/
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                location.href = '<?= $redirect ?>';
                            }
                        });
                    },
                    error: (xhr, ajaxOptions, errorThrown) => {
                        console.log(xhr);

                        if (xhr.responseJSON.mensaje instanceof Array) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: "-" + Object.values(xhr.responseJSON.mensaje).join("<br>-"),
                                showCloseButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: "-" + xhr.responseJSON.mensaje,
                                showCloseButton: false
                            });
                        }


                    }

                });
            }
        }
    </script>

</body>

</html>