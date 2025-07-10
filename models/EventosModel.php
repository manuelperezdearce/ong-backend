<?php

include_once "./models/Db.php";

class Eventos
{
    private $url = "./mock/eventos.json";

    public function getAll()
    {

        $db = new Db();
        $pdo = $db->connect();

        // Ejecutar consulta para obtener todos los eventos
        $stmt = $pdo->prepare("SELECT * FROM evento");
        $stmt->execute();

        // Obtener todos los resultados como un array asociativo
        $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si hay datos
        if ($eventos) {
            return $eventos;
        } else {
            return []; // Retornar un array vacío si no hay resultados
        }
    }

    public function getOneByID($id)
    {
        $db = new Db();
        $pdo = $db->connect();

        $stmt = $pdo->prepare("SELECT * FROM evento WHERE id_evento=:id");
        $stmt->execute([':id' => $id]);

        $evento = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($evento) {
            return $evento;
        } else {
            echo "Error en la consulta";
        }
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
