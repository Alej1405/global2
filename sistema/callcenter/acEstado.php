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
    
    // generar la fecha de cracion correcta
        $id_hist2 = "SELECT * FROM datosordenes WHERE id = ${id}";
        $cons_id2 = mysqli_query($db4, $id_hist2);
        $id_dispat2 = mysqli_fetch_assoc($cons_id2);
        $created_at = $id_dispat2['created_at'];
        //echo $created_at;
    //generar historial completo incluyendo comparamos si existe el id de despacho
    // si no existe, crear el despacho
        $id_hist = "SELECT * FROM dispatches WHERE order_id = ${id}";
        $cons_id = mysqli_query($db3, $id_hist);
        $id_dispat = mysqli_fetch_assoc($cons_id);
        if (empty($id_dispat)){
            //echo "la orden  no tiene despacho";
            //denifir varuables para la generacion del despacho
            $carrier_name = "NO ASIGNADO";
            $delivery_at = null;
            $transport_type = "LOGISTA GC";
            $observation = "En proceso";
            $deleted_at = null;
            $status = "collected"; // fecha capturada como parte del historial
            $fechaGest = date('y-m-d h:i:s'); // fecha capturada como parte del historial
            //insert para generar el despacho si, aun no esta generado
            $queryHIS = "INSERT INTO dispatches ( carrier_name, transport_type, status, observation, order_id, 
                        created_at, updated_at ) 
                        VALUES ('$carrier_name', '$transport_type', '$status', '$observation', '$id', 
                        '$created_at', '$fechaGest' )";
                        $hisrotial = mysqli_query($db3, $queryHIS);
        }
        //-- FIN DE LA ACTUALIZACION DE HISTORIAL--

    $errores = [];


            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                    //CONSULTA DE ID DE DESPACHO, COHERENCIA DE HISTORIAL
                    $id_hist = "SELECT * FROM dispatches WHERE order_id = ${id}";
                    $cons_id = mysqli_query($db3, $id_hist);
                    $id_dispat = mysqli_fetch_assoc($cons_id);
                    $dispatch_id = $id_dispat['id'];

                //datos consumo de API order_clients
                $status = mysqli_real_escape_string($db3, $_POST['status']);
                $n_visitas = $_POST['n_visitas'];
                $observ_estado = mysqli_real_escape_string($db3, $_POST['observacion_estado']);
                //datos para el cambio en la verificacion
                $contactado = $id;
                $facturado = null;
                $filtro = "no";
                $fechaGest = date('y-m-d h:i:s');
                //id de despacho para actualizacion
                $seg_despacho = $id_dispat['id'];
                //resonsable de la actualizacion
                $usuario_act = $_SESSION['usuario']; //base de datos sitema
                $id_historial = 5;
                //asignar transporte especifico
                $carrier_name = "motorizado GC";
                //fecha de creacion
                $created_at = $id_dispat2['created_at'];
                

                if(!$status) {
                    $errores[] = "No hay un estado registrado no se puede guardar, haz bien!!!!";
                }
                if(!$observ_estado) {
                    $errores[] = "Justifica por que, cambio a ese estado, pero sintetiza no cuentes historias!!";
                }
                if(!$n_visitas) {
                    $errores[] = "Agrega un numero de visita, pero de forma coherente!!";
                }
                if(empty($errores)) {


                    switch ($status){
                        case "delivered":
                            //ACTUALIZACION EN API
                                $query4 = "UPDATE orders SET    status = '${status}', 
                                                                delivery_at = '${fechaGest}', 
                                                                updated_at = '${fechaGest}' 
                                                                where id=${id}";
                                $resultado1 = mysqli_query($db3, $query4);
                            //ACTUALIZACION BDD DE SISTEMA
                                $query3 = "UPDATE datosordenes SET  status = '${status}', 
                                                                    delivery_at = '${fechaGest}', 
                                                                    observacion_estado = '${observ_estado}', 
                                                                    fechaGest = '${fechaGest}', 
                                                                    n_visitas = '${n_visitas}',
                                                                    gestion_user = '${id_historial}'  
                                                                    where id=${id}";
                                $resultado2 = mysqli_query($db4, $query3);
                            //ACTUALIZACION HISTORIAL DESPACHOS 
                                $query3 = "UPDATE dispatches SET  status = '${status}', 
                                                                    carrier_name = '${carrier_name}',
                                                                    delivery_at = '${fechaGest}',
                                                                    updated_at = '${fechaGest}', 
                                                                    observation = '${observ_estado}'  
                                                                    where order_id=${id}";
                                $resultado2 = mysqli_query($db3, $query3);
                            //GUARDAR DATOS DEL HISTORIAL 
                                $queryHIS = "INSERT INTO dispatch_statuses ( status, comment, dispatch_id, user_id, created_at, updated_at ) 
                                                            VALUES ('$status', '$observ_estado', '$dispatch_id', '5', '$created_at', '$fechaGest')";
                                $guardar_his = mysqli_query($db3, $queryHIS);
                                //echo $guardar_his;
                            
                            //RETURN DE PROCESO
                                if ($resultado2){
                                    header('location: porNorden.php');
                                }
                        break;

                        case "returnes":
                            //ACTUALIZACION EN API
                                $query4 = "UPDATE orders SET    status = '${status}', 
                                                                updated_at = '${fechaGest}' 
                                                                where id=${id}";
                                $resultado1 = mysqli_query($db3, $query4);
                            //ACTUALIZACION BDD DE SISTEMA
                                $query3 = "UPDATE datosordenes SET  status = '${status}', 
                                                                    observacion_estado = '${observ_estado}', 
                                                                    fechaGest = '${fechaGest}', 
                                                                    n_visitas = '${n_visitas}',
                                                                    gestion_user = '${id_historial}'   
                                                                    where id=${id}";
                                $resultado2 = mysqli_query($db4, $query3);
                            //ACTUALIZACION HISTORIAL DESPACHOS 
                                $query3 = "UPDATE dispatches SET  status = '${status}', 
                                                                    carrier_name = '${carrier_name}',
                                                                    updated_at = '${fechaGest}', 
                                                                    observation = '${observ_estado}'  
                                                                    where order_id=${id}";
                                $resultado2 = mysqli_query($db3, $query3);
                             //GUARDAR DATOS DEL HISTORIAL 
                                $queryHIS = "INSERT INTO dispatch_statuses ( status, comment, dispatch_id, user_id, created_at, updated_at ) 
                                                            VALUES ('$status', '$observ_estado', '$dispatch_id', '$id_historial', '$created_at', '$fechaGest')";
                                $guardar_his = mysqli_query($db3, $queryHIS);
                            //RETURN DE PROCESO
                                    if ($resultado2){
                                        header('location: porNorden.php');
                                    }
                        break;

                        case "undelivered":
                            //ACTUALIZACION EN API
                                $query4 = "UPDATE orders SET    status = '${status}', 
                                                                updated_at = '${fechaGest}' 
                                                                where id=${id}";
                                $resultado1 = mysqli_query($db3, $query4);
                            //ACTUALIZACION BDD DE SISTEMA
                                $query3 = "UPDATE datosordenes SET  status = '${status}', 
                                                                    observacion_estado = '${observ_estado}', 
                                                                    fechaGest = '${fechaGest}', 
                                                                    n_visitas = '${n_visitas}',
                                                                    gestion_user = '${id_historial}'  
                                                                    where id=${id}";
                                $resultado2 = mysqli_query($db4, $query3);
                            //ACTUALIZACION HISTORIAL DESPACHOS 
                                $query3 = "UPDATE dispatches SET  status = '${status}', 
                                                                    carrier_name = '${carrier_name}',
                                                                    updated_at = '${fechaGest}', 
                                                                    observation = '${observ_estado}'  
                                                                    where order_id=${id}";
                                $resultado2 = mysqli_query($db3, $query3);
                             //GUARDAR DATOS DEL HISTORIAL 
                                $queryHIS = "INSERT INTO dispatch_statuses ( status, comment, dispatch_id, user_id, created_at, updated_at ) 
                                                            VALUES ('$status', '$observ_estado', '$dispatch_id', '$id_historial', '$created_at', '$fechaGest')";
                                $guardar_his = mysqli_query($db3, $queryHIS);
                            //RETURN DE PROCESO
                                    if ($resultado2){
                                        header('location: porNorden.php');
                                    }
                        break;
                    }
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
                        </td>
                        <td>
                            <?php echo $resultadoApi2['last_name']; ?>
                        </td>
                        <td>
                            <?php echo $resultadoApi2['city']; ?>
                        </td>
                        <td>
                            <?php echo $resultadoApi2['address']; ?>
                        </td>
                        <td>
                            <?php echo $resultadoApi2['reference']; ?>
                        </td>
                        <td>
                            <?php echo $resultadoApi2['phone']; ?>
                        </td>
                        <td>
                            <?php echo $resultadoApi2['landline']; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2 class="form__titulo titulo__pagina">ACTUALIZAR ESTADO DE GESTION</h2>
        <p class="form__p form2--p">
            Solicitar todos los datos para poder completar la gestión.
        </p>
        <?php foreach($errores as $error) : ?>
            <div class="alerta">
                <?php echo $error; ?>
            </div>
        <?php endforeach ?>

    <div class="container2">
        <div class="form__container form2">
            <div class="form__grupo">
                <select name="status" aria-required="true" id="status" require class="form__input">
                    <option value=""> ---SELECCIONA EL ESTADO DE LA ORDEN--- </option>
                    <option value="returnes">RETURNES (devuelto, no desea, no contesta)</option>
                    <option value="undelivered">UNDELIVERED (visitado, postergado)</option>
                    <option value="delivered">DELIVERED (entregado sin novedad)</option>
                </select>
            </div>
            <div class="form__grupo">
                <input type="text" aria-required="true" name="observacion_estado" id="observacion_estado" class="form__input" require placeholder=" " value=""  maxlength="255">
                <label for="telefono" class="form__label">OBSERVACION DEL ESTADO</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="number" aria-required="true" name="n_visitas" id="n_visitas" class="form__input"  placeholder=" " value=""  maxlength="1">
                <label for="telefono" class="form__label">NUMERO DE VISITA</label>
                <span class="form__linea"></span>
            </div>
        </div>
    </div>
    </fieldset>

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
            <input type="submit" class="form__submit" value="ENVIAR DATOS"> 
        </div>
    </fieldset>

</form>

<div class="boton__anidado">
        <a href="../callcenter2.php" class="enlace">salir sin guardar</a>
    </div>