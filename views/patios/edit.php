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
                <h2>Editar Patio</h2>
                <form action="/gestionpatios/patios/update" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($patio["id"]); ?>">

                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código</label>
                        <input type="text" name="codigo" class="form-control" value="<?php echo htmlspecialchars($patio["codigo"]); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" class="form-control" value="<?php echo htmlspecialchars($patio["direccion"]); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="capacidad" class="form-label">Capacidad</label>
                        <input type="number" name="capacidad" class="form-control" value="<?php echo htmlspecialchars($patio["capacidad"]); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="/gestionpatios/patios" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>