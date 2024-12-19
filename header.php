<?php


if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart_item->execute([$delete_id]);
}

if (isset($_GET['delete_all'])) {
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart_item->execute([$user_id]);
}

if (isset($_POST['update_qty'])) {
    $cart_ids = $_POST['cart_id'];
    $p_quantities = $_POST['p_qty'];


    for ($i = 0; $i < count($cart_ids); $i++) {
        $cart_id = $cart_ids[$i];
        $p_qty = filter_var($p_quantities[$i], FILTER_SANITIZE_STRING);
        $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
        $update_qty->execute([$p_qty, $cart_id]);
    }

    $update_total = $conn->prepare("UPDATE `cart` SET total = price * quantity WHERE user_id = ?");
    $update_total->execute([$user_id]);


    echo '
    <script>
    Swal.fire({
        icon: "success",
        text: "Producto actualizado",
        confirmButtonText: "Continuar",
        showClass: {
            popup: "animate__animated animate__zoomIn"
        },
        hideClass: {
            popup: "animate__animated animate__zoomOut"
        }
    });
    </script>';
}

$select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
$select_cart->execute([$user_id]);
$grand_total = 0;

?>

<header id="header" class="header fixed-top d-flex align-items-center header-transparent">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <div class="logo">
            <a href="home.php">
                <img src="img/logo.png" alt="Logo foodie lab" class="img-fluid">
            </a>
        </div>

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul class="ulMenu">
                <li><a class="nav-link scrollto" href="home.php">Inicio</a></li>
                <li><a class="nav-link scrollto" href="home.php#menu">Menú</a></li>
                <li><a class="nav-link scrollto" href="ordenes.php">Ordenes</a></li>
                <li><a class="nav-link scrollto" href="contacto.php">Contacto</a></li>
                <li> <a href="favoritos.php" class="scrollto"><i class="ri-heart-line iconRight"></i> Favoritos</a>
                </li>
                <?php
                $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $count_cart_items->execute([$user_id]);
                $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                $count_wishlist_items->execute([$user_id]);
                ?>
                <div class="counterCar"><?= $count_wishlist_items->rowCount(); ?></div>
                <li><a class="scrollto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="sidebar mi carrito">
                        <i class="ri-shopping-cart-line iconRight"></i> Carrito
                    </a>
                </li>
                <div class="counterCar"><?= $count_cart_items->rowCount(); ?></div>
            </ul>
        </nav>

        <div class="navbar d-flex">
            <li class="nav-item dropdown">
                <?php
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_profile->execute([$user_id]);
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="uploadedImg/<?= $fetch_profile['image']; ?>" class="img-fluid" alt="Foto perfil">
                </a>
                <ul class="dropdown-menu">
                    <img src="uploadedImg/<?= $fetch_profile['image']; ?>" class="img-fluid mb-3" alt="Foto perfil">
                    <h3><?= $fetch_profile['name']; ?></h3>
                    <div class="d-flex justify-content-center align-items-center pb-3">
                        <a href="perfil.php" class="btnDropdown">Perfil</a>
                        <a href="login.php" class="btnDropdown">Cerrar sesión</a>
                    </div>
                </ul>
            </li>
        </div>
        <i class="ri-menu-3-fill iconHamburguer" data-bs-toggle="offcanvas" data-bs-target="#menuResponsive" aria-controls="menuResponsive"></i>
    </div>
</header>


