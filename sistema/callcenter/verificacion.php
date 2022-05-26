<?php 
    $mensaje = $_GET['resultado'] ?? null; 

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    //coneccion de sesion
    conectarDB();
    $db =conectarDB();

    //coneccion callcenter
    conectarDB3();
    $db3 =conectarDB3();

    //coneccion callcenter
    conectarDB4();
    $db4 =conectarDB4();

    $auth = estaAutenticado();

    // proteger la página
    if (!$auth) {
        header('location: index.php');
    }

    //consulta general de datos para facturar 
    $query = "SELECT * FROM datosordenes WHERE estado = 'REGISTRADO'";
    $resultado = mysqli_query($db4, $query);
    
    
?>

    <?php if(intval($mensaje) === 1 ): ?>
        <p class="alerta2">DATOS ENVIADOS CORRECTAMENTE</p>
    <?php endif ?>
    <fieldset class="form2 consulta__tabla">
        
    <div class="botones-fin">
        <div class="enlace--boton salir">
            <a href="../../includes/salir.php" class="enlace">SALIR DEL SISTEMA</a>
        </div>
        <div class="enlace--boton lectura">
            <a href="callcenter/datosmanual.php" class="enlace">CIERTOS DATOS GENERALES</a>
        </div>
    </div>
    <legend>VERIFICACION DE PAGOS</legend>

    <?php //consulta general de datos
    $trasf = "REGISTRADO";
    $query9 = "SELECT * FROM datosordenes WHERE estado = '${trasf}'";
    $resultado9 = mysqli_query($db4, $query9);?>

    <table class="form2 consulta__tabla" >
        
        <thead>
            <tr>
                <th>NUMERO DE ORDEN</th>
                <th>TOTAL A PAGAR</th>
                <th>CORREO</th>
                <th>TELÉFONO</th>
                <th>VERIFICAR</th>
            </tr>
        </thead>
        <tbody>
            <?php while($resultadoApi9 = mysqli_fetch_assoc($resultado9)) : ?>
                <tr>
                    <td><?php echo $resultadoApi9['order_id']; ?></td>
                    <td>$<?php $total2 =filter_var( $resultadoApi9['total'], FILTER_VALIDATE_FLOAT); echo $total2;?></td>
                    <td><?php echo $resultadoApi9['correo']; ?></td>
                    <td><?php echo $resultadoApi9['telefono']; ?></td>
                    <td>
                        <div class="accion__actualizar" >
                            <a  href="facturar.php?id=<?php echo $resultadoApi9['id']; ?>" class="acciones__enlace">FACTURAR</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>

                        
                    