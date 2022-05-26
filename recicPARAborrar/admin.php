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
                <legend class="empresa">GLOBAL CARGO</legend>
            <div class="contenedor__enlaces">
                <div class="usuario__enlaces">
                    <div class="enlace--boton">
                        <a href="global/cliente.php" class="enlace">REGISTRO DE CLIENTES</a>
                    </div>
                    <div class="enlace--boton">
                        <a href="global/cargas.php" class="enlace">REGISTRO DE CARGA</a>
                    </div>
                    <div class="enlace--boton">
                        <a href="global/declarar.php" class="enlace">INGRESAR PROCESO</a>
                    </div>
                    <div class="enlace--boton">
                        <a href="global/consig.php" class="enlace">CONSIGNAR CARGA GC-TRADE</a>
                    </div>
                </div>
                <div class="usuario__enlaces">
                    <div class="enlace--boton lectura">
                        <a href="globalverclientes.php" class="enlace">VER PRE ORDENES</a>
                    </div>
                    <div class="enlace--boton lectura">
                        <a href="global/vercargas.php" class="enlace">ESTADO DE CARGAS</a>
                    </div>
                    <div class="enlace--boton lectura">
                        <a href="global/verprocesos.php" class="enlace">REPORTE DE PROCESOS</a>
                    </div>
                    <div class="enlace--boton lectura">
                        <a href="" class="enlace">DESPACHOS GENERALES</a>
                    </div>
                </div>
            </div>
        </fieldset>
</div>
<div class="enlaces">
        <fieldset class="marco">
                <legend class="empresa">REGISTRO Y FACTURACION GC-BOX</legend>
            <div class="contenedor__enlaces">
                <div class="usuario__enlaces">
                    <div class="enlace--boton">
                        <a href="callcenter/registroSae.php" class="enlace">REGISTRAR FACTURA DE CLIENTE </a>
                    </div>
                    <div class="enlace--boton">
                        <a href="callcenter/verificacion.php" class="enlace">FACTURAR PEDIDOS</a>
                    </div>
                    <div class="enlace--boton">
                        <a href="callcenter/porNorden_gc.php" class="enlace">FILTRAR POR NUMERO DE ORDEN</a>
                    </div>
                </div>
            </div>
        </fieldset>
</div>

    <div class="botones-fin">
        <div class="enlace--boton salir">
            <a href="#" class="enlace">SALIR</a>
        </div>
    </div>