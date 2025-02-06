<?php
require_once __DIR__ . "/../models/Propietario.php";

class PropietarioController
{
    private $propietarioModel;

    public function __construct()
    {
        Auth::requirePermission("gestionar_propietarios");
        $this->propietarioModel = new Propietario();
    }

    public function index()
    {
        Auth::requirePermission("gestionar_propietarios");
        $propietarios = $this->propietarioModel->getAll();
        require_once __DIR__ . "/../views/propietarios/index.php";
    }

    public function create()
    {
        Auth::requirePermission("crear_propietario");
        require_once __DIR__ . "/../views/propietarios/create.php";
    }

    public function store()
    {
        Auth::requirePermission("crear_propietario");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cedula = $_POST["cedula"];
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $telefono = $_POST["telefono"];
            $email = $_POST["email"];

            $this->propietarioModel->insert($cedula, $nombre, $apellido, $telefono, $email);
            header("Location: /gestionpatios/propietarios");
            exit();
        }
    }

    public function edit()
    {
        Auth::requirePermission("editar_propietario");
        $cedula = $_GET["cedula"] ?? null;
        if (!$cedula) {
            header("Location: /gestionpatios/propietarios");
            exit();
        }

        $propietario = $this->propietarioModel->getById($cedula);
        require_once __DIR__ . "/../views/propietarios/edit.php";
    }

    public function update()
    {
        Auth::requirePermission("editar_propietario");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cedula = $_POST["cedula"];
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $telefono = $_POST["telefono"];
            $email = $_POST["email"];

            $this->propietarioModel->update($cedula, $nombre, $apellido, $telefono, $email);
            header("Location: /gestionpatios/propietarios");
            exit();
        }
    }

    public function delete()
    {
        Auth::requirePermission("eliminar_propietario");
        $cedula = $_GET["cedula"] ?? null;
        if ($cedula) {
            $this->propietarioModel->delete($cedula);
        }
        header("Location: /gestionpatios/propietarios");
        exit();
    }
}
