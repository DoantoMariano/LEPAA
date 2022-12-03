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
    if ($opcion == 2 || $opcion == 4) {
        $id = $_POST['id'];
        $categoria = $_POST['categoria'];
        $disciplina = $_POST['disciplina'];
        $apagar = $_POST['apagar'];
        $torneo = $_POST['torneo'];
        $observaciones = $_POST['observaciones'];
    }
}

switch ($opcion) {
    case 0:
        // Consulta de todos los patinadores del padron
        $cuit = $user['cuit'];

        if ($user['acceso'] != 'administrador') {
            $sql = "SELECT buenafe.*, users.nombre AS nombrealta, users.apellido AS apellidoalta, IFNULL(patinadores.nombrepatinador,'**EMPADRONAR**') AS nombrepatinador, IFNULL(patinadores.apellidopatinador,'**') AS apellidopatinador, IFNULL(DATE_FORMAT(patinadores.fechanacpatinador, '%d-%m-%Y'),'**') AS fechanacimiento, IFNULL(YEAR(CURDATE())-YEAR(patinadores.fechanacpatinador),'**') AS edad, IFNULL(patinadores.tipolicencia,'**') AS tipolicencia, IFNULL(patinadores.sexopatinador,'**') AS sexopatinador, IFNULL(clubs.institucion,buenafe.institucionalta) AS institucion FROM buenafe LEFT JOIN patinadores ON buenafe.dnibuenafe=patinadores.dnipatinador LEFT JOIN clubs ON patinadores.cuit=clubs.cuit LEFT JOIN users ON buenafe.dnialta = users.dni WHERE patinadores.cuit=$cuit or buenafe.cuitalta=$cuit";
        } else {
            $sql = "SELECT buenafe.*, users.nombre AS nombrealta, users.apellido AS apellidoalta, IFNULL(patinadores.nombrepatinador,'**EMPADRONAR**') AS nombrepatinador, IFNULL(patinadores.apellidopatinador,'**') AS apellidopatinador, IFNULL(DATE_FORMAT(patinadores.fechanacpatinador, '%d-%m-%Y'),'**') AS fechanacimiento, IFNULL(YEAR(CURDATE())-YEAR(patinadores.fechanacpatinador),'**') AS edad, IFNULL(patinadores.tipolicencia,'**') AS tipolicencia, IFNULL(patinadores.sexopatinador,'**') AS sexopatinador, IFNULL(clubs.institucion,buenafe.institucionalta) AS institucion FROM buenafe LEFT JOIN patinadores ON buenafe.dnibuenafe=patinadores.dnipatinador LEFT JOIN clubs ON patinadores.cuit=clubs.cuit LEFT JOIN users ON buenafe.dnialta = users.dni";
        }

        $result = mysqli_query($conexion, $sql);
        // creal el array con los datos del ciente
        $datos = array();
        while ($fila = mysqli_fetch_array($result)) {
            array_push($datos, $fila);
        }
        // convierte el array en formato Json
        echo json_encode($datos);
        break;

    case 1:
        // Consulta by ID
        $id = $_GET['id'];

        $sql = "SELECT buenafe.*, DATE_FORMAT(buenafe.fechaalta, '%d/%m/%Y') AS newfechaalta, DATE_FORMAT(buenafe.fechamod, '%d/%m/%Y') AS newfechamod, IFNULL(patinadores.nombrepatinador,'**SIN EMPADRONAR PREVIAMENTE**') AS nombrepatinador, IFNULL(patinadores.apellidopatinador,'') AS apellidopatinador, patinadores.fechanacpatinador, IFNULL(DATE_FORMAT(patinadores.fechanacpatinador, '%d/%m/%Y'),'**') AS fechanacimiento, IFNULL(YEAR(CURDATE())-YEAR(patinadores.fechanacpatinador),'**') AS edad, IFNULL(patinadores.tipolicencia,'**') AS tipolicencia, IFNULL(patinadores.sexopatinador,'**') AS sexopatinador, clubs.institucion, clubs.cuit FROM buenafe LEFT JOIN patinadores ON buenafe.dnibuenafe=patinadores.dnipatinador LEFT JOIN clubs ON patinadores.cuit=clubs.cuit WHERE buenafe.id=$id";

        $result = mysqli_query($conexion, $sql);

        $datos = array();
        while ($fila = mysqli_fetch_array($result)) {
            array_push($datos, $fila);
        }
        echo json_encode($datos);
        break;

    case 2:
        //Actualiza by ID
        $dnimod = $user['dni'];
        $nombremod = $user['nombre'];
        $apellidomod = $user['apellido'];
        $cuitmod = $user['cuit'];
        $institucionmod = $user['institucion'];
        $fechamod = date('Y-m-d');


        //acutaliza la tabla PATINADORES
        $sql = "UPDATE buenafe SET  categoria = '$categoria', disciplina = '$disciplina', torneo = '$torneo', observaciones = '$observaciones', apagar = '$apagar', dnimod = '$dnimod', nombremod = '$nombremod', apellidomod = '$apellidomod', cuitmod = '$cuitmod', institucionmod = '$institucionmod', fechamod = '$fechamod' WHERE buenafe.id = $id;";


        if (mysqli_query($conexion, $sql)) {
            echo json_encode('1');
        } else {
            echo json_encode('Las modificaiones NO pudieron registrarse!');
        }

        break;

    case 3:
        // Baja by ID
        $id = $_GET['id'];

        $dnibaja = $user['dni'];
        $nombrebaja = $user['nombre'];
        $apellidobaja = $user['apellido'];
        $institucionbaja = $user['institucion'];
        $recicledtabla = 'Buena Fe';

        //Guardar el usuario a ELIMINAR en la tabla RECICLED
        $sql = "INSERT INTO recicled(recicleddni, reciclednombre, recicledapellido, recicledinstitucion, recicledtabla, dnibaja, nombrebaja, apellidobaja, institucionbaja, fechabaja) 
        VALUES (
                (SELECT buenafe.dnibuenafe AS recicleddni FROM buenafe WHERE buenafe.id=$id),
        (SELECT IFNULL(patinadores.nombrepatinador,'**EMPADRONAR**') AS reciclednombre FROM buenafe LEFT JOIN patinadores ON buenafe.dnibuenafe=patinadores.dnipatinador WHERE buenafe.id=$id),
        (SELECT IFNULL(patinadores.apellidopatinador,'**') AS recicledapellido FROM buenafe LEFT JOIN patinadores ON buenafe.     dnibuenafe=patinadores.dnipatinador WHERE buenafe.id=$id),
        (SELECT IFNULL(clubs.institucion,buenafe.institucionalta) AS institucion FROM buenafe LEFT JOIN patinadores ON buenafe.dnibuenafe=patinadores.dnipatinador LEFT JOIN clubs ON patinadores.cuit=clubs.cuit LEFT JOIN users ON buenafe.dnialta = users.dni where buenafe.id=$id),'$recicledtabla','$dnibaja', '$nombrebaja', '$apellidobaja', '$institucionbaja', CURRENT_DATE())";

        if (mysqli_query($conexion, $sql)) {
            //borra el reguistro en la tabala especificada
            $sql = "DELETE FROM `buenafe` WHERE `buenafe`.`id` = $id;";
            $query = mysqli_query($conexion, $sql);
            echo json_encode('1');
        } else {
            echo json_encode('El patinador no pudo eliminarse!');
        };

        break;


    case 4:
        //Agrega Patinador 
        $dni = $_POST['dni'];
        $funcion = 'Patinador'; // dato fijo para el campo FUNCION
        $dnialta = $user['dni'];
        $nombrealta = $user['nombre'];
        $apellidoalta = $user['apellido'];
        $cuitalta = $user['cuit'];
        $institucionalta = $user['institucion'];
        $fechaalta = date('Y-m-d');

        if (!empty($_POST['dni'])) {
            $sentenciaSQL = $conn->prepare("SELECT * FROM buenafe WHERE dnibuenafe=:dni  AND categoria=:categoria AND disciplina=:disciplina AND torneo=:torneo");
            $sentenciaSQL->bindParam("dni", $_POST['dni'], PDO::PARAM_STR);
            $sentenciaSQL->bindParam("categoria", $_POST['categoria'], PDO::PARAM_STR);
            $sentenciaSQL->bindParam("disciplina", $_POST['disciplina'], PDO::PARAM_STR);
            $sentenciaSQL->bindParam("torneo", $_POST['torneo'], PDO::PARAM_STR);
            $sentenciaSQL->execute();
            $numeroRegistros = $sentenciaSQL->rowCount(); //devuelve el nuemro de registgros coincidentes con el usuario

            if ($numeroRegistros == 0) {
                // IMPORTANTE: Los VALUES deben estar en el mismo orden que la tabala de la BD
                $sql = "INSERT INTO buenafe (dnibuenafe, categoria, disciplina, apagar, torneo, observaciones, dnialta, nombrealta, apellidoalta, cuitalta, institucionalta, fechaalta) VALUES ('$dni', '$categoria', '$disciplina', '$apagar', '$torneo', '$observaciones', '$dnialta', '$nombrealta', '$apellidoalta', '$cuitalta', '$institucionalta', '$fechaalta')";

                if (mysqli_query($conexion, $sql)) {
                    echo json_encode('1');
                } else {
                    echo json_encode('El patinador no pudo registrarse!');
                }
            } else {
                echo json_encode('El patinador/a ya existe para la Categoria, Diciplina y Torneo que intenta registrar!');
            };
        }

        break;

    case 5:
        //ELIMINAR TODOS LOS USUARIOS
        $cuit = $_GET['cuit'];
        $dnibaja = $user['dni'];
        $nombrebaja = $user['nombre'];
        $apellidobaja = $user['apellido'];
        $institucionbaja = $user['institucion'];
        $recicledtabla = 'Buena Fe';
        //Guardar el usuario a ELIMINAR en la tabla RECICLED

        if ($cuit == 0) {
            //BORRA TODO
            $sql = "INSERT INTO recicled (recicleddni, reciclednombre, recicledapellido, recicledinstitucion, recicledtabla, dnibaja, nombrebaja, apellidobaja, institucionbaja, fechabaja)
            SELECT buenafe.dnibuenafe, patinadores.nombrepatinador, patinadores.apellidopatinador, clubs.institucion,'$recicledtabla', '$dnibaja', '$nombrebaja', '$apellidobaja', '$institucionbaja', CURRENT_DATE() FROM buenafe, patinadores, clubs WHERE buenafe.dnibuenafe=patinadores.dnipatinador and patinadores.cuit=clubs.cuit;";

            if (mysqli_query($conexion, $sql)) {
                $sql = "DELETE FROM buenafe ;";
                if (mysqli_query($conexion, $sql)) {
                    echo json_encode('1');
                };
            } else {
                echo json_encode('No se pudo eliminar los datos!');
            }
        } else {
            //BORRA SOLO LOS COMPETIDORES DEL CLUB
            //Inserta consulta con varios resultados en la tabla RECICLED, en este caso los coincidentes con el CLUB seleccionado
            $sql = "INSERT INTO recicled (recicleddni, reciclednombre, recicledapellido, recicledinstitucion, recicledtabla, dnibaja, nombrebaja, apellidobaja, institucionbaja, fechabaja)
            SELECT buenafe.dnibuenafe, patinadores.nombrepatinador, patinadores.apellidopatinador, clubs.institucion, '$recicledtabla', '$dnibaja', '$nombrebaja', '$apellidobaja', '$institucionbaja', CURRENT_DATE() FROM buenafe, patinadores, clubs WHERE buenafe.dnibuenafe=patinadores.dnipatinador and patinadores.cuit=clubs.cuit AND patinadores.cuit=$cuit;";

            if (mysqli_query($conexion, $sql)) {
                $sql = " DELETE buenafe.* FROM buenafe, patinadores, clubs WHERE buenafe.dnibuenafe=patinadores.dnipatinador and patinadores.cuit=clubs.cuit AND patinadores.cuit=$cuit;";
                $query = mysqli_query($conexion, $sql);
                if (mysqli_query($conexion, $sql)) {
                    echo json_encode('1');
                };
            } else {
                echo json_encode('No se pudo eliminar los datos!');
            }
        }
        break;

    case 6:
        // Consulta by DNI
        $dni = $_GET['dni'];

        $sql = "SELECT patinadores.*, YEAR(CURDATE())-YEAR(patinadores.fechanacpatinador) AS edad, IFNULL(DATE_FORMAT(patinadores.fechanacpatinador, '%d-%m-%Y'),'**') AS fechanacimiento, clubs.institucion FROM patinadores, clubs WHERE patinadores.cuit=clubs.cuit AND patinadores.dnipatinador=$dni";

        $result = mysqli_query($conexion, $sql);

        $datos = array();
        while ($fila = mysqli_fetch_array($result)) {
            array_push($datos, $fila);
        }
        echo json_encode($datos);
        break;
}
mysqli_close($conexion);
