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
    public function donar()
    {
        $donacionesModel = new Donaciones();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $monto = floatval($_POST['monto'] ?? 0);

            $donacion = $donacionesModel->getOneByID($id);

            if ($donacion && $monto > 0) {
                // Quitar símbolos y puntos para convertir a número
                $actual = floatval(str_replace(['$', '.', ','], ['', '', ''], $donacion['collected']));
                $nuevoTotal = $actual + $monto;
                $donacion['collected'] = '$' . number_format($nuevoTotal, 0, '', '.');

                $donacionesModel->edit($id, $donacion);

                header("Location: index.php?controller=donaciones&action=watch&id=" . urlencode($id));
                exit;
            } else {
                echo "Donación no encontrada o monto inválido.";
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $donacion = $donacionesModel->getOneByID($id);

            if ($donacion) {
?>
                <h1 class="text-2xl my-4 text-center font-bold">Realizar Donación</h1>
                <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
                    <h2 class="font-semibold mb-2"><?= htmlspecialchars($donacion['title'] ?? 'Donación') ?></h2>
                    <form action="index.php?controller=donaciones&action=donar&id=<?= urlencode($id) ?>" method="POST">
                        <label for="monto" class="block mb-2">Monto a donar:</label>
                        <input type="number" min="1" step="any" name="monto" id="monto" class="border px-3 py-2 rounded w-full mb-4" required>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Donar</button>
                        <a href="index.php?controller=donaciones&action=watch&id=<?= urlencode($id) ?>" class="ml-2 text-blue-600 hover:underline">Cancelar</a>
                    </form>
                </div>
<?php
            } else {
                echo "Donación no encontrada.";
            }
        } else {
            echo "ID de donación no especificado.";
        }
    }
}
