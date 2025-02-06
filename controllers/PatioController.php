<?php
require_once __DIR__ . "/../models/Patio.php";

class PatioController
{
    private $patioModel;

    public function __construct()
    {
        Auth::requirePermission("gestionar_patios");
        $this->patioModel = new Patio();
    }

    public function index()
    {
        Auth::requirePermission("gestionar_patios");
        $patios = $this->patioModel->getAll();
        require_once __DIR__ . "/../views/patios/index.php";
    }

    public function create()
    {
        Auth::requirePermission("crear_patio");
        require_once __DIR__ . "/../views/patios/create.php";
    }

    public function store()
    {
        Auth::requirePermission("crear_patio");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $codigo = $_POST["codigo"];
            $direccion = $_POST["direccion"];
            $capacidad = $_POST["capacidad"];

            $this->patioModel->insert($codigo, $direccion, $capacidad);
            header("Location: /gestionpatios/patios");
            exit();
        }
    }

    public function edit()
    {
        Auth::requirePermission("editar_patio");
        $id = $_GET["id"] ?? null;
        if (!$id) {
            header("Location: /gestionpatios/patios");
            exit();
        }

        $patio = $this->patioModel->getById($id);
        require_once __DIR__ . "/../views/patios/edit.php";
    }

    public function update()
    {
        Auth::requirePermission("editar_patio");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $codigo = $_POST["codigo"];
            $direccion = $_POST["direccion"];
            $capacidad = $_POST["capacidad"];

            $this->patioModel->update($id, $codigo, $direccion, $capacidad);
            header("Location: /gestionpatios/patios");
            exit();
        }
    }

    public function delete()
    {
        Auth::requirePermission("eliminar_patio");
        $id = $_GET["id"] ?? null;
        if ($id) {
            $this->patioModel->delete($id);
        }
        header("Location: /gestionpatios/patios");
        exit();
    }
}
