<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
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
    <title>Foodie Lab</title>
</head>

<body>

    <?php include 'headerAdmin.php'; ?>

    <section class="container homeAdmin ptMore">
        <div class="text-center">
            <h2>Panel</h2>
            <img src="img/line.png" class="img-fluid" alt="Raya decorativa">
        </div>

        <div class="row py-5 justify-content-center">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <img src="img/orders.jpg" class="card-img-top img-fluid" alt="Foto de ordenes en la cocina">
                    <div class="card-body text-center">
                        <h5 class="card-title">Ordenes</h5>
                        <a href="ordersAdmin.php" class="mb-5">Ingresar</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card">
                    <img src="img/products.jpg" class="card-img-top img-fluid" alt="Foto de productos">
                    <div class="card-body text-center">
                        <h5 class="card-title">Productos</h5>
                        <a href="productsAdmin.php" class="mb-5">Ingresar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <img src="img/clients.jpg" class="card-img-top img-fluid" alt="Foto de clientes">
                    <div class="card-body text-center">
                        <h5 class="card-title">Usuarios</h5>
                        <a href="usersAdmin.php" class="mb-5">Ingresar</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card">
                    <img src="img/products.jpg" class="card-img-top img-fluid" alt="Foto de productos">
                    <div class="card-body text-center">
                        <h5 class="card-title">Mensajes</h5>
                        <a href="messagesAdmin.php" class="mb-5">Ingresar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php include 'footerAdmin.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="js/scrollTo.js"></script>
</body>

</html>