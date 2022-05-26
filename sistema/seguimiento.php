<?php
    // pagina de inicio para el portal de callcenter
    // esta pagina esta vinculada directamente al inicio de la sesion de callcenter.
    // Las opciones que estaran disponibles seran todas las que se refiere a el ingreso de llamadas
    // de esta forma se genera un control de seguimiento.

    //incluye el header
    require '../includes/funciones.php';
    incluirTemplate('headersis');

    //coneccion a la base de datos
    require '../includes/config/database.php';
    conectarDB();
    $db =conectarDB();

    //coneccion callcenter
    conectarDB4();
    $db4 =conectarDB4();

    $auth = estaAutenticado();

    // // proteger la página
    if (!$auth) {
        header('location: index.php');
    }    
    
?>

<center><h1 class="titulo__pagina">SEGUIMIENTO Y CONTROL DE CARGAS CLIENTE <b>"SMART COSMETIC S.A."</b></h1></center>

            <?php 
                $query6 = "SELECT COUNT(order_id) FROM datosordenes";
                $cargasT = mysqli_query($db4, $query6);
                $cargastotales = mysqli_fetch_assoc($cargasT);
                // echo "<pre>";
                // var_dump($cargastotales);
                // echo "</pre>";
            ?>
            <p>Numero de Cajas en bodega <?php echo $cargastotales["COUNT(order_id)"];?></p>


<div class="usuario">
    <h2 class="nombre__usuario">Hola que gusto tenere por aquí <b><?php echo $_SESSION['nombre']; ?></b>.</h2>
</div>
<div class="enlaces">
    <fieldset class="marco">
                <legend class="empresa">REGISTRO Y REPORTE DE ORDENES</legend>
        <div class="contenedor__enlaces">
            <div class="usuario__enlaces">
                <div class="enlace--boton lecturaPrin">
                    <a href="callcenter/porfechaGest.php?pagina=1" class="enlace">
                       ORDENES PROCESADAS Y POR PROCESAR.
                    </a>
                </div>
                <div class="enlace--boton">
                    <a href="callcenter/porfechaReg.php?pagina=1" class="enlace">
                        CONTROL POR FECHA DE REGISTRO
                    </a>
                </div>
                <div class="enlace--boton">
                    <a href= "callcenter/resCall.php?pagina=1" class="enlace">
                        EFECTIVIDAD DE CONTACTOS
                    </a>
                </div>
                <div class="enlace--boton">
                    <a href= "callcenter/porEstado.php?pagina=1" class="enlace">
                        ESTADO DE OREDENES
                    </a>
                </div>
            </div>
            <div class="usuario__enlaces">
                <div class="enlace--boton">
                    <a href= "adminBodega.php?pagina=1" class="enlace">
                        CONTROL DE BODEGA
                    </a>
                </div>
                <div class="enlace--boton">
                    <a href= "callcenter/informeNovedaes.php?pagina=1" class="enlace">
                        INFORME DE NOVEDADES DIARIAS
                    </a>
                </div>
                <div class="enlace--boton">
                    <a href= "bodega/controlseguimiento.php?pagina=1" class="enlace">
                        CONTROL Y SEGUIMIENTO
                    </a>
                </div>
                <div class="enlace--boton">
                    <a href= "bodega/procesodellamadas.php?pagina=1" class="enlace">
                        CONTROL DE LLAMDAS
                    </a>
                </div>
            </div>
        </div>
    </fieldset>
</div>
<center>
    <div class="enlace--boton salir">
        <a href="../includes/salir.php" class="enlace">BOTON DE AUTO DESTRUCCION</a>
    </div>
</center>