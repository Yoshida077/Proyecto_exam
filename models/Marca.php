<?php
require_once __DIR__ . "/BaseModel.php";

class Marca extends BaseModel
{
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM marcas");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM marcas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($nombre)
    {
        $stmt = $this->db->prepare("INSERT INTO marcas (nombre) VALUES (?)");
        return $stmt->execute([$nombre]);
    }

    public function update($id, $nombre)
    {
        $stmt = $this->db->prepare("UPDATE marcas SET nombre = ? WHERE id = ?");
        return $stmt->execute([$nombre, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM marcas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
