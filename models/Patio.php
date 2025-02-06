<?php
require_once __DIR__ . "/BaseModel.php";

class Patio extends BaseModel
{
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM patios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM patios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($codigo, $direccion, $capacidad)
    {
        $stmt = $this->db->prepare("INSERT INTO patios (codigo, direccion, capacidad) VALUES (?, ?, ?)");
        return $stmt->execute([$codigo, $direccion, $capacidad]);
    }

    public function update($id, $codigo, $direccion, $capacidad)
    {
        $stmt = $this->db->prepare("UPDATE patios SET codigo = ?, direccion = ?, capacidad = ? WHERE id = ?");
        return $stmt->execute([$codigo, $direccion, $capacidad, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM patios WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function countAll()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM patios");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)["total"];
    }
}
