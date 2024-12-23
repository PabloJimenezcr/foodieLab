<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};


if (isset($_POST['update_profile'])) {
    $old_pass_input = $_POST['update_pass'];
    $old_pass_input = md5($old_pass_input);
    $old_pass_input = filter_var($old_pass_input, FILTER_SANITIZE_STRING);

    $get_current_pass_query = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
    $get_current_pass_query->execute([$user_id]);
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
        $update_profile->execute([$name, $email, $user_id]);

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploadedImg/' . $image;
        $old_image = $_POST['old_image'];

        if (!empty($image)) {
            if ($image_size > 2000000) {
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
                $update_image->execute([$image, $user_id]);
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
                }
            }
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
            $update_pass_query->execute([$new_pass, $user_id]);

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
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/foodlab/css/index.css">
    <title>Foodie Lab | Perfil</title>
</head>

<body>



    <?php include 'header.php'; ?>




    <section class="container profile ptMore">
        <div class="text-center">
            <h2>Editar perfil</h2>
            <img src="img/line.png" class="img-fluid" alt="Raya decorativa">

            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="input-boxes">
                    <figure>
                        <img src="uploadedImg/<?= $fetch_profile['image']; ?>" class="img-fluid" alt="Foto de perfil">
                    </figure>
                    <div class="d-flex columnInputsProfile">
                        <div class="input-box">
                            <i class="ri-user-line"></i>
                            <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" placeholder="Actualizar nombre" required>
                        </div>

                        <div class="input-box ms-lg-3 ms-md-3">
                            <i class="ri-mail-line"></i>
                            <input type="text" name="email" value="<?= $fetch_profile['email']; ?>" placeholder="Actualizar email" required>
                        </div>
                    </div>

                    <div class="d-flex columnInputsProfile">

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

                    <div class="button d-flex align-items-baseline justify-content-between">
                        <input type="submit" value="Actualizar" name="update_profile">
                        <p data-bs-toggle="modal" data-bs-target="#modalUpdatePassword">¿Actualizar contraseña?</p>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="modalUpdatePassword" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalUpdatePassword" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="modalUpdatePassword">Actualizar contraseña</h3>
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






    <footer class="container-fluid footerLanding m-0">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12">
                    <img src="img/logo.png" alt="Logo foodie lab" class="img-fluid logo">
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