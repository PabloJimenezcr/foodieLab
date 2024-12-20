<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

if (isset($_POST['add_to_wishlist'])) {

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $p_name = $_POST['p_name'];
    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
    $p_price = $_POST['p_price'];
    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
    $p_image = $_POST['p_image'];
    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);


    $check_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND pid = ?");
    $check_wishlist->execute([$user_id, $pid]);
    if ($check_wishlist->rowCount() > 0) {
        echo '<script>Swal.fire({
            icon: "info",
            text: "El producto ya está en favoritos",
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
        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
        $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
        echo '<script>Swal.fire({
            icon: "success",
            text: "Añadido a favoritos",
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
    $product_qty_key = 'p_qty_' . $product_id;
    if (isset($_POST[$product_qty_key])) {
        $p_qty = $_POST[$product_qty_key];
        $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE pid = ? AND user_id = ?");
        $check_cart_numbers->execute([$pid, $user_id]);

        if ($check_cart_numbers->rowCount() > 0) {
            echo '<script>
            Swal.fire({
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
            echo '<script>
            Swal.fire({
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
        echo '<script>
        Swal.fire({
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
    <title>Foodie Lab</title>
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

    <section class="container heroHome ptMore">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-5 col-md-8">
                <h1>Llegó el momento de comenzar
                    a ordenar tus platillos favoritos</h1>
                <a href="#menu">Ordenar <i class="ri-arrow-right-s-line"></i></a>
            </div>

            <div class="col-lg-4 col-md-4">
                <div class="rectangle">
                    <img src="img/chefBody2.png" alt="Foto de chef" class="img-fluid image">
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid menuHome">
        <div class="text-center">
            <h2>Menú</h2>
            <img src="img/line.png" alt="Raya decorativa titulos" class="img-fluid">
        </div>




        <div class="row justify-content-center pt-4" id="menu">
            <div class="col-lg-4 col-md-10">
                <form action="" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" name="search_box" class="form-control" placeholder="Buscar un platillo" aria-label="Buscar platillo" aria-describedby="button-addon2">
                        <div class="iconBox">
                            <button type="submit" name="search_btn">
                                <i class="ri-search-line iconSearch"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="container">
            <div class="row pt-5 justify-content-center">
                <?php
                $search_box = isset($_POST['search_box']) ? $_POST['search_box'] : '';

                $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%$search_box%' OR category LIKE '%$search_box%'");
                $select_products->execute();

                if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                        $product_name = $fetch_products['name'];
                        $product_details = $fetch_products['details'];
                        $product_price = $fetch_products['price'];
                        $product_image = 'uploadedImg/' . $fetch_products['image'];
                ?>
                        <div class="col-lg-4 mb-5 col-md-6">
                            <div class="card">
                                <div class="boxHeartCard">
                                    <form action="" method="POST">
                                        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                        <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                                        <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                                        <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
                                        <button type="submit" name="add_to_wishlist" class="wishlist-button" value="<?= $fetch_products['id']; ?>">
                                            <i class="ri-heart-line"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="text-center">
                                    <img src="uploadedImg/<?= $fetch_products['image']; ?>" class="card-img-top img-fluid" alt="Foto platillo">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $fetch_products['name']; ?></h5>
                                    <p class="card-text"><?= $fetch_products['details']; ?></p>


                                    <form action="" method="POST">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="price pt-lg-2">
                                                <p><?= $fetch_products['price']; ?></p>
                                            </div>


                                            <div class="inputStepper">

                                                <button type="button" class="less"> - </button>
                                                <input class="myInputStepper" type="number" min="1" max="100" step="1" value="1" name="p_qty_<?= $fetch_products['id']; ?>">
                                                <button type="button" class="more"> + </button>
                                                <div class="pt-3">
                                                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                                    <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                                                    <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                                                    <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <button type="submit" class="addCart" name="add_to_cart">Ordenar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '
                <script>Swal.fire({
                    icon: "info",
                    text: "No se encontraron productos relacioanados",
                    confirmButtonText: "Continuar",
                    showClass: {
                        popup: "animate__animated animate__zoomIn"
                    },
                    hideClass: {
                        popup: "animate__animated animate__zoomOut"
                    }
                });
                </script>';


                    $select_all_products = $conn->prepare("SELECT * FROM `products`");
                    $select_all_products->execute();

                    if ($select_all_products->rowCount() > 0) {
                        while ($fetch_products = $select_all_products->fetch(PDO::FETCH_ASSOC)) {
                            $product_name = $fetch_products['name'];
                            $product_details = $fetch_products['details'];
                            $product_price = $fetch_products['price'];
                            $product_image = 'uploadedImg/' . $fetch_products['image'];

                        ?>
                            <div class="col-lg-4 mb-5 col-md-6">
                                <div class="card">
                                    <div class="boxHeartCard">
                                        <form action="" method="POST">
                                            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                            <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                                            <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                                            <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
                                            <button type="submit" name="add_to_wishlist" class="wishlist-button" value="<?= $fetch_products['id']; ?>">
                                                <i class="ri-heart-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="text-center">
                                        <img src="uploadedImg/<?= $fetch_products['image']; ?>" class="card-img-top img-fluid" alt="Foto platillo">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $fetch_products['name']; ?></h5>
                                        <p class="card-text"><?= $fetch_products['details']; ?></p>


                                        <form action="" method="POST">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <div class="price pt-lg-2">
                                                    <p><?= $fetch_products['price']; ?></p>
                                                </div>


                                                <div class="inputStepper">

                                                    <button type="button" class="less"> - </button>
                                                    <input class="myInputStepper" type="number" min="1" max="100" step="1" value="1" name="p_qty_<?= $fetch_products['id']; ?>">
                                                    <button type="button" class="more"> + </button>
                                                    <div class="pt-3">
                                                        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                                        <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                                                        <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                                                        <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <button type="submit" class="addCart" name="add_to_cart">Ordenar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                <?php
                        }
                    } else {
                        echo '<div class="col-12 text-center">
                <p class="text-center">No hay productos por mostrar</p>
                </div>';
                    }
                }
                ?>
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
                <div class="col-lg-4 col-md-4">
                    <h4>Horario</h4>

                    <div class="d-flex">
                        <i class="ri-timer-2-line watch"></i>
                        <p class="ms-2">L-D 8 am a 11 pm</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
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

                <div class="col-lg-4 col-md-4">
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
</body>

</html>