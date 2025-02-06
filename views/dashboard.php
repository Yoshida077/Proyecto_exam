<?php

if (!isset($_SESSION["usuario"])) {
    header("Location: /gestionpatios/login");
    exit();
}
$usuario = $_SESSION["usuario"];

require_once __DIR__ . "/../models/Marca.php";
require_once __DIR__ . "/../models/Modelo.php";
require_once __DIR__ . "/../models/Vehiculo.php";
require_once __DIR__ . "/../models/Propietario.php";
require_once __DIR__ . "/../models/Infraccion.php";
require_once __DIR__ . "/../models/Patio.php";
require_once __DIR__ . "/../models/Registro.php";

// Crear instancias de los modelos
$marcaModel = new Marca();
$modeloModel = new Modelo();
$vehiculoModel = new Vehiculo();
$propietarioModel = new Propietario();
$infraccionModel = new Infraccion();
$patioModel = new Patio();
$registroModel = new Registro();

// Obtener el total de registros
$totalMarcas = count($marcaModel->getAll());
$totalModelos = count($modeloModel->getAll());
$totalVehiculos = count($vehiculoModel->getAll());
$totalPropietarios = count($propietarioModel->getAll());
$totalInfracciones = count($infraccionModel->getAll());
$totalPatios = count($patioModel->getAll());
$totalRegistros = count($registroModel->getAll());
?>

<?php include __DIR__ . "/layouts/header.php"; ?>
<?php include __DIR__ . "/layouts/navbar.php"; ?>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-3 sidebar">
            <?php include __DIR__ . "/layouts/sidebar.php"; ?>
        </div>
        <div class="col-9" style="margin-left: 250px;">
            <div class="container mt-5">
                <h2>Bienvenido, <?php echo htmlspecialchars($usuario["nombre"]); ?>!</h2>
                <p>Has iniciado sesión correctamente.</p>

                <!-- Tarjetas de Información -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-2">
                            <div class="card-header text-center"><i class="fas fa-tags"></i> Marcas</div>
                            <div class="card-body text-center">
                                <h4 class="card-title"><?php echo $totalMarcas; ?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-white bg-dark mb-2">
                            <div class="card-header text-center"><i class="fas fa-car-side"></i> Modelos</div>
                            <div class="card-body text-center">
                                <h4 class="card-title"><?php echo $totalModelos; ?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-white bg-info mb-2">
                            <div class="card-header text-center"><i class="fas fa-car"></i> Vehículos</div>
                            <div class="card-body text-center">
                                <h4 class="card-title"><?php echo $totalVehiculos; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-2">
                            <div class="card-header text-center"><i class="fas fa-user"></i> Propietarios</div>
                            <div class="card-body text-center">
                                <h4 class="card-title"><?php echo $totalPropietarios; ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-header text-center"><i class="fas fa-exclamation-triangle"></i> Infracciones</div>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo $totalInfracciones; ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-secondary mb-3">
                            <div class="card-header text-center"><i class="fas fa-warehouse"></i> Patios</div>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo $totalPatios; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-header text-center"><i class="fas fa-clipboard-list"></i> Registros</div>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo $totalRegistros; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <!-- Gráficos con Chart.js -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <canvas id="chartEstadisticas"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="chartDistribucion"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/layouts/footer.php"; ?>

<!-- Cargar Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Datos de estadísticas
        const labels = ["Marcas", "Modelos", "Vehículos", "Propietarios", "Infracciones", "Patios", "Registros"];
        const data = [<?php echo $totalMarcas; ?>, <?php echo $totalModelos; ?>, <?php echo $totalVehiculos; ?>,
            <?php echo $totalPropietarios; ?>, <?php echo $totalInfracciones; ?>, <?php echo $totalPatios; ?>,
            <?php echo $totalRegistros; ?>
        ];

        // Gráfico de Barras
        const ctx1 = document.getElementById("chartEstadisticas").getContext("2d");
        new Chart(ctx1, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    label: "Cantidad de Registros",
                    data: data,
                    backgroundColor: ["blue", "black", "skyblue", "green", "red", "gray", "purple"],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de Pastel
        const ctx2 = document.getElementById("chartDistribucion").getContext("2d");
        new Chart(ctx2, {
            type: "pie",
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: ["blue", "black", "skyblue", "green", "red", "gray", "purple"]
                }]
            },
            options: {
                responsive: true
            }
        });
    });
</script>