<?php 
    //$id = $_GET['id'];
    //$id = filter_var($id, FILTER_VALIDATE_INT);

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

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $buscar = $_POST['buscar'];
    } 
    
    $query2 = "SELECT * FROM datosordenes where order_id = ${buscar}";
           $resultado2 = mysqli_query($db4, $query2);

    $query = "SELECT * FROM orders where order_id = ${buscar}";
             $resultado2 = mysqli_query($db3, $query);

?>
<body class="bg-gradient-primary">
    <div class="container">
            <h1 class="text-primary fs-3 text-center">CONSULTAR DETALLES DE LAS ORDENES</h1>
            
        <!-- detalles generales de las ordenes agrupadas INICIO DE INFORMACION -->
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
                        <?php while($resultadoApi2 = mysqli_fetch_assoc($resultado2)) : 
                            $id_buscar = $resultadoApi2['id']; ?>
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
                                <?php echo $resultadoApi2['landline']; 
                                $buscar_D = $resultadoApi2['id']
                                ?>
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
                            
                            $query3 = "SELECT * FROM order_products where order_id = ${id_buscar}";
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
                        $query4 = "SELECT * FROM facturas where order_id = ${id_buscar}";
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
                                                $idver = $id_buscar;
                                                $busFact = "SELECT * FROM facturas WHERE id_orders = ${idver}";
                                                $fact = mysqli_query($db4, $busFact);
                                                $apiFact = mysqli_fetch_assoc($fact);
                                            ?>
                                            <a href="../../facturas/<?php echo $apiFact['num_fact']; ?>#toolbar=1&navpanes=1&scrollbar=0" target="blanck" class="tabla__archivos"> VER FACTURA↓</a>
                                        </td>
                                        <td>
                                            <?php  
                                                $idver = $id_buscar;
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
            <!-- DATOS PROPORSIONADOS POR EL CALL CENTER  -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseThree">
                        DATOS PROCESADOS POR EL CALL CENTER (si no hay datos la facturacion a consumidor fianl)
                    </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <?php 
                            $datos_sistema = "SELECT * FROM datosordenes where id = ${id_buscar}";
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
            <!-- HISTORIAL DE ENTREGA Y MOVIEMIENTO DE LA ORDEN -->
                <!-- consulta del numero de despacho -->
                <?php 
                    $dispatches = "SELECT * FROM dispatches WHERE order_id = ${buscar_D}";
                        $dispatch_es = mysqli_query($db3, $dispatches);
                        $disp_estado = mysqli_fetch_assoc($dispatch_es);
                ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingNine">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                        HISTORIAL DE GESTION Y MOVIMIENTO DE PAQUETES
                    </button>
                    </h2>
                    <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Estado Actual</strong>
                                <?php echo $disp_estado['status']; ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Fecha de Acutualizacion</strong>
                                <?php echo $disp_estado['updated_at']; ?>
                                / 
                                <strong>Obervacion</strong>
                                <?php echo $disp_estado['observation']; ?>
                            </li>
                        </ul>
                            <?php 
                                //CARGAR EL HISTORIAL COMPLETO
                                $id_despacho = $disp_estado['id'];
                                $historial = "SELECT * FROM dispatch_statuses WHERE dispatch_id = ${id_despacho}";
                                $historial_q = mysqli_query($db3, $historial);
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <?php while($historial_C = mysqli_fetch_assoc($historial_q)):?>
                                        <ul class="list-group list-group-flush border border-primary">
                                            <li class="list-group-item">
                                                <strong>Estado reportado</strong>
                                                <?php echo $historial_C['status']; ?>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Fecha Reporte</strong>
                                                <?php echo $historial_C['updated_at']; ?>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Obervacion</strong>
                                                <?php echo $historial_C['comment']; ?>
                                            </li>
                                        </ul>
                                    <?php endwhile?>
                                </div>
                            </div> 
                        <strong>Datos procesados</strong> desde el  <code>Sistema</code>.
                        
                    </div>
                    </div>
                </div>
            <!-- fin de historial completo -->
            <!-- HISTORIAL DE MOVIEMIENTO DE LA CARGA -->
                <!-- consulta del numero de despacho -->
                <?php 
                    $historial_p = "SELECT * FROM datosordenes WHERE id = ${buscar_D}";
                        $dispatch_pq = mysqli_query($db4, $historial_p);
                        $disp_paquetes = mysqli_fetch_assoc($dispatch_pq);
                ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingNine">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseten" aria-expanded="false" aria-controls="collapseten">
                        HISTORIAL MOVIMIENTO DE PAQUETES
                    </button>
                    </h2>
                    <div id="collapseten" class="accordion-collapse collapse" aria-labelledby="headingten" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Responsable</strong>
                                <?php echo $disp_paquetes['responsable_m']; ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Estado Actual</strong>
                                <?php echo $disp_paquetes['ubicacion_p']; ?>
                                / 
                                <strong>Actualizado por:</strong>
                                <?php echo $disp_paquetes['res_ubp']; ?>
                            </li>
                        </ul>
                            <?php 
                                //CARGAR EL HISTORIAL COMPLETO
                                $id_despacho = $disp_paquetes['id'];
                                $historial_p = "SELECT * FROM historial_paquetes WHERE id_primary = ${buscar_D}";
                                $historial_paq = mysqli_query($db4, $historial_p);
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <?php while($historial_paq2 = mysqli_fetch_assoc($historial_paq)):?>
                                        <ul class="list-group list-group-flush border border-primary">
                                            <li class="list-group-item">
                                                <strong>Estado reportado</strong>
                                                <?php echo $historial_paq2['ubicacion_p']; ?>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Responsable</strong>
                                                <?php echo $historial_paq2['res_ubp']; ?>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Obervacion</strong>
                                                <?php echo $historial_paq2['observacion']; ?>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Colaborador</strong>
                                                <?php echo $historial_paq2['responsable_m']; ?>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Fecha</strong>
                                                <?php echo $historial_paq2['fecha']; ?>
                                            </li>
                                        </ul>
                                    <?php endwhile?>
                                </div>
                            </div> 
                        <strong>Datos procesados</strong> desde el  <code>Sistema</code>.
                        
                    </div>
                    </div>
                </div>
            <!-- fin de historial de movimientos de paquetes -->
        </div>
    </div>



<?php 
    incluirTemplate('fottersis');     
?>