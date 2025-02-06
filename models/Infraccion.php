<?php
require_once __DIR__ . "/BaseModel.php";

class Infraccion extends BaseModel
{
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM infracciones");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM infracciones WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($descripcion, $multa)
    {
        $stmt = $this->db->prepare("INSERT INTO infracciones (descripcion, multa) VALUES (?, ?)");
        return $stmt->execute([$descripcion, $multa]);
    }

    public function update($id, $descripcion, $multa)
    {
        $stmt = $this->db->prepare("UPDATE infracciones SET descripcion = ?, multa = ? WHERE id = ?");
        return $stmt->execute([$descripcion, $multa, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM infracciones WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
