<?php
require_once __DIR__ . "/../models/Usuario.php";

class AuthController
{
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->verificarCredenciales($email, $password);

            if ($usuario) {
                $_SESSION["usuario"] = $usuario;
                header("Location: /gestionpatios/dashboard");
                exit();
            } else {
                $error = "Correo o contraseña incorrectos.";
            }
        }

        require_once __DIR__ . "/../views/auth/login.php";
        exit();
    }


    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: /gestionpatios/login");
        exit();
    }
    public function register()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = trim($_POST["nombre"]);
            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);

            if (empty($nombre) || empty($email) || empty($password)) {
                echo "<script>
                        alert('Todos los campos son obligatorios.');
                        window.location.href='/gestionpatios/register';
                      </script>";
                exit();
            }

            $usuarioModel = new Usuario();
            $resultado = $usuarioModel->registrarUsuario($nombre, $email, $password);

            if ($resultado) {
                echo "<script>
                        alert('Usuario registrado correctamente. Inicia sesión.');
                        window.location.href='/gestionpatios/login';
                      </script>";
                exit();
            } else {
                echo "<script>
                        alert('Error al registrar el usuario.');
                        window.location.href='/gestionpatios/register';
                      </script>";
                exit();
            }
        } else {
            require_once __DIR__ . "/../views/auth/register.php";
            exit();
        }
    }
}
