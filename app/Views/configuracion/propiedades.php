<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Propiedades del sistema - <?= NOMBRE_APP ?></title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-3 p-2">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h3>Propiedades del sistema</h3>
                    <p><span class="text-danger">Precaución:</span> Si desconoce su funcionamiento, no realice cambios.</p>
                </div>
                <div class="col-6 d-flex flex-row flex-wrap align-content-center justify-content-end">
                    <button id="btnNuevoEditar" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-plus"></i> Nueva propiedad</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tblPropiedades" class="table table-striped table-hover dt-responsive display wrap">
                    <thead>
                        <tr>
                            <th>Clave</th>
                            <th>Valor</th>
                            <th>Descripción</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Nueva propiedad</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="txtClaveProp">Clave</label>
                            <input class="form-control" id="txtClaveProp" onkeyup="checkColor(this);" type="text">
                        </div>
                        <div class="col-md-6">
                            <label for="txtValorProp">Valor</label>
                            <input class="form-control" id="txtValorProp" onkeyup="checkColor(this);" type="text">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-12">
                            <label for="txtClaveProp">Descripción de la propiedad</label>
                            <textarea class="form-control" id="txtDescripcion" onkeyup="checkColor(this);"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Fin modal-->

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    let table;
    let properties = [];
    let property;

    $(document).ready(() => {
        table = new DataTable("#tblPropiedades");
        cargarPropiedades();
        $("#btnGuardar").click(guardarPropiedad);
        $("#btnNuevoEditar").click(() => {
            $("#staticBackdropLabel").text("Nueva propiedad");
            reset_inputs(["#txtClaveProp", "#txtValorProp", "#txtDescripcion"]);
            property = null;
        });
    });

    function guardarPropiedad() {
        let clave = $("#txtClaveProp").val();
        let valor = $("#txtValorProp").val();
        let descripcion = $("#txtDescripcion").val();

        if (is_empty([clave, valor, descripcion])) {
            mostrarError({
                text: "Debe ingresar todos los datos."
            });
        } else {
            let data = {
                id_empresa: empresa.id,
                nombre: clave,
                valor: valor,
                descripcion: descripcion
            };
            if (property != null) {
                data.id = property.id;
            }
            $.ajax({
                method: "POST",
                url: `<?= ENDPOINT ?>/propiedades/${property == null ? "nuevo" : "editar"}`,
                data: data,
                success: (data) => {
                    console.log(data);
                    if (data.id > 0) {
                        reset_inputs(["#txtClaveProp", "#txtValorProp", "#txtDescripcion"]);
                        $(".btn-close")[0].click();
                        Swal.fire({
                            icon: "success",
                            text: "Propiedad guardada con éxito"
                        });
                        cargarPropiedades();
                    }
                }
            });
        }
    }

    function cargarPropiedades() {
        $.ajax({
            method: "GET",
            url: `<?= ENDPOINT ?>/propiedades/listar/${empresa.id}`,
            beforeSend: mostrarCargando(false),
            success: (data) => {
                properties = data.lista;

                for (let i = 0; i < data.lista.length; i++) {
                    const prop = data.lista[i];

                    let btnEditar = `<a class="btn btn-warning btn-sm me-1" onclick="editar(${i});"><i class="fa fa-pencil"></i></a>`;
                    let btnEliminar = `<a class="btn btn-danger btn-sm me-1" onclick="eliminar(${i});"><i class="fa fa-trash text-white"></i></a>`;
                    let cnt = `<div>${btnEditar}${btnEliminar}</div>`;

                    table.row.add([prop.nombre, prop.valor, prop.descripcion, cnt]).draw();
                }

                Swal.close();
            }
        });
    }

    function eliminar(index) {
        Swal.fire({
            title: "¿Seguro que deseas eliminar?",
            html: `Confirma los datos:<div class="text-start">  <br><strong>Propiedad:</strong> ${properties[index].nombre} <br><strong>Valor:</strong> ${properties[index].valor} <br><strong>Descripción:</strong> ${properties[index].descripcion}</div>`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Eliminar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "delete",
                    url: `<?= ENDPOINT ?>/propiedades/eliminar/${empresa.id}/${properties[index].nombre}`,
                    success: (data) => {
                        cargarPropiedades();
                    }
                });
            }
        });
    }

    function editar(index) {
        property = properties[index];
        $("#txtClaveProp").val(property.nombre);
        $("#txtValorProp").val(property.valor);
        $("#txtDescripcion").val(property.descripcion);
        $('#staticBackdrop').modal('show');
        $("#staticBackdropLabel").text("Editar propiedad");
    }

    function checkColor(input) {
        if (input.value.length == 0) {
            $(input).addClass("border-danger");
        } else {
            $(input).removeClass("border-danger");
        }
    }
</script>
<?= $this->endSection() ?>