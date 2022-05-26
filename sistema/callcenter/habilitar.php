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

    $errores = [];


            if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //datos consumo de API order_clients
            $idG  = $id;
            $fechaGest = date('y-m-d h:i:s');

                if(!$idG) {
                    $errores[] = "Lo que intentas hacer es peligroso por favor, PINSA QUE HACEEEEEES!!!!";
                }
            
                $queryb = "DELETE FROM verificacion WHERE contactado = ${idG};";
                $habilitar = mysqli_query($db4, $queryb);

                $queryc = "DELETE FROM datosordenes WHERE id = ${idG};";
                $habilitarb = mysqli_query($db4, $queryc);

                if ($habilitar){
                    header('location: dardeAlta.php?resultado=1');
            }
            }

?>
<form action="" method="post">
    <fieldset class="form2 consulta__tabla">
        <?php
        ?>
        <legend>DATOS DEL CLIENTE</legend>
        <table class="form2 consulta__tabla" >
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
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

        <?php foreach($errores as $error) : ?>
            <div class="alerta">
                <?php echo $error; ?>
            </div>
        <?php endforeach ?>

    
    <fieldset class="form2 consulta__tabla">
        <?php
            
        ?>
        <legend>DATOS GENERALES DE LA ORDEN</legend>
        <table class="form2 consulta__tabla" >
            <thead>
                <tr>
                    <th>NNÚMERO DE ORDEN</th>
                    <th>FECHA DE CREACION</th>
                    <th>FECHA ESTIMADA DE ENTEGA</th>
                    <th>TOTAL A PAGAR</th>
                    <th>ESTADO DE LA ORDEN</th>
                </tr>
            </thead>
            <tbody>
                <?php while($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
                    <tr>
                        <td>
                            <?php echo $resultadoApi['order_id']; //numero de la orden emitida en Rusia?>
                            <input type="hidden" name="order_id" value="<?php echo $resultadoApi['order_id'];?>">
                        </td>
                        <td>
                            <?php echo $resultadoApi['order_at']; ?>
                            <input type="hidden" name="order_at" value="<?php echo $resultadoApi['order_at'];?>" >
                        </td>
                        <td>
                            <?php echo $resultadoApi['delivery_at']; ?>
                            <input type="hidden" name="delivery_at" value="<?php echo $resultadoApi['delivery_at'];?>">
                        </td>
                        <td>
                            $<?php $total = $resultadoApi['total']/100; $total2 =filter_var( $total, FILTER_VALIDATE_FLOAT); echo $total2;?>
                            
                            <input type="hidden" name="total" value="<?php echo $total2;?>">
                        </td>
                        <td>
                            <?php echo $resultadoApi['status'];
                            $resultadoApi['created_at']; ?>
                            <input type="hidden" name="status1" value="<?php echo $resultadoApi['status'];?>">
                            <input type="hidden" name="created_at" value="<?php echo $resultadoApi['created_at'];?>">
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
        <div class="botones-fin">
            <input type="submit" class="form__submit" value="HABILITAR ORDENES"> 
        </div>
    </fieldset>

</form>

<div class="boton__anidado">
        <a href="dardeAlta.php" class="enlace">VOLVER AL INICIO</a>
</div>