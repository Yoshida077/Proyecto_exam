<?php
require_once __DIR__ . "/../controllers/AuthController.php";
require_once __DIR__ . "/../controllers/MarcaController.php";
require_once __DIR__ . "/../controllers/ModeloController.php";
require_once __DIR__ . "/../controllers/VehiculoController.php";
require_once __DIR__ . "/../controllers/PropietarioController.php";
require_once __DIR__ . "/../controllers/InfraccionController.php";
require_once __DIR__ . "/../controllers/RegistroController.php";
require_once __DIR__ . "/../controllers/PatioController.php";




$routes = [
    // Autenticación
    "login" => "AuthController@login",
    "logout" => "AuthController@logout",
    "register" => "AuthController@register",

    // CRUD de Marcas
    "marcas" => "MarcaController@index",
    "marcas/create" => "MarcaController@create",
    "marcas/store" => "MarcaController@store",
    "marcas/edit" => "MarcaController@edit",
    "marcas/update" => "MarcaController@update",
    "marcas/delete" => "MarcaController@delete",

    // CRUD de Modelos
    "modelos" => "ModeloController@index",
    "modelos/create" => "ModeloController@create",
    "modelos/store" => "ModeloController@store",
    "modelos/edit" => "ModeloController@edit",
    "modelos/update" => "ModeloController@update",
    "modelos/delete" => "ModeloController@delete",

    // CRUD de Vehículos
    "vehiculos" => "VehiculoController@index",
    "vehiculos/create" => "VehiculoController@create",
    "vehiculos/store" => "VehiculoController@store",
    "vehiculos/edit" => "VehiculoController@edit",
    "vehiculos/update" => "VehiculoController@update",
    "vehiculos/delete" => "VehiculoController@delete",

    // CRUD de Infracciones
    "infracciones" => "InfraccionController@index",
    "infracciones/create" => "InfraccionController@create",
    "infracciones/store" => "InfraccionController@store",
    "infracciones/edit" => "InfraccionController@edit",
    "infracciones/update" => "InfraccionController@update",
    "infracciones/delete" => "InfraccionController@delete",

    // CRUD de Registros
    "registros" => "RegistroController@index",
    "registros/create" => "RegistroController@create",
    "registros/store" => "RegistroController@store",
    "registros/edit" => "RegistroController@edit",
    "registros/update" => "RegistroController@update",
    "registros/delete" => "RegistroController@delete",


    // CRUD de Patios
    "patios" => "PatioController@index",
    "patios/create" => "PatioController@create",
    "patios/store" => "PatioController@store",
    "patios/edit" => "PatioController@edit",
    "patios/update" => "PatioController@update",
    "patios/delete" => "PatioController@delete",

    // Rutas de propietarios
    "propietarios" => "PropietarioController@index",
    "propietarios/create" => "PropietarioController@create",
    "propietarios/store" => "PropietarioController@store",
    "propietarios/edit" => "PropietarioController@edit",
    "propietarios/update" => "PropietarioController@update",
    "propietarios/delete" => "PropietarioController@delete",

];

// Redireccionar al login si la URL está vacía
if (!isset($_GET['url']) || empty($_GET['url'])) {
    header("Location: login");
    exit();
}

// Cargar el dashboard
if ($_GET['url'] === "dashboard") {
    require_once __DIR__ . "/../views/dashboard.php";
    exit();
}

// Manejo de rutas dinámico
if (array_key_exists($_GET['url'], $routes)) {
    $route = explode("@", $routes[$_GET['url']]);
    $controllerName = $route[0];
    $method = $route[1];

    // Verificar si la clase existe
    if (class_exists($controllerName)) {
        $controller = new $controllerName();

        // Verificar si el método existe en el controlador
        if (method_exists($controller, $method)) {
            $controller->$method();
        } else {
            echo "Error: Método '$method' no encontrado en el controlador '$controllerName'.";
        }
    } else {
        echo "Error: Controlador '$controllerName' no encontrado.";
    }
} else {
    echo "Página no encontrada";
}
