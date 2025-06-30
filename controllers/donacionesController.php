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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger datos del formulario dinámicamente
            $donacionesModel = new Donaciones();
            $estructura = $donacionesModel->getAll();
            $primeraDonacion = $estructura[0] ?? [];
            $nuevaDonacion = [];
            foreach ($primeraDonacion as $campo => $valor) {
                $nuevaDonacion[$campo] = $_POST[$campo] ?? '';
            }

            try {
                $donacionesModel->create($nuevaDonacion);

                // Redirigir a la lista de donaciones después de crear
                header("Location: index.php?controller=donaciones&action=list");
                exit;
            } catch (\Throwable $th) {
                echo "Error al crear la donación: " . $th->getMessage();
            }
        } else {
            // Leer la estructura de la primera donación para generar los campos
            $donacionesModel = new Donaciones();
            $estructura = $donacionesModel->getAll();
            $primeraDonacion = $estructura[0] ?? [];

            // Generar array de campos dinámicamente
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

            $controller = 'donaciones';
            $action = 'create';
            include "./views/components/crear.php";
        }
    }
}
