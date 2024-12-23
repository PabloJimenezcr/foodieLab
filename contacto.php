<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

if (isset($_POST['send'])) {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $number = isset($_POST['number']) ? trim($_POST['number']) : '';
    $msg = isset($_POST['msg']) ? trim($_POST['msg']) : '';

    if (empty($name) || empty($email) || empty($number) || empty($msg)) {
        echo '
        <script>
        Swal.fire({
            icon: "error",
            text: "Por favor, complete todos los campos requeridos",
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
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $number = filter_var($number, FILTER_SANITIZE_STRING);
        $msg = filter_var($msg, FILTER_SANITIZE_STRING);

        $select_message = $conn->prepare("SELECT * FROM `message` WHERE name = ? AND email = ? AND number = ? AND message = ?");
        $select_message->execute([$name, $email, $number, $msg]);

        if ($select_message->rowCount() > 0) {
            echo '
            <script>
            Swal.fire({
                icon: "success",
                text: "Mensaje ya enviado",
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
            $insert_message = $conn->prepare("INSERT INTO `message`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
            $insert_message->execute([$user_id, $name, $email, $number, $msg]);
            echo '
            <script>
            Swal.fire({
                icon: "success",
                text: "Mensaje enviado con éxito",
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
if (isset($_POST['send'])) {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $number = isset($_POST['number']) ? trim($_POST['number']) : '';
    $msg = isset($_POST['msg']) ? trim($_POST['msg']) : '';

    if (empty($name) || empty($email) || empty($number) || empty($msg)) {
        echo '
        <script>
        Swal.fire({
            icon: "error",
            text: "Por favor, complete todos los campos requeridos",
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
        $name = filter_var($name, FILTER_SANITIZE_STRING);


        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '
            <script>
            Swal.fire({
                icon: "error",
                text: "Por favor, ingresa una dirección de correo electrónico válida",
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
            $allowed_domains = array('gmail.com', 'hotmail.com', 'otrodominio.com');
            $email_parts = explode('@', $email);
            $domain = end($email_parts);

            if (!in_array($domain, $allowed_domains)) {
                echo '
                <script>
                Swal.fire({
                    icon: "error",
                    text: "Por favor, utiliza un correo electrónico con un dominio válido",
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
                $email = filter_var($email, FILTER_SANITIZE_STRING);
                $number = filter_var($number, FILTER_SANITIZE_STRING);
                $msg = filter_var($msg, FILTER_SANITIZE_STRING);

                $select_message = $conn->prepare("SELECT * FROM `message` WHERE name = ? AND email = ? AND number = ? AND message = ?");
                $select_message->execute([$name, $email, $number, $msg]);

                if ($select_message->rowCount() > 0) {
                    echo '
                    <script>
                    Swal.fire({
                        icon: "success",
                        text: "Mensaje enviado con éxito",
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
    <title>Foodie Lab | Contacto</title>
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



    <section class="container contact ptMore">
        <div class="text-center">
            <h2>Contacto</h2>
            <img src="img/line.png" alt="Raya decorativa" class="img-fluid">
        </div>
        <div class="row mt-5">
            <div class="col-lg-6 pe-0">
                <div class="image-container">
                    <img src="img/contactChef.jpg" alt="Foto chef cocinando" class="img-fluid chef  bg-white">
                </div>
            </div>

            <div class="col-lg-6 boxWhite">
                <form method="POST">
                    <div class="row mt-5">
                        <div class="col-lg-6 pb-5">
                            <i class="ri-user-line"></i>
                            <input name="name" type="text" placeholder="Ingresa tu nombre">
                        </div>

                        <div class="col-lg-6 pb-5">
                            <i class="ri-phone-line"></i>
                            <input name="number" type="number" placeholder="Ingresa tu teléfono">
                        </div>
                    </div>

                    <div class="col-lg-12 pb-5">
                        <i class="ri-mail-line"></i>
                        <input name="email" type="email" placeholder="Ingresa tu email">
                    </div>


                    <div class="col-lg-12 textarea pb-4">
                        <i class="ri-phone-line"></i>
                        <textarea name="msg" placeholder="Coméntanos que tal tu experiencia..."></textarea>
                    </div>

                    <div class="col-lg-12 button">
                        <input name="send" type="submit" value="Enviar">
                    </div>
                </form>
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