<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
    <?php
    
    ?>
<title>GLOBAL CARGO EC</title>
    <meta name="description:" content="Sistema de Gestión de Operaciones">
    <meta name="author" content="mashacorp-2022">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="DC.Languague" schemet="rfc1766" content="spanish">
    <meta property="og:locale" content="es_EC">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Global Cargo Ecuador">
    <meta property="og:description" content="Importación y Exportación Integral">
    <meta property="og:url" content="https://globalcargo-ec.com/">
    <meta property="og:site_name" content="Global Cargo Ecuador">

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css2/sb-admin-2.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="usuarios.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><?php echo $_SESSION['nombre']; ?> <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="usuarios.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Control General</span></a>
            </li>
<!-- MENU DE NAVEGACION PARA UN SUPER ADMIN DIMANICO CON CADA USUARIO  -->
    <?php if ($_SESSION['rol'] == "superAdmin"):?>
        <!-- MENU DE NAVEGACION - Gestion Global Cargo -->
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                EMPRESAS
            </div>
    
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Global Cargo</span>
                </a>
                <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Cargas:</h6>
                        <a class="collapse-item" href="./cargas_G.php">Registro</a>
                        <a class="collapse-item" href="./declarar_G.php">Declaración</a>
                        <a class="collapse-item" href="./consig_G.php">Despacho General</a>
                        <a class="collapse-item" href="./consig.php">Despacho Bodega</a>
                        <h6 class="collapse-header">Reportes:</h6>
                        <a class="collapse-item" href="./vercargas.php">Cargas</a>
                        <a class="collapse-item" href="./verprocesos.php">Estados y Documentos</a>
                    </div>
                </div>
            </li>
        <!-- FIN DE MENU GLOBAL CARGO - Gestion Global Cargo -->

        <!-- MENU DE NAVEGACION - Gestion Gc-Box Courier -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-cog"></i>
                    <!-- <i class="fas fa-fw fa-wrench"></i> -->
                    <span>GC-Box Courier</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Ingresos</h6>
                        <a class="collapse-item" href="utilities-color.html">Cargas</a>
                        <a class="collapse-item" href="utilities-border.html">Entregas</a>
                        <h6 class="collapse-header">Reportes</h6>
                        <a class="collapse-item" href="utilities-animation.html">Estados</a>
                        <a class="collapse-item" href="utilities-other.html">Por cliente</a>
                        <a class="collapse-item" href="utilities-other.html">Manifiestos</a>
                    </div>
                </div>
            </li>
        <!-- FIN DE MENU DE NAVEGACION - Gestion Gc-Box Courier -->

        <!-- MENU DE NAVEGACION - Gestion Gc-Trade -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2"
                    aria-expanded="true" aria-controls="collapseUtilities2">
                    <i class="fas fa-fw fa-cog"></i>
                    <!-- <i class="fas fa-fw fa-wrench"></i> -->
                    <span>Gc Trade</span>
                </a>
                <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities2"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- links de usuarios admin -->
                            <h6 class="collapse-header">Facturación:</h6>
                            <a class="collapse-item" href="facturar.php">Facturar y Registrar.</a>
                            <h6 class="collapse-header">Seguimiento:</h6>
                            <a class="collapse-item" href="vercargas.php">Manifiestos.</a>
                        <!-- fin de links admin  -->
                        <!-- links para usuarios de bodega y seguimiento -->
                            <h6 class="collapse-header">Gestion:</h6>
                            <a class="collapse-item" href="seguimiento.php">Historial</a>
                            <h6 class="collapse-header">BODEGA:</h6>
                            <a class="collapse-item" href="bodega_IS.php">Control de Ingreso</a>
                            <h6 class="collapse-header">Colaboradores:</h6>
                            <a class="collapse-item" href="reg_colab.php">Registrar</a>
                            <a class="collapse-item" href="consul_colab.php">Ver </a>
                        <!-- fin de lincs seguimiento -->

                    </div>
                </div>
            </li>
        <!-- FIN DE MENU DE NAVEGACION - Gestion Gc-Trade -->
             <!-- Divider -->
             <hr class="sidebar-divider">

        <!-- MENU DE NAVEGACION - Control Financiero -->
            <div class="sidebar-heading">
                CONTABILIDAD Y FINANCIERO
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities3"
                    aria-expanded="true" aria-controls="collapseUtilities3">
                    <i class="fas fa-fw fa-cog"></i>
                    <!-- <i class="fas fa-fw fa-wrench"></i> -->
                    <span>Financiero</span>
                </a>
                <div id="collapseUtilities3" class="collapse" aria-labelledby="headingUtilities3"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Registros:</h6>
                            <a class="collapse-item" href="depositos.php">Ingresar Depositos</a>
                        <h6 class="collapse-header">Seguimiento:</h6>
                            <a class="collapse-item" href="li_depositos.php">Estado de Cuenta</a>
                        <h6 class="collapse-header">Registro y movimiento financiero:</h6>
                            <a class="collapse-item" href="registro_fin.php">Ingreso de facturas</a>
                    </div>
                </div>
            </li>
        <!--  FIN DE MENU DE NAVEGACION - Control Financiero -->
    
             <!-- Divider -->
             <hr class="sidebar-divider">

        <!-- PATALLA DE DE VERIFICACION DE RECEPCION DE ORDENES -->
            <div class="sidebar-heading">
                EXTERNOS
            </div>

            <!-- Nav Item - Gestion Global Cargo -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo4"
                    aria-expanded="true" aria-controls="collapseTwo4">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Call Center</span>
                </a>
                <div id="collapseTwo4" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Control:</h6>
                        <a class="collapse-item active" href="CRUD_GLOBAL/registro.php"></a>
                        <a class="collapse-item" href="global/declarar.php">Declaración</a>
                        <a class="collapse-item" href="global/consig_G.php">Despacho General</a>
                        <a class="collapse-item" href="global/consig_G.php">Despacho Bodega</a>
                    </div>
                </div>
            </li>
        <!-- FIN DE PATALLA DE DE VERIFICACION DE RECEPCION DE ORDENES -->
            <!-- Divider -->
            <hr class="sidebar-divider">

        <!-- PANEL DE CONTROL SE HABILITA SOLAMENTE PARA LOS USUARIOS EN GENERAL-->
            <div class="sidebar-heading">
                PANEL DE CONTROL
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Corrección </span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Documentos:</h6>
                        <a class="collapse-item" href="login.html">Global Cargo</a>
                        <a class="collapse-item" href="register.html">Gc-Box</a>
                        <a class="collapse-item" href="forgot-password.html">Gc Trade</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2"
                    aria-expanded="true" aria-controls="collapsePages2">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Habilitar </span>
                </a>
                <div id="collapsePages2" class="collapse" aria-labelledby="headingPages2" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Ordenes:</h6>
                        <a class="collapse-item" href="login.html">Registro</a>
                        <a class="collapse-item" href="register.html">Facturación</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Control Api</span></a>
            </li>

        <!-- FIN DE PANEL DE CONTROL  SOLO PARA USUARIOS EN GENERAL-->
    <?php endif;?>
