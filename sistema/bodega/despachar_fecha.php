<?php 
    $id = $_GET['id']?? null;
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
        $status = "DESPACHADO";
        //$fecha_Desp = date('y-m-d h:i:s');
        $despachador = $_SESSION['usuario'];
        $fecha_Desp = mysqli_real_escape_string($db4, $_POST['fecha_despacho']);

            // guardar y actualizar los despcahos
            $query3 = "UPDATE datosordenes SET estado = '${status}', fecha_Desp = '${fecha_Desp}', despachador = '${despachador}' where id=${id}";
            $resultado3 = mysqli_query($db4, $query3);
                if ($resultado2){
                        header('location: ordenes.php');
                    }
        }

?>

<center>
    <h1>CONSULTAR DETALLES DE LAS ORDENES</h1>
</center>

<center>
            <div class="contenedor__enlaces">
                <div class="usuario__enlaces">
                    <div class="enlace--boton">
                        <a href="ordenes.php" class="enlace">REGRESAR AL INICIO </a>
                    </div>
                </div>
            </div>
</center>

<form action=" " method="post">
    <fieldset class="form2 consulta__tabla">
        <?php
            echo $_SESSION['rol'];
        ?>
        <legend>DATOS DEL CLIENTE</legend>
        <table class="form2 consulta__tabla" >
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>PROVINCIA</th>
                    <th>CIUDAD</th>
                    <th>DIRECCIÓN</th>
                    <th>REFERENCIA</th>
                    <th>TELEFONO</th>
                    <th>SEGUNDO CONTACTO</th>
                </tr>
            </thead>
            <tbody>
                <?php while($resultadoApi2 = mysqli_fetch_assoc($resultado2)) : ?>
                    <tr>
                        <td>
                            <?php echo $resultadoApi2['name']; ?>
                            <input type="hidden" name="name1" value="<?php echo $resultadoApi2['name'];?>">
                        </td>
                        <td>
                            <?php echo $resultadoApi2['last_name']; ?>
                            <input type="hidden" name="last_name" value="<?php echo $resultadoApi2['last_name'];?>">
                        </td>
                        <td>
                            <?php echo $resultadoApi2['province']; ?>
                            <input type="hidden" name="province" value="<?php echo $resultadoApi2['province'];?>">    
                        </td>
                        <td>
                            <?php echo $resultadoApi2['city']; ?>
                            <input type="hidden" name="city" value="<?php echo $resultadoApi2['city'];?>">
                        </td>
                        <td>
                            <?php echo $resultadoApi2['address']; ?>
                            <input type="hidden" name="address1" value="<?php echo $resultadoApi2['address'];?>">
                        </td>
                        <td>
                            <?php echo $resultadoApi2['reference']; ?>
                            <input type="hidden" name="reference" value="<?php echo $resultadoApi2['reference'];?>">
                        </td>
                        <td>
                            <?php echo $resultadoApi2['phone']; ?>
                            <input type="hidden" name="phone" value="<?php echo $resultadoApi2['phone'];?>">
                        </td>
                        <td>
                            <?php echo $resultadoApi2['landline']; ?>
                            <input type="hidden" name="landline" value="<?php echo $resultadoApi2['landline'];?>">
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </fieldset>

    <fieldset class="form2 consulta__tabla">
        <?php
            
        ?>
        <legend>DATOS DE LA ORDEN Y DOCUMENTOS</legend>
        <table class="form2 consulta__tabla" >
            <thead>
                <tr>
                    <th>NNÚMERO DE ORDEN</th>
                    <th>FECHA DE CREACION</th>
                    <th>FECHA ESTIMADA DE ENTEGA</th>
                    <th>TOTAL A PAGAR</th>
                    <th>ESTADO DE LA ORDEN</th>
                    <th>FACTURA</th>
                    <th>GUIA</th>
                </tr>
            </thead>
            <tbody>
                <?php while($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
                    <tr>
                        <td>
                            <?php echo $resultadoApi['order_id']; //numero de la orden emitida en Rusia?>
                        </td>
                        <td>
                            <?php echo $resultadoApi['order_at']; ?>
                        </td>
                        <td>
                            <?php echo $resultadoApi['delivery_at']; ?>
                        </td>
                        <td>
                            $<?php $total = $resultadoApi['total']/100; $total2 =filter_var( $total, FILTER_VALIDATE_FLOAT); echo $total2;?>
                        </td>
                        <td>
                            <?php echo $resultadoApi['status'];
                            $resultadoApi['created_at']; ?>
                        </td>
                        
                        <td>
                            <?php  
                                $idver = $resultadoApi['id'];
                                $busFact = "SELECT * FROM facturas WHERE id_orders = ${idver}";
                                $fact = mysqli_query($db4, $busFact);
                                $apiFact = mysqli_fetch_assoc($fact);
                            ?>
                            <a href="../../facturas/<?php echo $apiFact['num_fact']; ?>#toolbar=1&navpanes=1&scrollbar=0" target="blanck" class="tabla__archivos"> VER FACTURA↓</a>
                        </td>
                        <td>
                        <?php  
                            $idver = $resultadoApi['id'];
                            $busFact = "SELECT * FROM facturas WHERE id_orders = ${idver}";
                            $fact = mysqli_query($db4, $busFact);
                            $apiFact = mysqli_fetch_assoc($fact);
                        ?>
                        <a href="../../facturas/<?php echo $apiFact['guiaRem']; ?>#toolbar=1&navpanes=1&scrollbar=0" target="blanck" class="tabla__archivos"> VER GUIA ↓</a>
                    </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </fieldset>

    <fieldset class="form2 consulta__tabla">
        <?php
            $query3 = "SELECT * FROM order_products where order_id = ${id}";
            $resultado3 = mysqli_query($db3, $query3);
        ?>
        <legend>DETALLES DE PRODUCTOS</legend>
        <table class="form2 consulta__tabla" >
            <thead>
                <tr>
                    <th>PRODUCTO</th>
                    <th>PRECIO UNITARIO</th>
                    <th>CANTIDAD</th>
                </tr>
            </thead>
            <tbody>
                <?php while($resultadoApi3 = mysqli_fetch_assoc($resultado3)) : ?>
                    <tr>
                        <td><?php echo $resultadoApi3['name']; ?></td>
                        <td>
                            $<?php $total = $resultadoApi3['unit_price']/100; $total4 =filter_var( $total, FILTER_VALIDATE_FLOAT); echo $total4;?>
                            </td>
                        <td><?php echo $resultadoApi3['quantity']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="form__grupo">
                <input type="date" name="fecha_despacho" id="fecha_despacho"class="form__input" require placeholder=" " value="" >
                <label for="fecha_pago" class="form__label">FECHA DE DESPACHO</label>
                <span class="form__linea"></span>
            </div>
    </fieldset>
    <div class="botones-fin">
        <input type="submit" class="form__submit" value="ENVIAR DATOS"> 
    </div>
</form>
