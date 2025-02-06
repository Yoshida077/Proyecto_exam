<?php
require_once __DIR__ . '/../routes/routes.php';

// Redirigir automáticamente al login si no hay URL
if (!isset($_GET['url']) || empty($_GET['url'])) {
    header("Location: /gestionpatios/public/index.php?url=login");
    exit();
}
