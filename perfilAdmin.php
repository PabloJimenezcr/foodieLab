<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['update_profile'])) {

    $old_pass_input = $_POST['update_pass'];
    $old_pass_input = md5($old_pass_input);
    $old_pass_input = filter_var($old_pass_input, FILTER_SANITIZE_STRING);

    $get_current_pass_query = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
    $get_current_pass_query->execute([$admin_id]);
    $current_pass_db = $get_current_pass_query->fetchColumn();

    if ($old_pass_input !== $current_pass_db) {
        echo '<script>
            Swal.fire({
                icon: "error",
                text: "Debe escribir la contraseña actual para hacer los cambios",
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
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
        $update_profile->execute([$name, $email, $admin_id]);

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploadedImg/' . $image;
        $old_image = $_POST['old_image'];

        if (!empty($image)) {
            if ($image_size > 9000000) {
                echo '<script>Swal.fire({
                    icon: "info",
                    text: "La imagen pesa mucho",
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
                $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
                $update_image->execute([$image, $admin_id]);
                if ($update_image) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    unlink('uploadedImg/' . $old_image);
                    echo '<script>Swal.fire({
                        icon: "success",
                        text: "La imagen se ha actualizado",
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
            };
        }
        echo '<script>Swal.fire({
            icon: "success",
            text: "Los datos se han actualizado correctamente",
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

if (isset($_POST['update_password'])) {
    $old_pass_input = $_POST['update_pass'];
    $old_pass_input = md5($old_pass_input);
    $old_pass_input = filter_var($old_pass_input, FILTER_SANITIZE_STRING);
    $old_pass_db = $_POST['old_pass'];

    if ($old_pass_input !== $old_pass_db) {
        echo '<script>
            Swal.fire({
                icon: "error",
                text: "Debe escribir la contraseña actual para realizar los cambios",
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
        $new_pass = $_POST['new_pass'];
        $confirm_pass = $_POST['confirm_pass'];

        if (empty($new_pass) || empty($confirm_pass)) {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    text: "Los campos de nueva contraseña y confirmación de contraseña no pueden estar vacíos",
                    confirmButtonText: "Continuar",
                    showClass: {
                        popup: "animate__animated animate__zoomIn"
                    },
                    hideClass: {
                        popup: "animate__animated animate__zoomOut"
                    }
                });
            </script>';
        } elseif ($new_pass !== $confirm_pass) {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    text: "La confirmación de contraseña no coincide con la nueva contraseña",
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
            $new_pass = md5($new_pass);
            $update_pass_query = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
            $update_pass_query->execute([$new_pass, $admin_id]);

            if ($update_pass_query) {
                echo '<script>Swal.fire({
                    icon: "success",
                    text: "Contraseña actualizada correctamente",
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
                echo '<script>Swal.fire({
                    icon: "error",
                    text: "Error al actualizar la contraseña",
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
    <title>Foodie Lab | Peril</title>
</head>

<body>

    <?php include 'headerAdmin.php'; ?>


    <section class="container profile ptMore">
        <div class="text-center">
            <h2>Editar perfil</h2>
            <img src="img/line.png" class="img-fluid" alt="Raya decorativa">
        </div>

        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="input-boxes">
                <figure>
                    <img src="uploadedImg/<?= $fetch_profile['image']; ?>" class="img-fluid" alt="Foto de perfil">
                </figure>
                <div class="d-flex flexRowMobile">
                    <div class="input-box">
                        <i class="ri-user-line"></i>
                        <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" placeholder="Actualizar nombre" required>
                    </div>


                    <div class="input-box ms-lg-3 ms-md-3">
                        <i class="ri-mail-line"></i>
                        <input type="text" name="email" value="<?= $fetch_profile['email']; ?>" placeholder="Actualizar email" required>
                    </div>


                </div>

                <div class="d-flex flexRowMobile">
                    <div class="input-box">

                        <input type="file" id="file-input" class="input-file" name="image" accept="image/jpg, image/jpeg, image/png">
                        <i class="ri-camera-line"></i>
                        <label for="file-input" class="file-button">Actualizar foto</label>
                        <input type="hidden" name="old_image" value="<?= $fetch_profile['image']; ?>">
                    </div>


                    <div class="input-box ms-lg-3 ms-md-3">
                        <input type="hidden" name="old_pass" value="<?= $fetch_profile['password']; ?>">
                        <i class="ri-lock-line"></i>
                        <input type="password" placeholder="Contraseña actual" name="update_pass">
                        <i class="ri-eye-line showPassword"></i>
                    </div>
                </div>


                <div class="button d-flex align-items-baseline justify-content-between flexRowMobile">
                    <input type="submit" value="Actualizar" name="update_profile">
                    <p class="updatePassword" data-bs-toggle="modal" data-bs-target="#modalUpdatePasswordAdmin">¿Actualizar contraseña?</p>
                </div>
            </div>
        </form>

        <div class="modal fade" id="modalUpdatePasswordAdmin" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalUpdatePasswordAdmin" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="modalUpdatePasswordAdmin">Actualizar contraseña</h3>
                        <button type="button" data-bs-dismiss="modal" aria-label="Cerrar">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <div class="input-box ms-lg-3 ms-md-3">
                                <input type="hidden" name="old_pass" value="<?= $fetch_profile['password']; ?>">
                                <i class="ri-lock-line"></i>
                                <input type="password" placeholder="Contraseña actual" name="update_pass">
                                <i class="ri-eye-line showPassword"></i>
                            </div>

                            <div class="input-box ms-lg-3 ms-md-3">
                                <i class="ri-lock-line"></i>
                                <input type="password" name="new_pass" placeholder="Nueva contraseña">
                                <i class="ri-eye-line showPassword"></i>
                            </div>

                            <div class="input-box ms-lg-3 ms-md-3">
                                <i class="ri-lock-line"></i>
                                <input type="password" name="confirm_pass" placeholder="Confirmar contraseña">
                                <i class="ri-eye-line showPassword"></i>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input class="ms-lg-3 ms-md-3" type="submit" value="Actualizar" name="update_password">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>



    <?php include 'footerAdmin.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="js/scrollTo.js"></script>
    <script src="js/pass.js"></script>
    <script>
        const fileInput = document.getElementById('file-input');
        const fileButton = document.querySelector('.file-button');

        fileInput.addEventListener('change', () => {
            const files = fileInput.files;
            if (files.length > 0) {
                fileButton.textContent = files[0].name;
            } else {
                fileButton.textContent = 'Selecciona una foto';
            }
        });
    </script>

</body>

</html>