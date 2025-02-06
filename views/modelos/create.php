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
                <h2>Agregar Modelo</h2>
                <form action="/gestionpatios/modelos/store" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Modelo</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="marca_id" class="form-label">Marca</label>
                        <select name="marca_id" class="form-control" required>
                            <?php foreach ($marcas as $marca): ?>
                                <option value="<?php echo $marca["id"]; ?>"><?php echo htmlspecialchars($marca["nombre"]); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="/gestionpatios/modelos" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>