<?php
require_once __DIR__ . "/BaseModel.php";

class Propietario extends BaseModel
{
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM propietarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($cedula)
    {
        $stmt = $this->db->prepare("SELECT * FROM propietarios WHERE cedula = ?");
        $stmt->execute([$cedula]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($cedula, $nombre, $apellido, $telefono, $email)
    {
        $stmt = $this->db->prepare("INSERT INTO propietarios (cedula, nombre, apellido, telefono, email) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$cedula, $nombre, $apellido, $telefono, $email]);
    }

    public function update($cedula, $nombre, $apellido, $telefono, $email)
    {
        $stmt = $this->db->prepare("UPDATE propietarios SET nombre = ?, apellido = ?, telefono = ?, email = ? WHERE cedula = ?");
        return $stmt->execute([$nombre, $apellido, $telefono, $email, $cedula]);
    }

    public function delete($cedula)
    {
        $stmt = $this->db->prepare("DELETE FROM propietarios WHERE cedula = ?");
        return $stmt->execute([$cedula]);
    }
}
