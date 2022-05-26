<div class="mision">
            <p class="mis" id="nos">
            Somos una empresa dedicada a brindar servicios de Comercio Exterior
            y Logística internacional, enfocados siempre en la agilidad
            y calidad en cada uno de nuestros procesos.
            </p>
</div>

<div class="nuevo">
    <a href="registro.php" class="linck">REGISTRAR USUARIO</a>
</div> 

$nProceso = mysqli_real_escape_string($db, $_POST['nProceso'] );
        $fecha = mysqli_real_escape_string($db, $_POST['fecha'] );
        $distrito = mysqli_real_escape_string($db, $_POST['distrito'] );
        $regimen = mysqli_real_escape_string($db, $_POST['regimen'] );
        $agente = mysqli_real_escape_string($db, $_POST['agente'] );
        $nDai = mysqli_real_escape_string($db,  $_POST['nDai'] );
        $nLiq = mysqli_real_escape_string($db, $_POST['nLiq'] );
        $estado = mysqli_real_escape_string($db, $_POST['estado'] );
        $observacion = mysqli_real_escape_string($db, $_POST['observacion'] );
        $tAforo = mysqli_real_escape_string($db, $_POST['tAforo'] );
        $editor = $_SESSION['usuario'];
        $idCarga = mysqli_real_escape_string($db, $_POST['idCarga'] );

        //echo "<pre>";
        //var_dump($_POST);
        //echo "</pre>";

        $nProceso = mysqli_real_escape_string($db, $_POST['nProceso'] );
        $fecha = mysqli_real_escape_string($db, $_POST['fecha'] );
        $distrito = mysqli_real_escape_string($db, $_POST['distrito'] );
        $regimen = mysqli_real_escape_string($db, $_POST['regimen'] );
        $agente = mysqli_real_escape_string($db, $_POST['agente'] );
        $nDai = mysqli_real_escape_string($db,  $_POST['nDai'] );
        $nLiq = mysqli_real_escape_string($db, $_POST['nLiq'] );
        $estado = mysqli_real_escape_string($db, $_POST['estado'] );
        $observacion = mysqli_real_escape_string($db, $_POST['observacion'] );
        $tAforo = mysqli_real_escape_string($db, $_POST['tAforo'] );
        $editor = $_SESSION['usuario'];
        $idCarga = mysqli_real_escape_string($db, $_POST['idCarga'] );

        //echo "<pre>";
        //var_dump($usuario);
        //echo "</pre>";

        // validar el formulario

        if(!$nProceso) {
            $errores[] = "El número de proceso tienes que definir, COMPLETAAAAA!!!";
        }
        if(!$fecha) {
            $errores[] = "Registra la fecha en la que estás haciendo esto, ASI NO SE PUEDE!!";
        }
        if(!$distrito) {
            $errores[] = "Donde está la Carga, COMPLETA TODO!!!";
        }
        if(empty($errores)) {
            // insertar datos en la base
            $query = "INSERT INTO proceso (nProceso, fecha, distrito, regimen, agente, nDai, nLiq, estado, observacion, tAforo, editor, idCarga) 
                    VALUES ('$nProceso', '$fecha', '$distrito', '$regimen', '$agente', '$nDai', '$nLiq', '$estado', '$observacion', '$tAforo', '$editor', '$idCarga')";

            echo $query;

            $resultado = mysqli_query($db, $query);
                echo "hasta aqui vale";

                if ($resultado) {
                    header('location: ../superAdmin.php?resultado=1');
                }
        }


    
<!-- Content Row -->

<div class="row">

<!-- Area Chart -->
<div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Pie Chart -->
<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>





