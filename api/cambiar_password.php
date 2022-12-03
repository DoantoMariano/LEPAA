<?php
session_start();

require '../database.php';

$records = $conn->prepare('SELECT users.*, clubs.institucion, clubs.cuit FROM users, clubs WHERE users.cuit = clubs.cuit AND users.id= :id');

$records->bindParam(':id', $_SESSION['user_id']);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);


$user = null;
if (count($results) > 0) {
    $user = $results;
} else {
    header("Location: /newproyect_lepa/index.php");
}

// verifica si el usuario esta logeado
if (!isset($user)) {
    header("Location: /newproyect_lepa/index.php");
}

$dni = $user['dni'];
$newPassword = $_GET['newPassword'];

$sql = "UPDATE users SET password='$newPassword' WHERE users.dni=$dni;";

if (mysqli_query($conexion, $sql)) {
    echo json_encode('1');
} else {
    echo json_encode('0');
}
mysqli_close($conexion);