<!-- FIN DE MENU DE NAVEGACION PARA UN SUPER ADMIN DIMANICO CON CADA USUARIO  -->

<!-- MENU DE NAVEGACION PARA USUARIOS DE COORDINACION -->
    <?php if ($_SESSION['rol'] == "coordinacion"):?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            SEGUIMIENTO
        </div>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwox"
                aria-expanded="true" aria-controls="collapseTwox">
                <i class="fas fa-fw fa-cog"></i>
                <span>ACCION COMERCAL</span>
            </a>
            <div id="collapseTwox" class="collapse " aria-labelledby="headingTwox" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Dep. Comercial:</h6>
                    <a class="collapse-item" href="cotizador.php">Ingresar tarifas.</a>
                    <a class="collapse-item" href="ver_tarifas.php">Actualizar tarifas.</a>
                </div>
            </div>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Ordenes</span>
            </a>
            <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Actualización:</h6>
                    <a class="collapse-item" href="seguimiento_actu.php">Actualizar estados.</a>
                    <h6 class="collapse-header">Seguimiento:</h6>
                    <a class="collapse-item" href="vercargas.php">Control Genreal.</a>
                </div>
            </div>
            
        </li>
        <li class="nav-item">
            <?php 
                //CONSULTAR EL NOMBRE DEL ASESOR
                $nombre =  $_SESSION['nombre']." ".$_SESSION['apellido'];
            ?>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse00"
                aria-expanded="true" aria-controls="collapse00">
                <i class="fas fa-fw fa-cog"></i>
                <span>GC-GO Coordinacion</span>
            </a>
            <div id="collapse00" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Clientes:</h6>
                    <a class="collapse-item" href="ver_clientesgc.php">Ver registros.</a>
                    <h6 class="collapse-header">Paquetes:</h6>
                    <a class="collapse-item" href="ver_paquetesgc.php">Asignacion.</a>
                </div>
            </div>
        </li>
        <?php endif;?>
            <!-- CONTROL DE BODEGA Y PAQUETES POR CORREO FILTRO POR RESPONSABILIDAD DE GESTION -->
        <?php if ($_SESSION['usuario'] == "natalia@globalcargoecuador.com") : ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBODE"
                        aria-expanded="true" aria-controls="collapseBODE">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Control logistica</span>
                    </a>
                    <div id="collapseBODE" class="collapse " aria-labelledby="headingBODE" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Colaboradores:</h6>
                            <a class="collapse-item" href="reg_colab.php">Registrar</a>
                            <a class="collapse-item" href="consul_colab.php">Ver </a>
                            <h6 class="collapse-header">Control:</h6>
                            <a class="collapse-item" href="gest_colab.php">Gestion</a>
                            <h6 class="collapse-header">Bodega:</h6>
                            <a class="collapse-item" href="bodega_IS.php">Control de Ingreso</a>
                            <h6 class="collapse-header">Gestion:</h6>
                            <a class="collapse-item" href="seguimiento.php">Historial</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>GC-GO Coordinacion</span>
                    </a>
                    <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Clientes:</h6>
                            <a class="collapse-item" href="ver_clientesgc.php">Ver registros.</a>
                            <h6 class="collapse-header">Paquetes:</h6>
                            <a class="collapse-item" href="ver_paquetesgc.php">Asignacion.</a>
                        </div>
                    </div>
                </li>
        <?php endif ?>
        <?php if ($_SESSION['rol'] == "gerencia_paqueteria") : ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBODE"
                        aria-expanded="true" aria-controls="collapseBODE">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Control logistica</span>
                    </a>
                    <div id="collapseBODE" class="collapse " aria-labelledby="headingBODE" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Colaboradores:</h6>
                            <a class="collapse-item" href="reg_colab.php">Registrar</a>
                            <a class="collapse-item" href="consul_colab.php">Ver </a>
                            <h6 class="collapse-header">Control:</h6>
                            <a class="collapse-item" href="gest_colab.php">Gestion</a>
                            <h6 class="collapse-header">Bodega:</h6>
                            <a class="collapse-item" href="bodega_IS.php">Control de Ingreso</a>
                            <h6 class="collapse-header">Gestion:</h6>
                            <a class="collapse-item" href="seguimiento.php">Historial</a>
                            
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse00"
                        aria-expanded="true" aria-controls="collapse00">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>GC-GO Coordinacion</span>
                    </a>
                    <div id="collapse00" class="collapse " aria-labelledby="heading00" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Clientes:</h6>
                            <a class="collapse-item" href="ver_clientesgc.php">Ver registros.</a>
                            <h6 class="collapse-header">Paquetes:</h6>
                            <a class="collapse-item" href="ver_paquetesgc.php">Asignacion.</a>
                            <h6 class="collapse-header">Tarifas:</h6>
                            <a class="collapse-item" href="tarifas_paqueteria.php">Ingresar.</a>
                            <h6 class="collapse-header">Liquidaciones:</h6>
                            <a class="collapse-item" href="fin-gcgo.php">Estado de Cuenta</a>
                        </div>
                    </div>
                </li>
        <?php endif ?>
        <?php if ($_SESSION['usuario'] == "mailee@globalcargoecuador.com") : ?>   
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGest"
                    aria-expanded="true" aria-controls="collapseGest">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Facturas y Registro</span>
                </a>
                <div id="collapseGest" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Facturación:</h6>
                        <a class="collapse-item" href="facturar.php">Facturar y Registrar.</a>
                        <h6 class="collapse-header">Seguimiento:</h6>
                        <a class="collapse-item" href="vercargas.php">Manifiestos.</a>
                    </div>
                </div>
            </li>
        <?php endif ?>
        <!-- FI DE CONTROL DE BODEGA Y PAQUETES -->

