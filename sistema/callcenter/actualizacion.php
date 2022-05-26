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
            $name = mysqli_real_escape_string($db4, $_POST['name1']);
            $last_name = mysqli_real_escape_string($db4, $_POST['last_name']);
            $province = mysqli_real_escape_string($db4, $_POST['province']);
            $city = mysqli_real_escape_string($db4, $_POST['city']);
            $address = mysqli_real_escape_string($db4, $_POST['address1']);
            $reference = mysqli_real_escape_string($db4, $_POST['reference']);
            $phone = mysqli_real_escape_string($db4, $_POST['phone']);
            $landline = mysqli_real_escape_string($db4, $_POST['landline']);
            //datos consumo de API orders
            $order_id = mysqli_real_escape_string($db4, $_POST['order_id']);
            $order_at = mysqli_real_escape_string($db4, $_POST['order_at']);
            $delivery_at = mysqli_real_escape_string($db4, $_POST['delivery_at']);
            $total = mysqli_real_escape_string($db4, $_POST['total']);
            $status = mysqli_real_escape_string($db4, $_POST['status1']);
            $created_at = mysqli_real_escape_string($db4, $_POST['created_at']);
            //datos del formulario confirmación
            $nombres = mysqli_real_escape_string($db4, $_POST['nombres']);
            $cedula = mysqli_real_escape_string($db4, $_POST['cedula']);
            $direccion = mysqli_real_escape_string($db4, $_POST['direccion']);
            $correo = mysqli_real_escape_string($db4, $_POST['correo']);
            $telefono = mysqli_real_escape_string($db4, $_POST['telefono']);
            $metodoPago = mysqli_real_escape_string($db4, $_POST['metodoPago']);
            $observacion = mysqli_real_escape_string($db4, $_POST['observacion']);
            $fecha_pago = mysqli_real_escape_string($db4, $_POST['fecha_pago']);
            $resLlamada = mysqli_real_escape_string($db4, $_POST['resLlamada']);
            //datos para el cambio en la verificacion
            $contactado = $id;
            $facturado = null;
            $filtro = "no";
            $fechaGest = date('y-m-d h:i:s');
            //variables actualizacion de estados
            $status = "collected"; // fecha capturada como parte del historial
            $fechaGest = date('y-m-d h:i:s'); // fecha capturada como parte del historial
            //variables para generar el historial tabla despachos
            $carrier_name = "NO ASIGNADO";
            $delivery_at = null;
            $transport_type = "LOGISTA GC";
            $observation = "En proceso";
            $deleted_at = null;
            //Agregando campos para la generealizacion del sistem a CLIENTE y COD
            $cod = "si";
            $cliente = "smartcosmetics";
                //historial, tabla despachos estatus
                


                if(!$nombres) {
                    $errores[] = "Si no hay nombres no puedes guardar, asi no se HACE!!!!";
                }
                if(!$cedula) {
                    $errores[] = "Si no hay cédula por favor agrega ceros,";
                }
                if(!$metodoPago) {
                    $errores[] = "Solo tienes que elegir la forma de págo, pregunta todo!!!";
                }
                if(!$observacion) {
                    $errores[] = "Si no hay, lo más lógico es poner no hay Sin Novedad o S/N pero llena la observación";
                }
                if(!$correo) {
                    $errores[] = "Si el cliente no pasó este dato agrega correo@correo.com";
                }
                if(!$telefono) {
                    $errores[] = "Si no hay cambios con la informacion inicial, solo MISMO NUMERO pero llena todos los campos!!!";
                }
                if(!$direccion) {
                    $errores[] = "No solo es llenar tienes que especificar bien la direccion PILAS!!!";
                }
                if(!$fecha_pago) {
                    $errores[] = "La fecha de pago tambien es importante esto también llena todo POR FAVOR!!!!";
                }
                if(!$province) {
                    $errores[] = "Es necesario conocer la provincia, por favor selecciona una!!!!";
                }
                if(!$resLlamada) {
                    $errores[] = "Es necesario conocer la provincia, por favor selecciona una!!!!";
                }
                if(empty($errores)) {
            
                        $query4 = "INSERT INTO datosordenes (id, name, last_name, province, city, address, reference, 
                        phone, landline, order_id, order_at, delivery_at, total, status, created_at, nombres, cedula,
                        direccion, correo, telefono, metodoPago, estado, observacion, fecha_pago, fechaGest, resLlamada, cliente, cod ) 
                        VALUES ('$idG', '$name', '$last_name', '$province', '$city', '$address', '$reference', '$phone', 
                        '$landline', '$order_id', '$order_at', '$delivery_at', '$total', '$status', '$created_at', 
                        '$nombres', '$cedula', '$direccion', '$correo', '$telefono', '$metodoPago', '$filtro', '$observacion', '$fecha_pago', '$fechaGest', '$resLlamada', '$cliente', '$cod')";
                        $resultado1 = mysqli_query($db4, $query4);

                        $query3 = "INSERT INTO verificacion (contactado, facturado) values ('$contactado', '$facturado')";
                        $resultado2 = mysqli_query($db4, $query3);

                        //cambiar el estado a collected
                            $queryCO = "UPDATE orders SET status = '${status}', updated_at = '${fechaGest}' where id=${id}";
                            $resultadoCO1 = mysqli_query($db3, $queryCO);

                            $queryCOI = "UPDATE datosordenes SET status = '${status}', fechaGest = '${fechaGest}' where id=${id}";
                            $resultadoCOI2 = mysqli_query($db4, $queryCOI);

                        //Generar el historial captura de datos para despachos.

                            $queryHIS = "INSERT INTO dispatches ( carrier_name, transport_type, status, observation, order_id, 
                            created_at, updated_at ) 
                            VALUES ('$carrier_name', '$transport_type', '$status', '$observation', '$id', 
                            '$fechaGest', '$fechaGest' )";
                            $hisrotial = mysqli_query($db3, $queryHIS);

                            if ($resultado1){
                                    header('location: ../callcenter2.php?resultado=1');
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

        <h2 class="form__titulo titulo__pagina">DATOS PARA FACTURACIÓN</h2>
        <h2 class="form__titulo">FICHA DE INGRESO</h2>
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
                <input type="text" name="nombres" id="nombres"class="form__input" require placeholder=" " value="" minlength="8" maxlength="79">
                <label for="nombres" class="form__label">Nombre y Apellido factura</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="cedula" id="cedula"class="form__input" require placeholder=" " value="" minlength="10" maxlength="13">
                <label for="cedula" class="form__label">Número de Cédula</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <select name="metodoPago" id="" require class="form__input">
                    <option value=""> ---Selecciona un método de pago--- </option>
                    <option value="efectivo">Efectivo</option>
                    <option value="transferencia">Transferencia</option>
                </select>
            </div>
            <div class="form__grupo">
                <input type="text" name="observacion" id="observacion"class="form__input" require placeholder=" " value="" minlength="11" maxlength="200">
                <label for="observacion" class="form__label">Observacion</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <select name="resLlamada" id="resLlamada" require class="form__input">
                    <option value=""> ---Conclucion de la Gestion--- </option>
                    <option value="efectiva">Efectiva (Solamente si la llamada es positva en todo)</option>
                    <option value="no desea">No desa (Si el cliente no compro o no desea)</option>
                    <option value="segunda llamada">Volver a llamar (Pasa a segunda llamada)</option>
                    <option value="equivocado">Numero equivocado (Si el numero de contacto no es el correcto)</option>
                    <option value="programado">Programado (Si el cliente solicita entrega en otra fecha)</option>
                </select>
            </div>
        </div>
        <div class="form__container form2">
            <div class="form__grupo">
                <input type="email" name="correo" id="correo"class="form__input" require placeholder=" " value="" minlength="17" maxlength="45">
                <label for="correo" class="form__label">Correo para envío de Factura</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="telefono" id="telefono"class="form__input" require placeholder=" " value="" minlength="10" maxlength="10">
                <label for="telefono" class="form__label">Contacto para la entrega</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="direccion" id="direccion"class="form__input" require placeholder=" " value="" minlength="8" maxlength="200">
                <label for="direccion" class="form__label">Dirección Alternativa</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="date" name="fecha_pago" id="fecha_pago"class="form__input" require placeholder=" " value="" >
                <label for="fecha_pago" class="form__label">Fecha de Entrega</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <select name="province" id="" require class="form__input">
                    <option value=""> ---Selecciona una provincia--- </option>
                    <option value="Esmeraldas">ESMERALDAS</option>
                    <option value="Manabi">MANABI</option>
                    <option value="Los Rios">LOS RIOS</option>
                    <option value="Santa Elena">SANTA ELENA</option>
                    <option value="Guayas">GUAYAS</option>
                    <option value="Santo Domingo">SANTO DOMINGO</option>
                    <option value="El Oro">EL ORO</option>
                    <option value="Azuay">AZUAY</option>
                    <option value="Bolivar">BOLIVAR</option>
                    <option value="Canar">CANAR</option>
                    <option value="Carchi">CARCHI</option>
                    <option value="Cotopaxi">COTOPAXI</option>
                    <option value="Chimborazo">CHIMBORAZO</option>
                    <option value="Imbabura">IMBABURA</option>
                    <option value="Loja">LOJA</option>
                    <option value="Pichincha">PICHINCHA</option>
                    <option value="Tungurahua">TINGURAHUA</option>
                    <option value="Morona Santiago">MORONA SANTIAGO</option>
                    <option value="Napo">NAPO</option>
                    <option value="Orellana">ORELLANA</option>
                    <option value="Sucumbios">SUCUMBIOS</option>
                    <option value="Zamora Chinchipe">ZAMORA CHINCHIPE</option>
                    <option value="Galapagos">GALAPAGOS</option>
                    <option value="Pastaza">PASTAZA</option>
                </select>
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