<?php

include_once "./models/EventosModel.php";
include_once "./views/EventosView.php";

class eventosController
{
    public function list()
    {
        try {
            // Crear una instancia del modelo
            $eventosModel = new Eventos();
            // Llamar al método y guardar datos en una variable
            $eventos = $eventosModel->getAll();
            // Crear una instancia de la vista
            $eventosView = new EventosView();
            // Llamar al método y Enviar datos a la vista
            $eventos = $eventosView->renderLista($eventos);
        } catch (\Throwable $th) {
            echo $th;
        }
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger datos del formulario dinámicamente
            $eventosModel = new Eventos();
            $estructura = $eventosModel->getAll();
            $primerEvento = $estructura[0] ?? [];
            $nuevoEvento = [];
            foreach ($primerEvento as $campo => $valor) {
                $nuevoEvento[$campo] = $_POST[$campo] ?? '';
            }

            try {
                $eventosModel->create($nuevoEvento);

                // Redirigir a la lista de eventos después de crear
                header("Location: index.php?controller=eventos&action=list");
                exit;
            } catch (\Throwable $th) {
                echo "Error al crear el evento: " . $th->getMessage();
            }
        } else {
            // Leer la estructura del primer evento para generar los campos
            $eventosModel = new Eventos();
            $estructura = $eventosModel->getAll();
            $primerEvento = $estructura[0] ?? [];

            // Generar array de campos dinámicamente
            $campos = [];
            foreach ($primerEvento as $campo => $valor) {
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

            $controller = 'eventos';
            $action = 'create';
            include "./views/components/crear.php";
        }
    }
    public function watch()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $id = $_GET["id"];
            // Crear instancia de la entidad
            $eventoModel = new Eventos();
            // Llamar al método y guardar datos en una variable
            $evento = $eventoModel->getOneByID($id);
            // Crear una instancia de la vista
            $eventoView = new EventosView();
            // Llamar al método y Enviar datos a la vista
            $eventoView->renderOne($evento);
        }
    }
    public function edit()
    {
        $eventosModel = new Eventos();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger datos del formulario dinámicamente
            $estructura = $eventosModel->getAll();
            $primerEvento = $estructura[0] ?? [];
            $eventoEditado = [];
            foreach ($primerEvento as $campo => $valor) {
                $eventoEditado[$campo] = $_POST[$campo] ?? '';
            }
            // Asegúrate de mantener el id original
            $id = $_GET['id'] ?? $eventoEditado['id'] ?? null;

            try {
                $eventosModel->edit($id, $eventoEditado);

                // Redirigir a la lista de eventos después de editar
                header("Location: index.php?controller=eventos&action=list");
                exit;
            } catch (\Throwable $th) {
                echo "Error al editar el evento: " . $th->getMessage();
            }
        } else {
            // Obtener el evento actual por ID
            $id = $_GET['id'] ?? null;
            $evento = $eventosModel->getOneByID($id);

            // Leer la estructura para generar los campos
            $estructura = $eventosModel->getAll();
            $primerevento = $estructura[0] ?? [];
            $campos = [];
            foreach ($primerevento as $campo => $valor) {
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
            $eventosView = new EventosView();
            $eventosView->renderEdit($evento, $campos);
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $eventosModel = new Eventos();

            try {
                $eventosModel->delete($id);

                // Redirigir a la lista de eventos después de eliminar
                header("Location: index.php?controller=eventos&action=list");
                exit;
            } catch (\Throwable $th) {
                echo "Error al eliminar el proyecto: " . $th->getMessage();
            }
        } else {
            echo "ID de proyecto no especificado.";
        }
    }
}
