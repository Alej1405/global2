<?php 
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    //coneccion de sesion
    conectarDB();
    $db =conectarDB();

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
    $query2 = "SELECT * FROM order_clients where order_id = ${id}";
            $resultado2 = mysqli_query($db3, $query2);

    $query = "SELECT * FROM orders where id = ${id}";
            $resultado = mysqli_query($db3, $query);


    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //echo "sienvia";

        $id_orders = $id;
        $order_id = mysqli_real_escape_string($db, $_POST['order_id'] );
        $observacion = mysqli_real_escape_string($db, $_POST['observacion'] );
        $factura = $_FILES['num_fac'];
        $guiaRem = $_FILES['guiaRem'];
        $estado = "facturado";
        $comprobante = null;

        if(!$observacion) {
            $errores[] = "Si no hay observacion, pon no hay y listo";
        }
        if(empty($errores)){

            /**SUBIR ARCHIVOS A LA BASE DE DATOS */
            // Crear carpeta

            $facturas = '../../facturas/';

            if(!is_dir($facturas)){
                mkdir($facturas);
            }
            $nombreFactura = md5( uniqid( rand(), true)).".pdf";
            $nombreGuia = md5( uniqid( rand(), true)).".pdf";
            //subir los archivos
            move_uploaded_file($factura['tmp_name'], $facturas . $nombreFactura);
            move_uploaded_file($guiaRem['tmp_name'], $facturas . $nombreGuia);

            //guardar datos

            $query = "INSERT INTO facturas (id_orders, order_id, num_fact, guiaRem, estado, observacion) 
            values ('$id_orders', '$order_id', '$nombreFactura', '$nombreGuia', '$estado', '$observacion')";

            echo $query; 
            $guardar = mysqli_query($db4, $query);

            if($guardar){
                echo "se guardo";
            }
                $id_orders = $id;
                $verif = null;
                //actualizar el estado para el filtro
                $query4 = " UPDATE verificacion SET facturado = '${id}'
                                                    WHERE contactado = ${id}";
                $actualizar = mysqli_query($db4, $query4);
                if($actualizar){
                    $facturado = "facturado";
                    $query5 = " UPDATE datosordenes SET estado = '${facturado}'
                                                    WHERE id = ${id}";
                    $actualizar5 = mysqli_query($db4, $query5);
                    if ($actualizar5 == true){
                        header('location: ../facturacion.php?resultado=1');
                    }
                }

        }

    }

    //consulta general para el updete
    $queryGenereal = "SELECT * FROM datosordenes WHERE id = ${id}";
    $consultaGeneral = mysqli_query($db4, $queryGenereal);
    $general = mysqli_fetch_assoc($consultaGeneral);

    //consulta para los detalles del producto
    $queryProduct = "SELECT SUM(quantity) FROM order_products WHERE order_id = ${id}";
    $consultaProduct = mysqli_query($db3, $queryProduct);
    $product = mysqli_fetch_assoc($consultaProduct);

?>

