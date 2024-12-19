<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};



if (isset($_POST['add_to_cart'])) {
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $p_name = $_POST['p_name'];
    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
    $p_price = $_POST['p_price'];
    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
    $p_image = $_POST['p_image'];
    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);


    $product_id = $_POST['pid'];
    $product_qty_key = 'p_qty_' . $pid;
    if (isset($_POST[$product_qty_key])) {
        $p_qty = $_POST[$product_qty_key];
        $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);


        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE pid = ? AND user_id = ?");
        $check_cart_numbers->execute([$pid, $user_id]);

        if ($check_cart_numbers->rowCount() > 0) {
            echo '<script>Swal.fire({
                icon: "info",
                text: "El producto ya está en el carrito",
                confirmButtonText: "Continuar",
                showClass: {
                    popup: "animate__animated animate__zoomIn"
                },
                hideClass: {
                    popup: "animate__animated animate__zoomOut"
                }
            });
            </script>';
        } else {
            $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
            $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
            echo '<script>Swal.fire({
                icon: "success",
                text: "Producto agregado al carrito",
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
    } else {
        echo '<script>Swal.fire({
            icon: "success",
            text: "La cantidad del producto no está definida",
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
}


if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_type = $_GET['type'];

    if ($delete_type === 'wishlist') {
        $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
        $delete_wishlist_item->execute([$delete_id]);
        header('location:favoritos.php');
        exit();
    }
}

if (isset($_GET['delete_all']) && $_GET['delete_all'] === 'wishlist') {
    $delete_wishlist_all = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    $delete_wishlist_all->execute([$user_id]);
    header('location:favoritos.php');
    exit();
}



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/foodlab/css/index.css">
    <title>Foodie Lab | Favoritos</title>
</head>

