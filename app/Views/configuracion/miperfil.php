<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Mi Perfil - <?= NOMBRE_APP ?></title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-2">
    <div class="card">
        <div class="card-header">
            <h4>Cambiar contraseña</h4>
        </div>
        <div class="card-body">

            <div class="row justify-content-center pt-4 pb-4">
                <div class="col-md-6">

                    <form action="#">
                        <input hidden type="text" autocomplete="username" value="{{...}}">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Contraseña actual</label>
                                <input id="txtClaveActual" name="txtClaveActual" class="form-control" type="password" autocomplete="current-password" placeholder="Clave actual">
                            </div>
                            <div class="col-md-12">
                                <label for="">Contraseña nueva</label>
                                <input id="txtClaveNueva1" name="txtClaveNueva1" class="form-control" type="password" autocomplete="new-password" placeholder="Nueva clave">
                            </div>
                            <div class="col-md-12">
                                <label for="">Repita contraseña</label>
                                <input id="txtClaveNueva2" name="txtClaveNueva2" class="form-control" type="password" autocomplete="new-password" placeholder="Repita su Clave">
                            </div>
                        </div>
                    </form>
                    <div class="text-center mt-2 ">
                        <button id="btnCambiarClave" class="btn btn-success">Cambiar contraseña</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function actualizarClave() {
        let actual = $("#txtClaveActual").val();
        let claveNueva1 = $("#txtClaveNueva1").val();
        let claveNueva2 = $("#txtClaveNueva2").val();
        console.log("click!")
        if (!actual || !claveNueva1 || !claveNueva2) {
            Swal.fire({
                icon: "warning",
                title: "Faltan datos",
                text: "Debe ingresar tu clave actual, y la nueva clave."
            });
        } else if (claveNueva1 !== claveNueva2) {
            Swal.fire({
                icon: "warning",
                title: "Tus nuevas claves no coinciden.",
                text: "Las nuevas contraseñas no coinciden."
            });
        } else {
            $.ajax({
                url: "<?= ENDPOINT ?>/usuario/actualizarClave",
                method: "post",
                data: {
                    id_usuario: empresa.id,
                    actual: actual,
                    claveNueva1: claveNueva1,
                    claveNueva2: claveNueva2
                },
                success: (data) => {
                    if (data.mensajes.length > 0) {
                        Swal.fire({
                            icon: "success",
                            title: "Contraseña cambiada",
                            text: "Se cambió su clave con éxito."
                        })
                    }
                }

            });
        }

    }
    $("#btnCambiarClave").click(actualizarClave);
</script>
<?= $this->endSection() ?>