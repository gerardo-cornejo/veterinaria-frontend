<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Mis Productos - <?= NOMBRE_APP ?></title>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div class="container pt-3">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4><i class="fa fa-box"></i> Mis Productos</h4>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-plus"></i> Nuevo Producto</button>
            </div>
        </div>
        <div class="card-body">
            <p>Gestiona tus productos aquí.</p>
            <div class="table-responsive">
                <table id="tblProductos" class="table compact  w-100 wrap">
                    <thead>
                        <tr>
                            <th>Imagen</th>
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
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa fa-box text-secondary"></i> Nuevo Producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Seleccione imagen de producto</h6>
                        <div class="text-center">
                            <img class="img-thumbnail" style="max-height: 150px;" id="imgProducto" src="<?= ENDPOINT ?>/imagenes/productos/producto.jpg" alt="#">
                        </div>
                        <input class="form-control form-control-sm mt-2" type="file" id="inputProducto" accept="image/png, image/gif, image/jpeg">
                    </div>
                    <div class="col-md-6">
                        <h6>Información del producto</h6>
                        <div class="row">
                            <div class="col-12">
                                <label for="txtNombre">Nombre</label>
                                <input id="txtNombre" class="form-control" type="text" placeholder="Ej. Canbo adultos 1kg">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="txtPrecio">Precio (S/.)</label>
                                <input id="txtPrecio" class="form-control" type="number" placeholder="12.34">
                            </div>
                            <div class="col-md-6">
                                <label for="txtStock">Stock</label>
                                <input id="txtStock" class="form-control" min="-1" max="999" type="number" placeholder="10">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-close"></i> Cerrar </button>
                <button id="btnGuardar" type="button" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    let table;

    $(document).ready(() => {
        table = new DataTable("#tblProductos", {
            responsive: true
        });
        cargarProductos();
    });
    $("#btnGuardar").click(guardar);
    //Bendíceme, Jiafei T_T
    function cargarProductos() {
        $.ajax({
            method: "get",
            url: "<?= ENDPOINT ?>/productos/listar/" + empresa.id,
            success: (data) => {
                for (const producto of data.lista) {
                    console.log(producto);
                    table.row.add([
                        `<img class="img-thumbnail" style="width:64px; height: 64px;" alt="CANBO DOG CORDERO CACHORRO RAZA PEQUEÑA 1kg" src="${producto.imagen}">`,
                        `
                            <strong>Nombre: </strong>${producto.nombre}<br>
                            <strong>Precio: </strong>S/. ${Number(producto.precio).toFixed(2)}<br>
                            <strong>Stock: </strong> ${producto.stock==-1?"ilimitado":producto.stock}
                        `,
                        `
                            <div class="btn-group">
                                <button class="btn btn-info"><i class="fa fa-eye text-white"></i></button>
                                <button class="btn btn-warning"><i class="fa fa-pen text-white"></i></button>
                                <button class="btn btn-danger"><i class="fa fa-trash text-white"></i></button>
                            </div>
                        `
                    ]).draw();
                }
                table.responsive.rebuild().draw();
                table.responsive.recalc().draw();
                table.columns.adjust().draw();
                Swal.close();
            }
        });
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imgProducto').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#imgProducto').attr('src', '<?= ENDPOINT ?>/imagenes/productos/producto.jpg');
        }
    }

    $("#inputProducto").change(function() {
        readURL(this);
    });


    function guardar() {
        let nombre = $("#txtNombre").val();
        let precio = $("#txtPrecio").val();
        let stock = $("#txtStock").val();
        let files = document.getElementById("inputProducto").files;
        if (!nombre || !precio || !stock || !files.length) {
            Swal.fire({
                icon: "warning",
                title: "Faltan datos",
                text: "Debe ingresar el nombre, precio, stock y una imagen para el producto."
            })
        } else {
            let data = new FormData();
            data.append("id_empresa", empresa.id);
            data.append("nombre", nombre);
            data.append("precio", precio);
            data.append("imgProducto", files[0]);
            data.append("stock", stock);

            $.ajax({
                method: "post",
                url: `<?= ENDPOINT ?>/productos/nuevo`,
                data: data,
                contentType: false, // Indica a jQuery que no configure el Content-Type
                processData: false, // Indica a jQuery que no procese los datos
                success: function(response) {
                    console.log(response);
                }
            });
        }

    }
</script>

<?= $this->endSection() ?>