<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Mis suscrpipciones -
    <?= NOMBRE_APP ?>
</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-2">
    <div class="card">
        <div class="card-header bg-white">
            <h3>¡Hola, <span id="lblNombreUsuario"></span>! 👋</h3>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Mi suscripción</h4>
                </div>
                <div id="cntComprarSuscripcion" class="col-sm-6 d-flex justify-content-end">
                    <button class="btn btn-success btn-sm">Comprar suscripción</button>
                </div>
            </div>
            <div class="mb-5">
                <div class="row ">
                    <div class="col-sm-4">
                        <label for="">Nombre de suscripción</label>
                        <input class="form-control" type="text" id="txtNombreSuscripcion" readonly>
                    </div>
                    <div class="col-sm-4">
                        <label for="">Fecha Inicio</label>
                        <input class="form-control" type="text" id="txtFechaInicio" readonly>
                    </div>
                    <div class="col-sm-4">
                        <label for="">Fecha Fin</label>
                        <input class="form-control" type="text" id="txtFechaFin" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <label for="">Precio</label>
                        <input class="form-control" type="text" id="txtPrecio" readonly>
                    </div>
                    <div class="col-sm-6">
                        <label for="">Método de Pago</label>
                        <input class="form-control" type="text" id="txtMetodoPago" readonly>
                    </div>
                </div>
            </div>

            <h4>Otras suscripciones</h4>
            <table id="tblSusc" class="table compact wrap w-100 border-1">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
                        <th>Precio</th>
                        <th>Medio de Pago</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>

</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    let table;

    function check() {
        if (isMobile()) {
            $("#cntComprarSuscripcion").removeClass("justify-content-end");
            $("#cntComprarSuscripcion").addClass("justify-content-start");
        } else {
            $("#cntComprarSuscripcion").addClass("justify-content-end");
            $("#cntComprarSuscripcion").removeClass("justify-content-start");
        }
    }
    $(window).resize(function() {
        check();
    });
    $(document).ready(() => {
        check();
        $("#lblNombreUsuario").text(localStorage.getItem("nombre"));
        table = new DataTable("#tblSusc", {
            "bPaginate": false, //hide pagination
            "bFilter": false, //hide Search bar
            "bInfo": false, // hide showing entries
            responsive: true
        });
        cargarSuscripciones();
    });

    function
    compararFechas(objeto1, objeto2) {
        var fechaHora1 = new Date(objeto1.fecha_hora_fin);
        var fechaHora2 = new
        Date(objeto2.fecha_hora_fin); // Ordenar de mayor a menor if (fechaHora1> fechaHora2) {
        if (fechaHora1 > fechaHora2) {
            return -1;
        } else if (fechaHora1 < fechaHora2) {
            return 1;
        } else {
            return 0;
        }
    }

    function cargarSuscripciones() {
        $.ajax({
            url: "<?= ENDPOINT ?>/historial_suscripciones/listar/" + empresa.id,
            method: "get",
            success: (data) => {
                let suscripciones = data.lista.sort(compararFechas);
                console.log(suscripciones);
                Swal.close();
                if (suscripciones.length > 0) {
                    $("#txtNombreSuscripcion").val(suscripciones[0].descripcion);
                    $("#txtFechaInicio").val(suscripciones[0].fecha_hora_inicio);
                    $("#txtFechaFin").val(suscripciones[0].fecha_hora_fin);
                    $("#txtPrecio").val(Number(suscripciones[0].precio).toFixed(2));
                    $("#txtMetodoPago").val(suscripciones[0].medio_pago);
                }
                //otras suscripciones
                for (let i = 1; i < suscripciones.length; i++) {
                    const sus = suscripciones[i];
                    table.row.add([
                        sus.descripcion,
                        sus.fecha_hora_inicio,
                        sus.fecha_hora_fin,
                        Number(sus.precio).toFixed(2),
                        sus.medio_pago
                    ]).draw();

                }
            }

        });
    }
</script>
<?= $this->endSection() ?>