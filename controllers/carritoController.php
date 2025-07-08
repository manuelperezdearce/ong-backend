<?php

include_once "./views/CarritoView.php";
include_once "./models/DonacionesModel.php";

class carritoController
{
    public function list()
    {
        try {
            if ($this->isLogin()) {
                // Asegurar que el carrito esté definido
                $carrito = $_SESSION['cart'] ?? [];

                $carritoView = new CarritoView();
                $carritoView->renderLista($carrito);
            } else {
                echo "Ingresar para ver carrito";
                var_dump($_SESSION['username'] ?? 'No definido');
            }
        } catch (\Throwable $th) {
            echo "Error en carrito: " . $th->getMessage();
        }
    }

    public function addCart()
    {
        session_start();

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"], $_POST["monto"])) {
            $id = intval($_POST["id"]);
            $amount = floatval($_POST["monto"]);

            if ($id > 0 && $amount > 0) {
                $itemToAdd = $this->getByID($id);

                if ($itemToAdd) {
                    $item = [
                        "id" => $itemToAdd['id'],
                        "title" => $itemToAdd['title'],
                        "amount" => $amount
                    ];

                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = [];
                    }

                    $_SESSION['cart'][] = $item;

                    header("Location: index.php?controller=donaciones&action=list");
                    exit;
                } else {
                    echo "Donación no encontrada.";
                }
            } else {
                echo "ID o monto inválido.";
            }
        } else {
            echo "Solicitud inválida. Verifica que el ID y el monto estén definidos.";
        }
    }

    public function procesarPago()
    {

        // Validar que haya algo que procesar
        if (!empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }

        // Mostrar pantalla de agradecimiento
        $view = new CarritoView();
        $view->renderGracias();
    }

    private function isLogin()
    {
        return !empty($_SESSION['username']);
    }

    private function getByID($id)
    {
        $donacionesModel = new Donaciones();
        return $donacionesModel->getOneByID($id);
    }
}
