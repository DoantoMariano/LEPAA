<?php include('modulos/encabezado_user_admin.php'); ?>


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
  <!-- vendor css -->
  <link rel="stylesheet" href="assets/css/styles.css" />
  <!-- CSS adicional - propio -->
  <link rel="stylesheet" href="assets/css/stylesplus.css" />
  <!-- fontawesome PRO -->
  <script src="fw_pro.js" crossorigin="anonymous"></script>
  <!-- DataTable -->
  <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" />
  <!-- Sweet Alert2 -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="shortcut icon" href="assets/lepa.png">
  <title>LEPAA</title>
</head>

<body class="">

  <!-- [ Header ] start -->
  <?php include('modulos/header.php'); ?>
  <!-- [ Header ] end -->

  <!-- [ navigation menu ] start -->
  <?php include('modulos/navmenu_tablas.php'); ?>
  <!-- [ navigation menu ] end -->

  <!-- LOGOUT MPODAL-->
  <?php include('modulos/logout.php'); ?>
  <!-- End LOGOUT -->

  <!-- [ Main Content ] start -->
  <div class="pcoded-main-container mt-4">
    <div class="text-center">
      <h1>Movimientos de Ingresos</h1>
    </div>
    <div class="col-lg-12">
      <div class="table-responsive">
        <table id="tablaClientes" class="display responsive nowrap compact table-bordered">
          <thead class="text-center">
            <tr>
              <th>DNI/ID</th>
              <th>Nombre</th>
              <th>Institucion</th>
              <th>Fecha Ingreso</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
  <!-- Required Js -->
  <script src="assets/js/vendor-all.min.js"></script>
  <script src="assets/js/plugins/bootstrap.min.js"></script>
  <script src="assets/js/pcoded.min.js"></script>

  <!-- Apex Chart -->
  <script src="assets/js/plugins/apexcharts.min.js"></script>

  <!-- custom-chart js -->
  <script src="assets/js/pages/dashboard-main.js"></script>

  <!-- Datatable -->
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

  <!-- Librerias para exportar la tabla a distintos documentos -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

  <script>
    // === CARGA LA TABLA CON DATOS ===
    $(document).ready(function() {
      // Tabla Responsive y Exporta la tabla a EXCEL, PDF y PRINT
      fetch(`http://localhost/newproyect_lepa/api/registros_ingresos.php`, {
          method: "GET",
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
          },
        })
        .then((respuesta) => respuesta.json())
        .then((datos) => {
          // Recorre la ARRAY
          for (var dato of datos) {
            consultarDatosATabla(dato);
          }
          $("#tablaClientes").DataTable({
            dom: '"Bfrtilp"',
            "order": [
              [3, 'des'],
            ],
            buttons: ["excelHtml5", "pdfHtml5", "print"],
          });
        });
    });

    // Accede y vuelca los datos del array en la tabla
    function consultarDatosATabla(dato) {
      $("#tablaClientes tbody").append(
        `<tr>
              <td>${dato.dniingreso}</td>
              <td>${dato.nombreingreso} ${dato.apellidoingreso}</td>
              <td>${dato.institucioningreso}</td>
              <td>${dato.fechaingreso}</td>
        </tr>`
      );
    }
    // ===  FIN CARGA LA TABLA CON DATOS ===

    // === Pantalla MODAL del LOGOUT ===
    function logoutModal() {
      $('#logoutModal').modal('show');
    }
  </script>
</body>

</html>