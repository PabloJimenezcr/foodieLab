<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_message = $conn->prepare("DELETE FROM `message` WHERE id = ?");
    $delete_message->execute([$delete_id]);
    header('location:messagesAdmin.php');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.20/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="http://localhost/foodlab/css/index.css">
    <title>Foodie Lab | Mensajes</title>
</head>

<body>

    <?php include 'headerAdmin.php'; ?>

    <section class="container ordersAdmin ptMore">
        <div class="text-center">
            <h2>Mensajes</h2>
            <img src="img/line.png" class="img-fluid" alt="Raya decorativa">
        </div>

        <div class="row pt-5 justify-content-center">

            <?php
            $select_message = $conn->prepare("SELECT * FROM `message`");
            $select_message->execute();
            if ($select_message->rowCount() > 0) {
                while ($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)) {
            ?>


                    <div class="col-lg-4 mb-4">
                        <div class="box">
                            <div class="d-flex">
                                <p class="fw-medium">Nombre:</p>
                                <p class="mx-2"><?= $fetch_message['name']; ?></p>
                            </div>
                            <div class="d-flex">
                                <p class="fw-medium">Teléfono: </p>
                                <p class="mx-2"><?= $fetch_message['number']; ?></p>
                            </div>

                            <div class="d-flex">
                                <p class="fw-medium">Email: </p>
                                <p class="mx-2"><?= $fetch_message['email']; ?></p>
                            </div>

                            <div class="d-flex">
                                <p class="fw-medium">Mensaje: </p>
                                <p class="mx-2"><?= $fetch_message['message']; ?></p>
                            </div>


                            <div class="py-3">
                                <a class="delete" href="javascript:void(0);" onclick="confirmDeleteMessage(<?= $fetch_message['id']; ?>)">
                                    Eliminar
                                </a>


                            </div>
                        </div>
                    </div>
        </div>


<?php
                }
            } else {
                echo '<p class="text-center">No hay mensajes</p>';
            }
?>
    </section>


    <?php include 'footerAdmin.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.20/sweetalert2.min.js"></script>
    <script src="js/scrollTo.js"></script>
    <script>
        function confirmDeleteMessage(messageId) {
            Swal.fire({
                icon: "info",
                text: "¿Eliminar mensaje?",
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
                    window.location.href = `messagesAdmin.php?delete=${messageId}`;
                }
            });
        }
    </script>


</body>

</html>