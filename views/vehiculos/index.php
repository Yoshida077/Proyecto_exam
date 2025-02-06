<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["usuario"])) {
    header("Location: /gestionpatios/login");
    exit();
}
$usuario = $_SESSION["usuario"];
?>
<?php include __DIR__ . "/../layouts/header.php"; ?>
<?php include __DIR__ . "/../layouts/navbar.php"; ?>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-3">
            <?php include __DIR__ . "/../layouts/sidebar.php"; ?>
        </div>
        <div class="col-9">
            <div class="container mt-5">
                <h2>Lista de Vehículos</h2>
                <a href="/gestionpatios/vehiculos/create" class="btn btn-secondary mb-3">Agregar Vehículo</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Placa</th>
                            <th>Modelo</th>
                            <th>Marca</th>
                            <th>Chasis</th>
                            <th>Propietario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vehiculos as $vehiculo): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($vehiculo["placa"]); ?></td>
                                <td><?php echo htmlspecialchars($vehiculo["modelo"]); ?></td>
                                <td><?php echo htmlspecialchars($vehiculo["marca"]); ?></td>
                                <td><?php echo htmlspecialchars($vehiculo["chasis"]); ?></td>
                                <td><?php echo htmlspecialchars($vehiculo["propietario"]); ?></td>
                                <td><?php echo $vehiculo["estado"] == 1 ? "Activo" : "Inactivo"; ?></td>
                                <td>
                                    <a href="/gestionpatios/vehiculos/edit?placa=<?php echo $vehiculo["placa"]; ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="/gestionpatios/vehiculos/delete?placa=<?php echo $vehiculo["placa"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este vehículo?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>