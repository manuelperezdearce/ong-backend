<?php

class Eventos
{
    private $url = "./mock/eventos.json";

    public function getAll()
    {
        // Leer archivo JSON
        $json = file_get_contents($this->url);
        // Convertir en array
        $data = json_decode($json, true);
        // Retornar array al controlador
        return $data;
    }
    public function create($nuevoEvento)
    {
        // Leer los eventos actuales
        $json = file_get_contents($this->url);
        $data = json_decode($json, true);

        // Agregar el nuevo evento al array
        $data[] = $nuevoEvento;

        // Guardar el array actualizado en el archivo JSON
        file_put_contents($this->url, json_encode($data, JSON_PRETTY_PRINT));

        // Retornar el nuevo evento (opcional)
        return $nuevoEvento;
    }
}
