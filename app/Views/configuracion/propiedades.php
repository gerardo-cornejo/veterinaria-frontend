<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Propiedades del sistema - <?= NOMBRE_APP ?></title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">

    <h3>Propieddes del sistema</h3>
    <p><span class="text-danger">Precaución:</span> Si desconoce su funcionamiento, no realice cambios.</p>
    <table id="tblPropiedades" class="table compact">
        <thead>
            <tr>
                <th>Clave</th>
                <th>Valor</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>January</td>
                <td>$100</td>
                <td>
                    <button class="btn btn-warning btn-sm"><i class="fa fa-pen"></i></button>
                    <button class="btn btn-danger text-white btn-sm"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>February</td>
                <td>$80</td>
                <td>
                    <button class="btn btn-warning btn-sm"><i class="fa fa-pen"></i></button>
                    <button class="btn btn-danger text-white btn-sm"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
    </table>


</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(() => {
        $("#tblPropiedades").dataTable();
    });
</script>
<?= $this->endSection() ?>