<?php
require_once __DIR__ . "/BaseModel.php";

class Modelo extends BaseModel
{
    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT m.id, m.nombre AS modelo_nombre, ma.nombre AS marca_nombre
            FROM modelos m
            LEFT JOIN marcas ma ON m.marca_id = ma.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT modelos.*, marcas.nombre AS marca_nombre 
            FROM modelos
            LEFT JOIN marcas ON modelos.marca_id = marcas.id
            WHERE modelos.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($nombre, $marca_id)
    {
        $stmt = $this->db->prepare("INSERT INTO modelos (nombre, marca_id) VALUES (?, ?)");
        return $stmt->execute([$nombre, $marca_id]);
    }

    public function update($id, $nombre, $marca_id)
    {
        $stmt = $this->db->prepare("UPDATE modelos SET nombre = ?, marca_id = ? WHERE id = ?");
        return $stmt->execute([$nombre, $marca_id, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM modelos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
