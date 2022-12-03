<?php
session_start();
date_default_timezone_set("America/Argentina/Buenos_Aires");

require '../database.php';
require '../vendor/autoload.php';

//echo $_SESSION['valorCuit'];

//CONSULTA LOS DATOS DEL USUARIO LOGUEADO
if (isset($_SESSION['user_id'])) {

    $records = $conn->prepare('SELECT users.id, users.dni, users.nombre, users.apellido, users.acceso, clubs.institucion, clubs.cuit FROM users, clubs WHERE users.cuit = clubs.cuit AND users.id= :id');
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


//TOMAS LOS DATOS DEL EXCEL

class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    public function readCell($columnAddress, $row, $worksheetName = '')
    {
        // Lee el archivo omitiendo la fila 1
        if ($row > 3) {
            return true;
        }
        return false;
    }
}

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();

//Carga el archivo Excel en la variable
$inputFileName = $_FILES['excel']['tmp_name'];
// $inputFileName = '../padron_1.xlsx';


/**  Identify the type of $inputFileName  **/
$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);

/**  Create a new Reader of the type that has been identified  **/
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

//Lee la funcion para obtener los datos de una celda específica mayores al numero colocado en la funcion, en este caso >1
$reader->setReadFilter(new MyReadFilter());


/**  Load $inputFileName to a Spreadsheet Object  **/
$spreadsheet = $reader->load($inputFileName);

// Crea un Array en la variable Cantidad
$cantidad = $spreadsheet->getActiveSheet()->toArray();

// Verifica si el archovo es el PADRON
$archivo = ($cantidad[3][6]);
if ($archivo != 'buenafe') {

    foreach ($cantidad as $row) {

        $apellido = $row[0];
        $nombre = $row[1];
        $dni = $row[2];
        $direccion = $row[5];
        $nacionalidad = $row[6];
        $provincia = $row[7];
        $localidad = $row[8];
        $cp = $row[9];
        $telefono = $row[10];
        $email = $row[11];
        $partido = $row[12];
        $nombrePadre = $row[13];
        $dniPadre = $row[14];
        $nombreMadre = $row[15];
        $dniMadre = $row[16];
        $licencia = $row[17];
        $fechaNacimiento = $row[18];
        // $cuit = 30536802939; 
        $cuit = $_SESSION['valorCuit'];
        $dnialta = $user['dni'];
        $nombrealta = $user['nombre'];
        $apellidoalta = $user['apellido'];
        $cuitalta = $user['cuit'];
        $institucionalta = $user['institucion'];
        $fechaalta = date('Y-m-d');


        if (empty($cuit)) {
            $cuit = $user['cuit']; //toma el CUIT del club del usuario logueado
        } else {
            $cuit = $_SESSION['valorCuit']; //el VlorCuit proviene de padron_excel.php
        }

        if ($row[4] == 'F' || $row[4] == 'f') {
            $sexo = 'F';
            $funcion = "Patinadora";
        } else if ($row[4] == 'M' || $row[4] == 'm') {
            $sexo = 'M';
            $funcion = "Patinador";
        } else {
            $sexo = 'X';
            $funcion = "Binario";
        }

        if ($dni != '') {
            $checkPatinador_duplicado = ("SELECT dnipatinador FROM patinadores WHERE dnipatinador='$dni'");
            $ca_dupli = mysqli_query($conexion, $checkPatinador_duplicado);
            $patinadorDuplicado = mysqli_num_rows($ca_dupli);

            if ($patinadorDuplicado == 0) {
                // si no existe el lo inserta en la tabla
                $insertar = "INSERT INTO patinadores(dnipatinador, fechanacpatinador, nombrepatinador, apellidopatinador,  sexopatinador, tipolicencia, emailpatinador, telefonopatinador, domiciliopatinador, nacionalidadpatinador, provinciapatinador, localidadpatinador, cppatinador, funcionpatinador, partidopatinador, nombrepadre, dnipadre, nombremadre, dnimadre, cuit, dnialta, nombrealta, apellidoalta, cuitalta, institucionalta, fechaalta) VALUES ('$dni','$fechaNacimiento','$nombre','$apellido','$sexo','$licencia','$email','$telefono','$direccion','$nacionalidad','$provincia','$localidad','$cp','$funcion','$partido','$nombrePadre','$dniPadre','$nombreMadre','$dniMadre','$cuit', '$dnialta', '$nombrealta', '$apellidoalta', '$cuitalta', '$institucionalta', '$fechaalta')";

                $result = $conexion->query($insertar);
            } else {
                //si existe el lo actualiza en la tabla
                $update = "UPDATE `patinadores` SET `fechanacpatinador`='$fechaNacimiento', `nombrepatinador`='$nombre',`apellidopatinador`='$apellido',  `sexopatinador`='$sexo', `tipolicencia`='$licencia', `emailpatinador`='$email', `telefonopatinador`='$telefono', `domiciliopatinador`='$direccion', `nacionalidadpatinador`='$nacionalidad',`provinciapatinador`='$provincia', `localidadpatinador`='$localidad', `cppatinador`='$cp', `funcionpatinador`='$funcion', `partidopatinador`='$partido', `nombrepadre`='$nombrePadre', `dnipadre`='$dniPadre', `nombremadre`='$nombreMadre', `dnimadre`='$dniMadre', `cuit`='$cuit'  WHERE `dnipatinador`='$dni'";

                $result = $conexion->query($update);
            };
        };
    };
    echo json_encode('1');
} else {
    echo json_encode('Archivo incorrecto! Seleccione el archivo PADRON');
}
