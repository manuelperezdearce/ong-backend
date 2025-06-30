<?php

class Donaciones
{
    private $url = "./mock/donaciones.json";

    public function getAll()
    {
        // Leer archivo JSON
        $json = file_get_contents($this->url);
        // Convertir en array
        $data = json_decode($json, true);
        // Retornar array al controlador
        return $data;
    }
    public function create($nuevaDonacion)
    {
        // Leer las donaciones actuales
        $json = file_get_contents($this->url);
        $data = json_decode($json, true);

        // Agregar la nueva donación al array
        $data[] = $nuevaDonacion;

        // Guardar el array actualizado en el archivo JSON
        file_put_contents($this->url, json_encode($data, JSON_PRETTY_PRINT));

        // Retornar la nueva donación (opcional)
        return $nuevaDonacion;
    }
}
