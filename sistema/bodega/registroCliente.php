<?php 
    $id = $_GET['id'];
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

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id_orden = $id; 
        $order_id = $_POST['order_id'];
        $n_manifiesto = $_SESSION['usuario'];
        $fecha_proceso = date('y-m-d h:i:s');
        $registrado = "REGISTRADO";

            $query = "INSERT INTO registro (order_id, id_orden, n_manifiesto, fecha_proceso) 
                values ('$order_id', '$id_orden', '$n_manifiesto', '$fecha_proceso'  )";
                $guardar = mysqli_query($db4, $query);
            
            $query3 = "UPDATE datosordenes SET estado = '${registrado}' where id = ${id}";
                $resultado2 = mysqli_query($db4, $query3);

            if($resultado2){
                header('location:../callcenter/registroSae.php ');
            }
    }
?>

<center><h1 class="titulo__pagina">REGISTRO DE CLIENTE PARA FACTURACION</h1></center>
<form action=" " method="post">


    <!-- <div class="container2">
        <div class="form__container form2">
            
        </div>
        <div class="form__container form2">
            
        </div>
    </div> -->
    <br>
    
    <center>
        <div class="botones">
            <input type="submit" class="form__submit" value="GUARDAR">
        </div>
    </center>

<fieldset class="form2 consulta__tabla">
<legend>DATOS DE LA VENTA</legend>
        
    <table class="form2 consulta__tabla">
        <thead>
            <tr>
                <th>NOMBRE Y APELLIDO</th>
                <th>NUMERO DE ORDEN</th>
                <th>PROVINCIA</th>
                <th>CIUDAD</th>
                <th>DIRECCION EN LA ORDEN</th>
                <th>TELEFONOS</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $queryPro9 = "SELECT * FROM datosordenes WHERE datosordenes.id = ${id}";
            $reultadoPro5 = mysqli_query($db4, $queryPro9);
            while($orderProduct5 = mysqli_fetch_assoc($reultadoPro5)):?>
            <tr>
                <input type="text" hidden name="order_id" value="<?php echo $orderProduct5['order_id'];?>">
                <td><?php echo $orderProduct5['name']. " ". $orderProduct5['last_name']; ?></td>
                <td><?php echo $orderProduct5['order_id']; ?></td>
                <td><?php echo $orderProduct5['province']; ?></td>
                <td><?php echo $orderProduct5['city']; ?></td>
                <td><?php echo $orderProduct5['address']; ?></td>
                <td><?php echo $orderProduct5['phone'];  ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>

<fieldset class="form2 consulta__tabla">
<legend>DATOS PARA FACTURACION</legend>
        
    <table class="form2 consulta__tabla">
        <thead>
            <tr>
                <th>NUMERO DE SEGUIMIENTO</th>
                <th>NOMBRE Y APELLIDO</th>
                <th>NUMERO DE CEDULA</th>
                <th>OBSERVACION</th>
                <th>CIUDAD</th>
                <th>DIR CONFIRMADA</th>
                <th>TELEFONOS</th>
                <th>CORREO</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $queryPro9 = "SELECT * FROM datosordenes WHERE datosordenes.id = ${id}";
            $reultadoPro5 = mysqli_query($db4, $queryPro9);
            while($orderProduct5 = mysqli_fetch_assoc($reultadoPro5)):?>
            <tr>
                <td><?php echo $orderProduct5['id']; ?></td>
                <td><?php echo $orderProduct5['nombres'];?></td>
                <td><?php echo $orderProduct5['cedula'];?></td>
                <td><?php echo $orderProduct5['observacion']; ?></td>
                <td><?php echo $orderProduct5['city']; ?></td>
                <td><?php echo $orderProduct5['direccion']; ?></td>
                <td><?php echo $orderProduct5['telefono'];  ?></td>
                <td><?php echo $orderProduct5['correo'];  ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>
    
</form>

<div class="boton__anidado">
        <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
    </div>