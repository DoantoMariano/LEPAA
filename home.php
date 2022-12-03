<?php include('modulos/encabezado_user.php'); ?>
<!-- Fin PHP -->


<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Meta -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <meta http-equiv="Expires" content="0" />
  <meta http-equiv="Last-Modified" content="0" />
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <!-- Boostrap Style -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Favicon icon -->
  <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon" />
  <!-- vendor css -->
  <link rel="stylesheet" href="assets/css/styles.css" />
  <link rel="stylesheet" href="assets/css/stylesplus.css" />
  <!-- Boostrap Style -->
  <!-- <link rel="stylesheet" href="assets/css/plugins/bootstrap.min.css"> -->
  <!-- fontawesome PRO -->
  <script src="fw_pro.js" crossorigin="anonymous"></script>
  <!-- DataTable -->
  <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet" />
  <!-- Sweet Alert2 -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="shortcut icon" href="assets/lepa.png">
  <title>LEPAA</title>
</head>


<body class="">

  <!-- [ Header ] start -->
  <?php include('modulos/header.php') ?>
  <!-- [ Header ] end -->

  <!-- [ navigation menu ] start -->
  <?php include('modulos/navmenu.php') ?>
  <!-- [ navigation menu ] end -->

  <!-- LOGOUT MPODAL-->
  <?php include('modulos/logout.php'); ?>
  <!-- End LOGOUT -->

  <!-- [ Main Content ] start -->
  <div class="pcoded-main-container">
    <h1 class="mb-3 text-center">Liga de Entrenadores de Patín Artístico Argentina</h1>
    <img src="assets/lepa.png" alt="LogoLEPAA">
  </div>
  <!-- [ Main Content ] end -->


  <!-- Mensaje de error de Acceso a SYSTEM LEPA -->
  <?php if (!empty($_SESSION['mensajeAcceso'])) : ?>
    <?php if ($_SESSION['valorAcceso'] == 0) : ?>
      <p><?= '<script>Swal.fire("","' .  $_SESSION['mensajeAcceso'] . '","error");</script>'; ?></p>
      <?php $_SESSION['mensajeAcceso'] = '' ?>
    <?php endif; ?>
  <?php endif; ?>
  <!-- END de error de Acceso a SYSTEM LEPA -->

  <!-- Required Js -->
  <script src="assets/js/vendor-all.min.js"></script>
  <script src="assets/js/plugins/bootstrap.min.js"></script>
  <script src="assets/js/pcoded.min.js"></script>

  <script>
    function logoutModal() {
      $('#logoutModal').modal('show');
    }
  </script>
</body>

</html>