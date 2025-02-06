<?php
require_once __DIR__ . "/BaseModel.php";

class Vehiculo extends BaseModel
{
    public function getAll()
    {
        $stmt = $this->db->prepare("CALL GetAllVehiculos()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getById($placa)
    {
        $stmt = $this->db->prepare("CALL GetVehiculoByPlaca(?)");
        $stmt->execute([$placa]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($placa, $modelo_id, $chasis, $cant_puertas, $propietario_cedula, $estado)
    {
        $stmt = $this->db->prepare("CALL InsertVehiculo(?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$placa, $modelo_id, $chasis, $cant_puertas, $propietario_cedula, $estado]);
    }

    public function update($placa, $modelo_id, $chasis, $cant_puertas, $propietario_cedula, $estado)
    {
        $stmt = $this->db->prepare("CALL UpdateVehiculo(?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$placa, $modelo_id, $chasis, $cant_puertas, $propietario_cedula, $estado]);
    }

    public function delete($placa)
    {
        $stmt = $this->db->prepare("CALL DeleteVehiculo(?)");
        return $stmt->execute([$placa]);
    }
}
