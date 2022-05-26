<?php  
    $id = $_GET['id'] ?? NULL;
    $resultado = $_GET['resultado'] ?? null; 
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){
            $query = "DELETE FROM ingreso WHERE id = ${id}"; 
            //echo $query;
            //exit; 

            $resultado = mysqli_query($db2, $query);
            if($resultado){
                header('location: veringresos.php?resultado=1');
            }
        }

    }
?>

<div class="cajas__producto">
        <?php 
        $queryS = "SELECT marca, SUM(cCaja) FROM ingreso GROUP by (marca)";
        $total = mysqli_query($db2, $queryS);
        ?>
        <div class="datosactuales">
            <?php while($totalCajas = mysqli_fetch_assoc($total)):?>
            <p>Cajas de <a href="" class="suma"><?php echo $totalCajas["marca"]; ?> <?php echo $totalCajas["SUM(cCaja)"]; ?></a></p>
            <?php endwhile; ?>
        </div>
    </div>
<?php 
    //consultar los datos de la tabla general
    $query2 = "SELECT * FROM ingresog where id = ${id}";
    $consultaG = mysqli_query($db2, $query2);
?>


    <table class="form2 consulta__tabla">
    <h2 class="form__titulo titulo__pagina">DETALLE DE CARGAS E INGRESOS</h2>
    <p class="form2--p">
        INFORMACION GENERAL DE LA CARGA
    </p>
        <thead>
            <tr>
                <th>Numero de Guía</th>
                <th>Fecha de Ingreso</th>
                <th>Proveedor</th>
                <th>Cantidad de Cajas</th>
                <th>Producto</th>
            </tr>
        </thead>
        <tbody>
            <?php while($datos = mysqli_fetch_assoc($consultaG)):?>
                <tr>
                    <td><?php echo $datos['nGuia']; ?></td>
                    <td><?php echo $datos['fIngres']; ?></td>
                    <td><?php echo $datos['proveed']; ?></td>
                    <td><?php echo $datos['cCaja']; ?></td>
                    <td><?php echo $datos['produc']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>


    <?php 
    //consultar los datos de la tabla general
    $query2 = "SELECT * FROM ingreso where idIngresog = ${id} ORDER BY guia ";
    $consultaG = mysqli_query($db2, $query2);
?>
    <table class="form2 consulta__tabla">
    <p class="form2--p">
        INFORMACION GENERAL DE LA CARGA
    </p>
        <thead>
            <tr>
                <th>Marca</th>
                <th>Not Sanitaria</th>
                <th>Lote</th>
                <th>F Elaboracion</th>
                <th>F Vencimiento</th>
                <th>N Cajas</th>
                <th>N Unidades</th>
                <th>Vol Caja</th>
                <th>Vol Total</th>
                <th>Ubicación</th>
                <th>Observacion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($datos = mysqli_fetch_assoc($consultaG)):?>
                <tr>
                    <td><?php echo $datos['marca']; ?></td>
                    <td><?php echo $datos['notsanit']; ?></td>
                    <td><?php echo $datos['lote']; ?></td>
                    <td><?php echo $datos['fElab']; ?></td>
                    <td><?php echo $datos['fVenc']; ?></td>
                    <td><?php echo $datos['cCaja']; ?></td>
                    <td><?php echo $datos['cUnid']; ?></td>
                    <td><?php echo $datos['m3entrad']; ?></td>
                    <td><?php echo $datos['m3total']; ?></td>
                    <td><?php echo $datos['ubicac']; ?></td>
                    <td><?php echo $datos['observac']; ?></td>
                    <td>
                        <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $datos['id']; ?>">
                        <input type="submit" class="accion__eliminar" value="eliminar">
                        </form>
                        <div class="accion__actualizar">
                            <a href="actingreso.php?id=<?php echo $datos['id']; ?>" class="acciones__enlace">ACTUALIZAR</a>
                        </div>
                        <div class="accion__actualizar">
                            <a href="perchado.php?id=<?php echo $datos['id']; ?>" class="acciones__enlace">PERCHAR</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

<div class="boton__anidado">
        <a href="veringresos.php" class="enlace">salir sin guardar</a>
</div>
</html>