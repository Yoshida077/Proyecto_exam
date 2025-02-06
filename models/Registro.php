<?php
require_once __DIR__ . "/BaseModel.php";

class Registro extends BaseModel
{
    public function getAll()
    {
        $stmt = $this->db->prepare("CALL GetAllRegistros()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("CALL GetRegistroById(?)");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($vehiculo_placa, $tipo, $detalles, $usuario_id, $infraccion_id, $patio_id)
    {
        $stmt = $this->db->prepare("CALL InsertVehiculoRegistro(?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$vehiculo_placa, $tipo, $detalles, $usuario_id, $infraccion_id, $patio_id]);
    }

    public function update($id, $detalles, $fecha_salida = null)
    {
        $stmt = $this->db->prepare("CALL UpdateRegistro(?, ?, ?)");
        return $stmt->execute([$id, $detalles, $fecha_salida]);
    }



    public function delete($id)
    {
        $stmt = $this->db->prepare("CALL DeleteRegistro(?)");
        return $stmt->execute([$id]);
    }
}
