<?php
require_once "BaseController.php";
require_once __DIR__ . "/../models/Marca.php";

class MarcaController extends BaseController
{
    public function index()
    {
        Auth::requirePermission("gestionar_marcas");
        $marcaModel = new Marca();
        $marcas = $marcaModel->getAll();
        $this->view("marcas/index", ["marcas" => $marcas]);
    }

    public function create()
    {
        Auth::requirePermission("crear_marca");
        $this->view("marcas/create");
    }

    public function store()
    {
        Auth::requirePermission("crear_marca");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = $_POST["nombre"];

            $marcaModel = new Marca();
            $marcaModel->insert($nombre);

            header("Location: /gestionpatios/marcas");
            exit();
        }
    }

    public function edit()
    {
        Auth::requirePermission("editar_marca");
        if (!isset($_GET["id"])) {
            echo "Error: No se proporcionó un ID válido.";
            return;
        }

        $id = $_GET["id"];
        $marcaModel = new Marca();
        $marca = $marcaModel->getById($id);

        if (!$marca) {
            echo "Error: Marca no encontrada.";
            return;
        }

        $this->view("marcas/edit", ["marca" => $marca]);
    }

    public function update()
    {
        Auth::requirePermission("editar_marca");
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $nombre = $_POST["nombre"];

            $marcaModel = new Marca();
            $marcaModel->update($id, $nombre);

            header("Location: /gestionpatios/marcas");
            exit();
        }
    }

    public function delete()
    {
        Auth::requirePermission("eliminar_marca");
        if (!isset($_GET["id"])) {
            echo "Error: No se proporcionó un ID válido.";
            return;
        }

        $id = $_GET["id"];
        $marcaModel = new Marca();
        $marcaModel->delete($id);

        header("Location: /gestionpatios/marcas");
        exit();
    }
}
