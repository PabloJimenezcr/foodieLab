<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="img/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="http://localhost/foodlab/css/index.css">
    <title>Foodie Lab</title>
</head>

<body class="loading">

    <div class="overlay">
        <img src="img/logo.png" class="img-fluid" alt="Logo foodie lab">
        <h1>Foodie Lab</h1>
        <p>Creando delicias, sirviendo con pasión</p>
    </div>


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



    <header id="header" class="header fixed-top d-flex align-items-center header-transparent">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="logo">
                <a href="index.php">
                    <img src="img/logo.png" alt="Logo foodie lab" class="img-fluid">
                </a>
            </div>

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul class="ulMenu">
                    <li><a class="nav-link scrollto" href="#hero">Inicio</a></li>
                    <li><a class="nav-link scrollto" href="#about">Nosotros</a></li>
                    <li><a class="nav-link scrollto" href="#app">Aplicación</a></li>
                    <li><a class="nav-link scrollto" href="#chefs">Chefs</a></li>
                    <li><a class="nav-link scrollto" href="#menu">Menú</a></li>
                    <li><a class="nav-link scrollto" href="#contact">Contacto</a></li>
                </ul>
            </nav>
            <a href="login.php" class="loginBtn scrollto">Iniciar sesión</a>
            <i class="ri-menu-3-fill iconHamburguer" data-bs-toggle="offcanvas" data-bs-target="#menuResponsive" aria-controls="menuResponsive"></i>
        </div>
    </header>





    <div class="offcanvas offcanvas-start offcanvasResponsive" data-bs-scroll="true" tabindex="-1" id="menuResponsive" aria-labelledby="menu">
        <div class="offcanvas-header">
            <button type="button" data-bs-dismiss="offcanvas" aria-label="Cerrar">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <div class="text-center mb-5">
                <img src="img/logo.png" alt="Logo foodie lab" class="img-fluid">
            </div>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto" href="#hero">Inicio</a></li>
                    <li><a class="nav-link scrollto" href="#about">Nosotros</a></li>
                    <li><a class="nav-link scrollto" href="#app">Aplicación</a></li>
                    <li><a class="nav-link scrollto" href="#chefs">Chefs</a></li>
                    <li><a class="nav-link scrollto" href="#menu">Menú</a></li>
                    <li><a class="nav-link scrollto" href="login.php">Iniciar Sesión</a></li>
                    <li><a class="nav-link scrollto contact" href="#contact">Contacto</a></li>
                </ul>
            </nav>
            <div class="text-center pt-4">
                <h3>Visítanos</h3>
                <p>FoodLab, San José</p>
                <p>Santa Ana, Costa Rica</p>
                <p>Horario: 8am - 11pm</p>

                <a href="tel:+50622547545">
                    <span>+506 2254-7545</span>
                </a>
            </div>

            <div class="text-center pt-4">
                <h3>Reservas</h3>
                <a href="mailto:foodielab@hotmail.com">
                    <span class="span">foodielab@hotmail.com</span>
                </a>
            </div>
        </div>
    </div>



    <section id="hero" class="hero herro">
        <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h3 class="animate__animated animate__fadeInDown">Experiencia Única</h3>
                            <img class="animate__animated animate__fadeInDown img-fluid" src="img/line.png" alt="raya decorativa">
                            <h1 class="animate__animated animate__fadeInDown">Sabores auténticos hasta tu mesa
                                ordena ahora desde nuestra aplicación</h1>
                            <p class="animate__animated animate__fadeInUp">Descarga nuestra aplicación o inicia
                                sesión desde acá </p>
                            <div>
                                <a href="login.html" class="btnCarousel animate__animated animate__fadeInUp scrollto">
                                    Ordenar</a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="carousel-item">
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h3 class="animate__animated animate__fadeInDown">Únicos de sabor</h3>
                            <img class="animate__animated animate__fadeInDown img-fluid" src="img/line.png" alt="raya decorativa">
                            <h1 class="animate__animated animate__fadeInDown">Platillos creados por chefs únicos
                                con un menú amplio de opciones</h1>
                            <p class="animate__animated animate__fadeInUp">Observe nuestro amplio y sabroso menú</p>
                            <div>
                                <a href="#menu" class="btnCarousel animate__animated animate__fadeInUp scrollto">
                                    Menú</a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="carousel-item">
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h3 class="animate__animated animate__fadeInDown">Experiencia mundial</h3>
                            <img class="animate__animated animate__fadeInDown img-fluid" src="img/line.png" alt="raya decorativa">
                            <h1 class="animate__animated animate__fadeInDown">Nuestra experiencia siempre será
                                ver a cada uno disfrutar de su platillo</h1>
                            <p class="animate__animated animate__fadeInUp">Descubra más sobre nosotros</p>
                            <div>
                                <a href="#about" class="btnCarousel animate__animated animate__fadeInUp scrollto">
                                    Historia</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <a class="carousel-control-prev arrowCarousel" href="#heroCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon ri-arrow-left-s-line" aria-hidden="true"></span>
            </a>

            <a class="carousel-control-next arrowCarousel" href="#heroCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon ri-arrow-right-s-line" aria-hidden="true"></span>
            </a>

        </div>
    </section>



    <section id="about" class="container-fluid aboutSection">
        <div class="text-center">
            <h2>Foodie Lab</h2>
            <img src="img/line.png" alt="raya decorativa" class="img-fluid">
        </div>
        <div class="container">
            <div class="row pt-5">
                <div class="col-lg-6">
                    <img src="img/about.jpg" alt="Foto restaurante" class="img-fluid">
                </div>

                <div class="col-lg-6">
                    <h3>La tecnología evoluciona con nosotros</h3>
                    <p>En nuestra búsqueda constante por mejorar tu experiencia, hemos incorporado la última tecnología
                        en
                        nuestro restaurante. A través de nuestra innovadora aplicación, ahora puedes ordenar desde tu
                        mesa
                        sin necesidad de un mesero.</p>

                    <p>Con solo unos pocos toques en tu dispositivo móvil, tendrás acceso a nuestro menú completo y
                        podrás
                        personalizar tu pedido según tus preferencias.</p>


                    <div class="vdAbout mt-5">
                        <a href="vd/about.mp4" class="btnPlayAbout" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></a>
                    </div>
                </div>
            </div>
        </div>
        <img src="img/shape2.png" alt="Vegetales flotando" class="img-fluid shape shape1">
        <img src="img/shape1.png" alt="Vegetales flotando" class="img-fluid shape shape2">
    </section>


    <section id="app" class="container-fluid appSection">
        <div class="text-center">
            <h2>Descarga la app</h2>
            <img src="img/line.png" alt="raya decorativa" class="img-fluid">
        </div>

        <div class="row pt-5">
            <div class="col-lg-6 d-flex justify-content-center flex-column align-items-center mb-5">
                <div class="boxNumber">
                    <h3>1</h3>
                </div>
                <p>Descarga nuestra app de restaurante en
                    Google Play o App Store y disfruta de una
                    experiencia gastronómica única.</p>

                <div class="d-flex justify-content-center pt-3">
                    <a href="https://play.google.com/store/games?hl=es_CR&gl=US" target="blank">
                        <img src="img/googlePlay.png" alt="Icono de descarga google play" class="img-fluid store">
                    </a>



                    <a href="https://www.apple.com/la/app-store/" target="blank">
                        <img src="img/appStore.png" alt="Icono de descarga app store" class="img-fluid store">
                    </a>

                </div>
            </div>

            <div class="col-lg-6 d-flex flex-column align-items-center">
                <div class="boxNumber">
                    <h3>2</h3>
                </div>
                <p>Inicia sesión o regístrate totalmente gratis
                    para comenzar a ordenar tus platillos
                    favoritos desde tu mesa.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <img src="img/mobiles.png" alt="Celular con la app foodie lab" class="img-fluid mobile">
        </div>

        <div class="row">
            <div class="col-lg-6 d-flex justify-content-center flex-column align-items-center mb-5">
                <div class="boxNumber">
                    <h3>3</h3>
                </div>
                <p>Comienza a ordenar tus platillos favoritos,
                    añadiéndolos al carrito de compras y
                    especificando cuantos quieres.</p>
            </div>

            <div class="col-lg-6 d-flex justify-content-center flex-column align-items-center mb-5">
                <div class="boxNumber">
                    <h3>4</h3>
                </div>
                <p>Una vez ordenado, le llegara a nuestros chefs
                    la orden para que un robot la lleve hasta tu
                    mesa sin preocuparte de nada.</p>
            </div>
        </div>

        <img src="img/avocadoTomato.png" alt="Foto aguacate y tomate" class="img-fluid shape shape1">
        <img src="img/shape-3.png" alt="Foto ajo" class="img-fluid shape shape2">
    </section>


    <section id="chefs" class="container chefsSection">
        <div class="text-center">
            <h2>Nuestros chefs</h2>
            <img src="img/line.png" alt="raya decorativa" class="img-fluid">
        </div>

        <div class="row pt-5">
            <div class="col-lg-6">
                <div class="triangle text-center">
                    <img src="img/chefBody.png" alt="Foto chef" class="img-fluid chef">
                    <img src="img/coriander.png" alt="culantro" class="img-fluid shape coriander1">
                    <img src="img/coriander2.png" alt="culantro" class="img-fluid shape coriander2">
                    <img src="img/coriander3.png" alt="culantro" class="img-fluid shape coriander3">
                </div>
            </div>
            <div class="col-lg-6">
                <h3>¡Conoce a nuestros talentosos chefs!</h3>
                <p>En nuestro restaurante, tenemos el privilegio de contar con un equipo de chefs apasionados y
                    creativos que se dedican a brindar experiencias culinarias extraordinarias.</p>

                <p>Cada uno de nuestros chefs ha perfeccionado su oficio a lo largo de los años y trae consigo un
                    estilo único y sabores excepcionales.</p>


                <div class="row pt-2">
                    <div class="owl-carousel">
                        <div class="boxChef">
                            <img class="img-fluid" src="img/chef1.png" alt="Foto chef Sofía González">
                            <div>
                                <p>Sofía González</p>
                            </div>
                        </div>


                        <div class="boxChef">
                            <img class="img-fluid" src="img/chef2.png" alt="Foto chef Alejando Zúñiga">
                            <div>
                                <p>Alejando Zúñiga</p>
                            </div>
                        </div>

                        <div class="boxChef">
                            <img class="img-fluid" src="img/chef3.png" alt="Foto chef Ismael Pérez">
                            <div>
                                <p>Ismael Pérez</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="menu" class="container-fluid menuSection">
        <div class="text-center">
            <h2>Menú</h2>
            <img src="img/line.png" alt="raya decorativa" class="img-fluid">
        </div>

        <div class="row pt-5">
            <div class="slideshow">
                <ul class="navigation">
                    <li class="navigation-item active">
                        <span class="rotate-holder"></span>
                        <span class="background-holder" style="background-image: url(img/hamburguerCircle.jpg);"></span>
                    </li>

                    <li class="navigation-item">
                        <span class="rotate-holder"></span>
                        <span class="background-holder" style="background-image: url(img/coctelCircle.jpg);"></span>
                    </li>

                    <li class="navigation-item">
                        <span class="rotate-holder"></span>
                        <span class="background-holder" style="background-image: url(img/costillaCircle.jpg);"></span>
                    </li>

                    <li class="navigation-item">
                        <span class="rotate-holder"></span>
                        <span class="background-holder" style="background-image: url(img/ensaladaCircle.jpg);"></span>
                    </li>

                    <li class="navigation-item">
                        <span class="rotate-holder"></span>
                        <span class="background-holder" style="background-image: url(img/pizzaCircle.jpg);"></span>
                    </li>
                </ul>

                <div class="detail">
                    <div class="detail-item active">
                        <div class="headline">Hamburguesas</div>
                        <div class="background"></div>
                    </div>

                    <div class="detail-item">
                        <div class="headline">Cócteles</div>
                        <div class="background"></div>
                    </div>

                    <div class="detail-item">
                        <div class="headline">Costillas</div>
                        <div class="background"></div>
                    </div>


                    <div class="detail-item">
                        <div class="headline">Ensaladas</div>
                        <div class="background"></div>
                    </div>

                    <div class="detail-item">
                        <div class="headline">Pizzas</div>
                        <div class="background"></div>
                    </div>
                </div>
            </div>
    </section>

    <section id="contact" class="container contactSection">
        <div class="text-center">
            <h2>Contacto</h2>
            <img src="img/line.png" alt="raya decorativa" class="img-fluid">
        </div>

        <form>
            <div class="row mt-5">
                <div class="col-lg-6">
                    <img src="img/chefContact.jpg" alt="chef cocinando" class="img-fluid">
                </div>


                <div class="col-lg-6 mt-5 defaultMt">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 d-flex flex-column mb-3">
                            <label>Nombre</label>
                            <input type="text" id="name">
                        </div>
                        <div class="col-lg-5 d-flex flex-column mb-3">
                            <label>Teléfono</label>
                            <input type="number" id="phone">
                        </div>
                    </div>

                    <div class="row pt-3 justify-content-center">
                        <div class="col-lg-10 d-flex flex-column">
                            <label>Email</label>
                            <input type="email" id="mail">
                        </div>
                    </div>

                    <div class="row pt-3 justify-content-center">
                        <div class="col-lg-10 d-flex flex-column">
                            <label>Mensaje</label>
                            <textarea id="message" cols="20" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="row pt-3 justify-content-center">
                        <div class="col-lg-10 d-flex flex-column">
                            <input class="sendInput" type="submit" value="Enviar">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Foodie Lab</h1>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                        <video src="vd/about.mp4" controls></video>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btnClose" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <footer class="container-fluid footerLanding">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12">
                    <img src="img/logo.png" alt="Logo foodie lab" class="img- logo">
                </div>
            </div>

            <div class="line my-5"></div>

            <div class="row">
                <div class="col-lg-4 mb-3">
                    <h4>Horario</h4>

                    <div class="d-flex">
                        <i class="ri-timer-2-line watch"></i>
                        <p class="ms-2">L-D 8 am a 11 pm</p>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.2/TweenMax.min.js"></script>
    <script src="https://unpkg.com/imagesloaded@4.1.4/imagesloaded.pkgd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/CSSRulePlugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/plugins/TextPlugin.min.js"></script>



    <script src="js/scrollTo.js"></script>
    <script src="js/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/TweenMax.min.js"></script>
    <script src="js/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>