<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Mi carrito</h5>
        <button type="button" data-bs-dismiss="offcanvas" aria-label="Cerrar">
            <i class="ri-close-line"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <?php
        $grand_total = 0;
        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $select_cart->execute([$user_id]);
        if ($select_cart->rowCount() > 0) {
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {

                $grand_total += $fetch_cart['price'] * $fetch_cart['quantity'];

        ?>
                <div class="row">
                    <div class="col-lg-4 pb-4">
                        <form action="" method="POST">
                            <div class="box">
                                <img src="uploadedImg/<?= $fetch_cart['image']; ?>" alt="Foto platillo" class="img-fluid">
                            </div>
                        </form>
                    </div>


                    <div class="col-lg-8">
                        <div class="price pt-3">
                            <h3><?= $fetch_cart['name']; ?></h3>
                            <p>₡<?= $fetch_cart['price']; ?></p>
                            <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                        </div>

                        <form action="" method="POST" class="formStore">
                            <input type="hidden" name="cart_id[]" value="<?= $fetch_cart['id']; ?>">

                            <a href="#" class="less">
                                <i class="ri-subtract-line"></i>
                            </a>

                            <input class="myInputStepper" type="number" min="1" max="100" step="1" value="<?= $fetch_cart['quantity']; ?>" name="p_qty[]">



                            <a href="#" class="more">
                                <i class="ri-add-line"></i>
                            </a>


                            <a class="delete" href="#" onclick="confirmDelete(<?= $fetch_cart['id']; ?>)">
                                <i class="ri-delete-bin-line"></i>
                            </a>
                            <input type="submit" value="Actualizar" name="update_qty" class="updateBtn">

                        </form>
                    </div>
                </div>

                <hr>

        <?php
            }
        } else {
            echo '<p class="text-center">Carrito vacío</p>';
        }
        ?>

        <div class="d-flex justify-content-between fw-semibold pb-3">
            <p>Total :</p>
            <p>₡<?= $grand_total; ?></p>
        </div>
        </form>

        <div class="line mb-4"></div>



        <div class="d-flex text-center mb-4">
            <a class="<?= ($grand_total > 1) ? '' : 'disabled'; ?>" href="verificarOrden.php">Continuar</a>
        </div>

        <div class="d-flex text-center">
            <a href="home.php?delete_all" class="btnDelete <?= ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="confirmDeleteAllCart(); return false;">Eliminar carrito</a>
        </div>
    </div>
</div>


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
            $select_profile->execute([$user_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="uploadedImg/<?= $fetch_profile['image']; ?>" class="img-fluid mb-3 imgPerfil" alt="Foto perfil">
            <h4><?= $fetch_profile['name']; ?></h4>

        </div>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto" href="home.php">Inicio</a></li>
                <li><a class="nav-link scrollto" href="perfil.php">Perfil</a></li>
                <?php
                $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $count_cart_items->execute([$user_id]);
                $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                $count_wishlist_items->execute([$user_id]);
                ?>
                <li>
                    <a href="favoritos.php" class="nav-link scrollto">
                        Favoritos <div class="counterCar"><?= $count_wishlist_items->rowCount(); ?></div>
                    </a>
                </li>

                <li><a class="nav-link scrollto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="sidebar mi carrito">
                        Carrito <div class="counterCar"><?= $count_cart_items->rowCount(); ?></div>
                    </a>
                </li>

                <li><a class="nav-link scrollto" href="home.php">Menú</a></li>
                <li><a class="nav-link scrollto" href="ordenes.php">Ordenes</a></li>
                <li><a class="nav-link scrollto" href="contacto.php">Contacto</a></li>
                <li><a class="nav-link scrollto contact" href="login.php">Cerrar sesión</a></li>
            </ul>
        </nav>
        <div class="text-center pt-4">
            <h3>Visítanos</h3>
            <p>FoodLab, San José</p>
            <p>Santa Ana, Costa Rica</p>
            <p>Horario: 8am - 11pm</p>

            <a href="tel:+50622547545">
                <span>+506 2254-7545</span>
            </a>
        </div>

        <div class="text-center pt-4">
            <h3>Reservas</h3>
            <a href="mailto:foodielab@hotmail.com">
                <span class="span">foodielab@hotmail.com</span>
            </a>
        </div>
    </div>
</div>

<script>
    function confirmDelete(cartId) {
        const currentURL = window.location.href;
        Swal.fire({
            icon: "info",
            text: "¿Deseea eliminar el producto?",
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí, eliminar',
            showClass: {
                popup: "animate__animated animate__zoomIn"
            },
            hideClass: {
                popup: "animate__animated animate__zoomOut"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `home.php?delete=${cartId}`;
            }
        });
    }

    function confirmDeleteAllCart() {
        Swal.fire({
            icon: "info",
            text: "¿Desea eliminar todos los platillos del carrito?",
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí, eliminar',
            showClass: {
                popup: "animate__animated animate__zoomIn"
            },
            hideClass: {
                popup: "animate__animated animate__zoomOut"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "?delete_all";
            }
        });
    }
</script>