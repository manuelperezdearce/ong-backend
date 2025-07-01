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

    public function getOneByID($id)
    {
        $json = file_get_contents($this->url);
        $data = json_decode($json, true);

        foreach ($data as $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                return $item;
            }
        }
        return null;
    }

    public function create($nuevaDonacion)
    {
        $json = file_get_contents($this->url);
        $data = json_decode($json, true);

        $data[] = $nuevaDonacion;

        file_put_contents($this->url, json_encode($data, JSON_PRETTY_PRINT));

        return $nuevaDonacion;
    }

    public function edit($id, $donacionEditada)
    {
        $json = file_get_contents($this->url);
        $data = json_decode($json, true);

        foreach ($data as $index => $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                $data[$index] = $donacionEditada;
                break;
            }
        }

        file_put_contents($this->url, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function delete($id)
    {
        $json = file_get_contents($this->url);
        $data = json_decode($json, true);

        $data = array_filter($data, function ($item) use ($id) {
            return !(isset($item['id']) && $item['id'] == $id);
        });

        $data = array_values($data);

        file_put_contents($this->url, json_encode($data, JSON_PRETTY_PRINT));
    }
    public function donar($id, $monto)
    {
        $json = file_get_contents($this->url);
        $data = json_decode($json, true);

        foreach ($data as $index => $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                // Limpiar el valor actual de 'collected'
                $actual = floatval(str_replace(['$', '.', ','], ['', '', ''], $item['collected']));
                $nuevoTotal = $actual + $monto;
                // Guardar el nuevo valor con formato
                $data[$index]['collected'] = '$' . number_format($nuevoTotal, 0, '', '.');
                break;
            }
        }

        file_put_contents($this->url, json_encode($data, JSON_PRETTY_PRINT));
    }
}
