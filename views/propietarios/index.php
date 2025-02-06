<?php
if (!isset($_SESSION["usuario"])) {
    header("Location: /gestionpatios/login");
    exit();
}
$usuario = $_SESSION["usuario"];
?>
<?php include __DIR__ . "/../layouts/header.php"; ?>
<?php include __DIR__ . "/../layouts/navbar.php"; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-3">
            <?php include __DIR__ . "/../layouts/sidebar.php"; ?>
        </div>
        <div class="col-9">
            <div class="container mt-5">
                <h2>Lista de Propietarios</h2>
                <a href="/gestionpatios/propietarios/create" class="btn btn-secondary mb-3">Agregar Propietario</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($propietarios as $propietario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($propietario["cedula"]); ?></td>
                                <td><?php echo htmlspecialchars($propietario["nombre"]); ?></td>
                                <td><?php echo htmlspecialchars($propietario["apellido"]); ?></td>
                                <td><?php echo htmlspecialchars($propietario["telefono"] ?? "No registrado"); ?></td>
                                <td><?php echo htmlspecialchars($propietario["email"] ?? "No registrado"); ?></td>
                                <td>
                                    <a href="/gestionpatios/propietarios/edit?cedula=<?php echo $propietario["cedula"]; ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="/gestionpatios/propietarios/delete?cedula=<?php echo $propietario["cedula"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este propietario?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
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