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

    $query2 = "SELECT * FROM order_clients where order_id = ${id}";
            $resultado2 = mysqli_query($db3, $query2);

    $query = "SELECT * FROM orders where id = ${id}";
            $resultado = mysqli_query($db3, $query);
    
    $errores = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            //DECLARACION DE VARIABLES TABLA DATOSORDENES 
            $ubicacion_p = $_POST['ubicacion_p'];
            $fecha = $_POST['fecha'];
            $resp_ubp = $_SESSION['usuario'];
            $responsable_m = mysqli_real_escape_string($db, $_POST['responsable_m']);
            $observacion = mysqli_real_escape_string($db, $_POST['observacion']);
            if(!$ubicacion_p) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA LA GESTION";
            }
            if(!$responsable_m) {
                $errores[] = "OTRA VEZ!!!! QUESFFFF AGREGA UN RESPONSABLE DEL PAQUETE";
            }
            if(empty($errores)) {
                //ACTUALIZACION DE DATOS 
                    $ubicacion = "UPDATE datosordenes SET ubicacion_p = '${ubicacion_p}',
                                                          responsable_m = '${responsable_m}',
                                                          res_ubp = '${resp_ubp}',
                                                          fecha_salida = '${fecha}'
                                                          WHERE id = ${id};";
                    $act_ubicacion = mysqli_query($db4, $ubicacion);

                    //historial de paquetes 
                    $historial_ubicacion = "INSERT INTO historial_paquetes (id_primary, responsable_m, ubicacion_p, observacion, res_ubp, fecha) VALUES 
                                                            ('${id}', '${responsable_m}', '${ubicacion_p}', '${observacion}', '${resp_ubp}', '${fecha}');";
                    $his_ubicacion = mysqli_query($db4, $historial_ubicacion);
                        // echo $historial_ubicacion; 
                        // exit;
                    if ($his_ubicacion) {
                        echo '
                            <div class="alert alert-success">
                                <a href="seguimiento.php">Continuar actualizando la gestion</a>
                            </div>';
                        //header('location: usuarios.php');
                        exit();
                    }
            }


        }

