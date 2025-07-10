<?php

include_once "./models/DonacionesModel.php";
include_once "./views/DonacionesView.php";

class donacionesController
{
    public function list()
    {
        try {
            // Crear una instancia del modelo
            $donacionesModel = new Donaciones();
            // Llamar al método y guardar datos en una variable
            $donaciones = $donacionesModel->getAll();
            // Crear una instancia de la vista
            $donacionesView = new DonacionesView();
            // Llamar al método y Enviar datos a la vista
            $donaciones = $donacionesView->renderLista($donaciones);
        } catch (\Throwable $th) {
            echo $th;
        }
    }
    public function create()
    {
        $donacionesModel = new Donaciones();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nuevaDonacion = [
                'monto' => $_POST['monto'] ?? '',
                'fecha' => $_POST['fecha'] ?? '',
                'id_proyecto' => $_POST['id_proyecto'] ?? '',
                'id_usuario' => $_POST['id_usuario'] ?? ''
            ];

            try {
                $donacionesModel->create($nuevaDonacion);
                header("Location: index.php?controller=donaciones&action=list");
                exit;
            } catch (\Throwable $th) {
                echo "Error al crear la donación: " . $th->getMessage();
            }
        } else {
            // Campos para construir el formulario
            $campos = [
                ['name' => 'monto', 'label' => 'Monto', 'type' => 'number', 'required' => true],
                ['name' => 'fecha', 'label' => 'Fecha', 'type' => 'date', 'required' => true],
                ['name' => 'id_proyecto', 'label' => 'ID Proyecto', 'type' => 'number', 'required' => true],
                ['name' => 'id_usuario', 'label' => 'ID Usuario', 'type' => 'number', 'required' => true],
            ];

            $controller = 'donaciones';
            $action = 'create';

            include "./views/components/crear.php";
        }
    }
    public function watch()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
            $id = $_GET["id"];
            $donacionesModel = new Donaciones();
            $donacion = $donacionesModel->getOneByID($id);
            $donacionesView = new DonacionesView();
            $donacionesView->renderOne($donacion);
        }
    }

    public function edit()
    {
        $donacionesModel = new Donaciones();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $estructura = $donacionesModel->getAll();
            $primeraDonacion = $estructura[0] ?? [];
            $donacionEditada = [];
            foreach ($primeraDonacion as $campo => $valor) {
                $donacionEditada[$campo] = $_POST[$campo] ?? '';
            }
            $id = $_GET['id'] ?? $donacionEditada['id'] ?? null;

            try {
                $donacionesModel->edit($id, $donacionEditada);
                header("Location: index.php?controller=donaciones&action=list");
                exit;
            } catch (\Throwable $th) {
                echo "Error al editar la donación: " . $th->getMessage();
            }
        } else {
            $id = $_GET['id'] ?? null;
            $donacion = $donacionesModel->getOneByID($id);

            $estructura = $donacionesModel->getAll();
            $primeraDonacion = $estructura[0] ?? [];
            $campos = [];
            foreach ($primeraDonacion as $campo => $valor) {
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

            $donacionesView = new DonacionesView();
            $donacionesView->renderEdit($donacion, $campos);
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $donacionesModel = new Donaciones();

            try {
                $donacionesModel->delete($id);
                header("Location: index.php?controller=donaciones&action=list");
                exit;
            } catch (\Throwable $th) {
                echo "Error al eliminar la donación: " . $th->getMessage();
            }
        } else {
            echo "ID de donación no especificado.";
        }
    }
}
