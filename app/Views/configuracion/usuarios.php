<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Usuarios del sistema - <?= NOMBRE_APP ?></title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-3 p-2">

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h3>Usuarios del sistema</h3>
                </div>
                <div class="col-6 d-flex flex-row flex-wrap align-content-center justify-content-end">
                    <button id="btnNuevoEditar" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-plus"></i> Nuevo usuario</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tblUsuarios" class="table  table-hover dt-responsive display wrap compact">
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
        </div>
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
                    <form action="#">
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="txtClaveProp">DNI</label>
                                <div class="input-group">
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
                                <label for="txtClaveProp">Correo</label>
                                <input class="form-control" id="txtCorreo" onkeyup="checkColor(this);" type="email" autocomplete="off">
                            </div>
                            <div class="col-sm-6">
                                <label for="txtClaveProp">Contraseña</label>
                                <input class="form-control" id="txtClave" onkeyup="checkColor(this);" type="password" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="txtClaveProp">Fecha de Nacimiento</label>
                                <input class="form-control" id="txtFechaNacimiento" onkeyup="checkColor(this);" type="date">
                            </div>
                            <div class="col-sm-6">
                                <label for="txtClaveProp">Tipo de Usuario</label>
                                <select class="form-select" id="cmbTipoUsuario">
                                    <option value="">Seleccion tipo de usuario</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Logistica">Logistica</option>
                                    <option value="Ventas">Ventas</option>
                                </select>
                            </div>
                        </div>
                    </form>

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
        $("#btnGuardar").click(guardarUsuario);
        $("#btnBuscarDNI").click(buscarDNI);
        $("#btnNuevoEditar").click(resetFormulario);
    });

    function buscarDNI() {
        let dni = $("#txtDNI").val();
        if (!dni || dni.length !== 8) {
            mostrarError({
                text: "El DNI debe tener 8 caracteres"
            });
        } else {
            $.ajax({
                method: "post",
                url: "<?= ENDPOINT; ?>/documento",
                data: {
                    tipo_documento: "dni",
                    documento: dni,
                    extendido: 0
                },
                //beforeSend: () => {},
                success: mostrarUsuarioEncontrado,
            });
        }
    }

    function cargarUsuarios() {
        $.ajax({
            method: "GET",
            url: `<?= ENDPOINT; ?>/usuario/listar/${empresa.id}`,
            headers: {
                "Authorization": `Bearer ${token}`
            },
            beforeSend: mostrarCargando,
            success: mostrarUsuarios,
            error: mostrarError
        });
    }

    function mostrarUsuarios(data) {
        table.clear().draw();
        users = data.lista;
        users.forEach((user, index) => {
            const btnEditar = `<a class="btn btn-warning btn-sm me-1" onclick="editar(${index});"><i class="fa fa-pencil"></i></a>`;
            // const btnEliminar = `<a class="btn btn-danger btn-sm me-1" onclick="eliminar(${index});"><i class="fa fa-trash text-white"></i></a>`;
            const estado = `<span class="${user.activo==1?"text-success":"text-danger"} h6">${user.activo==1?"Habilitado":"Deshabilitado"}</span>`;
            const rowData = [
                `<strong>Nombres: </strong>${user.nombre} ${user.apellido_paterno} ${user.apellido_materno}<br>
             <strong>DNI: </strong> ${user.dni}<br>
             <strong>F. Nac.: </strong> ${user.fecha_nacimiento}<br>`,
                `<strong>Correo: </strong> ${user.correo}<br>
             <strong>Usuario: </strong> ${user.usuario}<br>
             <strong>Tipo usuario: </strong> ${user.tipo}<br>
             <strong>Estado: </strong> ${estado}<br>
             <strong>F. Creación: </strong>${user.fecha_creacion}`,
                btnEditar /* + btnEliminar*/
            ];
            table.row.add(rowData).draw();
        });
        Swal.close();
    }

    function mostrarUsuarioEncontrado(data) {
        if (data.code != null && data.code == 404) {
            mostrarError({
                text: "DNI no encontrado"
            });
        } else {
            $("#txtNombres").val(toLowerFirstLetter(data.nombres));
            $("#txtApellidoPaterno").val(toLowerFirstLetter(data.apellidoPaterno));
            $("#txtApellidoMaterno").val(toLowerFirstLetter(data.apellidoMaterno));
            Swal.close();
        }
    }
    /*
        function eliminar(index) {
            const user = users[index];
            Swal.fire({
                title: "¿Seguro que deseas eliminar?",
                html: `Confirma los datos:<div class="text-start">  <br><strong>Propiedad:</strong> ${user.nombre} <br><strong>Valor:</strong> ${user.valor} <br><strong>Descripción:</strong> ${user.descripcion}</div>`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Eliminar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "delete",
                        url: `<?= ENDPOINT ?>/usuario/eliminar/${empresa.id}/${user.nombre}`,
                        headers: {
                            "Authorization": `Bearer ${token}`
                        },
                        success: cargarUsuarios,
                        error: mostrarError
                    });
                }
            });
        }
    */
    function editar(index) {
        user = users[index];
        $("#txtDNI").val(user.dni);
        $("#txtNombres").val(user.nombre);
        $("#txtApellidoPaterno").val(user.apellido_paterno);
        $("#txtApellidoMaterno").val(user.apellido_materno);
        $("#txtFechaNacimiento").val(user.fecha_nacimiento);
        $("#txtCorreo").val(user.correo);
        $("#txtCorreo").attr("readonly", "readonly");
        $("#txtCorreo").attr("disabled", "disabled");
        $("#cmbTipoUsuario").val(user.tipo);
        $("#chkHabilitado").prop("checked", user.activo == 1);
        $("#txtClave").attr("readonly", "readonly");
        $("#txtClave").attr("disabled", "disabled");
        $("#staticBackdropLabel").text("Editar usuario");
        $('#staticBackdrop').modal('show');
    }

    function resetFormulario() {
        $("#staticBackdropLabel").text("Nuevo usuario");
        reset_inputs(["#txtDNI", "#txtNombres", "#txtApellidoPaterno", "#txtApellidoMaterno", "#txtFechaNacimiento", "#txtCorreo", "#txtClave"]);
        $("#cmbTipoUsuario").val("");
        $("#txtClave").removeAttr("readonly");
        $("#txtClave").removeAttr("disabled");
        user = null;
    }

    function guardarUsuario() {
        const dni = $("#txtDNI").val();
        const nombres = $("#txtNombres").val();
        const apellido_paterno = $("#txtApellidoPaterno").val();
        const apellido_materno = $("#txtApellidoMaterno").val();
        const fecha_nacimiento = $("#txtFechaNacimiento").val();
        const correo = $("#txtCorreo").val();
        const clave = $("#txtClave").val();
        const tipo = $("#cmbTipoUsuario").val();
        const habilitado = $("#chkHabilitado").prop("checked");

        if (!dni || !nombres || !apellido_paterno || !apellido_materno || !fecha_nacimiento || !correo || !tipo) {
            mostrarError({
                text: "Todos los campos son requeridos."
            });
        } else {
            let data = {
                id_empresa: empresa.id,
                nombre: nombres,
                apellido_paterno: apellido_paterno,
                apellido_materno: apellido_materno,
                dni: dni,
                fecha_nacimiento: fecha_nacimiento,
                correo: correo,
                clave: clave,
                tipo: tipo,
                activo: habilitado ? 1 : 0
            };
            if (user != null) {
                data.id = user.id;

            } else if (!clave) {
                mostrarError({
                    text: "Todos los campos son requeridos."
                });
                return;
            }
            $.ajax({
                url: `<?= ENDPOINT ?>/usuario/${user==null?"nuevo":"editar"}`,
                method: "POST",
                data: data,
                beforeSend: mostrarCargando,
                success: (data) => {
                    console.log(data);
                    if (data.id > 0) {
                        Swal.fire({
                            icon: "success",
                            title: "Usuario guardado con éxito."
                        });
                        $('#staticBackdrop').modal('hide');
                        cargarUsuarios();
                    }
                },
                error: mostrarError
            });
        }
    }
</script>
<?= $this->endSection() ?>