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
      <h1>Instituciones</h1>
    </div>
    <div class="col-lg-12">
      <div class="table-responsive">
        <table id="tablaClubs" class="display responsive nowrap compact table-bordered" style="width: 100%">
          <thead class="text-center">
            <tr>
              <th class="text-center">CUIT/CUIL/ID</th>
              <th class="text-center">Nombre Institución</th>
              <th class="text-center">Dirección</th>
              <th class="text-center">Localidad</th>
              <th class="text-center">Tipo Afiliaciones</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <!-- FROMULARIO MODAL CONSULTA/EDICION -->
  <form class="modal fade" id="modalConsulta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">Informacion Institucion</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="col-lg-12">
          <div class="form-group classid">
            <input name="id" type="number" class="form-control form-control-user ocultarID" id="consultarID" placeholder="id" />
          </div>
          <div class="form-group form-floating">
            <input name="cuit" type="number" class="form-control form-control-user" id="consultarCuit" placeholder="CUIT" />
            <label for="floatingInput">CUIT/CUIL</label>
          </div>

          <div class="form-group form-floating">
            <input name="institucion" type="text" class="form-control form-control-user" id="consultarInstitucion" placeholder="Nombre Institucion" required />
            <label for="floatingInput">Nombre Institucion</label>
          </div>
          <div class="form-group form-floating">
            <input name="direccion" type="text" class="form-control form-control-user" id="consultarDireccion" placeholder="Direccion" required />
            <label for="floatingInput">Direccion</label>
          </div>

          <div class="form-group form-floating">
            <input name="localidad" type="text" class="form-control form-control-user" id="consultarLocalidad" required />
            <label for="floatingInput">Localidad</label>
          </div>

          <div class="form-group form-floating">
            <select name="afiliaciones" class="form-select" id="consultarafiliaciones" required>
              <option value="">Seleccionar tipo de Afiliaciones</option>
              <option value="LEPAA-RUD">LEPAA-RUD</option>
              <option value="LEPAA-FEDERADO">LEPAA-FEDERADOS</option>
              <option value="LEPAA-FEDERADO y RUD">LEPAA-FEDERADO y RUD</option>
              <option value="AFILIADO-RIO">AFILIADO-RIO</option>
              <option value="INVITADO">INVITADO</option>
            </select>
            <label for="floatingInput">Tipo afiliacion</label>
          </div>

          <div>
            <label class="labelDatosAdicionales mb-0"><b>Alta:</b>
              <input name="datosAlta" type="text" class="datosAdicionales" id="datosAlta" disabled />
            </label>
            <label class="labelDatosAdicionales"><b>Ultima modificación:</b>
              <input name="datosMod" type="text" class="datosAdicionales" id="datosMod" disabled />
            </label>
          </div>

          <div class="ocultarInputOpcion">
            <input name="opcion" type="text" value="2">
          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal" id="botonCancel">
              Cancel
            </button>
            <button class="btn btn-primary btn-modificar" type="submit" id="botonAceptar">Aceptar</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <!-- END CONSULTA/EDICION -->

  <!-- FROMULARIO MODAL ALTA -->
  <form class="modal fade" id="modalAlta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">Alta Institucion</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="col-lg-12">
          <div class="form-group classid">
            <!-- <input name="id" type="number" class="form-control form-control-user ocultarID" id="consultarID" placeholder="id" /> -->
          </div>
          <div class="form-group form-floating">
            <input name="cuit" type="number" class="form-control form-control-user" id="altaCuit" placeholder="CUIT" required />
            <label for="floatingInput">CUIT/CUIL</label>
          </div>

          <div class="form-group form-floating">
            <input name="institucion" type="text" class="form-control form-control-user" id="altaInstitucion" placeholder="Nombre Institucion" required />
            <label for="floatingInput">Nombre Institucion</label>
          </div>

          <div class="form-group form-floating">
            <input name="direccion" type="text" class="form-control form-control-user" id="altaDireccion" placeholder="Direccion" required />
            <label for="floatingInput">Direccion</label>
          </div>

          <div class="form-group form-floating">
            <input name="localidad" type="text" class="form-control form-control-user" id="altaLocalidad" placeholder="Localidad" required />
            <label for="floatingInput">Localidad</label>
          </div>

          <div class="form-group form-floating">
            <select name="afiliaciones" class="form-select" id="altaAfiliaciones" required>
              <option value="">Seleccionar tipo de Afiliaciones</option>
              <option value="LEPAA-RUD">LEPAA-RUD</option>
              <option value="LEPAA-FEDERADO">LEPAA-FEDERADOS</option>
              <option value="LEPAA-FEDERADO y RUD">LEPAA-FEDERADO y RUD</option>
              <option value="AFILIADO-RIO">AFILIADO-RIO</option>
              <option value="INVITADO">INVITADO</option>
            </select>
            <label for="floatingInput">Tipo afiliacion</label>
          </div>

          <div class="ocultarInputOpcion">
            <input name="opcion" type="text" value="4">
          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal" id="botonCancel">
              Cancel
            </button>
            <button class="btn btn-primary btn-alta" type="submit" id="botonAceptar">Aceptar</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <!-- FIN FROMULARIO MODAL ALTA -->

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
    var opcion = '';
    var fila;

    $(document).ready(function() {
      opcion = 0;
      fetch(`http://localhost/newproyect_lepa/api/clubs.php?opcion=${opcion}`, {
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
          // Tabla Responsive y Exporta la tabla a EXCEL, PDF y PRINT
          $("#tablaClubs").DataTable({
            dom: '"Bfrtilp"',
            buttons: ["excelHtml5", "pdfHtml5", "print"],
          });
        });
    });

    // Accede y vuelca los datos del array en la tabla
    function consultarDatosATabla(dato) {
      $("#tablaClubs tbody").append(
        `<tr>
                    <td>${dato.cuit}</td>
                    <td>${dato.institucion}</td>
                    <td>${dato.direccion}</td>
                    <td>${dato.localidad}</td>
                    <td>${dato.tipoafiliacion}</td>
                    <td class="text-center">
                        <a href="#" onclick="consultarUnItem(${dato.id})" class="btn btn-info btn-circle btn-sm btnInfo">
                                <i class="fas fa-info-circle"></i>
                            </a>

                        <a href="#" onclick="consultarUnItem(${dato.id})" class="btn btn-primary btn-circle btn-sm btnEdit">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                        <a href="#" onclick="eliminarItem(${dato.id})" class="btn btn-danger btn-circle btn-sm">
                                <i class="fas fa-trash"></i>
                            </a>
                    </td>
                </tr>`
      );
    }
    // ===  FIN CARGA LA TABLA CON DATOS ===

    // === CONSULTAR DATOS ===
    function consultarUnItem(id) {
      opcion = 1;
      $('#modalConsulta').modal('show');

      // Mustra formulario modo Info
      $(document).on("click", ".btnInfo", function() {
        $(".form-control").prop('disabled', true);
        $(".form-select").prop('disabled', true);
        $('#botonAceptar').hide();
        $(".labelDatosAdicionales").show();
      });

      // Muestra formulario modo Edición
      $(document).on("click", ".btnEdit", function() {
        $(".form-control").prop('disabled', false);
        $(".form-select").prop('disabled', false);
        $("#consultarCuit").prop('disabled', true);
        $(".labelDatosAdicionales").hide();
        $('#botonAceptar').show();
      });
      // consulta a base de datos según ID y opcion
      fetch(
          `http://localhost/newproyect_lepa/api/clubs.php?id=${id}&opcion=${opcion}`, {
            method: 'GET',
            headers: {
              Accept: "application/json",
              "Content-Type": "application/json",
            },

          },
        )
        .then((respuesta) => respuesta.json())
        .then((datos) => {
          // Carga el formulario con los datos obtenidos
          $("#consultarID").val(datos[0].id);
          $("#consultarCuit").val(datos[0].cuit);
          $("#consultarInstitucion").val(datos[0].institucion);
          $("#consultarDireccion").val(datos[0].direccion);
          $("#consultarLocalidad").val(datos[0].localidad);
          $("#consultarafiliaciones").val(datos[0].tipoafiliacion);

          var alta = datos[0].nombrealta + ' ' + datos[0].apellidoalta + ' - ' + datos[0].newfechaalta
          if (datos[0].nombrealta === null || datos[0].nombrealta === '') {
            alta = "by System"
            $("#datosAlta").val(alta);
          } else {
            $("#datosAlta").val(alta);
          }

          var modificado = datos[0].nombremod + ' ' + datos[0].apellidomod + ' - ' + datos[0].newfechamod
          if (datos[0].nombremod === null || datos[0].nombremod === '') {
            modificado = "Sin modificacion"
            $("#datosMod").val(modificado);
          } else {
            $("#datosMod").val(modificado);
          }
        });
    }
    // === FIN CONSULTAR DATOS ===

    // === ACTUALIZA LOS DATOS en la BD ===
    var formulario = document.getElementById('modalConsulta');
    // $(document).on("click", ".btn-modificar", function(e) {
    document.getElementById('modalConsulta').addEventListener('submit', function(e) {
      e.preventDefault();
      var datos = new FormData(formulario);

      // envian los datos a modificar en la base de datos
      fetch(
          'http://localhost/newproyect_lepa/api/clubs.php', {
            method: 'POST',
            body: datos,
            headers: {
              Accept: "application/json",
            },
          },
        )
        .then((respuesta) => respuesta.json())
        .then((datos) => {
          $('#modalConsulta').modal('hide');
          if (datos == 1) {
            Swal.fire({
              icon: 'success',
              title: 'Ok!',
              text: 'Datos actualizados!',
            }).then((result) => {
              window.location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Ups..!',
              text: 'Las modificaiones NO pudieron registrarse!',
            })
          };
        });
    });
    // === FIN ACTUALIZAR DATOS ===

    // === ALTAS ===
    function altaNuevo() {
      $(".form-control").prop('disabled', false);
      $(".form-select").prop('disabled', false);
      $('#botonAceptar').show();
      $('#modalAlta').modal('show');
    }
    var formularioAlta = document.getElementById('modalAlta');
    document.getElementById('modalAlta').addEventListener('submit', function(e) {
      e.preventDefault();
      var datos = new FormData(formularioAlta);
      // envia los datos a crear en la base de datos
      fetch(
          'http://localhost/newproyect_lepa/api/clubs.php', {
            method: 'POST',
            body: datos,
            headers: {
              Accept: "application/json",
            },
          },
        )
        .then((respuesta) => respuesta.json())
        .then((datos) => {
          $('#modalAlta').modal('hide');
          if (datos == 1) {
            Swal.fire({
              icon: 'success',
              title: 'Ok!',
              text: 'Club ingresado con exito!',
            }).then((result) => {
              window.location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Ups..!',
              text: datos,
            })
          };
        });
    });

    // === FIN Alta USUARIO ===

    // === ELIMINAR por ID ===
    function eliminarItem(id) {
      opcion = 1;
      // toma los datos del id
      fetch(
          `http://localhost/newproyect_lepa/api/clubs.php?id=${id}&opcion=${opcion}`, {
            method: 'GET',
            headers: {
              Accept: "application/json",
              "Content-Type": "application/json",
            },
          },
        )
        .then((respuesta) => respuesta.json())
        .then((datos) => {
          nombreDato = (datos[0].institucion);
          // pide confirmación para eliminar
          Swal.fire({
            title: 'Esta seguro?',
            text: "Aceptar para borrar a: " + nombreDato,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            // elimina
            if (result.isConfirmed) {
              opcion = 3;
              console.log(id);
              fetch(`http://localhost/newproyect_lepa/api/clubs.php?id=${id}&opcion=${opcion}`, {
                  method: "GET",
                  headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                  },
                }).then((respuesta) => respuesta.json())
                .then((datos) => {
                  $('#formAlta').modal('hide');
                  if (datos == 1) {
                    Swal.fire({
                      icon: 'success',
                      title: 'Ok!',
                      text: 'Club eliminado con exito!',
                    }).then((result) => {
                      window.location.reload();
                    });
                  } else {
                    Swal.fire({
                      icon: 'error',
                      title: 'Ups..!',
                      text: 'El Club no pudo eliminarse!',
                    })
                  };
                });
            }
          });
        });
    }
    // === FIN ELIMINAR USUARIO ===


    // ELIMINAR -TODOS- LOS USUARIOS
    function eliminarTodos() {
      // aviso previo antes de eliminar todos los usuarios
      Swal.fire({
        title: 'Esta seguro?',
        text: "Esta por eliminar TODOS las Instituciones del sistema!!! Debe tener en cuenta que al eliminar una Institución se ELIMINARAN TODOS LOS DATOS RELACIONADOS CON ESTA: Usuarios - Patinadores - Padron - Listas de Buena Fe...",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          eliminar()
        };
      });
    }

    async function eliminar() {
      // solicita password para eliminar
      const {
        value: password
      } = await Swal.fire({
        title: 'Entre su Password',
        input: 'password',
        inputLabel: 'Ingrese su Password para eliminar TODAS las Instituciones',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        inputPlaceholder: 'Entre su password',
        inputAttributes: {
          maxlength: 50,
          autocapitalize: 'off',
          autocorrect: 'off'
        }
      })
      if (password) {
        // elimina todos los usuario, menos al que ejecuta el proceso
        opcion = 5;
        fetch(
            `http://localhost/newproyect_lepa/api/clubs.php?password=${password}&opcion=${opcion}`, {
              method: 'GET',
              headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
              },
            },
          )
          .then((respuesta) => respuesta.json())
          .then((datos) => {
            if (datos == 1) {
              Swal.fire({
                icon: 'success',
                title: 'Ok!',
                text: 'Instituciones eliminados!',
              }).then((result) => {
                window.location.reload();
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Ups..!',
                text: datos,
              });
            };
          })
      } else {
        Swal.fire({
          icon: 'info',
          title: 'Info..!',
          text: 'Debe introducir su password para eliminr todos las Instituciones.',
        });
      };
    }
    // === FIN ELIMINAR TODOS LOS USUARIO ===

    // === Pantalla MODAL del LOGOUT ===
    function logoutModal() {
      $('#logoutModal').modal('show');
    }
  </script>
</body>

</html>