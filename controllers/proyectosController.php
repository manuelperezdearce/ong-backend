<?php

include_once "./models/ProyectosModel.php";
include_once "./views/ProyectosView.php";

class proyectosController
{
    public function list()
    {
        try {
            // Crear una instancia del modelo
            $proyectosModel = new Proyectos();
            // Llamar al método y guardar datos en una variable
            $proyectos = $proyectosModel->getAll();
            // Crear una instancia de la vista
            $proyectosView = new ProyectosView();
            // Llamar al método y Enviar datos a la vista
            $proyectos = $proyectosView->renderLista($proyectos);
        } catch (\Throwable $th) {
            echo $th;
        }
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger datos del formulario dinámicamente
            $proyectosModel = new Proyectos();
            $estructura = $proyectosModel->getAll();
            $primerProyecto = $estructura[0] ?? [];
            $nuevoProyecto = [];
            foreach ($primerProyecto as $campo => $valor) {
                $nuevoProyecto[$campo] = $_POST[$campo] ?? '';
            }

            try {
                $proyectosModel->create($nuevoProyecto);

                // Redirigir a la lista de proyectos después de crear
                header("Location: index.php?controller=proyectos&action=list");
                exit;
            } catch (\Throwable $th) {
                echo "Error al crear el proyecto: " . $th->getMessage();
            }
        } else {
            // Leer la estructura del primer proyecto para generar los campos
            $proyectosModel = new Proyectos();
            $estructura = $proyectosModel->getAll();
            $primerProyecto = $estructura[0] ?? [];

            // Generar array de campos dinámicamente
            $campos = [];
            foreach ($primerProyecto as $campo => $valor) {
                $tipo = 'text';
                if (is_string($valor) && strlen($valor) > 100) {
                    $tipo = 'textarea';
                }
                $campos[] = [
                    'name' => $campo,
                    'label' => ucfirst($campo),
                    'type' => $tipo,
                    'required' => true
                ];
            }
            $controller = 'proyectos'; // o 'eventos', 'donaciones', etc.
            $action = 'create';
            include "./views/components/crear.php";
        }
    }

    public function watch()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $id = $_GET["id"];
            // Crear instancia de la entidad
            $proyectoModel = new Proyectos();
            // Llamar al método y guardar datos en una variable
            $proyecto = $proyectoModel->getOneByID($id);
            // Crear una instancia de la vista
            $proyectosView = new ProyectosView();
            // Llamar al método y Enviar datos a la vista
            $proyectosView->renderOne($proyecto);
        }
    }
    public function edit()
    {
        $proyectosModel = new Proyectos();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger datos del formulario dinámicamente
            $estructura = $proyectosModel->getAll();
            $primerProyecto = $estructura[0] ?? [];
            $proyectoEditado = [];
            foreach ($primerProyecto as $campo => $valor) {
                $proyectoEditado[$campo] = $_POST[$campo] ?? '';
            }
            // Asegúrate de mantener el id original
            $id = $_GET['id'] ?? $proyectoEditado['id'] ?? null;

            try {
                $proyectosModel->edit($id, $proyectoEditado);

                // Redirigir a la lista de proyectos después de editar
                header("Location: index.php?controller=proyectos&action=list");
                exit;
            } catch (\Throwable $th) {
                echo "Error al editar el proyecto: " . $th->getMessage();
            }
        } else {
            // Obtener el proyecto actual por ID
            $id = $_GET['id'] ?? null;
            $proyecto = $proyectosModel->getOneByID($id);

            // Leer la estructura para generar los campos
            $estructura = $proyectosModel->getAll();
            $primerProyecto = $estructura[0] ?? [];
            $campos = [];
            foreach ($primerProyecto as $campo => $valor) {
                $tipo = 'text';
                if (is_string($valor) && strlen($valor) > 100) {
                    $tipo = 'textarea';
                }
                $campos[] = [
                    'name' => $campo,
                    'label' => ucfirst($campo),
                    'type' => $tipo,
                    'required' => true
                ];
            }

            // Mostrar el formulario de edición
            $proyectosView = new ProyectosView();
            $proyectosView->renderEdit($proyecto, $campos);
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $proyectosModel = new Proyectos();

            try {
                $proyectosModel->delete($id);

                // Redirigir a la lista de proyectos después de eliminar
                header("Location: index.php?controller=proyectos&action=list");
                exit;
            } catch (\Throwable $th) {
                echo "Error al eliminar el proyecto: " . $th->getMessage();
            }
        } else {
            echo "ID de proyecto no especificado.";
        }
    }
}
