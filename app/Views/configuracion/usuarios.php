<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Usuarios del sistema - <?= NOMBRE_APP ?></title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">

    <div class="row">
        <div class="col-6">
            <h3>Usuarios del sistema</h3>
        </div>
        <div class="col-6 d-flex flex-row flex-wrap align-content-center justify-content-end">
            <button id="btnNuevoEditar" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-plus"></i> Nuevo usuario</button>
        </div>
    </div>
    <div class="table-responsive">
        <table id="tblUsuarios" class="table table-striped table-hover dt-responsive display wrap compact">
            <thead>
                <tr>
                    <th>Datos Personales</th>
                    <th>Datos de Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <!-- -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Nuevo usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <label for="txtClaveProp">DNI</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" onkeyup="checkColor(this);" id="txtDNI" placeholder="77665544" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="" id="basic-addon2">
                                    <button type="button" id="btnBuscarDNI" class="btn btn-primary" style="border-start-start-radius: 0px;border-end-start-radius: 0px;"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="txtClaveProp">Nombres completos</label>
                            <input class="form-control" id="txtNombres" onkeyup="checkColor(this);" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="txtClaveProp">Apellido paterno</label>
                            <input class="form-control" id="txtApellidoPaterno" onkeyup="checkColor(this);" type="text">
                        </div>
                        <div class="col-sm-6">
                            <label for="txtClaveProp">Apellido materno</label>
                            <input class="form-control" id="txtApellidoMaterno" onkeyup="checkColor(this);" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="txtClaveProp">Fecha de Nacimiento</label>
                            <input class="form-control" id="txtFechaNacimiento" onkeyup="checkColor(this);" type="date">
                        </div>
                        <div class="col-sm-6">
                            <label for="txtClaveProp">Usuario</label>
                            <input class="form-control" id="txtUsuario" onkeyup="checkColor(this);" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="txtClaveProp">Correo</label>
                            <input class="form-control" id="txtCorreo" onkeyup="checkColor(this);" type="email">
                        </div>
                        <div class="col-sm-6">
                            <label for="txtClaveProp">Contraseña</label>
                            <input class="form-control" id="txtClave" onkeyup="checkColor(this);" type="password">
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-sm-12">
                            <label for="txtClaveProp">Tipo de Usuario</label>
                            <select class="form-select" id="cmbTipoUsuario">
                                <option value="">Seleccion tipo de usuario</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Logistica">Logistica</option>
                                <option value="Ventas">Ventas</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" checked id="chkHabilitado">
                        <label class="form-check-label" for="chkHabilitado"> Habilitado </label>
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
    let users = [];
    let user;

    $(document).ready(() => {
        table = new DataTable("#tblUsuarios");
        cargarUsuarios();
        //$("#btnGuardar").click();
    });

    $("#btnBuscarDNI").click(() => {
        let dni = $("#txtDNI").val();
        if (is_empty([dni]) || dni.length < 8) {
            Swal.fire({
                icon: "warning",
                title: "Ocurrió un error",
                html: "El DNI debe tener 8 caracteres",
                showCloseButton: false
            });
        } else {
            $.ajax({
                method: "post",
                url: "https://services-dev.innite.net/documento",
                data: {
                    tipo_documento: "dni",
                    documento: dni,
                    extendido: 0
                },
                beforeSend: () => {
                    Swal.fire({
                        title: "Obteniendo datos..."
                    });
                    Swal.showLoading();
                },
                success: (data) => {
                    if (data.code != null && data.code == 404) {
                        Swal.fire({
                            title: "DNI no encontrado",
                            text: "No se encontró información con el DNI " + dni,
                            icon: "warning"
                        });
                    } else {
                        $("#txtNombres").val(toLowerFirstLetter(data.nombres));
                        $("#txtApellidoPaterno").val(toLowerFirstLetter(data.apellidoPaterno));
                        $("#txtApellidoMaterno").val(toLowerFirstLetter(data.apellidoMaterno));
                        Swal.close();
                    }

                }

            });
        }
    });

    function cargarUsuarios() {
        $.ajax({
            method: "GET",
            url: `<?= ENDPOINT_USERS; ?>/usuario/listar/${empresa.id}`,
            headers: {
                "Authorization": `Bearer ${token}`
            },
            beforeSend: () => {

                Swal.fire({
                    title: "Cargando..."
                });
                Swal.showLoading();
            },
            success: (data) => {
                users = data.lista;
                for (let i = 0; i < users.length; i++) {
                    const user = users[i];

                    let btnEditar = document.createElement("a");
                    btnEditar.setAttribute("class", "btn btn-warning btn-sm me-1");

                    let btnEliminar = document.createElement("a");
                    btnEliminar.setAttribute("class", "btn btn-danger btn-sm me-1");

                    let pencil = document.createElement("i");
                    pencil.setAttribute("class", "fa fa-pencil");
                    btnEditar.appendChild(pencil);
                    btnEditar.setAttribute("onclick", "editar(" + i + ");");

                    let trash = document.createElement("i");
                    trash.setAttribute("class", "fa fa-trash text-white");
                    btnEliminar.appendChild(trash);
                    btnEliminar.setAttribute("onclick", "eliminar(" + i + ");");

                    let cnt = document.createElement("div");
                    cnt.appendChild(btnEditar);
                    cnt.appendChild(btnEliminar);

                    table.row.add([
                        "<strong>Nombres: </strong>" + user.nombre + " " + user.apellido_paterno + " " + user.apellido_materno + "<br>" +
                        "<strong>DNI: </strong> " + user.dni + "<br>" +
                        "<strong>F. Nac.: </strong> " + user.fecha_nacimiento + "<br>",
                        "<strong>Correo: </strong> " + user.correo + "<br>" +
                        "<strong>Usuario: </strong> " + user.usuario + "<br>" +
                        "<strong>Tipo usuario: </strong> " + user.tipo + "<br>" +
                        "<strong>Estado: </strong> " + (user.activo ? '<span class="text-success h6">Habilitado</span>' : '<span class="text-danger h6">Deshabilitado</span>') + "<br>" +
                        "<strong>F. Creación: </strong>" + user.fecha_creacion,
                        cnt.innerHTML
                    ]).draw();
                }
                Swal.close();
            }
        });
    }

    function checkColor(input) {
        if (input.value.length == 0) {
            $(input).addClass("border-danger");
        } else {
            $(input).removeClass("border-danger");
        }
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
                    url: `https://innite-properties-dev.innite.net/propiedades/eliminar/${empresa.id}/${properties[index].nombre}`,
                    headers: {
                        "Authorization": `Bearer ${token}`
                    },
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
        $("#staticBackdropLabel").text("Editar usuario");
    }
    $("#btnNuevoEditar").click(() => {
        $("#staticBackdropLabel").text("Nuevo usuario");
        reset_inputs(["#txtClaveProp", "#txtValorProp", "#txtDescripcion"]);
        property = null;
    });
</script>
<?= $this->endSection() ?>