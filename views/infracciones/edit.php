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
                <h2>Editar Infracción</h2>
                <form action="/gestionpatios/infracciones/update" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($infraccion["id"]); ?>">

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" name="descripcion" class="form-control" value="<?php echo htmlspecialchars($infraccion["descripcion"]); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="multa" class="form-label">Multa</label>
                        <input type="number" step="0.01" name="multa" class="form-control" value="<?php echo htmlspecialchars($infraccion["multa"]); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="/gestionpatios/infracciones" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>