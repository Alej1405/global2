<?php

$guardar = $_GET['guardar'] ?? null;

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






//ordenes entregadas GC-COURIER
$ordenesGCS = "SELECT SUM(total)  FROM datosordenes WHERE status='delivered';";
$ordenes_GCS = mysqli_query($db4, $ordenesGCS);
$ordenesS = mysqli_fetch_assoc($ordenes_GCS);
$S_ordenes = $ordenesS["SUM(total)"];

//efectividad (medido por el numero de entregados) % de ENTREGAS REALIZADAS
$ordenesEF = "SELECT COUNT(order_id)  FROM datosordenes WHERE status ='delivered';";
$ordenes_EF = mysqli_query($db4, $ordenesEF);
$ordenEF = mysqli_fetch_assoc($ordenes_EF);
$EF_ordenes = $ordenEF["COUNT(order_id)"];

$efectividad = $EF_ordenes * 100 / $n_ordenes;

$efectividad_en = filter_var($efectividad, FILTER_VALIDATE_FLOAT);

$efectividad_entregad = round($efectividad_en);
//ESTADO DE ORDENES POR MES
//CORTE MES DE MAYO
//efectividad ordenes mes de MAYO
$ordenesRE = "SELECT count(id) FROM orders WHERE created_at BETWEEN '2022-05-01' And '2022-05-31';";
$ordenes_RE = mysqli_query($db3, $ordenesRE);
$ordenRE = mysqli_fetch_assoc($ordenes_RE);
$RE_ordenes = $ordenRE["count(id)"];

// ORDENES REQUESTED
$mayo_re = "SELECT count(id) FROM orders WHERE status = 'requested' and created_at BETWEEN '2022-05-01' And '2022-05-31';";
$M_req = mysqli_query($db3, $mayo_re);
$RQ_mayo = mysqli_fetch_assoc($M_req);
$requested_mayo = $RQ_mayo["count(id)"];
// ORDENES COLLECTED
$mayo_co = "SELECT count(id) FROM orders WHERE status = 'collected' and created_at BETWEEN '2022-05-01' And '2022-05-31';";
$M_co = mysqli_query($db3, $mayo_co);
$CO_mayo = mysqli_fetch_assoc($M_co);
$collected_mayo = $CO_mayo["count(id)"];
// ORDENES DELIVERED
$mayo_de = "SELECT count(id) FROM orders WHERE status = 'delivered' and created_at BETWEEN '2022-05-01' And '2022-05-31';";
$M_de = mysqli_query($db3, $mayo_de);
$DE_mayo = mysqli_fetch_assoc($M_de);
$delivered_mayo = $DE_mayo["count(id)"];
// ORDENES UNDELIVERED
$mayo_un = "SELECT count(id) FROM orders WHERE status = 'undelivered' and created_at BETWEEN '2022-05-01' And '2022-05-31';";
$M_und = mysqli_query($db3, $mayo_un);
$UN_mayo = mysqli_fetch_assoc($M_und);
$undelivered_mayo = $UN_mayo["count(id)"];
// ORDENES RETURNED
$mayo_re = "SELECT count(id) FROM orders WHERE status = 'returnes' and created_at BETWEEN '2022-05-01' And '2022-05-31';";
$M_ret = mysqli_query($db3, $mayo_re);
$RE_mayo = mysqli_fetch_assoc($M_ret);
$returned_mayo = $RE_mayo["count(id)"];
//FIN CORTE MAYO
//CORTE DE ABRIL
//efectividad ordenes mes de MAYO
$ordenes_abril = "SELECT count(id) FROM orders WHERE created_at BETWEEN '2022-04-01' And '2022-04-30';";
$ordenes_AB = mysqli_query($db3, $ordenes_abril);
$ordenAB = mysqli_fetch_assoc($ordenes_AB);
$AB_ordenes = $ordenAB["count(id)"];

