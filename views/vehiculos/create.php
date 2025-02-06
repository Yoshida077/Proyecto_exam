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
                <h2>Agregar Nuevo Vehículo</h2>
                <form action="/gestionpatios/vehiculos/store" method="POST">
                    <div class="mb-3">
                        <label for="placa" class="form-label">Placa</label>
                        <input type="text" name="placa" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="modelo_id" class="form-label">Modelo</label>
                        <select name="modelo_id" id="modeloSelect" class="form-control" required>
                            <option value="">Seleccione un modelo</option>
                            <?php foreach ($modelos as $modelo): ?>
                                <option value="<?php echo $modelo["id"]; ?>"
                                    data-marca="<?php echo htmlspecialchars($modelo["marca_nombre"] ?? 'Desconocida'); ?>">
                                    <?php echo htmlspecialchars($modelo["modelo_nombre"]); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" id="marcaInput" class="form-control" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="chasis" class="form-label">Chasis</label>
                        <input type="text" name="chasis" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="cant_puertas" class="form-label">Cantidad de Puertas</label>
                        <input type="number" name="cant_puertas" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="propietario_cedula" class="form-label">Propietario</label>
                        <select name="propietario_cedula" class="form-control" required>
                            <option value="">Seleccione un propietario</option>
                            <?php foreach ($propietarios as $propietario): ?>
                                <option value="<?php echo $propietario["cedula"]; ?>">
                                    <?php echo htmlspecialchars($propietario["nombre"]); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" class="form-control" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="/gestionpatios/vehiculos" class="btn btn-secondary">Cancelar</a>
                </form>

                <script>
                    document.getElementById('modeloSelect').addEventListener('change', function() {
                        let selectedOption = this.options[this.selectedIndex];
                        document.getElementById('marcaInput').value = selectedOption.dataset.marca;
                    });
                </script>

            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>

<script>
    document.getElementById('modeloSelect').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        document.getElementById('marcaInput').value = selectedOption.dataset.marca;
    });
</script>