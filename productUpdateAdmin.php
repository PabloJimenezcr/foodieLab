<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};


if (isset($_POST['update_product'])) {
    $pid = $_POST['pid'];
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
    $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
    $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = 'uploadedImg/' . $image;
    $old_image = $_POST['old_image'];

    $errors = [];

    if (empty($name) || empty($price) || empty($category) || empty($details)) {
        echo '<script>
            Swal.fire({
                icon: "error",
                text: "Todos los campos son obligatorios",
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
        $select_product = $conn->prepare("SELECT * FROM `products` WHERE name = ? AND id != ?");
        $select_product->execute([$name, $pid]);
        if ($select_product->rowCount() > 0) {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    text: "El nombre del producto ya existe",
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
            $update_product = $conn->prepare("UPDATE `products` SET name = ?, category = ?, details = ?, price = ? WHERE id = ?");
            $update_product->execute([$name, $category, $details, $price, $pid]);

            echo '<script>
                Swal.fire({
                    icon: "success",
                    text: "Producto actualizado",
                    confirmButtonText: "Continuar",
                    showClass: {
                        popup: "animate__animated animate__zoomIn"
                    },
                    hideClass: {
                        popup: "animate__animated animate__zoomOut"
                    }
                }).then(() => {
                    window.location.href = "productsAdmin.php#products";
                });
            </script>';

            if (!empty($image)) {
                if ($image_size > 9000000) {
                    echo '<script>
                        Swal.fire({
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
                    $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
                    $update_image->execute([$image, $pid]);

                    if ($update_image) {
                        move_uploaded_file($image_tmp_name, $image_folder);
                        unlink('uploadedImg/' . $old_image);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/foodlab/css/index.css">
    <title>Foodie Lab | Actualizar producto</title>
</head>

<body>

    <?php include 'headerAdmin.php'; ?>


    <section class="container productsAdmin ptMore">
        <div class="text-center">
            <h2>Actualizar un producto</h2>
            <img src="img/line.png" class="img-fluid" alt="Raya decorativa">
        </div>


        <?php
        $update_id = $_GET['update'];
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
        $select_products->execute([$update_id]);
        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="box boxProductUpdate mt-5">
                        <div class="row justify-content-center">
                            <img class="photoProductUpdate img-fluid mb-4" src="uploadedImg/<?= $fetch_products['image']; ?>" alt="Foto platillo">
                        </div>
                        <div class="row text-center py-lg-5">
                            <div class="col-lg-4 mb-4">
                                <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
                                <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                <input name="name" type="text" placeholder="Nombre del producto" value="<?= $fetch_products['name']; ?>">
                            </div>

                            <div class="col-lg-4 mb-4">
                                <input min="0" name="price" type="number" placeholder="Precio del producto" value="<?= $fetch_products['price']; ?>">
                            </div>

                            <div class="col-lg-4 mb-4">
                                <select name="category">
                                    <option selected><?= $fetch_products['category']; ?></option>
                                    <option value="pizzas">Pizza</option>
                                    <option value="hamburguesas">Hamburguesas</option>
                                    <option value="ensaladas">Ensaladas</option>
                                    <option value="cocteles">Cócteles</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="wrapper" onclick="defaultBtnActive()">
                                    <div class="image">
                                        <img class="imagePreview img-fluid" src="">
                                    </div>
                                    <div class="content">
                                        <div class="text-center">
                                            <i class="ri-upload-cloud-line"></i>
                                        </div>
                                        <div class="text-center">
                                            <p>Actualizar imagen del platillo</p>
                                        </div>
                                    </div>
                                    <div class="closeBtn">
                                        <i class="ri-close-line"></i>
                                    </div>
                                    <div class="file-name">
                                        Nombre del archivo aquí
                                    </div>
                                </div>
                                <input id="default-btn" type="file" name="image" hidden>
                            </div>

                            <div class="col-lg-6">
                                <textarea name="details" placeholder="Detalles del platillo..."><?= $fetch_products['details']; ?></textarea>
                            </div>

                            <div class="col-lg-6 pt-3">
                                <input name="update_product" class="sendInput" type="submit" value="Actualizar">
                                <a href="productsAdmin.php">Regresar</a>
                            </div>
                        </div>
                    </div>
                </form>

        <?php
            }
        } else {
            echo '<p class="text-center">No se encontro el producto</p>';
        }
        ?>
    </section>







    <?php include 'footerAdmin.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        const wrapper = document.querySelector(".wrapper");
        const fileName = document.querySelector(".file-name");
        const defaultBtn = document.querySelector("#default-btn");
        const cancelBtn = document.querySelector(".closeBtn i");
        const img = document.querySelector(".imagePreview");
        const content = document.querySelector(".content");
        let regExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;

        function defaultBtnActive() {
            if (!wrapper.classList.contains("active")) {
                defaultBtn.click();
            }
        }

        defaultBtn.addEventListener("change", function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    const result = reader.result;
                    img.src = result;
                    wrapper.classList.add("active");
                    hideContent();
                };
                cancelBtn.addEventListener("click", function() {
                    img.src = "";
                    wrapper.classList.remove("active");
                    showContent();
                });
                reader.readAsDataURL(file);
            }
            if (this.value) {
                let valueStore = this.value.match(regExp);
                fileName.textContent = valueStore;
            }
        });

        function hideContent() {
            content.style.display = "none";
        }

        function showContent() {
            content.style.display = "block";
        }
    </script>

    <script src="js/scrollTo.js"></script>
</body>

</html>