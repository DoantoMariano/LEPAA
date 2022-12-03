<?php

session_start();

//Variable: CUIT
$valorCuit = $_REQUEST['valorCuit'];
echo $valorCuit;
$_SESSION['valorCuit'] = $valorCuit;

//Variable: TORNEO
$valorTorneo = $_REQUEST['valorTorneo'];
echo $valorTorneo;
$_SESSION['valorTorneo'] = $valorTorneo;
