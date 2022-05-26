<?php
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

//incluye el header
require '../../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('location: index.php');
}

require '../../includes/config/database.php';
incluirTemplate('headersis2');
conectarDB();
$db = conectarDB();

//BASE DE DATOS BODEGA 
conectarDB2();
$db2 = conectarDB2();

//coneccion api
conectarDB3();
$db3 = conectarDB3();

//coneccion callcenter
conectarDB4();
$db4 = conectarDB4();

// proteger la página
if (!$auth) {
    header('location: index.php');
}
$query2 = "SELECT * FROM order_clients where order_id = ${id}";
$resultado2 = mysqli_query($db3, $query2);

$query = "SELECT * FROM orders where id = ${id}";
$resultado = mysqli_query($db3, $query);
$resultado_created = mysqli_fetch_assoc($resultado);
$errores = [];

//RECEPCION DE DATOS MEDIANTE POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //ESTADOS HISTORIAL Y REPORTE DE ACCUTALIZACION
            //inicio de historial
                //datos constantes de sistema
                $status = 'collected';
                $fechaGest = date('y-m-d h:i:s');
                $carrier_name = 'Personal Autorizado';
                $transport_type = 'Transporte autorizado';
                $observation = 'Inicio de gestion';
                $fechaGest_created = $resultado_created['created_at'];
                //cambiar el estado a collected
                        $queryCO = "UPDATE orders SET status = '${status}', updated_at = '${fechaGest}' where id=${id}";
                        $resultadoCO1 = mysqli_query($db3, $queryCO);

                        $queryCOI = "UPDATE datosordenes SET status = '${status}', fechaGest = '${fechaGest}' where id=${id}";
                        $resultadoCOI2 = mysqli_query($db4, $queryCOI);
                
                //crear numero de despacho
                        $queryHIS = "INSERT INTO dispatches ( carrier_name, transport_type, status, observation, order_id, 
                        created_at, updated_at ) 
                        VALUES ('$carrier_name', '$transport_type', '$status', '$observation', '$id', 
                        '$fechaGest_created', '$fechaGest' )";
                        $hisrotial = mysqli_query($db3, $queryHIS);

            //fin historial 
        //FIN DE ESTADOS REPORTES Y ACTULIZACION

        //DECLARACION DE VARIABLES
            //  CAPTURA DE DATOS EN LA BDD INTERNA
                //VARIABLES TABLA DATOSORDENES
                    //datos consumo de API order_clients
                    $id_orders = $id; //$idG  = $id;
                    $name = mysqli_real_escape_string($db3, $_POST['name1']);
                    $last_name = mysqli_real_escape_string($db3, $_POST['last_name']);
                    $province = mysqli_real_escape_string($db3, $_POST['province']);
                    $city = mysqli_real_escape_string($db3, $_POST['city']);
                    $address = mysqli_real_escape_string($db3, $_POST['address1']);
                    $reference = mysqli_real_escape_string($db3, $_POST['reference']);
                    $phone = mysqli_real_escape_string($db3, $_POST['phone']);
                    $landline = mysqli_real_escape_string($db3, $_POST['landline']);
                    //datos consumo de API orders
                    $order_id = mysqli_real_escape_string($db3, $_POST['order_id']);
                    $order_at = mysqli_real_escape_string($db3, $_POST['order_at']);
                    $delivery_at = mysqli_real_escape_string($db3, $_POST['delivery_at']);
                    $total = mysqli_real_escape_string($db3, $_POST['total']);
                    $status = 'collected';
                    $created_at = mysqli_real_escape_string($db3, $_POST['created_at']);
                    //datos generados en el sistema.
                    $cod = "si";
                    $cliente = "smartcosmetics";
                    $responsable_m = mysqli_real_escape_string($db, $_POST['responsable_m']);
                    $gestion_user = $_SESSION['id'];
                //FIN VARIABLES DATOSORDENES
                //VARIABLES TABLA VERIFICACION
                    $observacion = null;
                    $factura = $_FILES['num_fac'];
                    $guiaRem = $_FILES['guiaRem'];
                    $estado = "facturado";
                    $comprobante = null;
                    $contactado = $id;
                    $facturado = mysqli_real_escape_string($db, $_POST['n_guia']);
                     
                //FIN DE VAARIABLES TABLA VERIFICACION
                //variables para revisar
                    //datos del formulario confirmación datos para facturacion
                    // $nombres = mysqli_real_escape_string($db4, $_POST['nombres']);
                    // $cedula = mysqli_real_escape_string($db4, $_POST['cedula']);
                    // $direccion = mysqli_real_escape_string($db4, $_POST['direccion']);
                    // $correo = mysqli_real_escape_string($db4, $_POST['correo']);
                    // $telefono = mysqli_real_escape_string($db4, $_POST['telefono']);
                    // $metodoPago = mysqli_real_escape_string($db4, $_POST['metodoPago']);
                    // $observacion = mysqli_real_escape_string($db4, $_POST['observacion']);
                    // $fecha_pago = mysqli_real_escape_string($db4, $_POST['fecha_pago']);
                    // $resLlamada = mysqli_real_escape_string($db4, $_POST['resLlamada']);
                //fin de variables a revisar
        //FIN DE DECLARACION DE VARIABLES.

    //ASIGNAR EL NUMERO DE USURARIO
        switch ($_SESSION['usuario']) {
            case "andreina@globalcargoecuador.com":
                $usuario = 1;
                break;
            case "camila@globalcargoecuador.com":
                $usuario = 2;
                break;
            case "cristina@globalcargoecuador.com":
                $usuario = 3;
                break;
            case "celia@flobalcargoecuador.com":
                $usuario = 4;
        }
    //FIN DE ASIGTANCION DE USUARIO

    //INICIO DE PROCESO ---CRUD Y CREACION DE HISTORIAL---
        if (!$guiaRem) {
            $errores[] = "Por favor agregar la guia";
        }
        if (empty($errores)) {

            //----CAPTURAR INFORMACION EN LA BASE DE DATOS----
                //CAPTURA DE DATOS PRINCIPAL
                    // captura de datos DATOSORDENES
                        $query4 = "INSERT INTO datosordenes (id,
                                                            name, 
                                                            last_name, 
                                                            province, 
                                                            city, 
                                                            address, 
                                                            reference, 
                                                            phone, 
                                                            landline, 
                                                            order_id, 
                                                            order_at, 
                                                            delivery_at, 
                                                            total, 
                                                            status, 
                                                            created_at,
                                                            estado,
                                                            cliente,
                                                            gestion_user,
                                                            cod,
                                                            responsable_m) 
                                                        VALUES 
                                                            ('$id_orders',
                                                            '$name', 
                                                            '$last_name', 
                                                            '$province', 
                                                            '$city', 
                                                            '$address', 
                                                            '$reference', 
                                                            '$phone', 
                                                            '$landline', 
                                                            '$order_id', 
                                                            '$order_at', 
                                                            '$delivery_at', 
                                                            '$total', 
                                                            '$status', 
                                                            '$created_at', 
                                                            '$estado', 
                                                            '$cliente',
                                                            '$usuario',
                                                            '$cod',
                                                            '${responsable_m}')";
                                        $resultado1 = mysqli_query($db4, $query4);
                    // fin de captura de datos bdd DATOSORDERNES

                    /**SUBIR ARCHIVOS A LA BASE DE DATOS */
                        // Crear carpeta

                        $facturas = '../../facturas/';

                        if (!is_dir($facturas)) {
                            mkdir($facturas);
                        }
                        $nombreFactura = md5(uniqid(rand(), true)) . ".pdf";
                        $nombreGuia = md5(uniqid(rand(), true)) . ".pdf";
                        
                        //subir los archivos
                        move_uploaded_file($factura['tmp_name'], $facturas . $nombreFactura);
                        move_uploaded_file($guiaRem['tmp_name'], $facturas . $nombreGuia);

                        //guardar datos

                        $query = "INSERT INTO facturas (id_orders, order_id, num_fact, guiaRem, estado, observacion) 
                            values ('$id_orders', '$order_id', '$nombreFactura', '$nombreGuia', '$estado', '$observacion')";

                        $guardar = mysqli_query($db4, $query);
                    //FIN DE CARGA DE ARCHIVOS EN LA BDD
                //FIN DE CAPTURA PRINCIPAL
                //MOTORES DE ACTUALIZACION Y CONTROL DE FILTROS
                    $query5 = "INSERT INTO verificacion
                                            (contactado, 
                                            facturado) 
                                    values ('$contactado', 
                                            '$facturado')";
                    $resultado2 = mysqli_query($db4, $query5);
                //FIN DE CONTROL

                if ($resultado2) {
                    //GENERAR HISTORIAL CON COLLECTED 
                        //consultar el numero de despacho
                        $collected_historial = "SELECT * FROM dispatches WHERE order_id ='${id}'";
                        $buscar = mysqli_query($db3, $collected_historial);
                        $resultado = mysqli_fetch_assoc($buscar); // numero de despacho almacenado en la variable 
                        $id_historial = $resultado['id'];
                        $creado = $resultado['created_at'];
                        //echo $id_historial;
                        //echo $creado;
                        //exit;

                    // GUARDAR EL HISTORIAL CREANDO EL NUMERO DE DESPACHO
                    //declarar variables para el historial
                    $observ_estado = "inicio de proceso";
                    $dispatch_id = $id_historial;
                    $user_id = $usuario;
                    $created_at = $resultado['created_at'];

                    $queryHIS = "INSERT INTO dispatch_statuses ( status, comment, dispatch_id, user_id, created_at, updated_at ) 
                        VALUES ('$status', '$observ_estado', '$dispatch_id', '$user_id', '$created_at', '$fechaGest')";

                    $guardar_his = mysqli_query($db3, $queryHIS);


                    if ($guardar_his) {
                        echo '
                            <div class="alert alert-success">
                                <a href="facturar.php">Continuar facturando mas ordenes</a>
                            </div>';
                        //header('location: usuarios.php');
                        exit();
                    }
                    
                }
            }
        }

        //consulta general para el updete
        $queryGenereal = "SELECT * FROM datosordenes WHERE id = ${id}";
        $consultaGeneral = mysqli_query($db4, $queryGenereal);
        $general = mysqli_fetch_assoc($consultaGeneral);

        //consulta para los detalles del producto
        // $queryProduct = "SELECT SUM(quantity) FROM order_products WHERE order_id = ${id}";
        // $consultaProduct = mysqli_query($db3, $queryProduct);
        // $product = mysqli_fetch_assoc($consultaProduct);

        $query2 = "SELECT * FROM order_clients where order_id = ${id}";
                    $resultado2 = mysqli_query($db3, $query2);

        $query = "SELECT * FROM orders where id = ${id}";
                    $resultado = mysqli_query($db3, $query);

