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
                <h2>Lista de Patios</h2>
                <a href="/gestionpatios/patios/create" class="btn btn-secondary mb-3">Agregar Patio</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Dirección</th>
                            <th>Capacidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patios as $patio): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($patio["codigo"]); ?></td>
                                <td><?php echo htmlspecialchars($patio["direccion"]); ?></td>
                                <td><?php echo htmlspecialchars($patio["capacidad"]); ?></td>
                                <td>
                                    <a href="/gestionpatios/patios/edit?id=<?php echo $patio["id"]; ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="/gestionpatios/patios/delete?id=<?php echo $patio["id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este patio?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
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