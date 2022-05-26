<?php 

    $resultado = $_GET['resultado'] ?? null; 
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

<center><h1 class="titulo__pagina">COORDINACION LOGISTICA</h1></center>

<div class="usuario">
    <h2 class="nombre__usuario">Hola! que gusto tenerte por aquí <?php echo $_SESSION['nombre']; ?>.</h2>
    <p class="bienvenida">
        Si estás aquí recuerda que tu responsabilidad es grande, confiamos en tu trabajo y en tu capacidad!!
    </p>
    <?php if(intval($resultado) === 1 ): ?>
        <p class="alerta2">EL USUARIO HA SIDO AGREGADO CON ÉXITO</p>
    <?php elseif(intval($resultado) === 2 ): ?>
        <p class="alerta2">EL PROCESO SE REGISTRÓ CON ÉXITO</p>
    <?php endif ?>
</div>
<div class="enlaces">
        <fieldset class="marco">
                <legend class="empresa">GC-COURIER / PAQUETERIA PROCESO Y CONTROL</legend>
            <div class="contenedor__enlaces">
                <div class="usuario__enlaces">
                    <div class="enlace--boton">
                        <a href="callcenter/porNorden_gc.php" class="enlace" target="blanck">FILTRAR POR NUMERO DE ORDEN</a>
                    </div>
                    <div class="enlace--boton">
                        <a href="callcenter.php" class="enlace" target="blanck">LISTADO GENERAL DE OREDENES</a>
                    </div>
                    <div class="enlace--boton">
                        <a href= "callcenter/porCiudad.php?pagina=1" class="enlace" target="blanck">
                            FILTRAR POR CIUDAD
                        </a>
                    </div>
                    
                    <div class="enlace--boton">
                        <a href="bodega/porNorden_gc.php" class="enlace">DESPACHO POR N-ORDEN</a>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
    <div class="botones-fin">
        <div class="enlace--boton salir">
            <a href="#" class="enlace">SALIR</a>
        </div>
    </div>