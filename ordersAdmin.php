<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['update_order'])) {

    $order_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
    $update_orders = $conn->prepare("UPDATE `orders` SET orderStatus = ? WHERE id = ?");
    $update_orders->execute([$update_payment, $order_id]);
    echo '<script>Swal.fire({
        icon: "success",
        text: "Estado de la orden actualizada",
        confirmButtonText: "Continuar",
        showClass: {
            popup: "animate__animated animate__zoomIn"
        },
        hideClass: {
            popup: "animate__animated animate__zoomOut"
        }
    });
    </script>';
};

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_orders->execute([$delete_id]);
    header('location:ordersAdmin.php');
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
    <title>Foodie Lab | Ordenes</title>
</head>

<body>

    <?php include 'headerAdmin.php'; ?>


    <section class="container ordersAdmin ptMore">
        <div class="text-center">
            <h2>Ordenes</h2>
            <img src="img/line.png" class="img-fluid" alt="Raya decorativa">
        </div>

        <div class="row pt-5 justify-content-center">
            <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            if ($select_orders->rowCount() > 0) {
                while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                    $platillos = explode(', ', $fetch_orders['total_products']);
                    $detallesOrden = explode(', ', $fetch_orders['detailsOrden']);
            ?>
                    <div class="col-lg-4 mb-4">
                        <div class="box">
                            <div class="d-flex">
                                <p class="fw-medium">Nombre:</p>
                                <p class="mx-2"><?= $fetch_orders['name']; ?></p>
                            </div>
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

                            <form method="POST">
                                <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                                <p class="fw-medium">Estado de la orden: </p>
                                <select name="update_payment">
                                    <option value="" class="text-light" selected disabled><?= $fetch_orders['orderStatus']; ?></option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Preparando">Preparando</option>
                                    <option value="Completada">Completada</option>
                                </select>
                                <div class="pt-4">
                                    <input type="submit" name="update_order" value="Actualizar">
                                    <a class="delete" href="javascript:void(0);" onclick="confirmDelete(<?= $fetch_orders['id']; ?>)">
                                        Eliminar
                                    </a>

                                </div>
                            </form>
                        </div>
                    </div>

            <?php
                }
            } else {
                echo '<p class="text-center">No hay ordenes</p>';
            }
            ?>

        </div>

    </section>

    <?php include 'footerAdmin.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="js/scrollTo.js"></script>
    <script>
        function confirmDelete(orderId) {
            Swal.fire({
                icon: "info",
                text: "¿Desea eliminar la orden?",
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
                    window.location.href = `ordersAdmin.php?delete=${orderId}`;
                }
            });
        }
    </script>

</body>

</html>