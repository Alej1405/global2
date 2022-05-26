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

    $auth = estaAutenticado();

    // // proteger la página
    if (!$auth) {
        header('location: index.php');
    }    
    
?>

<center><h1 class="titulo__pagina">ADMINISTRACION Y RECEPCION DE ORNDES</h1></center>

<div class="usuario">
    <h2 class="nombre__usuario">Hola que gusto tenere por aquí<?php echo $_SESSION['nombre']; ?>.</h2>
</div>
<div class="enlaces">
    <fieldset class="marco">
                <legend class="empresa">REGISTRO Y REPORTE DE ORDENES</legend>
        <div class="contenedor__enlaces">
            <div class="usuario__enlaces">
                <div class="enlace--boton lecturaPrin">
                    <a href="callcenter/ordenesgenerales.php?pagina=1" class="enlace">
                        GESTION DE ORDENES POR FECHA
                    </a>
                </div>
                <div class="enlace--boton">
                    <a href="callcenter/porNorden_call.php?pagina=1" class="enlace">
                        FILTAR POR NUMERO DE ORDEN
                    </a>
                </div>
                <div class="enlace--boton">
                    <a href= "callcenter/porCiudad_call.php?pagina=1" class="enlace">
                        FILTRAR POR CIUDAD
                    </a>
                </div>
            
        
                <div class="lecturaSec">
                    <a href="callcenter2.php" class="enlace">
                        API LLAMADAS GENERALES
                    </a>
                </div>
                <div class="lecturaSec">
                    <a href="callcenter/porEstado.php?pagina=1" class="enlace">
                        CONSULTAR ESTADOS DE ORDEN
                    </a>
                </div>
                <div class="lecturaSec">
                    <a href="callcenter/apiosegllamadas.php?pagina=1" class="enlace">
                        ORDENES PARA SEGUNDA LLAMADA
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