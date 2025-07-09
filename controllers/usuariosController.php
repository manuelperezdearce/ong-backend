<?php

include_once "./views/UsuariosView.php";
include_once "./models/UsuariosModel.php";

class usuariosController
{
    public function iniciarSesion()
    {

        $iniciarSesionView = new UsuariosView();
        $iniciarSesionView->loginView();
    }

    public function addUserControl()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = $_POST["name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $rol = $_POST["rol"];

            $datosDelFormulario = [
                "username" => $username,
                "email" => $email,
                "password" => $password,
                "rol" => $rol
            ];

            $usuarioModel = new UsuariosModel();
            $usuarioModel->registrar($datosDelFormulario);

            echo ("Usuario registrado");
        }
    }
}
