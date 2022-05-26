<?php 
    $resultado = $_GET['resultado'] ?? null; 
    //incluye el header
    require '../includes/funciones.php';
    incluirTemplate('headersis');

    //coneccion a la base de datos
    require '../includes/config/database.php';
    conectarDB();
    $db =conectarDB();
    conectarDB2();
    $db2 =conectarDB2();

    $auth = estaAutenticado();

    // // proteger la página
    // if (!$auth) {
    //     header('location: global/index.php');
    // }    
    
?>



<div class="usuario">
    <h2 class="nombre__usuario">Hola! que gusto tenerte por aquí <?php echo $_SESSION['nombre']; ?>.</h2>
    <p class="bienvenida">
        Si estás aquí recuerda que tu responsabilidad es grande, confiamos en tu trabajo y en tu capacidad!!
    </p>

    <div class="datosactuales">
        <div class="cajastotales">
            <?php 
                $query6 = "SELECT COUNT(id) FROM ingreso";
                $cargasT = mysqli_query($db2, $query6);
                $cargastotales = mysqli_fetch_assoc($cargasT);
                // echo "<pre>";
                // var_dump($cargastotales);
                // echo "</pre>";
            ?>
            <p>Numero de trámites consignados <a href="bodega/veringresos.php" class="suma">ver <?php echo $cargastotales["COUNT(id)"];?></a></p>
                <?php 
                $query6 = "SELECT SUM(cCaja) FROM ingreso";
                $cargasT = mysqli_query($db2, $query6);
                $cargastotales = mysqli_fetch_assoc($cargasT);
                // echo "<pre>";
                // var_dump($cargastotales);
                // echo "</pre>";
            ?>
            <p>Numero de Cajas en bodega <a href="" class="suma"><?php echo $cargastotales["SUM(cCaja)"];?> Cajas</a></p>

            <?php 
                $query6 = "SELECT SUM(m3total) FROM ingreso";
                $cargasT = mysqli_query($db2, $query6);
                $cargastotales = mysqli_fetch_assoc($cargasT);
                // echo "<pre>";
                // var_dump($cargastotales);
                // echo "</pre>";
            ?>
            <p>Volumen ingresaso en bodega <a href="" class="suma"><?php echo $cargastotales["SUM(m3total)"];?></a> métros cúbicos</p>
            
        </div>
    </div>

    <?php if(intval($resultado) === 1 ): ?>
        <p class="alerta2">EL USUARIO HA SIDO AGREGADO CON ÉXITO</p>
    <?php elseif(intval($resultado) === 2 ): ?>
        <p class="alerta">EL PROCESO SE REGISTRÓ CON ÉXITO</p>
    <?php endif ?>
</div>

<div class="enlaces">
    <fieldset class="marco">
        <legend class="empresa">LISTADO DE CARGAS POR LLEGAR</legend>
        <table class="form2 consulta__tabla">
            
            <thead>
                <tr>
                    <th>Numero de Guia</th>
                    <th>Fecha de Ingreso</th>
                    <th>Producto</th>
                    <th>Proveedor</th>
                    <th>Cantidad de cajas</th>
                    <th>Metros cúbicos Totales</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php //consultar appi
                    $query = "SELECT * FROM ingresog ORDER BY fIngres DESC LIMIT 2;";
                    $consultaApi = mysqli_query($db2, $query); ?>
                <?php while( $consulta = mysqli_fetch_assoc($consultaApi)):
                    $consulta['idCarga'];
                    ?>
                <tr>
                        
                    <td>
                        <a href="../respaldos/<?php echo $consul['guia']; ?>#toolbar=1&navpanes=1&scrollbar=0" target="blanck" class="tabla__archivos"><?php echo $consulta['nGuia']; ?> ↓</a>
                    </td>
                    <td><?php echo $consulta['fIngres']; ?></td>
                    <td><?php echo $consulta['produc']; ?></td>
                    <td><?php echo $consulta['proveed']; ?></td>
                    <td><?php echo $consulta['cCaja']; ?></td>
                    <td><?php echo $consulta['m3total']; ?></td>
                    <td>
                        <div class="accion__actualizar">
                            <a href="bodega/detalle_ing.php?id=<?php echo $consulta['id']; ?>" class="acciones__enlace">INGRESAR</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="botones-fin">
            <div class="enlace--boton">
                <a href="bodega/veringresos.php" class="enlace">VER TRAMITES CONSIGNADOS</a>
            </div>
            <div class="enlace--boton">
                <a href="bodega/ingprod.php" class="enlace">REGISTRAR NUEVO PRODUCTO</a>
            </div>
            <div class="enlace--boton">
                <a href="bodega/verdetingreso.php" class="enlace">VER INGRESOS REALIZADOS</a>
            </div>
            <div class="enlace--boton">
                <a href="bodega/productos.php" class="enlace">PRODUCTOS</a>
            </div>
            <div class="enlace--boton">
                <a href="bodega/descargaexcel.php" class="enlace">DESCARGAR PRODUCTOS</a>
            </div>
        </div>
        <div class="botones-fin">
            <div class="enlace--boton">
                <a href="bodega/reingreso.php" class="enlace">RE-INGRESO DE PRODUCTOS</a>
            </div>
            <div class="enlace--boton">
                <a href="bodega/inventario.php" class="enlace">INVENTARIO</a>
            </div>
            <div class="enlace--boton">
                <a href="bodega/ingubic.php" class="enlace">CREAR UBUCACION</a>
            </div>
        </div>

        <div class="botones-fin">
            <div class="enlace--boton">
                <a href="bodega/liquidacion_bod.php" class="enlace">LIQUIDACION</a>
            </div>
            <div class="enlace--boton">
                <a href="bodega/porNorden_gc.php" class="enlace">DESPACHO POR N-ORDEN</a>
            </div>
            <div class="enlace--boton">
                <a href="callcenter/porNorden_id.php" class="enlace">DESPACHO POR N-SEGUIMEINTO</a>
            </div>
            <div class="enlace--boton">
                <a href="bodega/ordenes.php" class="enlace">DESPACHO GENERAL</a>
            </div>
            <div class="enlace--boton">
                <a href="bodega/manifiestoDiario.php" class="enlace">MANIFIESTO DIARIO</a>
            </div>
        </div>
    </fieldset>
</div>


<div class="botones-fin">
    
        <div class="enlace--boton salir">
            <a href="../../includes/salir.php" class="enlace">BOTON DE AUTO DESTRUCCION</a>
        </div>
        <div class="enlace--boton lectura">
            <a href="bodega/veringresos.php" class="enlace">CONSULTAR SISTEMA RUSIA</a>
        </div>
</div>