<?php

include_once "./models/Db.php";

class Proyectos
{
    private $url = "./mock/proyectos.json";

    public function getAll()
    {

        $db = new Db();
        $pdo = $db->connect();

        // Ejecutar consulta para obtener todos los proyectos
        $stmt = $pdo->prepare("SELECT * FROM proyecto");
        $stmt->execute();

        // Obtener todos los resultados como un array asociativo
        $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si hay datos
        if ($proyectos) {
            return $proyectos;
        } else {
            return []; // Retornar un array vacío si no hay resultados
        }
    }

    public function getAllWithPresupuesto()
    {
        $db = new Db();
        $pdo = $db->connect();

        $stmt = $pdo->prepare("
        SELECT 
            p.id_proyecto,
            p.nombre,
            p.descripcion,
            p.fecha_inicio,
            p.fecha_fin,
            p.status,
            p.goal,
            p.image,
            IFNULL(SUM(d.monto), 0) AS presupuesto
        FROM 
            proyecto p
        LEFT JOIN 
            donacion d ON p.id_proyecto = d.id_proyecto
        GROUP BY 
            p.id_proyecto, p.nombre, p.descripcion, p.fecha_inicio, p.fecha_fin, p.status, p.image
    ");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOneByID($id)
    {
        $db = new Db();
        $pdo = $db->connect();

        $stmt = $pdo->prepare("SELECT * FROM proyecto WHERE id_proyecto=:id");
        $stmt->execute([':id' => $id]);

        $proyecto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($proyecto) {
            return $proyecto;
        } else {
            echo "Error en la consulta";
        }
    }

    public function create($nuevoProyecto)
    {
        // Leer los proyectos actuales
        $json = file_get_contents($this->url);
        $data = json_decode($json, true);
        // Agregar el nuevo proyecto al array
        $data[] = $nuevoProyecto;
        // Guardar el array actualizado en el archivo JSON
        file_put_contents($this->url, json_encode($data, JSON_PRETTY_PRINT));
    }
    public function edit($id, $proyectoEditado)
    {
        $db = new Db();
        $pdo = $db->connect();

        $stmt = $pdo->prepare("UPDATE proyecto 
                           SET nombre = :nombre,
                               descripcion = :descripcion,
                               presupuesto = :presupuesto,
                               image = :image,
                               status = :status,
                               goal = :goal,
                               fecha_inicio = :fecha_inicio,
                               fecha_fin = :fecha_fin
                           WHERE id_proyecto = :id");

        $stmt->execute([
            ':nombre' => $proyectoEditado['nombre'],
            ':descripcion' => $proyectoEditado['descripcion'],
            ':presupuesto' => $proyectoEditado['presupuesto'],
            ':image' => $proyectoEditado['image'],
            ':status' => $proyectoEditado['status'],
            ':goal' => $proyectoEditado['goal'],
            ':fecha_inicio' => $proyectoEditado['fecha_inicio'],
            ':fecha_fin' => $proyectoEditado['fecha_fin'],
            ':id' => $id
        ]);
    }
    public function delete($id)
    {
        // Leer los proyectos actuales
        $json = file_get_contents($this->url);
        $data = json_decode($json, true);

        // Filtrar el proyecto a eliminar
        $data = array_filter($data, function ($item) use ($id) {
            return !(isset($item['id']) && $item['id'] == $id);
        });

        // Reindexar el array para evitar huecos en los índices
        $data = array_values($data);

        // Guardar el array actualizado en el archivo JSON
        file_put_contents($this->url, json_encode($data, JSON_PRETTY_PRINT));
    }
}
