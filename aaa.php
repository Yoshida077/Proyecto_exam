<?php
$host = "localhost";
$dbname = "gestion_patios"; // Asegúrate de que es el nombre correcto de tu base de datos
$username = "root"; // Cambia si tienes otro usuario
$password = ""; // Cambia si tienes una contraseña en MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $hashedPassword = password_hash("admin123", PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    $stmt->execute(["Admin", "admin@example.com", $hashedPassword]);

    echo "Usuario creado correctamente.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
