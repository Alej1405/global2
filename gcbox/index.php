<?php 
    require '../includes/funciones.php';
    incluirTemplate('header_GC');
?>
    <body class="d-flex flex-column h-100">
        <main class="flex-shrink-0"> 
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.html">GC-box COURIER</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="index.html">HOME</a></li>
                            <li class="nav-item"><a class="nav-link" href="about.html">Nosotros</a></li>
                            <li class="nav-item"><a class="nav-link" href="contact.html">Contactos</a></li>
                            <li class="nav-item"><a class="nav-link" href="pricing.html">Servicios</a></li>
                            <li class="nav-item"><a class="nav-link" href="faq.html">FAQ</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Blog</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                                    <li><a class="dropdown-item" href="blog-home.html">Noticias</a></li>
                                    <li><a class="dropdown-item" href="blog-post.html">Publiar</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownPortfolio" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Servicios</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownPortfolio">
                                    <li><a class="dropdown-item" href="portfolio-overview.html">Internacionales</a></li>
                                    <li><a class="dropdown-item" href="portfolio-item.html">Nacionales</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Header-->
            <header class="bg-dark py-5">
                <div class="container px-5">
                    <div class="row gx-5 align-items-center justify-content-center">
                        <div class="col-lg-8 col-xl-7 col-xxl-6">
                            <div class="my-5 text-center text-xl-start">
                                <h1 class="display-5 fw-bolder text-white mb-2">La venta al mundo comercial</h1>
                                <p class="lead fw-normal text-white-50 mb-4">
                                    Haz tus compras en las mejores tiendas del mundo y nosotros te las entregamos en la puerta
                                    de tu casa, sin cargos adicionales.
                                </p>
                                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                    <a class="btn btn-primary btn-lg px-4 me-sm-3" href="#features">Empecemos</a>
                                    <a class="btn btn-outline-light btn-lg px-4" href="#!">Leer mas</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center">
                            <img class="img-fluid rounded-3 my-5" src="https://dummyimage.com/600x400/343a40/6c757d" alt="..." />
                        </div>
                    </div>
                </div>
            </header>
            <!-- Features section-->
            <section class="py-5" id="features">
                <div class="container px-5 my-5">
                    <div class="row gx-5">
                        <div class="col-lg-4 mb-5 mb-lg-0"><h2 class="fw-bolder mb-0">Parte de nuestros servicos, nacionales e internacionales</h2></div>
                        <div class="col-lg-8">
                            <div class="row gx-5 row-cols-1 row-cols-md-2">
                                <div class="col mb-5 h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                                    <h2 class="h5">Reempaque</h2>
                                    <p class="mb-0">
                                        Consolidamos en Miami, si es necesario la reempacamos de acuerdo a la necesidad.
                                    </p>
                                </div>
                                <div class="col mb-5 h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-building"></i></div>
                                    <h2 class="h5">Proceso simplificado</h2>
                                    <p class="mb-0">
                                        Importacion facil, sin cargos adicionales, sin procedimientos inecesarios paga solo por el peso real.
                                    </p>
                                </div>
                                <div class="col mb-5 mb-md-0 h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                                    <h2 class="h5">Courier Nacional</h2>
                                    <p class="mb-0">
                                        Envio de paquetes y documentos a nivel nacional, 24h o de acuerdo al destino, recoleccion sin cargos. (Sujeto a politicas)
                                    </p>
                                </div>
                                <div class="col h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                                    <h2 class="h5">Busqueda de productos</h2>
                                    <p class="mb-0">
                                        Te ayudamos a encontrar ese producto, repuesto, regalo o lo que necesites, compras seguras.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Testimonial section-->
            <div class="py-5 bg-light">
                <div class="container px-5 my-5">
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-10 col-xl-7">
                            <div class="text-center">
                                <div class="fs-4 mb-4 fst-italic">
                                    "Importar no solamente es porder adquirir, aquello que no encontramos en el país, 
                                    !Tu emprendimiento puede subir al siguiente niel! aplica ese detalle que te haga 
                                    diferente o baja el precio optimizando la compra de materia prima."
                                </div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img class="rounded-circle me-3" src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." />
                                    <div class="fw-bold">
                                        GC-box Courier
                                        <span class="fw-bold text-primary mx-1">/</span>
                                        CEO, Operaciones
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Blog preview section-->
            <section class="py-5">
                <div class="container px-5 my-5">
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <div class="text-center">
                                <h2 class="fw-bolder">Cómo puedo importar..?</h2>
                                <p class="lead fw-normal text-muted mb-5">
                                    Estas son las reglas (regimen) determinadas por aduana para poder importar conocerlas
                                    es importante para poder optimizar y planificar las compras de mejor manera.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5">
                        <div class="col-lg-4 mb-5">
                            <div class="card h-100 shadow border-0">
                                <img class="card-img-top" src="https://dummyimage.com/600x350/ced4da/6c757d" alt="..." />
                                <div class="card-body p-4">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2">4x4</div>
                                    <a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3">Categoria B</h5></a>
                                    <p class="card-text mb-0">
                                        Realiza tus compras personales, en esta categoria puedes traer, ropa zapatos, perfumes, juguetes, entre otros productos
                                        con ciertas  excepciones.
                                    </p>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle me-3" src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." />
                                            <div class="small">
                                                <div class="fw-bold">Acutualizado</div>
                                                <div class="text-muted">March 25, 2022 &middot; 6 min read</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-5">
                            <div class="card h-100 shadow border-0">
                                <img class="card-img-top" src="https://dummyimage.com/600x350/adb5bd/495057" alt="..." />
                                <div class="card-body p-4">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2">C 50k</div>
                                    <a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3">REGIMEN C </h5></a>
                                    <p class="card-text mb-0">
                                        Potencia tu emprendimiento, el mercado mundial puede ofrecer nuevas y diferentes materias primas
                                        o quizá maquinaria especializada.
                                    </p>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle me-3" src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." />
                                            <div class="small">
                                                <div class="fw-bold">Actualizadp</div>
                                                <div class="text-muted">March 23, 2022 &middot; 4 min read</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-5">
                            <div class="card h-100 shadow border-0">
                                <img class="card-img-top" src="https://dummyimage.com/600x350/6c757d/343a40" alt="..." />
                                <div class="card-body p-4">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2">Especial</div>
                                    <a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3">Regimen especial</h5></a>
                                    <p class="card-text mb-0">
                                        Servicio especial para insumos medicos, también medicamentos que tengan receta médica, si lo requieres
                                        de forma periódica podemos ajustar el valor del servicio.
                                    </p>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle me-3" src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." />
                                            <div class="small">
                                                <div class="fw-bold">Actualizado</div>
                                                <div class="text-muted">March 2, 2022 &middot; 10 min read</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Call to action-->
                    <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
                        <div class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">
                            <div class="mb-4 mb-xl-0">
                                <div class="fs-3 fw-bold text-white">Necesitas mas informacion o cotizar.</div>
                                <div class="text-white-50">Déjanos tu correo e inmediatamente nos comunicaremos.</div>
                            </div>
                            <div class="ms-xl-4">
                                <div class="input-group mb-2">
                                    <input class="form-control" type="text" placeholder="Email..." aria-label="Email address..." aria-describedby="button-newsletter" />
                                    <button class="btn btn-outline-light" id="button-newsletter" type="button">Contactar</button>
                                </div>
                                <div class="small text-white-50">Tú privacidad es importante, tus datos son de uso exclusivo</div>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>
        </main>
<?php
    incluirTemplate('footer_GC');
?>