// ORDENES REQUESTED
$abril_re = "SELECT count(id) FROM orders WHERE status = 'requested' and created_at BETWEEN '2022-04-01' And '2022-04-30';";
$A_req = mysqli_query($db3, $abril_re);
$RQ_abril = mysqli_fetch_assoc($A_req);
$requested_abril = $RQ_abril["count(id)"];
// ORDENES COLLECTED
$abril_co = "SELECT count(id) FROM orders WHERE status = 'collected' and created_at BETWEEN '2022-04-01' And '2022-04-30';";
$A_co = mysqli_query($db3, $abril_co);
$CO_abril = mysqli_fetch_assoc($A_co);
$collected_abril = $CO_abril["count(id)"];
// ORDENES DELIVERED
$abril_de = "SELECT count(id) FROM orders WHERE status = 'delivered' and created_at BETWEEN '2022-04-01' And '2022-04-30';";
$A_de = mysqli_query($db3, $abril_de);
$DE_abril = mysqli_fetch_assoc($A_de);
$delivered_abril = $DE_abril["count(id)"];
// ORDENES UNDELIVERED
$abril_un = "SELECT count(id) FROM orders WHERE status = 'undelivered' and created_at BETWEEN '2022-04-01' And '2022-04-30';";
$A_und = mysqli_query($db3, $abril_un);
$UN_abril = mysqli_fetch_assoc($A_und);
$undelivered_abril = $UN_abril["count(id)"];
// ORDENES RETURNED
$abril_re = "SELECT count(id) FROM orders WHERE status = 'returnes' and created_at BETWEEN '2022-04-01' And '2022-04-30';";
$A_ret = mysqli_query($db3, $abril_re);
$RE_abril = mysqli_fetch_assoc($A_ret);
$returned_abril = $RE_abril["count(id)"];
//FIN CORTE ABRIL

//CORTE DE MARZO
//efectividad ordenes mes de MAYO
$ordenes_marzo = "SELECT count(id) FROM orders WHERE created_at BETWEEN '2022-03-01' And '2022-03-31';";
$ordenes_MA = mysqli_query($db3, $ordenes_marzo);
$ordenMA = mysqli_fetch_assoc($ordenes_MA);
$MA_ordenes = $ordenMA["count(id)"];

// ORDENES REQUESTED
$marzo_re = "SELECT count(id) FROM orders WHERE status = 'requested' and created_at BETWEEN '2022-03-01' And '2022-03-31';";
$M_req = mysqli_query($db3, $marzo_re);
$RQ_marzo = mysqli_fetch_assoc($M_req);
$requested_marzo = $RQ_marzo["count(id)"];
// ORDENES COLLECTED
$marzo_co = "SELECT count(id) FROM orders WHERE status = 'collected' and created_at BETWEEN '2022-03-01' And '2022-03-31';";
$M_co = mysqli_query($db3, $marzo_co);
$CO_marzo = mysqli_fetch_assoc($M_co);
$collected_marzo = $CO_marzo["count(id)"];
// ORDENES DELIVERED
$marzo_de = "SELECT count(id) FROM orders WHERE status = 'delivered' and created_at BETWEEN '2022-03-01' And '2022-03-31';";
$M_de = mysqli_query($db3, $marzo_de);
$DE_marzo = mysqli_fetch_assoc($M_de);
$delivered_marzo = $DE_marzo["count(id)"];
// ORDENES UNDELIVERED
$marzo_un = "SELECT count(id) FROM orders WHERE status = 'undelivered' and created_at BETWEEN '2022-03-01' And '2022-03-31';";
$M_und = mysqli_query($db3, $marzo_un);
$UN_marzo = mysqli_fetch_assoc($M_und);
$undelivered_marzo = $UN_marzo["count(id)"];
// ORDENES RETURNED
$marzo_re = "SELECT count(id) FROM orders WHERE status = 'returnes' and created_at BETWEEN '2022-03-01' And '2022-03-31';";
$M_ret = mysqli_query($db3, $marzo_re);
$RE_marzo = mysqli_fetch_assoc($M_ret);
$returned_marzo = $RE_marzo["count(id)"];
//FIN CORTE MARZO
// FIN DE REPORTE MENSUAL

//efectividad (medido por el numero de entregados) % POR PORCESAR
$ordenesCO = "SELECT COUNT(order_id)  FROM datosordenes WHERE status ='collected';";
$ordenes_CO = mysqli_query($db4, $ordenesCO);
$ordenCO = mysqli_fetch_assoc($ordenes_CO);
$CO_ordenes = $ordenCO["COUNT(order_id)"];

