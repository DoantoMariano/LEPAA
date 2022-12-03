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

<style>
  .tablas {
    flex: none !important;
    width: 20% !important;
    height: 20% !important;
  }

  .btn-select {
    line-height: 1 !important;
  }
</style>


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
      <h1>Movimiento de Registros Altas / Modificados</h1>
    </div>

    <div class="input-group mb-3 ml-3">
      <!-- <button class="btn btn-info btn-icon-split btn-select" onclick="location.reload()">
        <span class="icon text-white-50" title="Recargar">
          <i class="fas fa-undo"></i>
        </span>
      </button> -->
      <select name="tabla" class="form-select tablas" id="consultarTabla" onchange="localData()">
        <option value="0">Seleccionar tabla</option>
        <option value="1">Buena Fe</option>
        <option value="2">Categorias</option>
        <option value="3">Clubs</option>
        <option value="4">Licencias</option>
        <option value="5">Padron</option>
        <option value="6">Torneos</option>
        <option value="7">Usuarios</option>
      </select>
    </div>

    <div class="col-lg-12">
      <div class="table-responsive">
        <table id="tablaClientes" class="display responsive nowrap compact table-bordered" width="100%">
          <thead class="text-center thead-dark table-sm"">
            <tr>
              <th class=" bg-info">DNI/ID</th>
            <th class="bg-info">Nombre/Dato</th>
            <th class="bg-info">Institucion</th>
            <th class="bg-primary">CUIT/ID Alta</th>
            <th class="bg-primary">Nombre Alta</th>
            <th class="bg-primary">Institucion Alta</th>
            <th class="bg-primary">Fecha Alta</th>
            <th class="bg-warning">Tabla</th>
            <th class="bg-warning">DNI/ID Mod</th>
            <th class="bg-warning">Nombre Mod</th>
            <th class="bg-warning">Institucion Mod</th>
            <th class="bg-warning">Fecha Mod</th>
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
    var tablaValor = '';
    // === CARGA LA TABLA CON DATOS ===
    $(document).ready(function() {
      // asigna a la variable el valor que esta en el LocalStorage
      tablaValor = localStorage.tablaValor
      $("#consultarTabla").val(tablaValor);
      consultarDatos()
    });

    function localData() {
      // asigna a la variable el valor de Select
      tablaValor = $("#consultarTabla").val();
      // guarda la opción SELECT en localStorage
      localStorage.tablaValor = tablaValor;
      window.location.reload();
      consultarDatos()

    }

    function consultarDatos() {
      // toma el valor del LocalStorage
      tablaValor = localStorage.tablaValor
      // Tabla Responsive y Exporta la tabla a EXCEL, PDF y PRINT
      fetch(`http://localhost/newproyect_lepa/api/registros_modificados.php?tablaValor=${tablaValor}`, {
          method: "GET",
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
          },
        })
        .then((respuesta) => respuesta.json())
        .then((datos) => {
          for (var dato of datos) {
            consultarDatosATabla(dato);
          }
          $("#tablaClientes").DataTable({
            destroy: true,
            dom: '"Bfrtilp"',
            buttons: ["excelHtml5", "pdfHtml5", "print"],
          });
        });
    };

    // Accede y vuelca los datos del array en la tabla
    function consultarDatosATabla(dato) {
      $("#tablaClientes tbody").append(
        `<tr>
              <td>${dato.dni}</td>
              <td>${dato.nombre} ${dato.apellido}</td>
              <td>${dato.institucion}</td>
              <td>${dato.dnialta}</td>
              <td>${dato.nombrealta} ${dato.apellidoalta}</td>
              <td>${dato.institucionalta}</td>
              <td>${dato.fechaalta}</td>
              <td><b>${dato.tabla}</b></td>
              <td>${dato.dnimod}</td>
              <td>${dato.nombremod} ${dato.apellidomod}</td>
              <td>${dato.institucionmod}</td>
              <td>${dato.fechamod}</td>
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