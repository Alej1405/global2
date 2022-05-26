<?php 
    $id = $_GET['id'] ?? null;
    $id = filter_var($id, FILTER_VALIDATE_INT);

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    //coneccion de sesion
    conectarDB();
    $db =conectarDB();

    //BASE DE DATOS BODEGA 
    conectarDB2();
    $db2 =conectarDB2();

    //coneccion api
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
    $query = "SELECT * FROM datosordenes WHERE estado = 'facturado'";
    $resultado = mysqli_query($db4, $query);
?>

<center>
    <h1>DESPACHOS</h1>
</center>
<center>
            <div class="contenedor__enlaces">
                <div class="usuario__enlaces">
                    <div class="enlace--boton">
                        <a href="../adminBodega.php" class="enlace">REGRESAR AL INICIO </a>
                    </div>
                </div>
            </div>
</center>
<fieldset class="form2 consulta__tabla">
    <legend>ORDEN DE DESPACHO</legend>
    <table class="form2 consulta__tabla" >
        <thead>
            <tr>
                <th>Número de Orden</th>
                <th>Nombre</th>
                <th>Teleonos</th>
                <th>Provincia</th>
                <th>Ciudad</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php while($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <td>
                        <?php echo $resultadoApi['order_id']; ?></td>
                    <td>
                        <?php echo $resultadoApi['name'] . " ". $resultadoApi['last_name']. " " . $resultadoApi['nombres']; ?></td>
                    <td>
                        <?php echo $resultadoApi['phone']."/".$resultadoApi['telefono']; ?></td>
                    <td>
                        <?php echo $resultadoApi['province']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['city']; ?>
                    </td>
                    <td>
                        <div class="accion__actualizar" >
                            <a  href="despachar.php?id=<?php echo $resultadoApi['id']; ?>" class="acciones__enlace"> DESPACHAR</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>