$efectividadCO = $CO_ordenes * 100 / $n_ordenes;

$efectividad_enCO = filter_var($efectividadCO, FILTER_VALIDATE_FLOAT);

$efectividad_entregadCO = round($efectividad_enCO);

//efectividad (medido por el numero de entregados) % DE NO ENTREGADAS
$ordenesUN = "SELECT COUNT(order_id)  FROM datosordenes WHERE status ='undelivered';";
$ordenes_UN = mysqli_query($db4, $ordenesUN);
$ordenUN = mysqli_fetch_assoc($ordenes_UN);
$UN_ordenes = $ordenUN["COUNT(order_id)"];

$efectividadUN = $UN_ordenes * 100 / $n_ordenes;

$efectividad_enUN = filter_var($efectividadUN, FILTER_VALIDATE_FLOAT);

$efectividad_entregadUN = round($efectividad_enUN);

//efectividad (medido por el numero de entregados) % DE RETORNOS
$ordenesRET = "SELECT COUNT(order_id)  FROM datosordenes WHERE status ='returnes';";
$ordenes_RET = mysqli_query($db4, $ordenesRET);
$ordenRET = mysqli_fetch_assoc($ordenes_RET);
$RET_ordenes = $ordenRET["COUNT(order_id)"];

$efectividadRET = $RET_ordenes * 100 / $n_ordenes;

$efectividad_enRET = filter_var($efectividadRET, FILTER_VALIDATE_FLOAT);

$efectividad_entregadRET = round($efectividad_enRET);

//total de unidades despachadas, cuenta en tiempo real
$queryUNI = "SELECT SUM(quantity) FROM order_products";
$consultaUNI = mysqli_query($db3, $queryUNI);
$unidades = mysqli_fetch_assoc($consultaUNI);
$unidades_desp = $unidades['SUM(quantity)'] - 2071;
$porcentaje_total = $unidades_desp * 100 /

    //CONTEO DE NUMERO DE ORDENES A LA FECHA ACTUAL

    $fechaActual = 2022 - 02 - 20; //date('Y-m-d');
$fechaActual2 = date("Y-m-d", strtotime($fechaActual . "+ 1 days"));

$ordenesAC = "SELECT COUNT(order_id) FROM datosordenes WHERE created_at BETWEEN '${fechaActual}' AND '${fechaActual2}';";
$ordenes_AC = mysqli_query($db4, $ordenesAC);
$ordenAC = mysqli_fetch_assoc($ordenes_AC);

$ordenesAC2 = "SELECT COUNT(order_id) FROM datosordenes WHERE estado ='facturado';";
$ordenes_AC2 = mysqli_query($db4, $ordenesAC2);
$ordenAC2 = mysqli_fetch_assoc($ordenes_AC2);

//INICIO PARA COMPRAR ORDENES INGRESADAS VS PROCESADAS
$ordenesAC3 = "SELECT COUNT(order_id) FROM datosordenes WHERE estado ='no';";
$ordenes_AC3 = mysqli_query($db4, $ordenesAC3);
$ordenAC3 = mysqli_fetch_assoc($ordenes_AC3);

//numero de ordenes por ingresar
$ordenesAC4 = "SELECT COUNT(order_id) FROM datosordenes WHERE estado ='REGISTRADO';";
$ordenes_AC4 = mysqli_query($db4, $ordenesAC4);
$ordenAC4 = mysqli_fetch_assoc($ordenes_AC4);

//control de unidades
$query1 = "SELECT SUM(cUnidad) FROM ingresog";
$consulta1 = mysqli_query($db2, $query1);
$registog = mysqli_fetch_assoc($consulta1);

$porcentaje = $registog["SUM(cUnidad)"];
$porcentaje_t = $unidades_desp * 100 / $porcentaje;
$porcentaje_to = filter_var($porcentaje_t, FILTER_VALIDATE_FLOAT);
$porcentaje_total = round($porcentaje_to);

//calculo de stock en bodega lo que hay menos lo que salio.

$stock = $porcentaje - $unidades_desp;


