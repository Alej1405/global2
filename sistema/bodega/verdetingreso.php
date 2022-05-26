<?php  
    $resultado = $_GET['resultado'] ?? null; 
    $id = $_GET['id'] ?? NULL;
    $id = filter_var($id, FILTER_VALIDATE_INT);
    
    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    //BASE DE DATOS GLOBAL CARGO
    conectarDB();
    $db =conectarDB();
    $auth = estaAutenticado();
    //BASE DE DATOS BODEGA 
    conectarDB2();
    $db2 =conectarDB2();

    //proteger la página
    if (!$auth) {
        header('location: ../global/index.php');
    }

    $errores = [];
    $mensaje = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        

    }
?>
<?php 
    //consultar los datos de la tabla general
    $query2 = "SELECT * from ingresog INNER JOIN ingreso on ingresog.id = ingreso.idIngresog order by nGuia";
    $consultaG = mysqli_query($db2, $query2);
?>
    <table class="form2 consulta__tabla">
        <center><h2 class="form__titulo titulo__pagina">REPORTE DE INGRESOS DETALLADOS</h2></center>
        <p class="form2--p">
        INFORMACION GENERAL DE LA CARGA
    </p>
        <thead>
            <tr>
                <th>Numero de Guía</th>
                <th>Marca</th>
                <th>QT Cajas</th>
                <th>QT Unidades</th>
                <th>Vol TOTAL</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php while($datos = mysqli_fetch_assoc($consultaG)):?>
                <tr>
                    <td><?php echo $datos['nGuia']; ?></td>
                    <td><?php echo $datos['marca']; ?></td>
                    <td><?php echo $datos['cCaja']; ?></td>
                    <td><?php echo $datos['cUnid']; ?></td>
                    <td><?php echo $datos['m3total']; ?></td>
                    <td>
                        <div class="accion__actualizar">
                            <a href="perchado.php?id=<?php echo $datos['id']; ?>" class="acciones__enlace">PERCHAR</a>
                        </div>
                        <div class="accion__actualizar">
                            <a href="detpercha.php?id=<?php echo $datos['id']; ?>" class="acciones__enlace">DETALLE</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div class="boton__anidado">
        <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
    </div>
</html>