<!-- MENU DE NAVEGACION PARA USUARIOS DE COORDINACION -->

<!-- MENU DE NAVEGACION PARA USUARIOS DE ADMIN -->
    <?php if ($_SESSION['rol'] == "admin"):?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                GESTIÓN FINANCIERA
            </div>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Facturas y Registro</span>
            </a>
            <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Facturación:</h6>
                        <a class="collapse-item" href="facturar.php">Facturar y Registrar.</a>
                    <h6 class="collapse-header">Seguimiento:</h6>
                        <a class="collapse-item" href="vercargas.php">Manifiestos.</a>
                </div>
            </div>
        </li>
        <!-- CONTROL DE BODEGA Y PAQUETES POR CORREO FILTRO POR RESPONSABILIDAD DE GESTION -->
            <?php if ($_SESSION['usuario'] == "andrea@globalcargoecuador.com") : ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBODE"
                        aria-expanded="true" aria-controls="collapseBODE">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Dep. Financiero</span>
                    </a>
                    <div id="collapseBODE" class="collapse " aria-labelledby="headingBODE" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Registros:</h6>
                            <a class="collapse-item" href="depositos.php">Ingresar Depositos</a>
                            <h6 class="collapse-header">Seguimiento:</h6>
                            <a class="collapse-item" href="li_depositos.php">Estado de Cuenta</a>
                            <h6 class="collapse-header">Registro y Movimiento:</h6>
                            <a class="collapse-item" href="registro_fin.php">Ingresos y Egresos</a>
                            <a class="collapse-item" href="ver_fin.php">Ver registros</a>
                            <h6 class="collapse-header">GC-GO Liquidaciones:</h6>
                            <a class="collapse-item" href="fin-gcgo.php">Estado de Cuenta</a>
                        </div>
                    </div>
                </li>
            <?php endif ?>
        <!-- FI DE CONTROL DE BODEGA Y PAQUETES -->
    <?php endif;?>