// inventario por producto  QUERYS GENERALES
//Recardio corte por unidad 
$rec_Q = "SELECT SUM(quantity) from order_products WHERE name = 'Recardio (Ecuador)'";
$rec = mysqli_query($db3, $rec_Q);
$qt_recardio = mysqli_fetch_assoc($rec);
//Dialine corte por unidad 
$dia_Q = "SELECT SUM(quantity) from order_products WHERE name = 'Dialine (Ecuador)'";
$dia = mysqli_query($db3, $dia_Q);
$qt_dialine = mysqli_fetch_assoc($dia);
//Erasmin corte por unidad 
$eras_Q = "SELECT SUM(quantity) from order_products WHERE name = 'Erasmin (Ecuador)'";
$eras = mysqli_query($db3, $eras_Q);
$cu_erasmin = mysqli_fetch_assoc($eras);
// fin de cantidad por producto
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Panel de Control</h1>
        <div class="btn-group" role="group" aria-label="Basic example">
                <a href="../DESCARGAS/excell_gcgo.php" target="blanck" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"> 
                    <i class="fas fa-download fa-sm text-white-50"></i> Reporte General
                </a>
                <a href="../callcenter/descargaexcel.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"> 
                    <i class="fas fa-download fa-sm text-white-50"></i> Reporte Cliente Rusia
                </a>
            </div>
           
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- NUMERO DE ORDENES -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                GC-box NUMERO DE ORDENES</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $n_ordenes ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- COD EN TIEMPO REAL -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                RECOLECCION</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo $S_ordenes ?>,00</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- EFECTIVIDAD -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">efectividad
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $efectividad_entregad; ?>%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $efectividad_entregad ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARGAS GLOBAL CARGO -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                CARGAS GLOBAL CARGO</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $n_ordenesGB ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- TARJETAS DINAMICAS DE CONTENIDO -->
        <div class="col-lg-6 mb-4">

            <!-- NUMERO DE PAQUETES POR ESTADO -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">MAYO (ORDENES EN TOTAL <?php echo $RE_ordenes; ?>) </h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Request / Solicitado <span class="float-right"><?php echo $requested_mayo; ?></span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $requested_mayo; ?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="<?php echo $RE_ordenes; ?>"></div>
                    </div>
                    <h4 class="small font-weight-bold">Collected / Procesando <span class="float-right"><?php echo $collected_mayo; ?></span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $collected_mayo; ?>%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="<?php echo $RE_ordenes; ?>"></div>
                    </div>
                    <h4 class="small font-weight-bold">Delivered / Entregados <span class="float-right"><?php echo $delivered_mayo; ?></span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: <?php
                                                                                    $deli_mayo = $delivered_mayo * 100 / $RE_ordenes;
                                                                                    $ent_mayo = filter_var($deli_mayo, FILTER_VALIDATE_FLOAT);
                                                                                    $entregas_mayo = round($ent_mayo);
                                                                                    echo $entregas_mayo;
                                                                                    ?>%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="<?php echo $RE_ordenes; ?>"></div>
                    </div>
                    <h4 class="small font-weight-bold">Undelivered / No entregados <span class="float-right"><?php echo $undelivered_mayo; ?></span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php
                                                                                            $unde_mayo = $undelivered_mayo * 100 / $RE_ordenes;
                                                                                            $noent_mayo = filter_var($unde_mayo, FILTER_VALIDATE_FLOAT);
                                                                                            $noentregas_mayo = round($noent_mayo);
                                                                                            echo $noentregas_mayo;
                                                                                            ?>%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="<?php echo $RE_ordenes; ?>"></div>
                    </div>
                    <h4 class="small font-weight-bold">Returnes / Regresos <span class="float-right"><?php echo $returned_mayo; ?></span></h4>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width:<?php
                                                                                                $retu_mayo = $returned_mayo * 100 / $RE_ordenes;
                                                                                                $retur_mayo = filter_var($retu_mayo, FILTER_VALIDATE_FLOAT);
                                                                                                $regresos_mayo = round($retur_mayo);
                                                                                                echo $regresos_mayo;
                                                                                                ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="<?php echo $RE_ordenes; ?>"></div>
                    </div>
                </div>
            </div>

            <!-- NUMERO DE PAQUETES POR ESTADO -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">ABRIL (ORDENES EN TOTAL <?php echo $AB_ordenes; ?>)</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Delivered / Entregados <span class="float-right"><?php echo $delivered_abril; ?></span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: <?php
                                                                                    $deli_abril = $delivered_abril * 100 / $AB_ordenes;
                                                                                    $ent_abril = filter_var($deli_abril, FILTER_VALIDATE_FLOAT);
                                                                                    $entregas_abril = round($ent_abril);
                                                                                    echo $entregas_abril;
                                                                                    ?>%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="<?php echo $AB_ordenes; ?>"></div>
                    </div>
                    <h4 class="small font-weight-bold">Undelivered / No entregados <span class="float-right"><?php echo $undelivered_abril; ?></span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php
                                                                                            $undeli_abril = $undelivered_abril * 100 / $AB_ordenes;
                                                                                            $noent_abril = filter_var($undeli_abril, FILTER_VALIDATE_FLOAT);
                                                                                            $noentregas_abril = round($noent_abril);
                                                                                            echo $noentregas_abril;
                                                                                            ?>%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="<?php echo $AB_ordenes; ?>"></div>
                    </div>
                    <h4 class="small font-weight-bold">Returnes / Regresos <span class="float-right"><?php echo $returned_abril; ?></span></h4>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php
                                                                                                $ret_abril = $returned_abril * 100 / $AB_ordenes;
                                                                                                $regre_abril = filter_var($ret_abril, FILTER_VALIDATE_FLOAT);
                                                                                                $regresos_abril = round($regre_abril);
                                                                                                echo $regresos_abril;
                                                                                                ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="<?php echo $AB_ordenes; ?>"></div>
                    </div>
                </div>
            </div>

            <!-- NUMERO DE PAQUETES POR ESTADO -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">MARZO (ORDENES EN TOTAL <?PHP echo $MA_ordenes; ?>)</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Delivered / Entregados <span class="float-right"><?php echo $delivered_marzo; ?></span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: <?php
                                                                                    $deli_marzo = $delivered_marzo * 100 / $MA_ordenes;
                                                                                    $ent_marzo = filter_var($deli_marzo, FILTER_VALIDATE_FLOAT);
                                                                                    $entregas_marzo = round($ent_marzo);
                                                                                    echo $entregas_marzo;
                                                                                    ?>%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="<?php echo $MA_ordenes; ?>"></div>
                    </div>
                    <h4 class="small font-weight-bold">Undelivered / No entregados <span class="float-right"><?php echo $undelivered_marzo; ?></span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php
                                                                                            $undeli_marzo = $undelivered_marzo * 100 / $MA_ordenes;
                                                                                            $noent_marzo = filter_var($undeli_marzo, FILTER_VALIDATE_FLOAT);
                                                                                            $noentregas_marzo = round($noent_marzo);
                                                                                            echo $noentregas_marzo;
                                                                                            ?>%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="<?php echo $MA_ordenes; ?>"></div>
                    </div>
                    <h4 class="small font-weight-bold">Returnes / Regresos <span class="float-right"><?php echo $returned_marzo; ?></span></h4>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php
                                                                                                $ret_marzo = $returned_marzo * 100 / $MA_ordenes;
                                                                                                $regre_marzo = filter_var($ret_marzo, FILTER_VALIDATE_FLOAT);
                                                                                                $regresos_marzo = round($regre_marzo);
                                                                                                echo $regresos_marzo;
                                                                                                ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="<?php echo $MA_ordenes; ?>"></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detalle de Stock</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Unidades recibidas:<span class="float-right"><?php echo $registog["SUM(cUnidad)"] ?></span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $registog["SUM(cUnidad)"] ?>%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="<?php echo $registog["SUM(cUnidad)"] ?>"></div>
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Unidades despachadas:<span class="float-right"><?php echo $unidades_desp; ?></span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $porcentaje_total; ?>%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="<?php echo $registog["SUM(cUnidad)"]; ?>"></div>
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Unidades en Bodega <span class="float-right"><?php echo $stock; ?></span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $stock; ?>%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="<?php echo $registog["SUM(cUnidad)"] ?>"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php
incluirTemplate('fottersis');
?>