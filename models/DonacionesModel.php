<?php
include_once "./models/Db.php";

class Donaciones
{
    private $url = "./mock/donaciones.json";

    public function getAll()
    {

        $db = new Db();
        $pdo = $db->connect();

        // Ejecutar consulta para obtener todos los donaciones
        $stmt = $pdo->prepare("SELECT * FROM donacion");
        $stmt->execute();

        // Obtener todos los resultados como un array asociativo
        $donaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si hay datos
        if ($donaciones) {
            return $donaciones;
        } else {
            return []; // Retornar un array vacío si no hay resultados
        }
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
        // Conectar a la base de datos
        $db = new Db();
        $pdo = $db->connect();

        // Preparar y ejecutar el INSERT
        $stmt = $pdo->prepare("
        INSERT INTO donacion (monto, id_proyecto, id_usuario)
        VALUES (:monto, :id_proyecto, :id_usuario)
    ");

        $stmt->execute([
            ':monto' => $nuevaDonacion['monto'],
            ':id_proyecto' => $nuevaDonacion['id_proyecto'],
            ':id_usuario' => $nuevaDonacion['id_usuario']
        ]);

        // Retornar el ID insertado u opcionalmente los datos
        $nuevaDonacion['id_donacion'] = $pdo->lastInsertId();

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


    // public function donar($id, $monto)
    // {
    //     $json = file_get_contents($this->url);
    //     $data = json_decode($json, true);

    //     foreach ($data as $index => $item) {
    //         if (isset($item['id']) && $item['id'] == $id) {
    //             // Limpiar el valor actual de 'collected'
    //             $actual = floatval(str_replace(['$', '.', ','], ['', '', ''], $item['collected']));
    //             $nuevoTotal = $actual + $monto;
    //             // Guardar el nuevo valor con formato
    //             $data[$index]['collected'] = '$' . number_format($nuevoTotal, 0, '', '.');
    //             break;
    //         }
    //     }

    //     file_put_contents($this->url, json_encode($data, JSON_PRETTY_PRINT));
    // }
}
