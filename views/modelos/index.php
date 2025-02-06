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
                <h2>Lista de Modelos</h2>
                <a href="/gestionpatios/modelos/create" class="btn btn-secondary mb-3">Agregar Modelo</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre del Modelo</th>
                            <th>Marca</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($modelos as $modelo): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($modelo["modelo_nombre"]); ?></td>
                                <td><?php echo htmlspecialchars($modelo["marca_nombre"]); ?></td>
                                <td>
                                    <a href="/gestionpatios/modelos/edit?id=<?php echo $modelo["id"]; ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $modelo['id']; ?>)" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        if (confirm("¿Estás seguro de eliminar este modelo?")) {
            window.location.href = "/gestionpatios/modelos/delete?id=" + id;
        }
    }
</script>

<?php include __DIR__ . "/../layouts/footer.php"; ?>