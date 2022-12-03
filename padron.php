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
  <!-- CSS loading -->
  <link rel="stylesheet" href="assets/css/loading.css" />
  <!-- fontawesome PRO -->
  <script src="fw_pro.js" crossorigin="anonymous"></script>
  <!-- DataTable -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.1.0/css/searchPanes.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.5.0/css/select.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.6.1/css/colReorder.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" />
  <!-- Sweet Alert2 -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="shortcut icon" href="assets/lepa.png">
  <title>LEPAA</title>
</head>

<!-- Estilos para esta pagina -->
<style>
  .form-floating>.form-control {
    height: calc(1.5em + 1.25rem + 14px);
  }

  .accordion-collapse {
    background-color: white;
  }

  th {
    font-size: 12px;
  }

  td {
    font-size: 11px;
  }

  input,
  select {
    font-weight: 700 !important;
  }

  .userPass {
    display: none;
  }

  .ocultarInputOpcion,
  .ocultarFiltros {
    display: none;
  }

  #contenedor {
    display: none;
  }

  .textoLoading {
    color: white !important;
    text-align: center !important;
  }

  div.dtsp-panesContainer {
    /* width: 100%; */
    background-color: white;
    padding: 7px;
    border-radius: 5px;
    border: 1px solid grey;
    margin-left: auto;
    margin-right: auto;
    display: none;
  }
