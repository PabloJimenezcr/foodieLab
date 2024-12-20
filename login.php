<?php

@include 'config.php';

session_start();


if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = md5($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    if (empty($email) || empty($pass)) {
        echo '<script>Swal.fire({
            icon: "error",
            text: "Debe ingresar el email y contraseña",
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
        $sql = "SELECT * FROM `users` WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email, $pass]);
        $rowCount = $stmt->rowCount();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($rowCount > 0) {

            if ($row['user_type'] == 'admin') {

                $_SESSION['admin_id'] = $row['id'];
                header('location:homeAdmin.php');
            } elseif ($row['user_type'] == 'user') {

                $_SESSION['user_id'] = $row['id'];
                header('location:home.php');
            }
        } else {
            echo '<script>Swal.fire({
                    icon: "error",
                    text: "No se encontró al usuario",
                    confirmButtonText: "Continuar",
                    showClass: {
                        popup: "animate__animated animate__zoomIn"
                      },
                      hideClass: {
                        popup: "animate__animated animate__zoomOut"
                      }
                });</script>';
        }
    }
}




if (isset($_POST['submitR'])) {
    $nameR = $_POST['nameRegister'];
    $nameR = filter_var($nameR, FILTER_SANITIZE_STRING);
    $emailR = $_POST['emailRegister'];
    $emailR = filter_var($emailR, FILTER_SANITIZE_STRING);
    $passR = md5($_POST['passR']);
    $passR = filter_var($passR, FILTER_SANITIZE_STRING);
    $cpass = md5($_POST['cPass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploadedImg/' . $image;

    $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select->execute([$emailR]);

    if ($select->rowCount() > 0) {
        echo '<script>
        Swal.fire({
            icon: "info",
            text: "¡El correo electrónico ya está registrado!",
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
        if ($passR != $cpass) {

            echo '<script>
            Swal.fire({
                icon: "error",
                text: "¡La confirmación de contraseña no coincide!",
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
            if (empty($image)) {
                echo '<script>
                        Swal.fire({
                            icon: "error",
                            text: "¡Por favor, carga una imagen!",
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
                $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)");

                if (empty($nameR) || empty($emailR) || empty($_POST['passR']) || empty($_POST['cPass'])) {
                    echo '<script>
                        Swal.fire({
                            icon: "error",
                            text: "¡Por favor, completa todos los campos!",
                            confirmButtonText: "Continuar",
                            showClass: {
                                popup: "animate__animated animate__zoomIn"
                              },
                              hideClass: {
                                popup: "animate__animated animate__zoomOut"
                              }
                        });
                        
                      </script>';
                } else if ($insert->execute([$nameR, $emailR, $passR, $image])) {
                    if ($image_size > 2000000) {
                        echo '<script>
                            Swal.fire({
                                icon: "error",
                                text: "¡El tamaño de la imagen es demasiado grande!",
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
                        move_uploaded_file($image_tmp_name, $image_folder);
                        echo '<script>
                            Swal.fire({
                                icon: "success",
                                text: "¡Registrado exitosamente!",
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="http://localhost/foodlab/css/index.css">
    <title>Foodie Lab | Iniciar sesión</title>
</head>

<body>

    <body>

        <section class="login">
            <div class="container">
                <input type="checkbox" id="flip">
                <div class="cover">
                    <div class="front">
                        <img src="img/login.jpg" alt="Foto persona sosteniendo un celular y comiendo">
                        <div class="text">
                            <p class="text-1">Inicia sesión para comenzar a</p>
                            <p class="text-2">ordenar tus platillos favoritos</p>
                        </div>
                    </div>
                    <div class="back">
                        <img class="backImg" src="img/register.jpg" alt="Foto persona sosteniendo un celular y comiendo">
                        <div class="text">
                            <p>Regístrate para comenzar a</p>
                            <p>ordenar tus platillos favoritos</p>
                        </div>
                    </div>
                </div>
                <div class="forms">
                    <div class="form-content">
                        <div class="login-form">
                            <h3>Iniciar sesión</h3>
                            <form action="" method="POST">
                                <div class="input-boxes">
                                    <div class="input-box">
                                        <i class="ri-mail-line"></i>
                                        <input name="email" type="text" placeholder="Ingresa tu email">
                                    </div>
                                    <div class="input-box">
                                        <i class="ri-lock-line"></i>
                                        <input name="pass" type="password" placeholder="Ingresa tu contraseña">
                                    </div>
                                    <div class="button input-box">
                                        <input name="submit" type="submit" value="Ingresar">
                                    </div>
                                    <div class="text sign-up-text">¿No tienes cuenta?<label for="flip"> Regístrate
                                            ahora</label></div>
                                </div>
                            </form>
                        </div>
                        <div class="signup-form">
                            <h3>Registro</h3>
                            <form action="" enctype="multipart/form-data" method="POST">
                                <div class="input-boxes">
                                    <div class="imageUploadContainer">
                                        <figure class="imagePreview">
                                            <img src="img/user.png" class="img-fluid" id="chosen-image">
                                            <figcaption id="file-name"></figcaption>
                                        </figure>

                                        <label class="labelPhoto" for="foto">
                                            <i class="ri-camera-line"></i>
                                            <input type="file" id="foto" name="image" accept="image/jpg, image/jpeg, image/png">
                                        </label>
                                    </div>
                                    <div class="input-box">
                                        <i class="ri-user-line"></i>
                                        <input name="nameRegister" type="text" placeholder="Ingresa tu nombre">
                                    </div>
                                    <div class="input-box">
                                        <i class="ri-mail-line"></i>
                                        <input name="emailRegister" type="text" placeholder="Ingresa tu email">
                                    </div>
                                    <div class="input-box">
                                        <i class="ri-lock-line"></i>
                                        <input name="passR" type="password" placeholder="Ingresa una contraseña">
                                        <i class="ri-eye-line showPassword"></i>
                                    </div>
                                    <div class="input-box">
                                        <i class="ri-lock-line"></i>
                                        <input name="cPass" type="password" placeholder="Confirma tu contraseña">
                                        <i class="ri-eye-line showPassword"></i>
                                    </div>
                                    <div class="button input-box">
                                        <input type="submit" value="Registrarse" name="submitR">
                                    </div>
                                    <div class="text sign-up-text">¿Ya tienes cuenta? <label for="flip">
                                            Inicia sesión ahora</label></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <img src="img/hoja2.png" alt="Hoja decorativa" class="img-fluid shape shape1">
            <img src="img/hoja1.png" alt="Hoja decorativa" class="img-fluid shape shape2">
        </section>


        <script src="js/photoChange.js"></script>
        <script src="js/pass.js"></script>
    </body>

</html>