?>
<body class="bg-gradient-primary">
    <div class="container">
            <h1 class="text-primary fs-3 text-center">ACTUALIZAR UBICACION DE PAQUETES</h1>
            
        <!-- detalles generales de las ordenes agrupadas INICIO DE INFORMACION -->
        <div class="accordion" id="accordionExample">
            <!-- INFORMACION COMPILADA DE LA API 
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
                                <strong>Ciudad</strong>
                                <?php echo $resultadoApi2['city']; ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Direccion</strong>
                                <?php echo $resultadoApi2['address']; ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Direccion</strong>
                                <?php echo $resultadoApi2['reference']; ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Direccion</strong>
                                <?php echo $resultadoApi2['phone']; ?>
                                <?php echo $resultadoApi2['landline']; ?>
                            </li>
                        </ul>
                        <?php endwhile; ?>
                        <strong class="fs-6">Informacion directa</strong> Informacion sin filtro
                         <code class="fs-6">Compilado desde la API</code>.
                    </div>
                    </div>
                </div>
            FIN COMPILADA DE LA API -->
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
                                    <strong>Direccion</strong>
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
            <!-- DOCUMENTOS DE LA ORDEN  -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                        DOCUMENTOS DE SOPORTE DE LA ORDEN (factura y guia)
                    </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                    <?php
                        $query4 = "SELECT * FROM facturas where order_id = ${id}";
                        $resultado3 = mysqli_query($db4, $query4);
                    ?>
                
                        <table class="table" >
                            <thead>
                                <tr>
                                    <th>FACTURA</th>
                                    <th>GUIA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php //while($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
                                    <tr>
                                        <td>
                                            <?php  
                                                $idver = $id;
                                                $busFact = "SELECT * FROM facturas WHERE id_orders = ${idver}";
                                                $fact = mysqli_query($db4, $busFact);
                                                $apiFact = mysqli_fetch_assoc($fact);
                                            ?>
                                            <a href="../../facturas/<?php echo $apiFact['num_fact']; ?>#toolbar=1&navpanes=1&scrollbar=0" target="blanck" class="tabla__archivos"> VER FACTURA↓</a>
                                        </td>
                                        <td>
                                            <?php  
                                                $idver = $id;
                                                $busFact = "SELECT * FROM facturas WHERE id_orders = ${idver}";
                                                $fact = mysqli_query($db4, $busFact);
                                                $apiFact = mysqli_fetch_assoc($fact);
                                            ?>
                                            <a href="../../facturas/<?php echo $apiFact['guiaRem']; ?>#toolbar=1&navpanes=1&scrollbar=0" target="blanck" class="tabla__archivos"> VER GUIA ↓</a>
                                        </td>

                                    </tr>
                                <?php //endwhile; ?>
                            </tbody>
                        </table>
                        <strong>Datos procesados .</strong> desde el <code>Sistema</code>
                    </div>
                    </div>
                </div>
            <!-- FIN DOCUMENTOS DE LA ORDEN  -->
        </div>
        <br>
        <!-- FORMULARIO DE ACTUALIZACION -->
            <div class="card bg-light">
                    <?php foreach($errores as $error) : ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach ?>
                <div class="card-header">
                    ACTUALIZAR
                </div>
                <form action ='' method="POST">
                    <div class="mb-3">
                                <?php 
                                    $estado_orden = "SELECT status FROM datosordenes WHERE id = ${id};";
                                    $Q_estado = mysqli_query($db4, $estado_orden);
                                    $ver_estado = mysqli_fetch_assoc($Q_estado);
                                    echo $ver_estado['status'];
                                ?>
                                   
                                        
                                   <select name="ubicacion_p" class="form-select" aria-label="Default select example">
                                        <?php if($ver_estado['status'] == 'returnes') : ?>
                                                <option value="solicitar devolucion" selected readonly>SOLICITTAR REGRESO</option>
                                        <?php else: ?>
                                                <option value=" ">SELECCIONAR LA GESTION</option>
                                                <option value="sin gestion">SIN GESTION</option>
                                                <option value="en proceso">EN PROCESO</option>
                                                <option value="entregado">ENTREGADO</option>
                                                <option value="entregado y depositado">ENTREGADO Y DEPOSITADO</option>
                                                <option value="solicitar devolucion">SOLICITTAR REGRESO</option>
                                        <?php endif; ?>
                                    </select>
                                    
                    </div>
                    <div class="mb-3">
                                    <select name="responsable_m" class="form-select" aria-label="Default select example">
                                    <option value="<?php 
                                                        $responsable = "SELECT responsable_m FROM datosordenes WHERE id = ${id};";
                                                        $Q_responsable = mysqli_query($db4, $responsable);
                                                        $ver_responsable = mysqli_fetch_assoc($Q_responsable);
                                                        echo $ver_responsable['responsable_m'];
                                                        ?>" selected><?php if(!$ver_responsable['responsable_m']){
                                                                            echo "ASIGNAR Responsable";
                                                                        }else{
                                                                            echo $ver_responsable['responsable_m'];
                                                                        }?></option>
                                        <option value="Henrry">HENRRY</option>
                                        <option value="Roberto">ROBERTO</option>
                                        <option value="Mariana">MARIANA</option>
                                        <option value="Esteban Trejo">ESTEBAN TREJO</option>
                                        <option value="Alisson">ALISSON</option>
                                        <option value="Vanessa">VANESSA</option>
                                        <option value="Francisco">DON FRANCISCO</option>
                                        <option value="Urbano">URBANO</option>
                                        <option value="Ma Eugenia">MARIA EUGENIA</option>
                                        <option value="Juan Luis">JUAN LUIS</option>
                                        <option value="Marco Cisneros">MARCO CISNEROS</option>
                                        <option value="Eloisa">ELOISA</option>
                                        <option value="Carlos Capon">CARLOS CAPON</option>
                                        <option value="Alexandra">ALEXANDRA</option>
                                        <option value="Ivan Ortega">IVAN ORTEGA</option>
                                        <option value="Xavier">XAVIER</option>
                                        <option value="Jhonathan">JHONATHAN</option>
                                        <option value="Jose">JOSE</option>
                                        <option value="Bryan">BRYAN</option>
                                        <option value="Fabricio">FABRICIO</option>
                                        <option value="Carolina">CAROLINA</option>
                                        <option value="Katherine Nogales">KATHERINE NOGALES</option>
                                        <option value="Sin despacho">SIN DESPACHO</option>
                                        <option value="DALIS">DALIS</option>
                                        <option value="Luis Arevalo">LUIS AREVALO</option>
                                        <option value="Steven">STEVEN</option>
                                        <option value="Jesus">JESUS</option>
                                        <option value="Luis Gutierres">LUIS GUTIERRES</option>
                                        <option value="Carlos Brito">CARLOS BRITO</option>
                                        <option value="Javier Jarrin">JAVIER JARRIn</option>
                                        <option value="Richard">RICHARD</option>
                                        <option value="Oficina GYE">OFICINA GYE</option>
                                        <option value="Oficina UIO">OFICINA QUITO</option>
                                        <option value="OTRO">OTRO</option>
                                    </select>
                    </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Observacion</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="observacion"></textarea>
                        </div>
                    <div>
                    </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Fecha de Gestion</label>
                            <input type ="date" class="form-control" id="exampleFormControlTextarea1" rows="3" name="fecha"></input>
                        </div>
                    <div>
                        <input type="submit" class="btn btn-primary aling-c" value='GUARDAR'>
                    </div>
                </form>
            </div>
        <!-- FIN DE FORMULARIO DE ACTUALIZACION -->
    </div>



<?php 
    incluirTemplate('fottersis');     
?>