</style>
<!-- FIN Estilos para esta pagina -->

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

  <!-- LOADING -->
  <?php include('modulos/loading.php'); ?>
  <!-- END LOADING -->

  <!-- [ Main Content ] start -->
  <div class="pcoded-main-container mt-4">
    <div class="text-center">
      <h1>Padron</h1>
    </div>

    <!-- CARGA VIA EXCEL -->
    <section id="contenedor"></section>

    <div class="col-lg-10 row mb-3 mt-4" id="altaExcel">
      <div class="input-group col-sm-5 btn-icon-split excel">
        <div class="custom-file">
          <input type="file" name="dataCliente" id="txt_archivo" class="custom-file-input" accept=".xlsx, .xls, .xlsb, .xlsm" onChange="onLoadImage(event.target.files)">
          <label class="custom-file-label" for="inputGroupFile04" id="nombreArchivo"><b>Seleccionar EXCEL</b></label>
        </div>
        <div class="input-group-append btn-icon-split">
          <button class="btn btn-danger" type="submit" name="subir" onclick="pasarCuit()">Grabar</button>
        </div>
      </div>

      <div class="form-group col-md-3 m-0 ml-2">
        <select name="cuit" class="form-control form-control-user" id="modificarCuit">
          <option value="">Seleccionar Institucion</option>
          <?php //Completa el SELECT on los datos de la tabla CLUBS
          $select = mysqli_query($con, "SELECT * FROM clubs");
          while ($clubs = mysqli_fetch_row($select)) {
          ?>
            <option value="<?php echo $clubs[1] ?>"><?php echo $clubs[2] ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group col-md-3 m-0">
        <button class="btn btn-secondary mostrarFiltros" id="mostrarFiltros" name="filtros" onclick="mostrarFiltros()" title="Muestra filtros para aplicar a la tabla"><i class="fas fa-filter"></i> <i class="fas fa-eye-slash"></i></button>
        <button class="btn btn-success ocultarFiltros" id="ocultarFiltros" name="filtros" onclick="ocultarFiltros()" title="Muestra filtros para aplicar a la tabla"><i class="fas fa-filter"></i> <i class="fas fa-eye"></i></button>
      </div>
    </div>
    <!-- FIN CARGA VIA EXCEL -->

    <div class="col-lg-12">
      <div class="table-responsive">
        <table id="tablaClientes" class="display responsive nowrap compact table-bordered" style="width: 100%">
          <thead class="text-center">
            <tr>
              <th>Apellido</th>
              <th>Nombres</th>
              <th>DNI</th>
              <th>Fecha Nacimiento</th>
              <th>Edad</th>
              <th>Sexo</th>
              <th>Nacionalidad</th>
              <th>Domicilio</th>
              <th>Provincia</th>
              <th>Localidad</th>
              <th>CP</th>
              <th>Función</th>
              <th>Tipo Licencia</th>
              <th>Telefono</th>
              <th>Institución</th>
              <th>Tipo afiliacion Club</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <!-- FROMULARIO MODAL CONSULTA/EDICION USUARIO -->
  <form class="modal fade" id="modalConsulta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <!-- cabecera del modal -->
        <div class="modal-header text-center">
          <h1 class="modal-title text-rigth" id="exampleModalLabel">Información Patinador/a</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- cuerpo del modal -->
        <div class="col-lg-12 modal-body">

          <div class="accordion" id="accordionExample">
            <!-- Acordeon 1 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Datos Personlaes
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="form-group classid">
                    <input name="id" type="number" class="form-control form-control-user ocultarID" id="consultarID" placeholder="id" />
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-5 form-floating">
                      <input name="dni" type="number" class="form-control" id="consultarDni" placeholder="DNI" />
                      <label for="floatingInput">DNI</label>
                    </div>
                    <div class="form-group col-md-4 form-floating">
                      <input name="fechanacimiento" type="date" class="form-control" id="consultarFechaNacimeinto" placeholder="Fecha Nacimeinto" required />
                      <label for="floatingInput">Fecha Nacimiento</label>
                    </div>
                    <div class="form-group col-md-3 form-floating">
                      <input name="nacionalidad" type="text" class="form-control form-control-user" id="consultarNacionalidad" placeholder="Nacionalidad" required />
                      <label for="floatingInput">Nacionalidad</label>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-5 form-floating">
                      <input name="nombre" type="text" class="form-control" id="consultarFirstName" placeholder="Nombre" required />
                      <label for="floatingInput">Nombre</label>
                    </div>
                    <div class="form-group col-md-7 form-floating">
                      <input name="apellido" type="text" class="form-control" id="consultarLastName" placeholder="Apellido" required />
                      <label for="floatingInput">Apellido</label>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-2 form-floating">
                      <select name="sexo" class="form-control form-select" id="consultarSexo" required>
                        <!-- <option value="vacio"></option> -->
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                        <option value="X">Binario</option>
                      </select>
                      <label for="floatingSelect">Sexo</label>
                    </div>
                    <div class="form-group col-md-3 form-floating">
                      <input name="telefono" type="number" class="form-control form-control-user" id="consultarTelefono" placeholder="Telefono" required />
                      <label for="floatingInput">Telefono</label>
                    </div>
                    <div class="form-group col-md-7 form-floating">
                      <input name="email" type="email" class="form-control form-control-user" id="consultarEmail" placeholder="Email" required />
                      <label for="floatingInput">Email</label>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <!-- Acordeon 2 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Domicilio
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="form-row">
                    <div class="form-group col-md-12 form-floating">
                      <input name="domicilio" type="text" class="form-control form-control-user" id="consultarDomicilio" placeholder="Domicilio" required />
                      <label for="floatingInput">Domicilio</label>
                    </div>
                  </div>
                  <div class="form-row">

                    <div class="form-group col-md-6 form-floating">
                      <input name="localidad" type="text" class="form-control form-control-user" id="consultarLocalidad" placeholder="Localidad" required />
                      <label for="floatingInput">Localidad</label>
                    </div>
                    <div class="form-group col-md-6 form-floating">
                      <input name="partido" type="text" class="form-control form-control-user" id="consultarPartido" placeholder="Partido" required />
                      <label for="floatingInput">Partido</label>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6 form-floating">
                      <input name="cp" type="text" class="form-control form-control-user" id="consultarCP" placeholder="Cód. Postal" required />
                      <label for="floatingInput">Cód. Postal</label>
                    </div>
                    <div class="form-group col-md-6 form-floating">
                      <input name="provincia" type="text" class="form-control form-control-user" id="consultarProvincia" placeholder="Provincia" required />
                      <label for="floatingInput">Provincia</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Acordeon 3 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Datos del Club
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="form-row">
                    <div class="form-group col-md-8 form-floating">
                      <select name="cuit" class="form-control form-control-user" id="consultarCuit" required>
                        <?php //Completa el SELECT on los datos de la tabla CLUBS
                        $select = mysqli_query($con, "SELECT * FROM clubs");
                        while ($clubs = mysqli_fetch_row($select)) {
                        ?>
                          <option value="<?php echo $clubs[1] ?>"><?php echo $clubs[2] ?></option>
                        <?php } ?>
                      </select>
                      <label for="floatingSelect">Club</label>
                    </div>

                    <div class="form-group col-md-4 form-floating">
                      <select name="licencia" class="form-control form-control-user" id="consultarLicencia" required>
                        <?php //Completa el SELECT on los datos de la tabla
                        $select = mysqli_query($con, "SELECT * FROM tipolicencias");
                        while ($licencia = mysqli_fetch_row($select)) {
                        ?>
                          <option value="<?php echo ($licencia[1]) ?>"><?php echo ($licencia[1]) ?></option>
                        <?php } ?>
                      </select>
                      <label for="floatingSelect">Licencia</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Acordeon 4 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Datos de los padres
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="form-row">
                    <div class="form-group col-md-7 form-floating">
                      <input name="nombrePadre" type="text" class="form-control" id="consultarNamePadre" placeholder="Nombre del Padre" required />
                      <label for="floatingInput">Nombre del Padre</label>
                    </div>
                    <div class="form-group col-md-5 form-floating">
                      <input name="dniPadre" type="number" class="form-control" id="consultarDniPadre" placeholder="DNI del Padre" required />
                      <label for="floatingInput">DNI del Padre</label>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-7 form-floating">
                      <input name="nombreMadre" type="text" class="form-control" id="consultarNameMadre" placeholder="Nombre de la Madre" required />
                      <label for="floatingInput">Nombre de la Madre</label>
                    </div>
                    <div class="form-group col-md-5 form-floating">
                      <input name="dniMadre" type="number" class="form-control" id="consultarDniMadre" placeholder="DNI de la Madre" required />
                      <label for="floatingInput">DNI de la Madre</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="ocultarInputOpcion">
            <input name="opcion" type="text" value="2">
          </div>

          <div>
            <label class="labelDatosAdicionales mb-0"><b>Alta:</b>
              <input name="datosAlta" type="text" class="datosAdicionales" id="datosAlta" disabled />
            </label>
            <label class="labelDatosAdicionales"><b>Ultima modificación:</b>
              <input name="datosMod" type="text" class="datosAdicionales" id="datosMod" disabled />
            </label>
          </div>
          <!-- Footer del modal -->
          <div class="modal-footer form-row">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="botonCancel">Close</button>
            <button class="btn btn-primary btn-modificar" type="submit" id="botonAceptar">Aceptar</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <!-- END CONSULTA/EDICION USUARIO -->


  <!-- FROMULARIO MODAL ALTA USUARIOS -->
  <form class="modal fade" id="formAlta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <!-- cabecera del modal -->
        <div class="modal-header text-center">
          <h1 class="modal-title text-rigth" id="exampleModalLabel">Información Patinador/a</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- cuerpo del modal -->
        <div class="col-lg-12 modal-body">

          <div class="accordion" id="accordionExample">
            <!-- Acordeon 1 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Datos Personlaes
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="form-group classid">
                    <input name="id" type="number" class="form-control form-control-user ocultarID" id="consultarID" placeholder="id" />
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-5 form-floating">
                      <input name="dni" type="number" class="form-control" id="altaDni" placeholder="DNI" required />
                      <label for="floatingInput">DNI</label>
                    </div>
                    <div class="form-group col-md-4 form-floating">
                      <input name="fechanacimiento" type="date" class="form-control" id="altaFechaNacimeinto" placeholder="Fecha Nacimeinto" required />
                      <label for="floatingInput">Fecha Nacimiento</label>
                    </div>
                    <div class="form-group col-md-3 form-floating">
                      <input name="nacionalidad" type="text" class="form-control form-control-user" id="altaNacionalidad" placeholder="Nacionalidad" required />
                      <label for="floatingInput">Nacionalidad</label>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-5 form-floating">
                      <input name="nombre" type="text" class="form-control" id="altaFirstName" placeholder="Nombre" required />
                      <label for="floatingInput">Nombre</label>
                    </div>
                    <div class="form-group col-md-7 form-floating">
                      <input name="apellido" type="text" class="form-control" id="altaLastName" placeholder="Apellido" required />
                      <label for="floatingInput">Apellido</label>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-2 form-floating">
                      <select name="sexo" class="form-control form-select" id="altaSexo" required>
                        <!-- <option value="vacio"></option> -->
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                        <option value="X">Binario</option>
                      </select>
                      <label for="floatingSelect">Sexo</label>
                    </div>
                    <div class="form-group col-md-3 form-floating">
                      <input name="telefono" type="number" class="form-control form-control-user" id="altaTelefono" placeholder="Telefono" required />
                      <label for="floatingInput">Telefono</label>
                    </div>
                    <div class="form-group col-md-7 form-floating">
                      <input name="email" type="email" class="form-control form-control-user" id="altaEmail" placeholder="Email" required />
                      <label for="floatingInput">Email</label>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <!-- Acordeon 2 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Domicilio
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="form-row">
                    <div class="form-group col-md-12 form-floating">
                      <input name="domicilio" type="text" class="form-control form-control-user" id="altaDomicilio" placeholder="Domicilio" required />
                      <label for="floatingInput">Domicilio</label>
                    </div>
                  </div>
                  <div class="form-row">

                    <div class="form-group col-md-6 form-floating">
                      <input name="localidad" type="text" class="form-control form-control-user" id="altaLocalidad" placeholder="Localidad" required />
                      <label for="floatingInput">Localidad</label>
                    </div>
                    <div class="form-group col-md-6 form-floating">
                      <input name="partido" type="text" class="form-control form-control-user" id="altaPartido" placeholder="Partido" required />
                      <label for="floatingInput">Partido</label>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6 form-floating">
                      <input name="cp" type="text" class="form-control form-control-user" id="altaCP" placeholder="Cód. Postal" required />
                      <label for="floatingInput">Cód. Postal</label>
                    </div>
                    <div class="form-group col-md-6 form-floating">
                      <input name="provincia" type="text" class="form-control form-control-user" id="altaProvincia" placeholder="Provincia" required />
                      <label for="floatingInput">Provincia</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Acordeon 3 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Datos del Club
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="form-row">
                    <div class="form-group col-md-8 form-floating">
                      <select name="cuit" class="form-control form-control-user" id="altaCuit" required>
                        <option value=""></option>
                        <?php //Completa el SELECT on los datos de la tabla CLUBS
                        $select = mysqli_query($con, "SELECT * FROM clubs");
                        while ($clubs = mysqli_fetch_row($select)) {
                        ?>
                          <option value="<?php echo $clubs[1] ?>"><?php echo $clubs[2] ?></option>
                        <?php } ?>
                      </select>
                      <label for="floatingSelect">Club</label>
                    </div>

                    <div class="form-group col-md-4 form-floating">
                      <select name="licencia" class="form-control form-control-user" id="altaLicencia" required>
                        <option value=""></option>
                        <?php //Completa el SELECT on los datos de la tabla
                        $select = mysqli_query($con, "SELECT * FROM tipolicencias");
                        while ($licencia = mysqli_fetch_row($select)) {
                        ?>
                          <option value="<?php echo ($licencia[1]) ?>"><?php echo ($licencia[1]) ?></option>
                        <?php } ?>
                      </select>
                      <label for="floatingSelect">Licencia</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Acordeon 4 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Datos de los padres
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <div class="form-row">
                    <div class="form-group col-md-7 form-floating">
                      <input name="nombrePadre" type="text" class="form-control" id="altaNamePadre" placeholder="Nombre del Padre" required />
                      <label for="floatingInput">Nombre del Padre</label>
                    </div>
                    <div class="form-group col-md-5 form-floating">
                      <input name="dniPadre" type="number" class="form-control" id="altaDniPadre" placeholder="DNI del Padre" required />
                      <label for="floatingInput">DNI del Padre</label>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-7 form-floating">
                      <input name="nombreMadre" type="text" class="form-control" id="altaNameMadre" placeholder="Nombre de la Madre" required />
                      <label for="floatingInput">Nombre de la Madre</label>
                    </div>
                    <div class="form-group col-md-5 form-floating">
                      <input name="dniMadre" type="number" class="form-control" id="altaDniMadre" placeholder="DNI de la Madre" required />
                      <label for="floatingInput">DNI de la Madre</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="ocultarInputOpcion">
            <input name="opcion" type="text" value="4">
          </div>

          <!-- Footer del modal -->
          <div class="modal-footer form-row">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="botonCancel">Close</button>
            <button class="btn btn-primary btn-modificar" type="submit" id="botonAceptar">Aceptar</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <!-- FIN FROMULARIO MODAL ALTA USUARIOS -->

  <!-- FROMULARIO MODAL BORRAR PATINADORES -->
  <form class="modal fade" id="formModalBorrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h1 class="modal-title text-rigth" id="exampleModalLabel">Eliminar Patinadores/as</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="col-lg-12 modal-body">
          <!-- Toma la Password del usuario -->
          <input type="text" class="userPass" name="userPass" value="<?php echo $user['password'] ?>" id="userPass">

          <p class="ml-4 font-weight-bold text-danger">Usted es un ADMINISTRADOR y esta por eliminar competidores del PADRON. Podrá eliminar TODOS los patinadores o SOLO aquellos del CLUB que seleccione!!</p>
          <div class="form-group col-md-12 form-floating">
            <select name="cuit" class="form-control form-control-user" id="borrarCuit">
              <option value=""></option>
              <option value="0">Eliminar TODOS</option>
              <?php
              $select = mysqli_query($con, "SELECT * FROM clubs");
              while ($clubs = mysqli_fetch_row($select)) { ?>

                <option value="<?php echo $clubs[1] ?>"><?php echo $clubs[2] ?></option>
              <?php  }
              ?>
            </select>
            <label for="floatingSelect">Seleccionar opción</label>
          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
              Cancel
            </button>
            <button class="btn btn-primary" type="submit">Aceptar</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <!-- FIN FROMULARIO MODAL BORRAR PATINADORES -->


  <!-- SCRIPTS -->

  <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
  <!-- Boostrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Required Js -->
  <script src="assets/js/vendor-all.min.js"></script>
  <script src="assets/js/plugins/bootstrap.min.js"></script>
  <script src="assets/js/pcoded.min.js"></script>
  <!-- Apex Chart -->
  <script src="assets/js/plugins/apexcharts.min.js"></script>
  <!-- custom-chart js -->
  <script src="assets/js/pages/dashboard-main.js"></script>
  <!-- Datatable -->
  <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/searchpanes/2.1.0/js/dataTables.searchPanes.min.js"></script>
  <script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script>
  <script src="https://cdn.datatables.net/colreorder/1.6.1/js/dataTables.colReorder.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
  <!-- Librerias para exportar la tabla a distintos documentos -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

  <script>
    // === CARGA LA TABLA CON DATOS ===
    var opcion = '';
    var fila;

    $(document).ready(function() {
      opcion = 0;
      fetch(`http://localhost/newproyect_lepa/api/padron.php?opcion=${opcion}`, {
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
          $("#tablaClientes").DataTable({
            searchPanes: {
              viewTotal: true,
              layout: 'columns-5',
              initCollapsed: true
            },
            columnDefs: [{
                searchPanes: {
                  show: true
                },
                targets: [3, 4, 5, 6, 8, 12, 14, 15]
              },
              {
                searchPanes: {
                  show: false
                },
                targets: [0, 7, 10]
              }
            ],
            colReorder: true,
            dom: '"PBfrtilp"',
            buttons: ["excelHtml5", "pdfHtml5", "print"],
          });
        });
    });

    // Accede y vuelca los datos del array en la tabla
    function consultarDatosATabla(dato) {
      $("#tablaClientes tbody").append(
        `<tr>
                    <td>${dato.apellidopatinador}</td>
                    <td>${dato.nombrepatinador}</td>
                    <td class="text-center">${dato.dnipatinador}</td>
                    <td class="text-center">${dato.fechanacimiento}</td>
                    <td class="text-center">${dato.edad}</td>
                    <td class="text-center">${dato.sexopatinador}</td>
                    <td class="text-center">${dato.nacionalidadpatinador}</td>
                    <td>${dato.domiciliopatinador}</td>
                    <td>${dato.provinciapatinador}</td>
                    <td>${dato.localidadpatinador}</td>
                    <td class="text-center">${dato.cppatinador}</td>
                    <td>${dato.funcionpatinador}</td>
                    <td>${dato.tipolicencia}</td>
                    <td>${dato.telefonopatinador}</td>
                    <td>${dato.institucion}</td>
                    <td>${dato.tipoafiliacion}</td>
                    <td class="text-center">
                        <a href="#" onclick="consultarUnCliente(${dato.id})" class="btn btn-info btn-circle btn-sm btnInfo">
                                <i class="fas fa-info-circle"></i>
                            </a>

                        <a href="#" onclick="consultarUnCliente(${dato.id})" class="btn btn-primary btn-circle btn-sm btnEdit">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                        <a href="#" onclick="eliminarCliente(${dato.id})" class="btn btn-danger btn-circle btn-sm">
                                <i class="fas fa-trash"></i>
                            </a>
                    </td>
                </tr>`
      );
    }
    // ===  FIN CARGA LA TABLA CON DATOS ===


    // === CONSULTAR DATOS ===
    function consultarUnCliente(id) {
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
        $("#consultarDni").prop('disabled', true);
        $(".labelDatosAdicionales").hide();
        $('#botonAceptar').show();
      });
      // consulta a base de datos según ID y opcion
      fetch(
          `http://localhost/newproyect_lepa/api/padron.php?id=${id}&opcion=${opcion}`, {
            method: 'GET',
            headers: {
              Accept: "application/json",
              "Content-Type": "application/json",
            },

          },
        )
        .then((respuesta) => respuesta.json())
        .then((datos) => {
          $("#consultarID").val(datos[0].id);
          $("#consultarDni").val(datos[0].dnipatinador);
          $("#consultarFechaNacimeinto").val(datos[0].fechanacpatinador);
          $("#consultarNacionalidad").val(datos[0].nacionalidadpatinador);
          $("#consultarFirstName").val(datos[0].nombrepatinador);
          $("#consultarLastName").val(datos[0].apellidopatinador);
          $("#consultarSexo").val(datos[0].sexopatinador);
          $("#consultarTelefono").val(datos[0].telefonopatinador);
          $("#consultarEmail").val(datos[0].emailpatinador);
          $("#consultarDomicilio").val(datos[0].domiciliopatinador);
          $("#consultarLocalidad").val(datos[0].localidadpatinador);
          $("#consultarPartido").val(datos[0].partidopatinador);
          $("#consultarCP").val(datos[0].cppatinador);
          $("#consultarProvincia").val(datos[0].provinciapatinador);
          $("#consultarCuit").val(datos[0].cuit);
          $("#consultarLicencia").val(datos[0].tipolicencia);
          $("#consultarNamePadre").val(datos[0].nombrepadre);
          $("#consultarDniPadre").val(datos[0].dnipadre);
          $("#consultarNameMadre").val(datos[0].nombremadre);
          $("#consultarDniMadre").val(datos[0].dnimadre);

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
    document.getElementById('modalConsulta').addEventListener('submit', function(e) {
      e.preventDefault();
      var datos = new FormData(formulario);
      // console.log(datos.get('fechanacimiento'));
      fetch(
          'http://localhost/newproyect_lepa/api/padron.php', {
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
              text: datos,
            })
          };
        });
    });
    // === FIN ACTUALIZAR DATOS ===

    // === ALTA de USUARIO ===
    function altaNuevo() {
      $(".form-control").prop('disabled', false);
      $(".form-select").prop('disabled', false);
      $('#botonAceptar').show();
      $('#formAlta').modal('show');
    }
    var formularioAlta = document.getElementById('formAlta');
    document.getElementById('formAlta').addEventListener('submit', function(e) {
      e.preventDefault();
      console.log('ALTA');
      var datos = new FormData(formularioAlta);
      // envia los datos a crear en la base de datos
      fetch(
          'http://localhost/newproyect_lepa/api/padron.php', {
            method: 'POST',
            body: datos,
            headers: {
              Accept: "application/json",
            },
          },
        )
        .then((respuesta) => respuesta.json())
        .then((datos) => {
          $('#formAlta').modal('hide');
          if (datos == 1) {
            Swal.fire({
              icon: 'success',
              title: 'Ok!',
              text: 'Patinador Ingresado con exito!',
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

    // === ELIMINAR USUARIO ===
    function eliminarCliente(id) {
      opcion = 1;
      // toma los datos del patinador
      fetch(
          `http://localhost/newproyect_lepa/api/padron.php?id=${id}&opcion=${opcion}`, {
            method: 'GET',
            headers: {
              Accept: "application/json",
              "Content-Type": "application/json",
            },
          },
        )
        .then((respuesta) => respuesta.json())
        .then((datos) => {
          nombre = (datos[0].nombrepatinador);
          apellido = (datos[0].apellidopatinador);
          // pide confirmación para eliminar
          Swal.fire({
            title: 'Esta seguro?',
            text: "Aceptar para borrar a: " + nombre + " " + apellido,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            // elimina el usuario
            if (result.isConfirmed) {
              opcion = 3;
              fetch(`http://localhost/newproyect_lepa/api/padron.php?id=${id}&opcion=${opcion}`, {
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
                      text: '"' + nombre + ' ' + apellido + '" eliminada/o con exito! ',
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
        text: "Esta por eliminar TODOS los usuarion del sistema!!!",
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
      var userPass = $("#userPass").val();
      console.log(userPass);
      // solicita password para eliminar
      const {
        value: checkPassword
      } = await Swal.fire({
        title: 'Entre su Password',
        input: 'password',
        inputLabel: 'Ingrese su Password para eliminar',
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
      if (checkPassword == userPass) {
        $('#formModalBorrar').modal('show');
      } else if (checkPassword == '') {
        Swal.fire({
          icon: 'info',
          title: 'Info..!',
          text: 'Debe introducir su password para poder eliminar',
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Ups..!',
          text: 'La password es incorrecta!',
        });
      };
    }

    // var formularioEliminar = document.getElementById('formModalBorrar');
    document.getElementById('formModalBorrar').addEventListener('submit', function(e) {
      e.preventDefault();
      //     var datos = new FormData(formularioEliminar);
      $('#formModalBorrar').modal('hide');
      opcion = 5;
      var cuit = $("#borrarCuit").val();

      if (cuit === '') {
        Swal.fire({
          icon: 'error',
          title: 'Ups..!',
          text: 'Debe seleccionar una opción a ejecutar!',
        });
      } else {
        fetch(
            `http://localhost/newproyect_lepa/api/padron.php?opcion=${opcion}&cuit=${cuit}`, {
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
                text: 'Patinadores eliminados!',
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
          });
      }
    });
    // === FIN ELIMINAR TODO ===

    // === Pantalla MODAL del LOGOUT ===
    function logoutModal() {
      $('#logoutModal').modal('show');
    }

    // CARGA DE DATOS VIA EXCEL
    // Muestra el nombre del archivo seleccionado
    function onLoadImage(files) {
      $(".form-control").prop('disabled', false);
      if (files && files[0]) {
        document
          .getElementById('nombreArchivo')
          .innerHTML = files[0].name
      }
    }

    //Verifica que archivo tenga extención EXCEL
    $('input[type="file"]').on('change', function() {
      var ext = $(this).val().split('.').pop();
      if ($(this).val() != '') {
        if (ext == 'xlsx' || ext == 'xls' || ext == 'xlsb' || ext == 'xlsm') {} else {
          $(this).val('');
          Swal.fire("Error", "Extensión no permitida: " + ext + "", "error");
        }
      }
    });

    function pasarCuit() {
      //Verifica que se selecciono un archivo y un club
      var cuit = $("#modificarCuit").val();
      let archivo = document.getElementById('txt_archivo').value;
      if (archivo.length == 0) {
        return Swal.fire("Advertencia", "Seleccione un Archivo", "warning");
      } else if (cuit == '') {
        return Swal.fire("Advertencia", "Seleccione una Institución", "warning");
      } else {
        $("#contenedor").load("variables_selects.php", {
          valorCuit: cuit
        });
        $('#modalLoading').modal('show');
        Cargar_Excel();
      }
    }

    //Carga los datos del EXCEL a la BD
    function Cargar_Excel() {
      $('#modalLoading').modal('show');
      let formData = new FormData();
      let excel = $("#txt_archivo")[0].files[0];
      formData.append('excel', excel);

      fetch(
          'http://localhost/newproyect_lepa/api/carga_excel_padron.php', {
            method: 'POST',
            body: formData,
            headers: {
              Accept: "application/json",
            },
          },
        )
        .then((respuesta) => respuesta.json())
        .then((datos) => {
          $('#modalLoading').modal('hide');
          $('#formAlta').modal('hide');
          if (datos == 1) {
            Swal.fire({
              icon: 'success',
              title: 'Ok!',
              text: 'Proceso finalizado',
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
    }

    // === MOSTRAR - OCULTAR FILTRO ===
    function mostrarFiltros() {
      document.querySelector(".dtsp-panesContainer").style.display = "block";
      document.getElementById("mostrarFiltros").style.display = "none";
      document.getElementById("ocultarFiltros").style.display = "block";
    }

    function ocultarFiltros() {
      document.querySelector(".dtsp-panesContainer").style.display = "none";
      document.getElementById("mostrarFiltros").style.display = "block";
      document.getElementById("ocultarFiltros").style.display = "none";
    }
    // === FIN MOSTRAR - OCULTAR FILTRO ===
  </script>
</body>

</html>