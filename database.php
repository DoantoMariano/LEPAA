<?php

// Conexiones PHP local

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'database_test';


try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}

// conexion a Base de Datos para el Excel
$con = new mysqli("localhost", "root", "", "database_test") or die("not connected" . mysqli_connect_error());
mysqli_query($con, "SET SESSION collation_connection ='utf8_unicode_ci'");
$db = mysqli_select_db($con, $database) or die("Upps! Error en conectar a la Base de Datos");

//otra conexion
$conexion = new mysqli("localhost", "root", "", "database_test") or die("not connected" . mysqli_connect_error());


//hostinger: UTILIZAR ESTAS CONEXIONES

// $server = 'localhost';
// $username = 'id19101333_lepaa';
// $password = 'Velocirraptor_2013';
// $database = 'id19101333_database';

// try {
//   $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
// } catch (PDOException $e) {
//   die('Connection Failed: ' . $e->getMessage());
// }

// conexion a Base de Datos para el Excel
// $con = new mysqli("localhost", "id19101333_lepaa", "Velocirraptor_2013", "id19101333_database") or die("not connected" . mysqli_connect_error());
// mysqli_query($con, "SET SESSION collation_connection ='utf8_unicode_ci'");
// $db = mysqli_select_db($con, $database) or die("Upps! Error en conectar a la Base de Datos");

//otra conexion
// $conexion = new mysqli("localhost", "id19101333_lepaa", "Velocirraptor_2013", "id19101333_database") or die("not connected" . mysqli_connect_error());
