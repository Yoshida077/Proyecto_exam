<?php
require_once __DIR__ . "/BaseModel.php";

class Usuario extends BaseModel
{
    public function verificarCredenciales($email, $password)
    {
        $stmt = $this->db->prepare("
            SELECT u.*, r.nombre AS rol 
            FROM usuarios u
            LEFT JOIN roles r ON u.rol_id = r.id
            WHERE u.email = ? 
            LIMIT 1
        ");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario || !password_verify($password, $usuario['password'])) {
            return false;
        }

        // Obtener permisos del usuario
        $stmt = $this->db->prepare("
            SELECT p.nombre 
            FROM permisos p
            JOIN rol_permiso rp ON p.id = rp.permiso_id
            WHERE rp.rol_id = ?
        ");
        $stmt->execute([$usuario["rol_id"]]);
        $usuario["permisos"] = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $usuario;
    }



    public function registrarUsuario($nombre, $email, $password)
    {
        // Verificar si el email ya está registrado
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return false; // Usuario ya existe
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$nombre, $email, $hashedPassword]);
    }
}
