<?php
require_once __DIR__ . "/../models/Registro.php";
require_once __DIR__ . "/../models/Vehiculo.php";
require_once __DIR__ . "/../models/Infraccion.php";
require_once __DIR__ . "/../models/Patio.php";

class RegistroController
{
    private $registroModel;
    private $vehiculoModel;
    private $infraccionModel;
    private $patioModel;

    public function __construct()
    {
        Auth::requirePermission("gestionar_registros");
        $this->registroModel = new Registro();
        $this->vehiculoModel = new Vehiculo();
        $this->infraccionModel = new Infraccion();
        $this->patioModel = new Patio();
    }

    public function index()
    {
        Auth::requirePermission("gestionar_registros");
        $registros = $this->registroModel->getAll();
        require_once __DIR__ . "/../views/registros/index.php";
    }

    public function create()
    {
        Auth::requirePermission("crear_registro");
        session_start();
        if (!isset($_SESSION["usuario"])) {
            header("Location: /gestionpatios/login");
            exit();
        }

        $vehiculos = $this->vehiculoModel->getAll();
        $infracciones = $this->infraccionModel->getAll();
        $patios = $this->patioModel->getAll();

        require_once __DIR__ . "/../views/registros/create.php";
    }

    public function store()
    {
        Auth::requirePermission("crear_registro");
        session_start();
        if (!isset($_SESSION["usuario"])) {
            header("Location: /gestionpatios/login");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $vehiculo_placa = $_POST["vehiculo_placa"];
            $tipo = $_POST["tipo"];
            $detalles = $_POST["detalles"];
            $usuario_id = $_SESSION["usuario"]["id"];
            $infraccion_id = !empty($_POST["infraccion_id"]) ? $_POST["infraccion_id"] : null;
            $patio_id = !empty($_POST["patio_id"]) ? $_POST["patio_id"] : null;

            $this->registroModel->insert($vehiculo_placa, $tipo, $detalles, $usuario_id, $infraccion_id, $patio_id);
            header("Location: /gestionpatios/registros");
            exit();
        }
    }

    public function edit()
    {
        Auth::requirePermission("editar_registro");
        if (!isset($_GET["id"])) {
            echo "Error: No se proporcionó un ID de registro.";
            exit();
        }

        $id = $_GET["id"];
        $registro = $this->registroModel->getById($id);

        if (!$registro) {
            echo "Error: Registro no encontrado.";
            exit();
        }

        require_once __DIR__ . "/../views/registros/edit.php";
    }



    public function update()
    {
        Auth::requirePermission("editar_registro");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"] ?? null;
            $detalles = $_POST["detalles"] ?? "";
            $fecha_salida = !empty($_POST["fecha_salida"]) ? $_POST["fecha_salida"] : null;

            if (!$id) {
                echo "Error: ID de registro no proporcionado.";
                exit();
            }

            $this->registroModel->update($id, $detalles, $fecha_salida);
            header("Location: /gestionpatios/registros");
            exit();
        }
    }




    public function delete()
    {
        Auth::requirePermission("eliminar_registro");
        $id = $_GET["id"] ?? null;
        if ($id) {
            $this->registroModel->delete($id);
        }
        header("Location: /gestionpatios/registros");
        exit();
    }
}