<body>

    <section id="topbar" class="container-fluid fixed-top topbar-transparent d-flex justify-content-between align-items-center topBar">
        <div>
            <i class="ri-map-pin-line ">
                <span> San José, Santa Ana, Costa Rica</span>
            </i>


            <i class="ri-timer-2-line ms-4">
                <span>Abierto todos los días de 8 am a 11 pm</span>
            </i>
        </div>
        <div>
            <i class="ri-phone-line tel">
                <a href="tel:+50622547545">
                    <span>+506 2254-7545</span>
                </a>
            </i>


            <i class="ri-mail-line ms-4 email">
                <a href="mailto:foodielab@hotmail.com">
                    <span class="span">foodielab@hotmail.com</span>
                </a>
            </i>
        </div>
    </section>

    <?php include 'header.php'; ?>


    <section class="container favorite ptMore">
        <div class="text-center">
            <h2>Platillos favoritos</h2>
            <img src="img/line.png" alt="Raya decorativa" class="img-fluid">
        </div>
        <div class="row pt-5 justify-content-center">
            <?php
            $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $select_wishlist->execute([$user_id]);
            if ($select_wishlist->rowCount() > 0) {
                while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="col-lg-4 mb-5">
                        <div class="card">
                            <div class="boxHeartCard">
                                <a href="?delete=<?= $fetch_wishlist['id']; ?>&type=wishlist" onclick="confirmDeleteFavorite(<?= $fetch_wishlist['id']; ?>); return false;">
                                    <i class="ri-close-line"></i>
                                </a>
                            </div>
                            <div class="text-center">
                                <img src="uploadedImg/<?= $fetch_wishlist['image']; ?>" class="card-img-top img-fluid" alt="Foto platillo">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= $fetch_wishlist['name']; ?></h5>

                                <form method="POST">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="price pt-lg-2">
                                            <p>₡<?= $fetch_wishlist['price']; ?></p>
                                        </div>

                                        <div class="inputStepper">

                                            <button type="button" class="less"> - </button>
                                            <input class="myInputStepper" type="number" min="1" max="100" step="1" value="1" name="p_qty_<?= $fetch_wishlist['id']; ?>">
                                            <button type="button" class="more"> + </button>
                                            <input type="hidden" name="pid" value="<?= $fetch_wishlist['id']; ?>">
                                            <input type="hidden" name="p_name" value="<?= $fetch_wishlist['name']; ?>">
                                            <input type="hidden" name="p_price" value="<?= $fetch_wishlist['price']; ?>">
                                            <input type="hidden" name="p_image" value="<?= $fetch_wishlist['image']; ?>">

                                        </div>
                                    </div>

                                    <div class="pb-3">
                                        <button type="submit" name="add_to_cart">Ordenar</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

            <?php
                }
            } else {
                echo '<p class="text-center">No hay platillos</p>';
            }
            ?>

            <div class="button">
                <a href="?delete_all=wishlist" onclick="confirmDeleteAllFavorites(); return false;">Eliminar todos</a>
            </div>

        </div>

    </section>



    <footer class="container-fluid footerLanding m-0">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12">
                    <img src="img/logo.png" alt="Logo foodie lab" class="img- logo">
                </div>
            </div>

            <div class="line my-5"></div>

            <div class="row">
                <div class="col-lg-4">
                    <h4>Horario</h4>

                    <div class="d-flex">
                        <i class="ri-timer-2-line watch"></i>
                        <p class="ms-2">L-D 8 am a 11 pm</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <h4>Redes</h4>
                    <div class="d-flex align-items-center">
                        <div class="box">
                            <i class="ri-facebook-fill"></i>
                        </div>
                        <a href="https://www.facebook.com/" target="blank">
                            <p class="ms-2 mt-3">Facebook</p>
                        </a>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="box">
                            <i class="ri-instagram-line"></i>
                        </div>
                        <a href="https://www.instagram.com/" target="blank">
                            <p class="ms-2 mt-3">Instagram</p>
                        </a>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="box">
                            <i class="ri-twitter-line"></i>
                        </div>
                        <a href="https://twitter.com/" target="blank">
                            <p class="ms-2 mt-3">Twitter</p>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <h4>Ubicación</h4>
                    <div class="d-flex align-items-center">
                        <div class="box waze">
                            <img src="img/waze.png" alt="Icono de waze" class="img-fluid">
                        </div>
                        <a href="https://www.facebook.com/" target="blank">
                            <p class="ms-2 mt-3">Waze</p>
                        </a>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="box">
                            <i class="ri-google-fill"></i>
                        </div>
                        <a href="https://www.google.com/maps/?hl=es" target="blank">
                            <p class="ms-2 mt-3">Google Maps</p>
                        </a>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="box">
                            <i class="ri-map-pin-range-line"></i>
                        </div>
                        <a href="https://twitter.com/" target="blank">
                            <p class="ms-2 mt-3">Map Maker</p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="line my-5"></div>

            <div class="row">
                <div class="d-flex justify-content-center">
                    <a href="https://play.google.com/store/games?hl=es_CR&gl=US" target="blank">
                        <img src="img/googlePlay.png" alt="Icono de descarga google play" class="img-fluid store">
                    </a>



                    <a href="https://www.apple.com/la/app-store/" target="blank">
                        <img src="img/appStore.png" alt="Icono de descarga app store" class="img-fluid store">
                    </a>

                </div>
            </div>
        </div>
    </footer>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="js/scrollTo.js"></script>
    <script src="js/inputMoreLess.js"></script>

    <script>
        function confirmDeleteFavorite(itemId) {
            Swal.fire({
                icon: "info",
                text: "¿Desea eliminar este platillo de favoritos?",
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
                    window.location.href = `?delete=${itemId}&type=wishlist`;
                }
            });
        }

        function confirmDeleteAllFavorites() {
            Swal.fire({
                icon: "info",
                text: "¿Desea eliminar todos los platillos de favoritos?",
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí, eliminar todos',
                showClass: {
                    popup: "animate__animated animate__zoomIn"
                },
                hideClass: {
                    popup: "animate__animated animate__zoomOut"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "?delete_all=wishlist";
                }
            });
        }
    </script>



</body>

</html>