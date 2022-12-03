<?php include('modulos/encabezado_user.php'); ?>

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

  <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.3.0/css/rowGroup.dataTables.min.css">
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
    text-align: center;
    font-size: 8.5px;
  }

  td {
    font-size: 10px;
  }

  input,
  select {
    font-weight: 700 !important;
  }

  .ocultarInputOpcion,
  .ocultarFiltros,
  .ocultarGrupos {
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

  /* .dtrg-group th {
    color: black;
  }

  .dtrg-level-0 th {
    font-size: 13px;
    background-color: rgb(185, 141, 185) !important;
  }

  .dtrg-level-1 th {
    background-color: rgb(225, 167, 225) !important;
  } */
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
      <h1>Buena Fe</h1>
    </div>

    <!-- toma el tipo de acceso y password del usuario -->
    <div class="ocultarInputOpcion">
      <input name="tipoAcceso" id="tipoAcceso" type="text" value="<?php echo $user['acceso'] ?>">
      <input type="text" name="userPass" id="userPass" value="<?php echo $user['password'] ?>">
    </div>

    <!-- CARGA VIA EXCEL -->
    <section id="contenedor"></section>

    <div class="col-lg-12 row mb-3 mt-4" id="altaExcel">
      <div class="input-group col-sm-5 btn-icon-split excel mb-2">
        <div class="custom-file">
          <input type="file" name="dataCliente" id="txt_archivo" class="custom-file-input" accept=".xlsx, .xls, .xlsb, .xlsm" onChange="onLoadImage(event.target.files)">
          <label class="custom-file-label" for="inputGroupFile04" id="nombreArchivo"><b>Seleccionar EXCEL</b></label>
        </div>
        <div class="input-group-append btn-icon-split">
          <button class="btn btn-danger" type="submit" name="subir" onclick="pasarTorneo()">Grabar</button>
        </div>
      </div>

      <div class="form-group col-md-3 m-0">
        <select name="torneo" class="form-control form-control-user" id="modificarTorneo">
          <option value="">Seleccionar Torneo</option>
          <?php //Completa el SELECT on los datos de la tabla CLUBS
          $select = mysqli_query($con, "SELECT * FROM torneo");
          while ($opcion = mysqli_fetch_row($select)) {
          ?>
            <option value="<?php echo ($opcion[1]) ?>"><?php echo ($opcion[1]) ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group col-md-1 m-0">
        <button class="btn btn-secondary mostrarFiltros" id="mostrarFiltros" name="filtros" onclick="mostrarFiltros()" title="Filtros DESACTIVADOS"><i class="fas fa-filter"></i></i></button>
        <button class="btn btn-success ocultarFiltros" id="ocultarFiltros" name="filtros" onclick="ocultarFiltros()" title="Filtros ACTIVADOS"><i class="fas fa-filter"></i></i></button>
      </div>

      <!-- FIN CARGA VIA EXCEL -->

      <div class="col-lg-12">
        <div class="table-responsive">
          <table id="tablaClientes" class="display responsive nowrap compact table-bordered" style="width: 100%">
            <thead class="text-center">
              <tr>
                <th>DNI</th>
                <th>Sexo</th>
                <th>Apellido</th>
                <th>Nombres</th>
                <th>Fecha Nacimiento</th>
                <th>Edad</th>
                <th>Categoria</th>
                <th>Disciplina</th>
                <th>Tipo Licencia</th>
                <th>A Pagar</th>
                <th>Torneo</th>
                <th>Institución</th>
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
            <h1 class="modal-title text-rigth" id="exampleModalLabel">Información Buena Fe Patinador/a</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <!-- cuerpo del modal -->
          <div class="col-lg-12 modal-body">

            <div class="accordion" id="accordionExample">
              <!-- Acordeon 1 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Datos Personales Patinador/a
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <div class="form-group classid">
                      <input name="id" type="number" class="ocultarID" id="consultarID" placeholder="id" />
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-5 form-floating">
                        <input name="dni" type="number" class="form-control" id="consultarDni" placeholder="DNI" />
                        <label for="floatingInput">DNI</label>
                      </div>
                      <div class="form-group col-md-3 form-floating">
                        <input name="fechanacimiento" type="text" class="form-control" id="consultarFechaNacimiento" placeholder="Fecha Nacimeinto" required />
                        <label for="floatingInput">Fecha Nacimiento</label>
                      </div>
                      <div class="form-group col-md-2 form-floating">
                        <input name="edad" type="text" class="form-control" id="consultarEdad" placeholder="Edad" required />
                        <label for="floatingInput">Edad</label>
                      </div>
                      <div class="form-group col-md-2 form-floating">
                        <select name="sexo" class="form-control form-select" id="consultarSexo" required>
                          <option value=""></option>
                          <option value="M">Masculino</option>
                          <option value="F">Femenino</option>
                          <option value="X">Binario</option>
                        </select>
                        <label for="floatingSelect">Sexo</label>
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
                      <div class="form-group col-md-8 form-floating">
                        <select name="cuit" class="form-control" id="consultarCuit" required>
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
                        <select name="licencia" class="form-control" id="consultarLicencia" required>
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

              <!-- Acordeon 2 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    Datos del torneo
                  </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <div class="form-row">

                      <div class="form-group col-md-4 form-floating">
                        <select name="disciplina" class="form-control form-control-edit" id="consultarDisciplina" required>
                          <option value=""></option>
                          <!-- <option value="">Seleccionar Institucion</option> -->
                          <?php
                          $select = mysqli_query($con, "SELECT * FROM disciplinas");
                          while ($opcion = mysqli_fetch_row($select)) { ?>
                            <option value="<?php echo $opcion[1] ?>"><?php echo $opcion[1] ?></option>
                          <?php  }
                          ?>
                        </select>
                        <label for="floatingSelect">Disciplina</label>
                      </div>
                      <div class="form-group col-md-4 form-floating">
                        <select name="categoria" class="form-control form-control-edit" id="consultarCategoria" required>
                          <option value=""></option>
                          <!-- <option value="">Seleccionar Categoria</option> -->
                          <?php
                          $select = mysqli_query($con, "SELECT * FROM categorias");
                          while ($opcion = mysqli_fetch_row($select)) { ?>
                            <option value="<?php echo $opcion[1] ?>"><?php echo $opcion[1] ?></option>
                          <?php  }
                          ?>
                        </select>
                        <label for="floatingSelect">Categoria</label>
                      </div>
                      <div class="form-group col-md-4 form-floating">
                        <input name="apagar" type="text" class="form-control form-control-edit text-end" id="consultarApagar" placeholder="A pagar" required />
                        <label for="floatingInput">A pagar</label>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-md-12 form-floating">
                        <select name="torneo" class="form-control form-control-edit" id="consultarTorneo" required>
                          <option value=""></option>
                          <?php //Completa el SELECT on los datos de la tabla CLUBS
                          $select = mysqli_query($con, "SELECT * FROM torneo");
                          while ($opcion = mysqli_fetch_row($select)) {
                          ?>
                            <option value="<?php echo ($opcion[1]) ?>"><?php echo ($opcion[1]) ?></option>
                          <?php } ?>
                        </select>
                        <label for="floatingSelect">Torneo</label>
                      </div>
                    </div>

                    <div class="form-floating">
                      <textarea name="observaciones" id="observaciones" class="form-control form-control-edit" placeholder="Observaciones" style="height: 70px"></textarea>
                      <label for="floatingTextarea2">Observaciones</label>
                    </div>

                  </div>
                </div>
              </div>

            </div>
            <!-- Fin acordeon -->

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
            <h1 class="modal-title text-rigth" id="exampleModalLabel">Alta Patinador/a</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- cuerpo del modal -->
          <div class="col-lg-12 modal-body">
            <div class="accordion" id="accordionExample">
              <!-- Acordeon 1 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Datos Personales
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <div class="form-group classid">
                      <input name="id" type="number" class="ocultarID" id="consultarID" placeholder="id" />
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-5 form-floating">
                        <input name="dni" type="number" class="form-control" id="altaDni" placeholder="DNI" onchange="altaNuevo()" required />
                        <label for="floatingInput">DNI</label>
                      </div>
                      <div class="form-group col-md-3 form-floating">
                        <input name="fechanacimiento" type="text" class="form-control inactivo" id="altaFechaNacimiento" placeholder="Fecha Nacimeinto" />
                        <label for="floatingInput">Fecha Nacimiento</label>
                      </div>
                      <div class="form-group col-md-2 form-floating">
                        <input name="edad" type="text" class="form-control inactivo" id="altaEdad" placeholder="Edad" />
                        <label for="floatingInput">Edad</label>
                      </div>
                      <div class="form-group col-md-2 form-floating">
                        <select name="sexo" class="form-control form-select inactivo" id="altaSexo">
                          <option value=""></option>
                          <option value="M">Masculino</option>
                          <option value="F">Femenino</option>
                          <option value="X">Binario</option>
                        </select>
                        <label for="floatingSelect">Sexo</label>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-md-5 form-floating">
                        <input name="nombre" type="text" class="form-control inactivo" id="altaFirstName" placeholder="Nombre" />
                        <label for="floatingInput">Nombre</label>
                      </div>
                      <div class="form-group col-md-7 form-floating">
                        <input name="apellido" type="text" class="form-control inactivo" id="altaLastName" placeholder="Apellido" />
                        <label for="floatingInput">Apellido</label>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-md-8 form-floating">
                        <select name="cuit" class="form-control inactivo" id="altaCuit">
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
                        <select name="licencia" class="form-control inactivo" id="altaLicencia">
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

              <!-- Acordeon 2 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    Datos del torneo
                  </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <div class="form-row">

                      <div class="form-group col-md-4 form-floating">
                        <select name="disciplina" class="form-control form-control-edit" id="altaDisciplina" required>
                          <option value=""></option>
                          <!-- <option value="">Seleccionar Institucion</option> -->
                          <?php
                          $select = mysqli_query($con, "SELECT * FROM disciplinas");
                          while ($opcion = mysqli_fetch_row($select)) { ?>
                            <option value="<?php echo $opcion[1] ?>"><?php echo $opcion[1] ?></option>
                          <?php  }
                          ?>
                        </select>
                        <label for="floatingSelect">Disciplina</label>
                      </div>
                      <div class="form-group col-md-4 form-floating">
                        <select name="categoria" class="form-control form-control-edit" id="altaCategoria" required>
                          <option value=""></option>
                          <!-- <option value="">Seleccionar Categoria</option> -->
                          <?php
                          $select = mysqli_query($con, "SELECT * FROM categorias");
                          while ($opcion = mysqli_fetch_row($select)) { ?>
                            <option value="<?php echo $opcion[1] ?>"><?php echo $opcion[1] ?></option>
                          <?php  }
                          ?>
                        </select>
                        <label for="floatingSelect">Categoria</label>
                      </div>
                      <div class="form-group col-md-4 form-floating">
                        <input name="apagar" type="text" class="form-control form-control-edit text-end" id="altaApagar" placeholder="A pagar" required />
                        <label for="floatingInput">A pagar</label>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-md-12 form-floating">
                        <select name="torneo" class="form-control form-control-edit" id="altaTorneo" required>
                          <option value=""></option>
                          <?php //Completa el SELECT on los datos de la tabla CLUBS
                          $select = mysqli_query($con, "SELECT * FROM torneo");
                          while ($opcion = mysqli_fetch_row($select)) {
                          ?>
                            <option value="<?php echo ($opcion[1]) ?>"><?php echo ($opcion[1]) ?></option>
                          <?php } ?>
                        </select>
                        <label for="floatingSelect">Torneo</label>
                      </div>
                    </div>

                    <div class="form-floating">
                      <textarea name="observaciones" id="observaciones" class="form-control form-control-edit" placeholder="Observaciones" style="height: 70px"></textarea>
                      <label for="floatingTextarea2">Observaciones</label>
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
            <!-- si el usuario es administrador se pregunta si elimina todo o algun club en particular -->
            <?php if ($user['acceso'] == 'administrador') : ?>
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
            <?php endif; ?>

            <!-- si el usuario NO es administrador se muestra solo el club a eliminar al que pertenece el usuario -->
            <?php if ($user['acceso'] != 'administrador') : ?>
              <p class="ml-4 font-weight-bold text-danger">Usted esta por eliminar *TODOS* los competidores del siguiente club:</p>
              <div class="form-group col-md-12">
                <select name="cuit" class="form-control form-control-user" id="borrarCuit" disabled>
                  <?php
                  $select = mysqli_query($con, "SELECT * FROM clubs WHERE clubs.cuit = $valorCuit");
                  while ($clubs = mysqli_fetch_row($select)) { ?>
                    <option value="<?php echo $clubs[1] ?>"><?php echo $clubs[2] ?></option>
                  <?php  }
                  ?>
                </select>
              </div>
            <?php endif; ?>
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

    <!-- <script src="https://code.jquery.com/jquery-3.6.1.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
    <!-- libreria para mover columnas -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.1.0/js/dataTables.searchPanes.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.6.1/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.3.0/js/dataTables.rowGroup.min.js"></script>
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
      // var fila;
      var userPass = $("#userPass").val();
      var tipoAcceso = $("#tipoAcceso").val();

      $(document).ready(function() {
        opcion = 0;
        fetch(`http://localhost/newproyect_lepa/api/buenafe.php?opcion=${opcion}`, {
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
              // columnas a ordenar 
              // order: [
              //   [7, 'asc']
              // ],
              // columnas de agrupamiento
              // rowGroup: {
              //   dataSrc: [7, 6]
              // },
              // paneles de busqueda filtros
              searchPanes: {
                viewTotal: true,
                layout: 'columns-4',
                initCollapsed: true
              },
              // definicion de columnas en el filtro
              columnDefs: [{
                searchPanes: {
                  show: true
                },
                targets: [1, 4, 5, 6, 7, 8, 9, 11]
              }],
              // drag and drop columnas de la tabla
              colReorder: true,
              // Tabla con scroll
              scrollY: 330,
              // Paginación de la taba
              paging: false,
              // Botenes de la tabla
              buttons: ["excelHtml5", "pdfHtml5", "print"],
              // Filtro Si agregamos una P en el don aparece el buscar
              dom: '"PBfrtilp"',
              createdRow: function(row, data, index) {
                //pintar una celda en rojo
                // console.log(data);
                if (data[3] == "**EMPADRONAR**") {
                  //pinta en rojo una fila
                  $("td", row).css({
                    "background-color": "#ff5252",
                    color: "white",
                    "border-style": "solid",
                    "border-color": "#bdbdbd",
                  });
                };
                if (data[9] == 0) {
                  //Pinta en rojo una celda
                  $('td', row).eq(9).css({
                    'background-color': '#ff5252',
                    'color': 'white',
                  });
                }
              },
            });
          });
      });

      // Accede y vuelca los datos del array en la tabla
      function consultarDatosATabla(dato) {
        $("#tablaClientes tbody").append(
          `<tr>
                    <td class="text-center">${dato.dnibuenafe}</td>
                    <td class="text-center">${dato.sexopatinador}</td>
                    <td>${dato.apellidopatinador}</td>
                    <td>${dato.nombrepatinador}</td>
                    <td class="text-center">${dato.fechanacimiento}</td>
                    <td class="text-center">${dato.edad}</td>
                    <td>${dato.categoria}</td>
                    <td>${dato.disciplina}</td>
                    <td>${dato.tipolicencia}</td>
                    <td class="text-end">${dato.apagar}</td>
                    <td>${dato.torneo}</td>
                    <td>${dato.institucion}</td>
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
          $(".form-control").prop('disabled', true);
          $(".form-select").prop('disabled', true);
          $(".form-control-edit").prop('disabled', false);
          $(".labelDatosAdicionales").hide();
          $('#botonAceptar').show();
        });

        fetch(
            `http://localhost/newproyect_lepa/api/buenafe.php?id=${id}&opcion=${opcion}`, {
              method: 'GET',
              headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
              },
            },
          )
          .then((respuesta) => respuesta.json())
          .then((datos) => {
            // console.log(datos);
            $("#consultarID").val(datos[0].id);
            $("#consultarDni").val(datos[0].dnibuenafe);
            $("#consultarSexo").val(datos[0].sexopatinador);
            $("#consultarLastName").val(datos[0].apellidopatinador);
            $("#consultarFirstName").val(datos[0].nombrepatinador);
            $("#consultarFechaNacimiento").val(datos[0].fechanacimiento);
            $("#consultarEdad").val(datos[0].edad);
            $("#consultarCuit").val(datos[0].cuit);
            $("#consultarLicencia").val(datos[0].tipolicencia);
            $("#consultarCategoria").val(datos[0].categoria);
            $("#consultarDisciplina").val(datos[0].disciplina);
            $("#consultarApagar").val(datos[0].apagar);
            $("#consultarTorneo").val(datos[0].torneo);
            $("#observaciones").val(datos[0].observaciones);


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
        console.log(datos.get('id'));

        fetch(
            'http://localhost/newproyect_lepa/api/buenafe.php', {
              method: 'POST',
              body: datos,
              headers: {
                Accept: "application/json",
              },
            },
          )
          .then((respuesta) => respuesta.json())
          .then((datos) => {
            console.log(datos);
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
        $(".inactivo").prop('disabled', true);
        $('#botonAceptar').show();
        $('#formAlta').modal('show');

        var dni = $("#altaDni").val();
        opcion = 6;

        if (dni != '') {
          fetch(
              `http://localhost/newproyect_lepa/api/buenafe.php?dni=${dni}&opcion=${opcion}`, {
                method: "GET",
                headers: {
                  Accept: "application/json",
                  "Content-Type": "application/json",
                },
              }
            )
            .then((respuesta) => respuesta.json())
            .then((datos) => {
              // console.log(datos);
              // console.log(datos[0].nombrepatinador);
              $("#altaFirstName").val(datos[0].nombrepatinador);
              $("#altaLastName").val(datos[0].apellidopatinador);
              $("#altaSexo").val(datos[0].sexopatinador);
              $("#altaLicencia").val(datos[0].tipolicencia);
              $("#altaFechaNacimiento").val(datos[0].fechanacimiento);
              $("#altaCuit").val(datos[0].cuit);
              $("#altaLicencia").val(datos[0].tipolicencia);
              $("#altaEdad").val(datos[0].edad);
            });
        };
      }

      var formularioAlta = document.getElementById('formAlta');
      document.getElementById('formAlta').addEventListener('submit', function(e) {
        e.preventDefault();
        // console.log('ALTA');
        var datos = new FormData(formularioAlta);
        // envia los datos a crear en la base de datos
        fetch(
            'http://localhost/newproyect_lepa/api/buenafe.php', {
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
            `http://localhost/newproyect_lepa/api/buenafe.php?id=${id}&opcion=${opcion}`, {
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
                fetch(`http://localhost/newproyect_lepa/api/buenafe.php?id=${id}&opcion=${opcion}`, {
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
          text: "Esta por eliminar los patinadoras/es de la lista de Buena Fe!!!",
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

      // Eliminacion por el Administrador
      async function eliminar() {
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
              `http://localhost/newproyect_lepa/api/buenafe.php?opcion=${opcion}&cuit=${cuit}`, {
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

      // PONER LAS VARIABLES DEL TORNEO
      function pasarTorneo() {
        //Verifica que se selecciono un archivo y un club
        var cuit = $("#modificarCuit").val();
        var torneo = $("#modificarTorneo").val();
        var archivo = document.getElementById('txt_archivo').value;
        if (archivo.length == 0) {
          return Swal.fire("Advertencia", "Seleccione un Archivo", "warning");
        } else if (torneo == '') {
          return Swal.fire("Advertencia", "Seleccione un Torneo", "warning");
        } else {
          $("#contenedor").load("variables_selects.php", {
            valorTorneo: torneo
          });
          // $('#modalLoading').modal('show');
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
            'http://localhost/newproyect_lepa/api/carga_excel_buenafe.php', {
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

      // === Pantalla MODAL del LOGOUT ===
      function logoutModal() {
        $('#logoutModal').modal('show');
      }
      // === FIN Pantalla MODAL del LOGOUT ===

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