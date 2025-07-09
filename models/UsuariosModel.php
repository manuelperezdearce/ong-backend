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
}