<!-- FIN MENU DE NAVEGACION -->

<!-- MENU DE NAVEGACION PARA USUARIOS DE SEGUIMIENTO -->
    <?php if ($_SESSION['rol'] == "seguimiento"):?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                SEGUIMIENTO
            </div>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Paquetes</span>
            </a>
            <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                <!-- <?php //if ($_SESSION['usuario'] == "luis@globalcargoecuador.com") : ?>
                    <h6 class="collapse-header">Gestion:</h6>
                        <a class="collapse-item" href="seguimiento.php">Historial</a>
                    <h6 class="collapse-header">Listados:</h6>
                        <a class="collapse-item" href="facturar.php">Ubicacion</a> -->
                <?php //elseif($_SESSION['usuario'] == "gissela@globalcargoecuador.com"): ?>
                    <h6 class="collapse-header">BODEGA:</h6>
                        <a class="collapse-item" href="bodega_IS.php">Control de Ingreso</a>
                        <a class="collapse-item" href="lista_pesos.php">Registrar pesos</a>
                    <h6 class="collapse-header">Paquetes:</h6>
                        <a class="collapse-item" href="ver_paquetesgc.php">Asignacion.</a>
                <?php //endif; ?>
                </div>
            </div>
        </li>
    <?php endif;?>
    <!-- navegacion de asesor comercial -->
        <?php if ($_SESSION['rol'] == "asesor") : ?>
                <li class="nav-item">
                    <?php 
                        //CONSULTAR EL NOMBRE DEL ASESOR
                        $nombre =  $_SESSION['nombre']." ".$_SESSION['apellido'];
                    ?>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>GC-GO Coordinacion</span>
                    </a>
                    <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Clientes:</h6>
                            <a class="collapse-item" href="ver_clientesgc.php?nombre=<?php echo $nombre?>">Ver registros.</a>
                            <a class="collapse-item" href="fin-gcgo.php?id=<?php echo $nombre?>">Estado de Cuenta</a>
                            <h6 class="collapse-header">Paquetes:</h6>
                            <a class="collapse-item" href="ver_paquetesgc.php?nombre=<?php echo $nombre?>">Asignacion.</a>
                            <?php if ($_SESSION['usuario'] == "domenica@globalcargoecuador.com") : ?>
                                <h6 class="collapse-header">BODEGA:</h6>
                                    <a class="collapse-item" href="lista_pesos.php">Registrar pesos</a>
                                <h6 class="collapse-header">Paquetes:</h6>
                                    <a class="collapse-item" href="ver_paquetesgc.php">Asignacion.</a>
                            <?php endif ?>
                        </div>
                    </div>
                </li>
        <?php endif ?>
    <!-- fin de navegacion de asesor comercial -->
