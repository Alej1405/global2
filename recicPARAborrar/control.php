<?php 
    //incluye el header
    require '../includes/funciones.php';
    incluirTemplate('headersis');

    //coneccion a la base de datos
    require '../includes/config/database.php';
    conectarDB();
    $db =conectarDB();

    $auth = estaAutenticado();

    // // proteger la página
    if (!$auth) {
        header('location: index.php');
    }    
    
?>
<div class="usuario">
    <h2 class="nombre__usuario">Hola que gusto tenere por aquí<?php echo $_SESSION['nombre']; ?>.</h2>
</div>
<div class="usuario__enlaces">
    <div class="enlace--boton">
        <a href="global/cliente.php" class="enlace">REGISTRO DE CLIENTES</a>
    </div>
    <div class="enlace--boton">
        <a href="global/cargas.php" class="enlace">RESGISTRO DE CARGA</a>
    </div>
    <div class="enlace--boton">
        <a href="" class="enlace">DECLARAR CARGA</a>
    </div>
    <div class="enlace--boton">
        <a href="" class="enlace">DESPACHAR CARGA</a>
    </div>
    <div class="enlace--boton">
        <a href="" class="enlace">VER CLIENTES</a>
    </div>
    <div class="enlace--boton">
        <a href="" class="enlace">ESTADO DE CARGAS</a>
    </div>
    <div class="enlace--boton">
        <a href="" class="enlace">REPORTE DE CARGAS</a>
    </div>
    <div class="enlace--boton">
        <a href="" class="enlace">INFORME DE DESPACHOS</a>
    </div>
</div>