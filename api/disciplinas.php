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

if (isset($_GET['opcion'])) {
    $opcion = $_GET['opcion'];
}

if (isset($_POST['opcion'])) {
    $opcion = $_POST['opcion'];
    $disciplina = $_POST['disciplina'];
}

switch ($opcion) {
    case 0:
        // consulta SQL
        $sql = "SELECT disciplinas.* FROM disciplinas;";
        $result = mysqli_query($conexion, $sql);
        $datos = array();
        while ($fila = mysqli_fetch_array($result)) {
            array_push($datos, $fila);
        }
        echo json_encode($datos);
        break;

    case 1:
        // Consulta by ID
        $id = $_GET['id'];

        $sql = "SELECT disciplinas.*, DATE_FORMAT(disciplinas.fechaalta, '%d/%m/%Y') AS newfechaalta, DATE_FORMAT(disciplinas.fechamod, '%d/%m/%Y') AS newfechamod  FROM disciplinas where disciplinas.id = $id";
        $result = mysqli_query($conexion, $sql);
        $datos = array();
        while ($fila = mysqli_fetch_array($result)) {
            array_push($datos, $fila);
        }
        echo json_encode($datos);
        break;

    case 2:
        // Actualiza los datos by ID
        $id = $_POST['id'];
        if (isset($id)) {
            $dnimod = $user['dni'];
            $nombremod = $user['nombre'];
            $apellidomod = $user['apellido'];
            $cuitmod = $user['cuit'];
            $institucionmod = $user['institucion'];
            $fechamod = date('Y-m-d');

            $sql = "UPDATE disciplinas SET disciplina = '$disciplina', dnimod = '$dnimod', nombremod = '$nombremod', apellidomod = '$apellidomod', cuitmod = '$cuitmod', institucionmod = '$institucionmod', fechamod = '$fechamod' WHERE disciplinas.id = $id;";

            if (mysqli_query($conexion, $sql)) {
                echo json_encode('1');
            } else {
                echo json_encode('0');
            }
        } else {
            echo json_encode('0');
        }
        break;

    case 3:
        // Eliminar by ID
        $id = $_GET['id'];
        $dnibaja = $user['dni'];
        $nombrebaja = $user['nombre'];
        $apellidobaja = $user['apellido'];
        $institucionbaja = $user['institucion'];
        $recicledtabla = 'Categorias';

        if (isset($id)) {
            //Guardar el usuario a ELIMINAR en la tabla RECICLED
            $sql = "INSERT INTO recicled (recicleddni, reciclednombre, recicledtabla, dnibaja, nombrebaja, apellidobaja, institucionbaja, fechabaja) VALUES (
                    (SELECT disciplinas.id FROM disciplinas WHERE disciplinas.id=$id),
                    (SELECT disciplinas.disciplina FROM disciplinas WHERE disciplinas.id=$id),'$recicledtabla','$dnibaja', '$nombrebaja', '$apellidobaja', '$institucionbaja', CURRENT_DATE())";

            //borra el reguistro en la tabala especificada
            if (mysqli_query($conexion, $sql)) {
                $sql = "DELETE FROM disciplinas WHERE disciplinas.id = $id;";
                if (mysqli_query($conexion, $sql)) {
                    echo json_encode('1');
                } else {
                    echo json_encode('0');
                };
            } else {
                echo json_encode('0');
            };
        } else {
            echo json_encode('0');
        };
        break;

    case 4:
        // Altas
        $dnialta = $user['dni'];
        $nombrealta = $user['nombre'];
        $apellidoalta = $user['apellido'];
        $cuitalta = $user['cuit'];
        $institucionalta = $user['institucion'];
        $fechaalta = date('Y-m-d');

        // Verifica si existe la categoria
        $sentenciaSQL = $conn->prepare("SELECT * FROM disciplinas WHERE disciplinas.disciplina=:disciplina");
        $sentenciaSQL->bindParam("disciplina", $_POST['disciplina'], PDO::PARAM_STR);
        $sentenciaSQL->execute();
        $numeroRegistros = $sentenciaSQL->rowCount(); //devuelve el nuemro de registgros coincidentes con el usuario

        //si no existe registra
        if ($numeroRegistros == 0) {

            $sql = "INSERT INTO disciplinas (disciplina, dnialta, nombrealta, apellidoalta, cuitalta, institucionalta, fechaalta) VALUES ('$disciplina', '$dnialta', '$nombrealta', '$apellidoalta', '$cuitalta', '$institucionalta', '$fechaalta')";

            if (mysqli_query($conexion, $sql)) {
                echo json_encode('1');
            } else {
                echo json_encode('La Disciplina no pudo registrarse!');
            };
        } else {
            echo json_encode('La Disciplina ya existe');
        };
        break;

    case 5:
        //ELIMINAR TODOS
        $password = $_GET['password'];
        $dnibaja = $user['dni'];
        $nombrebaja = $user['nombre'];
        $apellidobaja = $user['apellido'];
        $institucionbaja = $user['institucion'];
        $usercuit = $user['cuit'];
        $recicledtabla = 'Usuarios';

        //Guardar el usuario a ELIMINAR en la tabla RECICLED
        if ($password == $user['password']) {
            $sql = "INSERT INTO recicled (recicleddni, reciclednombre, recicledtabla, dnibaja, nombrebaja, apellidobaja, institucionbaja, fechabaja)
                SELECT disciplinas.id, disciplinas.disciplina,'$recicledtabla', '$dnibaja', '$nombrebaja', '$apellidobaja', '$institucionbaja', CURRENT_DATE() FROM disciplinas;";

            // Elimina todos los datotos de la tabla
            if (mysqli_query($conexion, $sql)) {
                $sql = "DELETE FROM disciplinas;";

                if (mysqli_query($conexion, $sql)) {
                    echo json_encode('1');
                } else {
                    echo json_encode('No se pudo borrar las Disciplinas');
                };
            } else {
                echo json_encode('No se pudo borrar las Disciplinas');
            };
        } else {
            echo json_encode('Las passwords no coinciden');
        }
        break;
}
mysqli_close($conexion);
