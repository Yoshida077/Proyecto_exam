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
                <h2>Lista de Registros</h2>
                <a href="/gestionpatios/registros/create" class="btn btn-secondary mb-3">Agregar Registro</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Vehículo</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Detalles</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registros as $registro): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($registro["vehiculo_placa"]); ?></td>
                                <td><?php echo htmlspecialchars($registro["tipo"]); ?></td>
                                <td><?php echo htmlspecialchars($registro["fecha"]); ?></td>
                                <td><?php echo htmlspecialchars($registro["detalles"]); ?></td>
                                <td><?php echo htmlspecialchars($registro["usuario"]); ?></td>
                                <td>
                                    <a href="/gestionpatios/registros/edit?id=<?php echo $registro["id"]; ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="/gestionpatios/registros/delete?id=<?php echo $registro["id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este registro?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
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