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
        header("Location: /proyecto_lepaa/index.php");
    }

    $cuit = $user['cuit'];
}

$opcion = $_POST['opcion'];
$dni = $_POST['dni'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$domicilio = $_POST['domicilio'];
$localidad = $_POST['localidad'];
$partido = $_POST['partido'];
$cuit = $_POST['cuit'];
$acceso = $_POST['acceso'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];

$fechalata = date('Y-m-d');
$dnialta = $user['dni'];
$nombrealta = $user['nombre'];
$apellidoalta = $user['apellido'];
$cuitalta = $user['cuit'];
$institucionalta = $user['institucion'];
$fechaalta = $fechalata;

// Verifica si el Usuario esta duplicado
$sentenciaSQL = $conn->prepare("SELECT * FROM users WHERE dni=:dni");
$sentenciaSQL->bindParam("dni", $_POST['dni'], PDO::PARAM_STR);
$sentenciaSQL->execute();
$numeroRegistros = $sentenciaSQL->rowCount(); //devuelve el nuemro de registgros coincidentes con el usuario

//SI NO EXISTE USUARIO LO REGISTRA
if ($numeroRegistros == 0) {

    $sql = "INSERT INTO users (`nombre`, `apellido`, `domicilio`, `localidad`, `partido`, `telefono`, `email`, `acceso`, `cuit`, `dni`, `password`,`dnialta`, `nombrealta`, `apellidoalta`, `cuitalta`, `institucionalta`, `fechaalta`) VALUES ('$nombre', '$apellido', '$domicilio', '$localidad', '$partido', '$telefono ', '$email', '$acceso', '$cuit', '$dni', '$password', '$dnialta', '$nombrealta', '$apellidoalta', '$cuitalta', '$institucionalta', '$fechaalta');";

    if (mysqli_query($conexion, $sql)) {
        echo json_encode('1');
    } else {
        echo json_encode('El usuario no pudo registrarse!');
    };
} else {
    echo json_encode('El usuario ya existe');
};
mysqli_free_result($result);
mysqli_close($conexion);
