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
                <h2>Agregar Nuevo Registro</h2>
                <form action="/gestionpatios/registros/store" method="POST">
                    <div class="mb-3">
                        <label for="vehiculo_placa" class="form-label">Vehículo</label>
                        <select name="vehiculo_placa" class="form-control" required>
                            <option value="">Seleccione un vehículo</option>
                            <?php foreach ($vehiculos as $vehiculo): ?>
                                <option value="<?php echo htmlspecialchars($vehiculo["placa"]); ?>">
                                    <?php echo htmlspecialchars($vehiculo["placa"] . " - " . ($vehiculo["modelo"] ?? "Desconocido")); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo de Registro</label>
                        <select name="tipo" class="form-control" required>
                            <option value="Liberación">Liberación</option>
                            <option value="Baja">Baja</option>
                            <option value="Custodia">Custodia</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="infraccion_id" class="form-label">Infracción</label>
                        <select name="infraccion_id" class="form-control">
                            <option value="">Sin Infracción</option>
                            <?php foreach ($infracciones as $infraccion): ?>
                                <option value="<?php echo $infraccion["id"]; ?>">
                                    <?php echo htmlspecialchars($infraccion["descripcion"]); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="patio_id" class="form-label">Asignar a Patio</label>
                        <select name="patio_id" class="form-control">
                            <option value="">Sin Patio</option>
                            <?php foreach ($patios as $patio): ?>
                                <option value="<?php echo $patio["id"]; ?>">
                                    <?php echo htmlspecialchars($patio["codigo"] . " - " . $patio["direccion"]); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="detalles" class="form-label">Detalles</label>
                        <textarea name="detalles" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="/gestionpatios/registros" class="btn btn-secondary">Cancelar</a>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>