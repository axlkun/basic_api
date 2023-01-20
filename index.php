<?php
include_once 'conexion.php';

$pdo = new Conexion();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['id'])) {

        $query = 'SELECT * FROM contactos WHERE id=:id';
        $sql = $pdo->prepare($query);
        $sql->bindValue(':id', $_GET['id']);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($sql->fetchAll());
        exit;
    } else {

        $query = 'SELECT * FROM contactos';
        $sql = $pdo->prepare($query);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($sql->fetchAll());
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = "INSERT INTO contactos (nombre,telefono,email) VALUES (:nombre, :telefono, :email)";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':nombre', $_POST['nombre']);
    $stmt->bindValue(':telefono', $_POST['telefono']);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->execute();
    $idPost = $pdo->lastInsertId();

    if ($idPost) {
        $query = 'SELECT * FROM contactos WHERE id=:id';
        $sql = $pdo->prepare($query);
        $sql->bindValue(':id', $idPost);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($sql->fetchAll());
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $query = "UPDATE contactos SET nombre=:nombre, telefono=:telefono, email=:email WHERE id=:id";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':nombre', $_GET['nombre']);
    $stmt->bindValue(':telefono', $_GET['telefono']);
    $stmt->bindValue(':email', $_GET['email']);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    header("HTTP/1.1 200 OK");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $query = "DELETE FROM contactos WHERE id=:id";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    header("HTTP/1.1 200 OK");
    exit;
}

header("HTTP/1.1 400 BAD REQUEST");

?>


