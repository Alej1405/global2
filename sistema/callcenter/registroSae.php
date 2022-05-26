<?php 
    $mensaje = $_GET['resultado'] ?? null; 

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    //coneccion de sesion
    conectarDB();
    $db =conectarDB();

    //BASE DE DATOS BODEGA 
    conectarDB2();
    $db2 =conectarDB2();

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
    $query = "SELECT * FROM datosordenes WHERE estado = 'no'";
    $resultado = mysqli_query($db4, $query);
    
    
?>

<center><h1 class="titulo__pagina">LISTADO DE CLIENTES PARA REGISTRAR</h1></center>

<center>
            <div class="contenedor__enlaces">
                <div class="usuario__enlaces">
                    <div class="enlace--boton">
                        <a href="../admin.php" class="enlace">REGRESAR AL INICIO </a>
                    </div>
                </div>
            </div>
</center>

<fieldset class="form2 consulta__tabla">
    <legend>INGRESO / REGISTRO DE CLIENTES SISTEMA SAE (facturacion)</legend>
    <table class="form2 consulta__tabla" >
        <thead>
            <tr>
                <th>Número de Orden</th>
                <th>Nombre de compra / Nombre de facturacion</th>
                <th>Total</th>
                <th>Forma de Pago</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php while($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <td> <?php echo $resultadoApi['order_id']; ?></td>
                    <td><?php echo $resultadoApi['name'] . " ". $resultadoApi['last_name']. " / " . $resultadoApi['nombres']; ?></td>
                    <td><?php echo $resultadoApi['total']; ?></td>
                    <td><?php echo $resultadoApi['metodoPago']; ?></td>
                    <td>
                            <div class="accion__actualizar" >
                                <a  href="../bodega/registroCliente.php?id=<?php echo $resultadoApi['id']; ?>" class="acciones__enlace"> VER DETALLE</a>
                            </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>

                        
                    