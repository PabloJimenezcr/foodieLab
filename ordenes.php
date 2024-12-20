<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
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
    <link rel="stylesheet" href="css/index.css">
    <title>Foodie Lab | Ordenes</title>
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


    <section class="container orders ptMore">
        <div class="text-center">
            <h2>Tus ordenes</h2>
            <img src="img/line.png" alt="Raya decorativa" class="img-fluid">
        </div>

        <div class="accordion accordion-flush" id="accordionOrders">

            <div class="row pt-5 justify-content-center">
                <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
                $select_orders->execute([$user_id]);
                if ($select_orders->rowCount() > 0) {
                    $accordionIndex = 1;
                    while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                        $platillos = explode(', ', $fetch_orders['total_products']);
                        $detallesOrden = explode(', ', $fetch_orders['detailsOrden']);
                ?>
                        <div class="col-lg-4">
                            <div class="accordion-item mb-4">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion<?= $accordionIndex ?>" aria-expanded="false" aria-controls="accordion<?= $accordionIndex ?>">
                                        <?= $fetch_orders['placed_on']; ?>
                                    </button>
                                </h3>

                                <div id="accordion<?= $accordionIndex ?>" class="accordion-collapse collapse" data-bs-parent="#accordionOrders">
                                    <div class="accordion-body">
                                        <p class="fw-medium">Platillos:</p>
                                        <ul>
                                            <?php foreach ($platillos as $platillo) : ?>
                                                <?php
                                                $parts = explode('(', $platillo);
                                                $nombrePlatillo = trim($parts[0]);
                                                $cantidadPlatillo = trim(str_replace(')', '', $parts[1]));
                                                ?>

                                                <li><?= $nombrePlatillo; ?><span> (<?= $cantidadPlatillo; ?>)</span></li>
                                            <?php endforeach; ?>


                                        </ul>
                                        <div class="d-flex">
                                            <p class="fw-medium">Número de la mesa: </p>
                                            <p class="mx-2"><?= $fetch_orders['numberTable']; ?></p>
                                        </div>
                                        <p class="fw-medium">Detalles de la orden:</p>

                                        <ul>
                                            <?php foreach ($detallesOrden as $detalle) : ?>
                                                <li><?= $detalle; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <div class="d-flex">
                                            <p class="fw-medium">Total: </p>
                                            <p class="mx-2">₡<?= $fetch_orders['total_price']; ?></p>
                                        </div>
                                        <div class="d-flex">
                                            <p class="fw-medium">Estado del pedido: </p>
                                            <span class="mx-2" style="color:<?php
                                                                            if ($fetch_orders['orderStatus'] == 'Pendiente') {
                                                                                echo '#e11a1a';
                                                                            } elseif ($fetch_orders['orderStatus'] == 'Preparando') {
                                                                                echo '#e8aa42';
                                                                            } else {
                                                                                echo '#fc7800';
                                                                            }
                                                                            ?>"><?= $fetch_orders['orderStatus']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                        $accordionIndex++;
                    }
                } else {
                    echo '<p class="text-center">No hay ordenes</p>';
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