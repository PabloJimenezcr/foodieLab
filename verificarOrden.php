<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

if (isset($_POST['orderCard'])) {

    date_default_timezone_set('America/Mexico_City');

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $numberTable = $_POST['numberTable'];
    $numberTable = filter_var($numberTable, FILTER_SANITIZE_STRING);
    $detailsOrden = $_POST['detailsOrden'];
    $detailsOrden = filter_var($detailsOrden, FILTER_SANITIZE_STRING);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products = array();

    $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $cart_query->execute([$user_id]);
    if ($cart_query->rowCount() > 0) {
        while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
            $cart_products[] = $cart_item['name'] . ' ( ' . $cart_item['quantity'] . ' )';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        };
    }

    $total_products = implode(', ', $cart_products);

    if (empty($name) || empty($number) || empty($email) || empty($method) || empty($numberTable) || empty($detailsOrden)) {
        echo '
        <script>
        Swal.fire({
            icon: "error",
            text: "Por favor, completa todos los campos requeridos",
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
        $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND total_products = ? AND total_price = ?");
        $order_query->execute([$name, $number, $email, $method, $total_products, $cart_total]);

        if ($cart_total == 0) {
            echo '
            <script>
            Swal.fire({
                icon: "info",
                text: "Tu carrito está vacío",
                confirmButtonText: "Continuar",
                showClass: {
                    popup: "animate__animated animate__zoomIn"
                },
                hideClass: {
                    popup: "animate__animated animate__zoomOut"
                }
            });
            </script>';
        } elseif ($order_query->rowCount() > 0) {
            echo '
            <script>
            Swal.fire({
                icon: "success",
                text: "Pedido ya realizado",
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
            $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, numberTable, detailsOrden, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?,?)");
            $insert_order->execute([$user_id, $name, $number, $email, $method, $numberTable, $detailsOrden, $total_products, $cart_total, $placed_on]);
            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);
            header('Location: cooking.php');
        }
    }
}



if (isset($_POST['orderCash'])) {

    date_default_timezone_set('America/Mexico_City');

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $numberTable = $_POST['numberTable'];
    $numberTable = filter_var($numberTable, FILTER_SANITIZE_STRING);
    $detailsOrden = $_POST['detailsOrden'];
    $detailsOrden = filter_var($detailsOrden, FILTER_SANITIZE_STRING);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products = array();

    $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $cart_query->execute([$user_id]);
    if ($cart_query->rowCount() > 0) {
        while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
            $cart_products[] = $cart_item['name'] . ' ( ' . $cart_item['quantity'] . ' )';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        };
    }

    $total_products = implode(', ', $cart_products);

    if (empty($name) || empty($number) || empty($email) || empty($method) || empty($numberTable) || empty($detailsOrden)) {
        echo '<script>
        Swal.fire({
            icon: "error",
            text: "Por favor, complete  todos los campos",
            confirmButtonText: "Continue",
            showClass: {
                popup: "animate__animated animate__zoomIn"
            },
            hideClass: {
                popup: "animate__animated animate__zoomOut"
            }
        });
        </script>';
    } else {
        $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND total_products = ? AND total_price = ?");
        $order_query->execute([$name, $number, $email, $method, $total_products, $cart_total]);

        if ($cart_total == 0) {
            echo '<script>
            Swal.fire({
                icon: "info",
                text: "Tu carrito está vacío",
                confirmButtonText: "Continue",
                showClass: {
                    popup: "animate__animated animate__zoomIn"
                },
                hideClass: {
                    popup: "animate__animated animate__zoomOut"
                }
            });
            </script>';
        } elseif ($order_query->rowCount() > 0) {
            echo '<script>
            Swal.fire({
                icon: "success",
                text: "Pedido ya realizado",
                confirmButtonText: "Continue",
                showClass: {
                    popup: "animate__animated animate__zoomIn"
                },
                hideClass: {
                    popup: "animate__animated animate__zoomOut"
                }
            });
            </script>';
        } else {
            $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, numberTable, detailsOrden, total_products, total_price, placed_on) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $insert_order->execute([$user_id, $name, $number, $email, $method, $numberTable, $detailsOrden, $total_products, $cart_total, $placed_on]);
            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);
            header('Location: cooking.php');
        }
    }
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="img/favicon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/foodlab/css/index.css">
    <title>Foodie Lab | Verificar orden</title>
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



    <section class="container-fluid ptMore checkOrden">
        <div class="text-center">
            <h2>Verificar orden</h2>
            <img src="img/line.png" alt="Raya decorativa" class="img-fluid">
        </div>

        <div class="row pt-5 justify-content-center">
            <div class="col-lg-7 secondColumnMobile">
                <ul class="nav nav-tabs d-flex justify-content-center">
                    <li class="col-lg-6 pb-4">
                        <a class="nav-link d-flex justify-content-between align-items-center active" data-bs-toggle="tab" data-bs-target="#card">
                            <h4>
                                <i class="ri-bank-card-line"></i>
                                Tarjeta
                            </h4>
                            <i class="ri-check-line checkActive d-flex justify-content-center align-items-center"></i>
                        </a>
                    </li>

                    <li class="col-lg-6 pb-4">
                        <a class="nav-link d-flex justify-content-between align-items-center left" data-bs-toggle="tab" data-bs-target="#cash">
                            <h4>
                                <i class="ri-cash-line"></i>
                                Efectivo
                            </h4>
                            <i class="ri-check-line checkActive d-flex justify-content-center align-items-center"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade active show" id="card">
                        <form action="#" method="POST">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-box">
                                        <i class="ri-user-line"></i>
                                        <input type="text" name="name" placeholder="Ingresa tu nombre">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-box">
                                        <i class="ri-phone-line"></i>
                                        <input type="number" name="number" placeholder="Ingresa tu teléfono">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-box">
                                        <i class="ri-mail-line"></i>
                                        <input type="email" name="email" placeholder="Ingresa tu email">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-box">
                                        <i class="ri-restaurant-2-line"></i>
                                        <input type="number" name="numberTable" placeholder="Ingresa tu número de mesa">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-box textarea">
                                        <i class="ri-message-2-line"></i>
                                        <textarea name="detailsOrden" placeholder="Detalles de la orden"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-box">
                                        <i class="ri-user-line"></i>
                                        <input name="titleCard" type="text" placeholder="Titular de la tarjeta">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-box">
                                        <i class="ri-bank-card-2-line"></i>
                                        <input name="numberCard" type="number" placeholder="Número de la tarjeta">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-box">
                                        <i class="ri-calendar-line"></i>
                                        <input name="date" type="text" placeholder="Fecha de vencimiento">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-box">
                                        <i class="ri-bank-card-2-line"></i>
                                        <input name="cvv" type="number" placeholder="CVV">
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="method" value="Tarjeta">

                            <input type="submit" name="orderCard" class="btnOrder <?= ($cart_grand_total > 1) ? '' : 'disabled'; ?>" value="Ordenar">


                        </form>
                    </div>
                </div>



                <div class="tab-content">
                    <div class="tab-pane fade" id="cash">
                        <form action="#" method="POST">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-box">
                                        <i class="ri-user-line"></i>
                                        <input name="name" type="text" placeholder="Ingresa tu nombre">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-box">
                                        <i class="ri-phone-line"></i>
                                        <input type="number" name="number" placeholder="Ingresa tu teléfono">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-box">
                                        <i class="ri-mail-line"></i>
                                        <input name="email" type="email" placeholder="Ingresa tu email">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-box">
                                        <i class="ri-restaurant-2-line"></i>
                                        <input name="numberTable" type="number" placeholder="Ingresa tu número de mesa">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-box textarea">
                                        <i class="ri-message-2-line"></i>
                                        <textarea name="detailsOrden" placeholder="Detalles de la orden"></textarea>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="method" value="Efectivo">


                            <input type="submit" name="orderCash" class="btnOrder <?= ($cart_grand_total > 1) ? '' : 'disabled'; ?>" value="Ordenar">

                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 firtsColumnMobile mb-5">
                <div class="box">
                    <?php
                    $cart_grand_total = 0;
                    $select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                    $select_cart_items->execute([$user_id]);
                    if ($select_cart_items->rowCount() > 0) {
                        while ($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)) {
                            $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
                            $cart_grand_total += $cart_total_price;
                    ?>
                            <div class="row py-4">
                                <div class="col-lg-4 pb-4 paddingMore">
                                    <div class="boxProduct">
                                        <img src="uploadedImg/<?= $fetch_cart_items['image']; ?>" class="img-fluid" alt="Foto platillo">
                                    </div>
                                </div>

                                <div class="col-lg-6 paddingMore">
                                    <h3><?= $fetch_cart_items['name']; ?></h3>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="price pt-lg-2">
                                            <p>₡<?= $fetch_cart_items['price']; ?></p>
                                        </div>

                                        <div class="counProduct">
                                            <?= $fetch_cart_items['quantity']; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                    <?php
                        }
                    } else {
                        echo '<p class="text-center">No hay productos agregados</p>';
                    }
                    ?>

                    <div class="d-flex justify-content-center total">
                        <p>Total:</p>
                        <p>₡<?= $cart_grand_total; ?></p>
                    </div>
                </div>
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

</body>

</html>