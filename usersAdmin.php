<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
    $delete_users->execute([$delete_id]);
    header('location:usersAdmin.php');
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
    <title>Foodie Lab | Usuarios</title>
</head>

<body>

    <?php include 'headerAdmin.php'; ?>

    <section class="container usersAdmin ptMore">
        <div class="text-center">
            <h2>Usuarios</h2>
            <img src="img/line.png" class="img-fluid" alt="Raya decorativa">
        </div>

        <div class="row pt-5 justify-content-center">
            <?php
            $select_users = $conn->prepare("SELECT * FROM `users`");
            $select_users->execute();

            $num_users = 0;

            while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)) {
                if ($fetch_users['id'] != $admin_id) {
                    $num_users++;
            ?>
                    <div class="col-lg-4 mb-5">
                        <div class="box text-center">
                            <img src="uploadedImg/<?= $fetch_users['image']; ?>" alt="Foto usuario" class="img-fluid userImg">
                            <p><span>Nombre:</span> <?= $fetch_users['name']; ?></p>
                            <p><span>Email: </span><?= $fetch_users['email']; ?></p>
                            <div class="d-flex py-3 justify-content-center">
                                <a class="delete" href="javascript:void(0);" onclick="confirmDeleteUser(<?= $fetch_users['id']; ?>)">
                                    Eliminar
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }

            if ($num_users == 0) {
                echo '<p class="text-center">No hay usuarios para mostrar</p>';
            }
            ?>
        </div>


    </section>



    <?php include 'footerAdmin.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="js/scrollTo.js"></script>
    <script>
        function confirmDeleteUser(userId) {
            Swal.fire({
                icon: "info",
                text: "¿Desea eliminar al usuario?",
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
                    window.location.href = `usersAdmin.php?delete=${userId}`;
                }
            });
        }
    </script>


</body>

</html>