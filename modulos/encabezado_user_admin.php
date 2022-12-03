<?php
session_start();

require 'database.php';

// Toma los datos del usuario para mostrar en el encabezado de la pagina
if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT users.*, clubs.institucion, clubs.cuit FROM users, clubs WHERE users.cuit = clubs.cuit AND users.id= :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
        $user = $results;
    }
}

// verifica si el usuario esta logeado
if (!isset($user)) {
    header("Location: /newproyect_lepa/index.php");
}

// Verifica que el accso sea de ADMINISTRADORES
if ($user['acceso'] != 'administrador') {
    $valorAcceso = 0;
    $mensajeAcceso = 'No tiene acceso a esta sección';
    $_SESSION['valorAcceso'] = $valorAcceso;
    $_SESSION['mensajeAcceso'] = $mensajeAcceso;
    header("Location: /newproyect_lepa/home.php");
}
