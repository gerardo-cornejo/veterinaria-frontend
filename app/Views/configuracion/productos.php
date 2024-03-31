<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Mis Productos - <?= NOMBRE_APP ?></title>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div class="container pt-3">
    <div class="card">
        <div class="card-header">
            <h4><i class="fa fa-box"></i> Mis Productos</h4>
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
                            <strong>Precio: </strong>S/. ${Number(producto.precio).toFixed(2)}
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
</script>

<?= $this->endSection() ?>