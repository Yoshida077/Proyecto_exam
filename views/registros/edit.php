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

<div class="container-fluid">
    <div class="row">
        <div class="col-3">
            <?php include __DIR__ . "/../layouts/sidebar.php"; ?>
        </div>
        <div class="col-9">
            <div class="container mt-5">
                <h2>Editar Registro</h2>
                <form action="/gestionpatios/registros/update" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($registro["id"]); ?>">
                    <div class="mb-3">
                        <label for="vehiculo_placa" class="form-label">Vehículo</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($registro["vehiculo_placa"]); ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo de Registro</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($registro["tipo"]); ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="detalles" class="form-label">Detalles</label>
                        <textarea name="detalles" class="form-control"><?php echo htmlspecialchars($registro["detalles"]); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_salida" class="form-label">Fecha de Salida</label>
                        <input type="datetime-local" name="fecha_salida" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="/gestionpatios/registros" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . "/../layouts/footer.php"; ?>