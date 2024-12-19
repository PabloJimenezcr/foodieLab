<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}


$category = "";

if (isset($_POST['add_product'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
    $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);
    $category = isset($_POST['category']) ? filter_var($_POST['category'], FILTER_SANITIZE_STRING) : '';

    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploadedImg/' . $image;
    $image_size = $_FILES['image']['size'];

    $errors = [];

    if (empty($name) || empty($price) || empty($details) || empty($image)) {
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
    } elseif (empty($category)) {
        echo '<script>
            Swal.fire({
                icon: "error",
                text: "El campo de categoría es obligatorio",
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
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
        $select_products->execute([$name]);

        if ($select_products->rowCount() > 0) {
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
            $insert_products = $conn->prepare("INSERT INTO `products`(name, category, details, price, image) VALUES(?,?,?,?,?)");
            $insert_products->execute([$name, $category, $details, $price, $image]);

            if ($insert_products) {
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
                    move_uploaded_file($image_tmp_name, $image_folder);
                    echo '<script>
                        Swal.fire({
                            icon: "success",
                            text: "Producto agregado exitosamente",
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


if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $select_delete_image = $conn->prepare("SELECT image FROM `products` WHERE id = ?");
    $select_delete_image->execute([$delete_id]);
    $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
    unlink('uploadedImg/' . $fetch_delete_image['image']);
    $delete_products = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_products->execute([$delete_id]);
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
    $delete_wishlist->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    header('location:productsAdmin.php');
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
    <title>Foodie Lab | Añadir producto</title>
</head>

<body>

    <?php include 'headerAdmin.php'; ?>


    <section class="container productsAdmin ptMore">
        <div class="text-center">
            <h2>Agregar un producto</h2>
            <img src="img/line.png" class="img-fluid" alt="Raya decorativa">
        </div>

        <form method="POST" enctype="multipart/form-data">
            <div class="box mt-5">
                <div class="row text-center py-5 pyNone">
                    <div class="col-lg-4 mb-4">
                        <input name="name" type="text" placeholder="Nombre del producto">
                    </div>

                    <div class="col-lg-4 mb-4">
                        <input min="0" name="price" type="number" placeholder="Precio del producto">
                    </div>

                    <div class="col-lg-4 mb-4">
                        <select name="category">
                            <option disabled selected>Categoría del producto</option>
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
                                    <p>Sube una imagen del platillo</p>
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

                    <div class="col-lg-6 mb-4">
                        <textarea name="details" placeholder="Detalles del platillo..."></textarea>
                    </div>

                    <div class="col-lg-6 pt-3 mb-4">
                        <input name="add_product" class="sendInput" type="submit" value="Agregar">
                    </div>
                </div>
            </div>
        </form>
    </section>


    <section class="container cardsAdmiProductUpdate" id="products">
        <div class="text-center">
            <h2>Productos</h2>
            <img src="img/line.png" class="img-fluid" alt="Raya decorativa">
        </div>

        <div class="row pt-5">
            <?php
            $show_products = $conn->prepare("SELECT * FROM `products`");
            $show_products->execute();
            if ($show_products->rowCount() > 0) {
                while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="col-lg-4 mb-5 col-md-6">
                        <div class="card">
                            <div class="boxPrice">
                                <p>₡<?= $fetch_products['price']; ?></p>
                            </div>
                            <div class="text-center">
                                <img src="uploadedImg/<?= $fetch_products['image']; ?>" class="card-img-top img-fluid" alt="Foto producto">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= $fetch_products['name']; ?></h5>
                                <p class="card-text"><?= $fetch_products['details']; ?></p>
                                <p class="category">Categoría: <?= $fetch_products['category']; ?></p>
                                <div class="d-flex py-3 buttonsCardAdmin">
                                    <a href="productUpdateAdmin.php?update=<?= $fetch_products['id']; ?>">Actualizar</a>
                                    <a class="delete" href="javascript:void(0);" onclick="confirmDeleteProduct(<?= $fetch_products['id']; ?>)">
                                        Eliminar
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="text-center">No hay productos agregados</p>';
            }
            ?>
        </div>

    </section>


    <?php include 'footerAdmin.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="js/scrollTo.js"></script>
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

    <script>
        function confirmDeleteProduct(productId) {
            Swal.fire({
                icon: "info",
                text: "¿Desea eliminar el producto?",
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
                    window.location.href = `productsAdmin.php?delete=${productId}`;
                }
            });
        }
    </script>

</body>

</html>