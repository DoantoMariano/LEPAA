<header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
        <a href="index.php" class="b-brand">
            <!-- ========   change your logo hear   ============ -->
            <h1 class="logo">LEPAA</h1>
            <!-- <img src="assets/images/logo.png" alt="" class="logo" /> -->
            <img src="assets/images/logo-icon.png" alt="" class="logo-thumb" />
        </a>
        <a href="#!" class="mob-toggler">
            <i class="feather icon-more-vertical"></i>
        </a>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li>
                <div class="dropdown drp-user">
                    <span><?php echo $user['dni'] . " / " . $user['nombre'] . " " . $user['apellido'] . " / " . $user['institucion'] . " / " . $user['acceso']; ?></span>
                </div>
            </li>
        </ul>
    </div>
</header>