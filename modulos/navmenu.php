<style>
    .fa-lock-alt {
        margin-right: 3%;
    }
</style>
<nav class="pcoded-navbar pcoded-navbar-home">
    <div class="navbar-wrapper">
        <div class="navbar-content scroll-div">
            <div class="">
                <div class="main-menu-header">
                    <i class="feather icon-user"></i>
                    <!-- <img class="img-radius" src="assets/images/user/avatar-2.jpg" alt="User-Profile-Image" /> -->
                    <div class="user-details">
                        <span><?php echo  $user['nombre'] . " " . $user['apellido']; ?></span>
                        <div id="more-details">
                            <i class="fa fa-chevron-down m-l-5"></i>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="nav-user-link">
                    <ul class="list-unstyled">
                        <li class="list-group-item">
                            <a href="#!" onclick="verModal()"><i class="fal fa-lock-alt"></i> Password</a>
                        </li>
                        <li class="list-group-item">
                            <a href="#" data-toggle="modal" data-target="#logoutModal" onclick="logoutModal()">
                                <i class="feather icon-log-out m-r-5"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="nav pcoded-inner-navbar">

                <!-- MENU LEPAA -->
                <li class="nav-item pcoded-menu-caption">
                    <label>MENU</label>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-micon"><i class="feather icon-box"></i></span>
                        <span class="pcoded-mtext">LEPAA</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <!-- Gestion -->
                        <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link">
                                <span class="pcoded-micon"><i class="fab fa-uncharted"></i></span>
                                <span class="pcoded-mtext">GESTION</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li><a href="usuarios.php">Usuarios</a></li>
                                <li><a href="institucion.php">Clubs</a></li>
                                <li><a href="padron.php">Gestion Padron</a></li>
                                <li><a href="buenafe.php">Libro Buena Fe</a></li>
                            </ul>
                        </li>
                        <!-- Padron -->
                        <!-- <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link">
                                <span class="pcoded-micon"><i class="fab fa-uncharted"></i></span>
                                <span class="pcoded-mtext">PADRON</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li><a href="padron.php">Gestion Padron</a></li>
                                <li><a href="#">Reporte Padron</a></li>
                            </ul>
                        </li> -->
                        <!-- Tablas -->
                        <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link">
                                <span class="pcoded-micon"><i class="fab fa-uncharted"></i></span>
                                <span class="pcoded-mtext">TABLAS</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li><a href="tabla_licencias.php">Licencia</a></li>
                                <li><a href="tabla_disciplina.php">Disciplinas</a></li>
                                <li><a href="tabla_categoria.php">Categorias</a></li>
                                <li><a href="tabla_torneos.php">Torneos</a></li>
                            </ul>
                        </li>
                        <!-- Registros -->
                        <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link">
                                <span class="pcoded-micon"><i class="fab fa-uncharted"></i></span>
                                <span class="pcoded-mtext">REGISTROS</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li><a href="registros_eliminados.php">Eliminados</a></li>
                                <li><a href="registros_modificados.php">Modificados</a></li>
                                <li><a href="registros_ingresos.php">Ingresos</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- MENU BUENA FE -->
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-micon"><i class="feather icon-box"></i></span>
                        <span class="pcoded-mtext">TORNEOS</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li><a href="buenafe.php">Buena Fe</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambiar Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrarModal()"></button>
            </div>
            <form id="cambiarPass">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input name="newPassword" type="password" class="form-control" id="newPassword" placeholder="Nueva Password">
                        <label for="floatingPassword">Nueva Password</label>
                    </div>
                    <div class="form-floating">
                        <input name="confirmPassword" type="password" class="form-control" id="confirmPassword" placeholder="Confirmar Password">
                        <label for="floatingPassword">Confirmar Password</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="cerrarModal()">Cerrar</button>
                    <!-- <button type="button" class="btn btn-primary" onclick="cambiarPass()">Save changes</button> -->
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function verModal() {
        $('#passwordModal').modal('show');
    }
    // === CAMBIO DE PASSWORD ===
    document.getElementById('cambiarPass').addEventListener('submit', function(e) {
        e.preventDefault();
        // var datos = new FormData(formulario);
        var newPassword = $("#newPassword").val();
        var confirmPassword = $("#confirmPassword").val();
        if (newPassword === confirmPassword) {
            fetch(
                    `http://localhost/newproyect_lepa/api/cambiar_password.php?newPassword=${newPassword}`, {
                        method: 'GET',
                        headers: {
                            Accept: "application/json",
                            "Content-Type": "application/json",
                        },
                    },
                )
                .then((respuesta) => respuesta.json())
                .then((datos) => {
                    $('#passwordModal').modal('hide');
                    if (datos == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Ok!',
                            text: 'Nueva password registrada con exito!',
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
        } else {
            $('#passwordModal').modal('hide');
            Swal.fire({
                icon: 'error',
                title: 'Ups..!',
                text: 'Las contraseñas no coinciden!',
            })
        };
    });

    // ==========
    function cerrarModal() {
        $('#passwordModal').modal('hide');
    }
</script>