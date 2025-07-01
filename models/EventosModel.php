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
    public function getOneByID($id)
    {
        // Leer archivo JSON
        $json = file_get_contents($this->url);
        // Convertir en array
        $data = json_decode($json, true);

        // Buscar el evento por ID
        foreach ($data as $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                return $item;
            }
        }
        // Si no se encuentra, retorna null
        return null;
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
    public function edit($id, $eventoEditado)
    {
        // Leer los eventos actuales
        $json = file_get_contents($this->url);
        $data = json_decode($json, true);

        // Buscar y actualizar el evento por ID
        foreach ($data as $index => $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                $data[$index] = $eventoEditado;
                break;
            }
        }

        // Guardar el array actualizado en el archivo JSON
        file_put_contents($this->url, json_encode($data, JSON_PRETTY_PRINT));
    }
    public function delete($id)
    {
        // Leer los eventos actuales
        $json = file_get_contents($this->url);
        $data = json_decode($json, true);

        // Filtrar el evento a eliminar
        $data = array_filter($data, function ($item) use ($id) {
            return !(isset($item['id']) && $item['id'] == $id);
        });

        // Reindexar el array para evitar huecos en los índices
        $data = array_values($data);

        // Guardar el array actualizado en el archivo JSON
        file_put_contents($this->url, json_encode($data, JSON_PRETTY_PRINT));
    }
}
