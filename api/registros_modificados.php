<?php

session_start();

// conexion SQL
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

// consulta SQL
$valor = $_GET['tablaValor'];

if ($valor == 1) {
    $sql = "SELECT buenafe.dnibuenafe AS dni, IFNULL(patinadores.nombrepatinador,'**') AS nombre, IFNULL(patinadores.apellidopatinador,'**') AS apellido, 'Buena Fe' AS tabla, IFNULL(clubs.institucion,buenafe.institucionalta) AS institucion, buenafe.* FROM buenafe  LEFT JOIN patinadores ON buenafe.dnibuenafe=patinadores.dnipatinador LEFT JOIN clubs ON patinadores.cuit=clubs.cuit LEFT JOIN users ON buenafe.dnialta = users.dni WHERE buenafe.dnimod<>'' ;";
} elseif ($valor == 2) {
    $sql = "SELECT categorias.id AS dni, categorias.categoria AS nombre, '' AS institucion,'' AS apellido, 'Categorias' AS tabla, categorias.* FROM categorias WHERE categorias.dnimod <> '';";
} elseif ($valor == 3) {
    $sql = "SELECT clubs.cuit AS dni, clubs.institucion AS nombre, '' AS apellido, 'Clubs' AS tabla, clubs.*  FROM clubs WHERE dnimod <> '';";
} elseif ($valor == 4) {
    $sql = "SELECT tipolicencias.id AS dni, tipolicencias.tipolicencia AS nombre, '' AS institucion,'' AS apellido, 'Licencias' AS tabla, tipolicencias.* FROM tipolicencias WHERE dnimod <> '';";
} elseif ($valor == 5) {
    $sql = "SELECT patinadores.dnipatinador AS dni, patinadores.nombrepatinador AS nombre, patinadores.apellidopatinador AS apellido, clubs.institucion AS institucion, 'Padron' AS tabla, patinadores.* FROM patinadores, clubs WHERE patinadores.cuit=clubs.cuit AND patinadores.dnimod <> '';";
} elseif ($valor == 6) {
    $sql = "SELECT torneo.id AS dni, torneo.nombretorneo AS nombre, torneo.fechatorneo AS apellido, '' AS institucion, 'Torneos' AS tabla, torneo.* FROM torneo WHERE torneo.dnimod <> '';";
} elseif ($valor == 7) {
    $sql = "SELECT users.dni, users.nombre, users.apellido, clubs.institucion, 'Usuarios' AS tabla, users.* FROM users, clubs WHERE users.cuit=clubs.cuit AND users.dnimod<>'';";
};


$result = mysqli_query($conexion, $sql);

// creal el array con los datos del ciente
$clientes = array();
while ($fila = mysqli_fetch_array($result)) {
    array_push($clientes, $fila);
}

// convierte el array en formato Json
echo json_encode($clientes);
mysqli_close($conexion);
