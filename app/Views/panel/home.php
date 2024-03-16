<?= $this->extend('layout') ?>

<?= $this->section('header') ?>
<title>Panel - <?= NOMBRE_APP ?></title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <!-- Cuadros-->
    <div class="row">
        <div class="col-sm-3 mt-2 mb-2">
            <div class="card bg-transparent border-0">
                <div class="card-body py-0">
                    <div class="row text-white">
                        <div class="col-lg-3 bg-success bg-opacity-75 py-3 text-center d-inline-flex flex-column justify-content-around">
                            <i class="fa fa-coins fa-2x"></i>
                        </div>
                        <div class="col-lg-9 bg-success py-3">Ventas del día<br><span class="font-size-xx-large">999</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3 mt-2 mb-2">
            <div class="card bg-transparent border-0">
                <div class="card-body py-0">
                    <div class="row text-white">
                        <div class="col-lg-3 bg-secondary bg-opacity-75 py-3 text-center d-inline-flex flex-column justify-content-around">
                            <i class="fa fa-basket-shopping fa-2x"></i>

                        </div>
                        <div class="col-lg-9 bg-secondary py-3">Ventas del mes<br><span class="font-size-xx-large">19</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3 mt-2 mb-2">
            <div class="card bg-transparent border-0">
                <div class="card-body py-0">
                    <div class="row text-white">
                        <div class="col-lg-3 bg-warning bg-opacity-75 py-3 text-center d-inline-flex flex-column justify-content-around">
                            <i class="fa fa-calendar-week fa-2x"></i>

                        </div>
                        <div class="col-lg-9 bg-warning py-3">Citas para hoy<br><span class="font-size-xx-large">19</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3 mt-2 mb-2 ">
            <div class="card bg-transparent border-0">
                <div class="card-body py-0">
                    <div class="row text-white">
                        <div class="col-lg-3 bg-primary bg-opacity-75 py-3 text-center d-inline-flex flex-column justify-content-around">
                            <i class="fa fa-user-doctor fa-2x"></i>

                        </div>
                        <div class="col-lg-9 bg-primary py-3">Veterinarios<br><span class="font-size-xx-large">19</span></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--Citas-->
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>Mis citas para hoy</strong>
                </div>
                <div class="card-body">
                    <table class="table border">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Mascota</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Juanito Alimaña</td>
                                <td>Zet</td>
                                <td>10:50am</td>
                            </tr>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Ventas-->
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>Ventas del día</strong>
                </div>
                <div class="card-body">
                    <table class="table border">
                        <thead>
                            <tr>
                                <th>Cantidad</th>
                                <th>Producto</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Cambo Adulto 1/2kg</td>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>