<!-- FIN MENU DE NAVEGACION -->
    
        <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- BARRA DE BUSQUEDA GENERAL -->
                        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="post" action="../../sistema/USUARIOS/buscar.php">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                    aria-label="Search" aria-describedby="basic-addon2" name="buscar">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    <!-- FIN DE BARRA DE BUSQUEDA GENERAL -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Alerta de nuevas ordenes  -->
                                    <span class="badge badge-danger badge-counter">
                                        <?php 
                                            //require '../funciones.php';
                                            //require '../config/database.php';
                                            conectarDB();
                                            $db =conectarDB(); 
                                            
                                            //BASE DE DATOS BODEGA 
                                            conectarDB2();
                                            $db2 =conectarDB2();
                                        
                                            //conexion api
                                            conectarDB3();
                                            $db3 =conectarDB3();
                                            
                                            //coneccion callcenter
                                            conectarDB4();
                                            $db4 =conectarDB4();

                                            //CONTEO DE ORDENES NUEVAS, (ORDENES NUEVAS)
                                            $query_count = "SELECT COUNT(id) FROM orders WHERE status = 'requested';";
                                                $eje_query_count = mysqli_query($db3, $query_count);
                                                $ordenes_n = mysqli_fetch_assoc($eje_query_count);
                                            
                                            //Mostrar el numero de ordenes nuevas
                                            echo $ordenes_n['COUNT(id)'];
                                        ?>
                                    </span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    NOVEDADES!!
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="ordenes_N.php?consulta_v=requested">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Ordenes</div>
                                        <span class="font-weight-bold">Ver todas las ordenes ingresadas</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="seguimiento_actu.php">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Detalles y ordenes</div>
                                        Ver la orden completa, con detalles y productos.
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="despacho.php?consulta_v=facturado">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Empaques</div>
                                        Ver todas las ordenes PENDIENTES de EMPACAR.
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="despacho.php?consulta_v=empacado">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-info">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Despachos</div>
                                        Ver todas las ordenes por DESPACHADAS.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">nuevas funciones YA MISMO!!</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['nombre']; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../salir.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    CERRAR SESION
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->