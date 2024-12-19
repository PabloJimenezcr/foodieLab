<header id="header" class="header fixed-top d-flex align-items-center header-transparent">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <div class="logo">
            <a href="homeAdmin.php">
                <img src="img/logo.png" alt="Logo foodie lab" class="img-fluid">
            </a>
        </div>

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul class="ulMenu">
                <li><a class="nav-link scrollto" href="homeAdmin.php">Inicio</a></li>
                <li><a class="nav-link scrollto" href="ordersAdmin.php">Ordenes</a></li>
                <li><a class="nav-link scrollto" href="productsAdmin.php">Productos</a></li>
                <li><a class="nav-link scrollto" href="usersAdmin.php">Usuarios</a></li>
                <li><a class="nav-link scrollto" href="messagesAdmin.php">Mensajes</a></li>
            </ul>
        </nav>

        <div class="navbar d-flex">
            <li class="nav-item dropdown">
                <?php
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_profile->execute([$admin_id]);
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="uploadedImg/<?= $fetch_profile['image']; ?>" class="img-fluid" alt="Foto perfil">
                </a>
                <ul class="dropdown-menu">
                    <img src="uploadedImg/<?= $fetch_profile['image']; ?>" class="img-fluid mb-3" alt="Foto perfil">
                    <h3><?= $fetch_profile['name']; ?></h3>
                    <div class="d-flex justify-content-center align-items-center pb-3">
                        <a href="perfilAdmin.php" class="btnDropdown">Perfil</a>
                        <a href="login.php" class="btnDropdown">Cerrar sesión</a>
                    </div>
                </ul>
            </li>
        </div>
        <i class="ri-menu-3-fill iconHamburguer" data-bs-toggle="offcanvas" data-bs-target="#menuResponsive" aria-controls="menuResponsive"></i>
    </div>
</header>

<div class="offcanvas offcanvas-start offcanvasResponsive" data-bs-scroll="true" tabindex="-1" id="menuResponsive" aria-labelledby="menu">
    <div class="offcanvas-header">
        <button type="button" data-bs-dismiss="offcanvas" aria-label="Cerrar">
            <i class="ri-close-line"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <div class="text-center mb-5">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="uploadedImg/<?= $fetch_profile['image']; ?>" class="img-fluid mb-3 imgPerfil" alt="Foto perfil">
            <h3><?= $fetch_profile['name']; ?></h3>
        </div>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto" href="homeAdmin.php">Inicio</a></li>
                <li><a class="nav-link scrollto" href="perfilAdmin.php">Perfil</a></li>
                <li><a class="nav-link scrollto" href="ordersAdmin.php">Ordenes</a></li>
                <li><a class="nav-link scrollto" href="productsAdmin.php">Productos</a></li>
                <li><a class="nav-link scrollto" href="usersAdmin.php">Usuarios</a></li>
                <li><a class="nav-link scrollto" href="messagesAdmin.php">Mensajes</a></li>
                <li><a class="nav-link scrollto contact" href="login.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </div>
</div>