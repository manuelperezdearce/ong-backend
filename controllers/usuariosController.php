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
    public function loginUserControl()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $datosDelFormulario = [
                "email" => $email,
                "password" => $password,
            ];

            $usuarioModel = new UsuariosModel();
            $usuario = $usuarioModel->ingresar($datosDelFormulario);

            $_SESSION['username'] = $usuario['nombre'];
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['rol'] = $usuario['rol'];
            $_SESSION['avatar'] = $usuario['avatar'];
            $_SESSION['cart'] = [];

            header("Location: index.php");
            exit();
        }
    }
    public function exitUserControl()
    {
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