<center><h1 class="titulo__pagina">DATOS PARA A FACTURA</h1></center>
<form action=" " method="post" enctype="multipart/form-data">
    <div class="container2">
        <div class="form__container form2">
            <div class="form__grupo">
                <input type="file" name="num_fac" id="num_fac"class="form__input" placeholder=" " value="<?php echo $product["SUM(quantity)"];?>" >
                <label for="num_fac" class="form__label">Adjuntar la factura</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="file" name="guiaRem" id="guiaRem"class="form__input" placeholder=" " value="<?php echo $product["SUM(quantity)"];?>" >
                <label for="guiaRem" class="form__label">Adjuntar la Guia de Remision</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" readonly name="nombres" id="nombres"class="form__input" placeholder=" " value="<?php echo $general['phone']. " / ". $general['telefono'];?>" >
                <label for="nombres" class="form__label">Número de teléfono</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" readonly name="nombres" id="nombres"class="form__input" placeholder=" " value="<?php echo $general['name']. " ". $general['last_name'];?>" >
                <label for="nombres" class="form__label">Nombre de la orden</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" readonly name="cedula" id="cedula"class="form__input" placeholder=" " value="<?php echo $general['nombres'];?>" >
                <label for="cedula" class="form__label">Nonmre a Facturar</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" readonly name="cedula" id="cedula"class="form__input" placeholder=" " value="<?php echo $general['cedula'];?>" >
                <label for="cedula" class="form__label">Número de cedula</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" readonly name="cedula" id="cedula"class="form__input" placeholder=" " value="<?php echo $general['address'];?>" >
                <label for="cedula" class="form__label">Direccion de la Orden</label>
                <span class="form__linea"></span>
            </div>          
        </div>
        <div class="form__container form2">
            <div class="form__grupo">
                <input type="email" readonly name="correo" id="correo"class="form__input" placeholder=" " value="<?php echo $general['correo'];?>" >
                <label for="correo" class="form__label">Correo para envío de Factura</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" readonly name="telefono" id="telefono"class="form__input" placeholder=" " value="$<?php $total2 =filter_var( $general['total'], FILTER_VALIDATE_FLOAT); echo $total2;?>" >
                <label for="telefono" class="form__label">Total a pagar</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" readonly name="direccion" id="direccion"class="form__input" placeholder=" " value="<?php echo $general['metodoPago'];?>" >
                <label for="direccion" class="form__label">Forma de pago</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" readonly name="direccion" id="direccion"class="form__input" placeholder=" " value="<?php echo $product["SUM(quantity)"];?>" >
                <label for="direccion" class="form__label">Cantidad de Productos</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="observacion" id="observacion"class="form__input" placeholder=" " value="" >
                <label for="observacion" class="form__label">Observación</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" readonly name="cedula" id="cedula"class="form__input" placeholder=" " value="<?php echo $general['direccion'];?>" >
                <label for="cedula" class="form__label">Direccion solicitada</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" readonly name="cedula" id="cedula"class="form__input" placeholder=" " value="<?php echo $general['order_id'];?>" >
                <label for="cedula" class="form__label">Numero de Orden</label>
                <span class="form__linea"></span>
            </div>
            <input type="text" hidden name="order_id" id="order_id"class="form__input" placeholder=" " value="<?php echo $general['order_id'];?>" >
        </div>
        
    </div>
    <br>
    <center>
        <div class="botones">
            <input type="submit" class="form__submit" value="GUARDAR">
        </div>
    </center>

<fieldset class="form2 consulta__tabla">
<legend>DETALLE DE PRODUCTOS</legend>
        
    <table class="form2 consulta__tabla">
        <thead>
            <?php 
            $queryPro = "SELECT * FROM order_products WHERE order_id = ${id}";
            $reultadoPro = mysqli_query($db3, $queryPro);
            
            ?>
            <tr>
                <th>PRODUCTO</th>
                <th>PRECIO UNITARIO</th>
                <th>CANTIDAD</th>
            </tr>
        </thead>
        <tbody>
            <?php while($orderProduct = mysqli_fetch_assoc($reultadoPro)):?>
            <tr>
                <td><?php echo $orderProduct['name']; ?></td>
                <td>$ <?php $punit =  $orderProduct['unit_price']/100; $punit2 =filter_var( $punit, FILTER_VALIDATE_FLOAT); echo $punit2; ?></td>
                <td><?php echo $orderProduct['quantity']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>

<fieldset class="form2 consulta__tabla">
<legend>NUMERO DE PRODUCTOS</legend>
        
    <table class="form2 consulta__tabla">
        <thead>
            <?php 
            $queryPro2 = "SELECT COUNT(name) FROM order_products WHERE order_id = ${id}";
            $reultadoPro2 = mysqli_query($db3, $queryPro2);
            
            ?>
            <tr>
                <th>NUMERO DE PRODUCTOS</th>
            </tr>
        </thead>
        <tbody>
            <?php while($orderProduct2 = mysqli_fetch_assoc($reultadoPro2)):?>
            <tr>
                <td><?php echo $orderProduct2['COUNT(name)']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>

    
</form>

<div class="boton__anidado">
        <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
    </div>