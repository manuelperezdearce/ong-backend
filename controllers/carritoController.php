<?php

include_once "./views/CarritoView.php";
include_once "./models/DonacionesModel.php";

class carritoController
{
    public function list()
    {
        try {
            if ($this->isLogin()) {
                $carrito = $_SESSION['cart'];

                $carritoView = new CarritoView();
                // Llamar al método y Enviar datos a la vista
                $carritoView->renderLista($carrito);
            } else {
                echo ("Ingresar para ver carrito");
                var_dump($_SESSION['username']);
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function addCart()
    {
        echo ("llegamos al controlador :3 con el id:" . $_GET['id']);

        if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
            $id = $_GET["id"];
            # Buscar id en donaciones
            $itemToAdd = $this->getByID($id);

            # Preparar item para agregar a $_SESSION['cart]
            var_dump($itemToAdd);

            $item = [
                "id" => $itemToAdd['id'],
                "title" => $itemToAdd['title'],
                "amount" => "50000"
            ];
            # Agregar item a la lista de carrito
            $_SESSION['cart'][] = $item;
            # Redirigir a la página anterior
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    private function isLogin()
    {
        if (!empty($_SESSION['username'])) {
            return true;
        } else {
            return false;
        }
    }

    private function getByID($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
            $id = $_GET["id"];
            $donacionesModel = new Donaciones();
            return $donacionesModel->getOneByID($id);
        }
    }
}
