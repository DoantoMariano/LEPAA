<?php

session_start();
require '../database.php';
date_default_timezone_set("America/Argentina/Buenos_Aires");

if (isset($_SESSION['user_id'])) {

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
}

// verifica si el usuario esta logeado
if (!isset($user)) {
    header("Location: /newproyect_lepa/index.php");
}


$sql = "SELECT * FROM ingresos;";

$result = mysqli_query($conexion, $sql);

// creal el array con los datos del ciente
$datos = array();
while ($fila = mysqli_fetch_array($result)) {
    array_push($datos, $fila);
}
echo json_encode($datos);
mysqli_close($conexion);
