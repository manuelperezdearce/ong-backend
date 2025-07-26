<?php
include_once "./models/Db.php";

class UsuariosModel
{
    public function registrar($data)
    {
        $db = new Db();
        $pdo = $db->connect();

        var_dump($pdo);


        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['username'], $data['email'], $data['password'], $data['rol']]);
    }

    public function ingresar($data)
    {
        $db = new Db();
        $pdo = $db->connect();

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND password = :password");
        $stmt->execute([
            ':email' => $data['email'],
            ':password' => $data['password']
        ]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            return $usuario;
        } else {
            echo "Nombre de usuario o contraseña incorrectos.";
        }
    }
}
