<?php
require_once "BaseController.php";
require_once __DIR__ . "/../models/Modelo.php";
require_once __DIR__ . "/../models/Marca.php"; // Para obtener las marcas

class ModeloController extends BaseController
{
    public function index()
    {
        Auth::requirePermission("gestionar_modelos");
        $modeloModel = new Modelo();
        $modelos = $modeloModel->getAll();
        $this->view("modelos/index", ["modelos" => $modelos]);
    }

    public function create()
    {
        Auth::requirePermission("crear_modelo");
        $marcaModel = new Marca();
        $marcas = $marcaModel->getAll(); // Obtener todas las marcas para el select
        $this->view("modelos/create", ["marcas" => $marcas]);
    }

    public function store()
    {
        Auth::requirePermission("crear_modelo");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = $_POST["nombre"];
            $marca_id = $_POST["marca_id"];

            $modeloModel = new Modelo();
            $modeloModel->insert($nombre, $marca_id);

            header("Location: /gestionpatios/modelos");
            exit();
        }
    }

    public function edit()
    {
        Auth::requirePermission("editar_modelo");
        if (!isset($_GET["id"])) {
            echo "Error: No se proporcionó un ID válido.";
            return;
        }

        $id = $_GET["id"];
        $modeloModel = new Modelo();
        $modelo = $modeloModel->getById($id);

        if (!$modelo) {
            echo "Error: Modelo no encontrado.";
            return;
        }

        $marcaModel = new Marca();
        $marcas = $marcaModel->getAll(); // Obtener todas las marcas

        $this->view("modelos/edit", ["modelo" => $modelo, "marcas" => $marcas]);
    }

    public function update()
    {
        Auth::requirePermission("editar_modelo");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $nombre = $_POST["nombre"];
            $marca_id = $_POST["marca_id"];

            $modeloModel = new Modelo();
            $modeloModel->update($id, $nombre, $marca_id);

            header("Location: /gestionpatios/modelos");
            exit();
        }
    }

    public function delete()
    {
        Auth::requirePermission("eliminar_modelo");
        if (!isset($_GET["id"])) {
            echo "Error: No se proporcionó un ID válido.";
            return;
        }

        $id = $_GET["id"];
        $modeloModel = new Modelo();
        $modeloModel->delete($id);

        header("Location: /gestionpatios/modelos");
        exit();
    }
}