?>
<div class="container">
    <!-- formulario e ingreso de ordenes -->
        <div class="card text-center">
            <div class="card-header">
                <h5 class="card-title">Facturacion y Guias</h5>
            </div>
            <div class="card-body">
                <!-- formulario de ingreso de documentos y registros a manifiestos -->
                <form action=" " method="post" enctype="multipart/form-data">
                <?php foreach($errores as $error) : ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endforeach ?>
                    <div class="container2">
                        <div class="form__container form2">
                            <div class="mb-3" hidden>
                                <label for="formFileSm" class="form-label">Adjuntar la factura</label>
                                <input class="form-control form-control-sm" name="num_fac" id="num_fac" type="file">
                            </div>
                            <div class="mb-3">
                                <label for="formFileSm" class="form-label">Adjuntar la Guia de Remision</label>
                                <input class="form-control form-control-sm" name="guiaRem" id="guiaRem" type="file">
                            </div>
                            <div class="mb-3">
                                <label for="formFileSm" class="form-label">Numero de guia</label>
                                <input class="form-control form-control-sm" name="n_guia" id="guiaRem" type="text">
                            </div>
                            <div class="mb-3">
                                <select name="responsable_m" class="form-select" aria-label="Default select example">
                                    <option selected>Responsable de Provincia</option>
                                    <option value="ofiGYE">OFICINA GUAYAQUIL</option>
                                    <option value="ofiUIO">OFICINA QUITO</option>
                                    <option value="Henrry Roberto">LOS RIOS (HENRRY ROBERTO)</option>
                                    <option value="Mariana Moreno">MARIANA</option>
                                    <option value="Esteban Trejo">ESTEBAN</option>
                                    <option value="Bryan Jonathan">EL ORO (BRYAN JOATHAN)</option>
                                    <option value="Alisson Quezada">ALISSON</option>
                                    <option value="Vanessa Mera">VANESSA</option>
                                    <option value="Francisco">DON FRANCISCO</option>
                                    <option value="Urbano">URBANO</option>
                                    <option value="Ma Eugenia">MARIA EUGENIA</option>
                                    <option value="Juan Luis">JUAN LUIS</option>
                                    <option value="Marco Cisneros">JUAN LUIS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <center>
                        <div class="botones">
                            <input type="submit" class="btn btn-primary" value="GUARDAR">
                        </div>
                    </center>
                    <div hiddden>
                            <?php 
                                //consulta de datos para la bdd general
                                $query222 = "SELECT * FROM order_clients where order_id = ${id}";
                                $resultado222 = mysqli_query($db3, $query222); 
                                
                                while($resultadoApi002 = mysqli_fetch_assoc($resultado222)) : 
                            ?>
                                        <input type="hidden" name="name1" value="<?php echo $resultadoApi002['name'];?>">
                                        <input type="hidden" name="last_name" value="<?php echo $resultadoApi002['last_name'];?>">
                                        <input type="hidden" name="province" value="<?php echo $resultadoApi002['province'];?>">
                                        <input type="hidden" name="city" value="<?php echo $resultadoApi002['city'];?>">
                                        <input type="hidden" name="address1" value="<?php echo $resultadoApi002['address'];?>">
                                        <input type="hidden" name="reference" value="<?php echo $resultadoApi002['reference'];?>">
                                        <input type="hidden" name="phone" value="<?php echo $resultadoApi002['phone'];?>">
                                        <input type="hidden" name="landline" value="<?php echo $resultadoApi002['landline'];?>">

                            <?php endwhile; ?>
                            <?php 
                                //consulta de datos para la bdd general
                                $query2220 = "SELECT * FROM orders where id = ${id}";
                                $resultado2220 = mysqli_query($db3, $query2220); 
                                
                                while($resultadoApi0002 = mysqli_fetch_assoc($resultado2220)) : 
                            ?>
                                        <input type="hidden" name="order_id" value="<?php echo $resultadoApi0002['order_id'];?>">
                                        <input type="hidden" name="order_at" value="<?php echo $resultadoApi0002['order_at'];?>">
                                        <input type="hidden" name="delivery_at" value="<?php echo $resultadoApi0002['delivery_at'];?>">
                                        <input type="hidden" name="total" value="<?php
                                                                                            $precio = $resultadoApi0002['total']/100; 
                                                                                            echo $precio;
                                                                                        ?>">
                                        <input type="hidden" name="status" value="<?php echo $resultadoApi0002['status'];?>">
                                        <input type="hidden" name="created_at" value="<?php echo $resultadoApi0002['created_at'];?>">
                                       

                            <?php endwhile; ?>
                    </div>
                </form>
                <!-- FIN formulario de ingreso de documentos y registros a manifiestos -->
            </div>
            <div class="card-footer text-muted">
            Numero de ORDEN <?php echo $general['order_id']; ?>
            </div>
        </div>
    <!-- fin del formulario e ingreso de las ordenes -->
    <!-- informacion para la facturacion -->
        <div class="accordion" id="accordionExample">
            <!-- INFORMACION COMPILADA DE LA API -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        INFORMACION DEL CLIENTE (recopilacion desde API)
                    </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?php while($resultadoApi2 = mysqli_fetch_assoc($resultado2)) : ?>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Nombre Apellido</strong>
                                <?php echo $resultadoApi2['name']." ".$resultadoApi2['last_name']; ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Provincia</strong>
                                <?php echo $resultadoApi2['province']; ?>
                                / 
                                <strong>Canton</strong>
                                <?php echo $resultadoApi2['canton']; ?>
                                / 
                                <strong>Ciudad</strong>
                                <?php echo $resultadoApi2['city']; ?>
                                / 
                                <strong>Parroquia</strong>
                                <?php echo $resultadoApi2['parish']; ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Direccion</strong>
                                <?php echo $resultadoApi2['address']; ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Referencia </strong>
                                <?php echo $resultadoApi2['reference']; ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Contactos</strong>
                                 <?php echo $resultadoApi2['phone']; ?> / 
                                <?php echo $resultadoApi2['landline']; ?>
                            </li>
                        </ul>
                        <?php endwhile; ?>
                        <strong class="fs-6">Informacion directa</strong> Informacion sin filtro
                         <code class="fs-6">Compilado desde la API</code>.
                    </div>
                    </div>
                </div>
            <!-- FIN COMPILADA DE LA API -->
            <!-- DETLLES DE LA ORDEN  -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTwo">
                        DATOS DE LA ORDEN (cantidad, orden, fechas)
                    </button>
                    </h2>
                    <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?php while($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <strong>Numero de Orden</strong>
                                    <?php echo $resultadoApi['order_id']; //numero de la orden emitida en Rusia?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Fecha de Creacion</strong>
                                    <?php echo $resultadoApi['order_at']; ?>
                                    / 
                                    <strong>Valor de la Orden</strong>
                                    $<?php $total = $resultadoApi['total']/100; $total2 =filter_var( $total, FILTER_VALIDATE_FLOAT); echo $total2;?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Estado de la Orden</strong>
                                    <?php echo $resultadoApi['status']; ?>
                                </li>
                            </ul>
                        <?php endwhile; ?>
                        <strong>Detalles de la Orden</strong>Reporte compilado de la orden desde  <code>API</code>.
                    </div>
                    </div>
                </div>
            <!-- FIN DETLLES DE LA ORDEN  -->
            <!-- DETLLES DE LOS PRODUCTOS  -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        DETALLE DE LOS PRODUCTOS
                    </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <?php
                            $query3 = "SELECT * FROM order_products where order_id = ${id}";
                            $resultado3 = mysqli_query($db3, $query3);
                        ?>
                    <div class="accordion-body">
                        
                            <table class="table" >
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
                                            <td>
                                                <?php echo $resultadoApi3['name']; ?>
                                            </td>
                                            <td>
                                                $<?php $total = $resultadoApi3['unit_price']/100; $total4 =filter_var( $total, FILTER_VALIDATE_FLOAT); echo $total4;?>
                                                </td>
                                            <td>
                                                <?php echo $resultadoApi3['quantity']; ?>
                                            </td>
                                        </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        <strong>Informacion desde la API.</strong>Productos desde <code>API</code>.
                    </div>
                    </div>
                </div>
            <!-- FIN DETLLES DE LOS PRODUCTOS  -->
                <!-- DATOS PROPORSIONADOS POR EL CALL CENTER  -->
                    <div class="accordion-item" hidden>
                        <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseThree">
                            DATOS PROCESADOS POR EL CALL CENTER (si no hay datos la facturacion a consumidor fianl)
                        </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <?php 
                                $datos_sistema = "SELECT * FROM datosordenes where id = ${id}";
                                $datos_ord = mysqli_query($db4, $datos_sistema);
                            ?>
                        <div class="accordion-body">
                        <?php while($resultadoApi12 = mysqli_fetch_assoc($datos_ord)) : ?>
                        <ul class="list-group">
                                <li class="list-group-item">
                                    <strong>Nombres</strong>
                                    <?php echo $resultadoApi12['nombres']; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Cedula</strong>
                                    <?php echo $resultadoApi12['cedula']; ?>
                                    / 
                                    <strong>Ciudad</strong>
                                    <?php echo $resultadoApi12['city']; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Direccion</strong>
                                    <?php echo $resultadoApi12['direccion']; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Correo</strong>
                                    <?php echo $resultadoApi12['correo']; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Observacion</strong>
                                    <?php echo $resultadoApi12['observacion']; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Estado de Operacion</strong>
                                    <?php echo $resultadoApi12['estado']; ?>
                                </li>
                            </ul>
                            <?php endwhile; ?>
                            <strong>Datos procesados</strong> desde el  <code>Sistema</code>.
                        </div>
                        </div>
                    </div>
                <!--  FIN DATOS PROPORSIONADOS POR EL CALL CENTER  -->
        </div>
    <!-- fin del acoordeon de informacion para facturacion -->
</div>

<?php
incluirTemplate('fottersis');
?>