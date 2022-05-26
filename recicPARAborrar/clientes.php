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
    
    //numero de cargas GC-COURIER
    $ordenesGC = "SELECT COUNT(order_id)  FROM datosordenes;";
    $ordenes_GC = mysqli_query($db4, $ordenesGC);
    $ordenes = mysqli_fetch_assoc($ordenes_GC);
    $n_ordenes = $ordenes["COUNT(order_id)"];

    //numero de cargas GLOBAL CARGO
    $ordenesG = "SELECT COUNT(id)  FROM cargas;";
    $ordenes_G = mysqli_query($db, $ordenesG);
    $ordenesGB = mysqli_fetch_assoc($ordenes_G);
    $n_ordenesGB = $ordenesGB["COUNT(id)"];

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

    $efectividad = $EF_ordenes * 100/$n_ordenes;

    $efectividad_en = filter_var($efectividad, FILTER_VALIDATE_FLOAT);

    $efectividad_entregad = round($efectividad_en);

    //efectividad (medido por el numero de entregados) % ORDENES SOLICITDAS SIN PROCESAR
    $ordenesRE = "SELECT COUNT(order_id)  FROM datosordenes WHERE status ='requested';";
    $ordenes_RE = mysqli_query($db4, $ordenesRE);
    $ordenRE = mysqli_fetch_assoc($ordenes_RE);
    $RE_ordenes = $ordenRE["COUNT(order_id)"];

    $efectividadRE = $RE_ordenes * 100/$n_ordenes;

    $efectividad_enRE = filter_var($efectividadRE, FILTER_VALIDATE_FLOAT);

    $efectividad_entregadRE = round($efectividad_enRE);

    //efectividad (medido por el numero de entregados) % POR PORCESAR
    $ordenesCO = "SELECT COUNT(order_id)  FROM datosordenes WHERE status ='collected';";
    $ordenes_CO = mysqli_query($db4, $ordenesCO);
    $ordenCO = mysqli_fetch_assoc($ordenes_CO);
    $CO_ordenes = $ordenCO["COUNT(order_id)"];

    $efectividadCO = $CO_ordenes * 100/$n_ordenes;

    $efectividad_enCO = filter_var($efectividadCO, FILTER_VALIDATE_FLOAT);

    $efectividad_entregadCO = round($efectividad_enCO);

    //efectividad (medido por el numero de entregados) % DE NO ENTREGADAS
    $ordenesUN = "SELECT COUNT(order_id)  FROM datosordenes WHERE status ='undelivered';";
    $ordenes_UN = mysqli_query($db4, $ordenesUN);
    $ordenUN = mysqli_fetch_assoc($ordenes_UN);
    $UN_ordenes = $ordenUN["COUNT(order_id)"];

    $efectividadUN = $UN_ordenes * 100/$n_ordenes;

    $efectividad_enUN = filter_var($efectividadUN, FILTER_VALIDATE_FLOAT);

    $efectividad_entregadUN = round($efectividad_enUN);

    //efectividad (medido por el numero de entregados) % DE RETORNOS
    $ordenesRET = "SELECT COUNT(order_id)  FROM datosordenes WHERE status ='returnes';";
    $ordenes_RET = mysqli_query($db4, $ordenesRET);
    $ordenRET = mysqli_fetch_assoc($ordenes_RET);
    $RET_ordenes = $ordenRET["COUNT(order_id)"];

    $efectividadRET = $RET_ordenes * 100/$n_ordenes;

    $efectividad_enRET = filter_var($efectividadRET, FILTER_VALIDATE_FLOAT);

    $efectividad_entregadRET = round($efectividad_enRET);

    //CONTEO DE NUMERO DE ORDENES A LA FECHA ACTUAL

    $fechaActual = 2022-02-20;//date('Y-m-d');
    $fechaActual2 = date("Y-m-d",strtotime($fechaActual."+ 1 days")); 

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

?>
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Panel de Control</h1>
    <a href="DESCARGAS/descargaexcel.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Reporte General</a>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            GC-box NUMERO DE ORDENES</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $n_ordenes?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            RECOLECCION</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo $S_ordenes?>,00</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
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
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: <?php echo $efectividad_entregad ?>%" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
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

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        CARGAS GLOBAL CARGO</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $n_ordenesGB?></div>
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

    <!-- Content Column -->
    <div class="col-lg-6 mb-4">

        <!-- TARJETA PARA CONJUNTO DE APLICACIONES -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Estados Generales</h6>
            </div>
            <div class="card-body">
                <h4 class="small font-weight-bold">Request / Solicitado <span
                        class="float-right"><?php echo $efectividad_entregadRE; ?>%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $efectividad_entregadRE; ?>%"
                        aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Collected / Procesando <span
                        class="float-right"><?php echo $efectividad_entregadCO; ?>%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $efectividad_entregadCO; ?>%"
                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Delivered / Entregados <span
                        class="float-right"><?php echo $efectividad_entregad; ?>%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $efectividad_entregad; ?>%"
                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Undelivered / No entregados <span
                        class="float-right"><?php echo $efectividad_entregadUN; ?>%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $efectividad_entregadUN; ?>%"
                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Returnes / Regresos <span
                        class="float-right"><?php echo $efectividad_entregadRET; ?>%</span></h4>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $efectividad_entregadRET; ?>%"
                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <!-- Color System -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        Primary
                        <div class="text-white-50 small">#4e73df</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        Success
                        <div class="text-white-50 small">#1cc88a</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-info text-white shadow">
                    <div class="card-body">
                        Info
                        <div class="text-white-50 small">#36b9cc</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        Warning
                        <div class="text-white-50 small">#f6c23e</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                        Danger
                        <div class="text-white-50 small">#e74a3b</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-secondary text-white shadow">
                    <div class="card-body">
                        Secondary
                        <div class="text-white-50 small">#858796</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-light text-black shadow">
                    <div class="card-body">
                        Light
                        <div class="text-black-50 small">#f8f9fc</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body">
                        Dark
                        <div class="text-white-50 small">#5a5c69</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-6 mb-4">

        <!-- Illustrations -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">CONTROL GC TRADE</h6>
            </div>
            <div class="card-body">
                <h4 class="small font-weight-bold">Pedidos de <?php echo $fechaActual; ?><span
                        class="float-right"><?php echo $ordenAC['COUNT(order_id)']; ?></span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $ordenAC['COUNT(order_id)']; ?>%"
                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="card-body">
                <h4 class="small font-weight-bold">Ingresos pendientes<span
                        class="float-right"><?php echo $ordenAC3['COUNT(order_id)']; ?></span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $ordenAC3['COUNT(order_id)']; ?>%"
                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="card-body">
                <h4 class="small font-weight-bold">Facturas pendientes<span
                        class="float-right"><?php echo $ordenAC4['COUNT(order_id)']; ?></span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $ordenAC4['COUNT(order_id)']; ?>%"
                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="card-body">
                <h4 class="small font-weight-bold">Ornedes por Empacadar<span
                        class="float-right"><?php echo $ordenAC2['COUNT(order_id)']; ?></span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $ordenAC2['COUNT(order_id)']; ?>%"
                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
            </div>
            <div class="card-body">
                <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                    CSS bloat and poor page performance. Custom CSS classes are used to create
                    custom components and custom utility classes.</p>
                <p class="mb-0">Before working with this theme, you should become familiar with the
                    Bootstrap framework, especially the utility classes.</p>
            </div>
        </div>

    </div>
</div>

</div>
<!-- /.container-fluid -->






<?php 
    incluirTemplate('fottersis');     
?>