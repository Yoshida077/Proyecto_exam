<?php
session_start();

class Auth
{
    // Verifica si el usuario ha iniciado sesión
    public static function isLoggedIn()
    {
        return isset($_SESSION["usuario"]);
    }

    // Retorna los datos del usuario logueado
    public static function getUser()
    {
        return $_SESSION["usuario"] ?? null;
    }

    // Verifica si el usuario tiene un rol específico
    public static function hasRole($role)
    {
        return self::isLoggedIn() && $_SESSION["usuario"]["rol"] === $role;
    }

    // Verifica si el usuario tiene un permiso específico
    public static function hasPermission($permission)
    {
        return self::isLoggedIn() && in_array($permission, $_SESSION["usuario"]["permisos"]);
    }

    // Bloquea el acceso si el usuario no tiene el permiso requerido
    public static function requirePermission($permission)
    {
        if (!self::hasPermission($permission)) {
            header("Location: /gestionpatios/403");
            exit();
        }
    }

    // Cierra la sesión del usuario
    public static function logout()
    {
        session_destroy();
        header("Location: /gestionpatios/login");
        exit();
    }
}
