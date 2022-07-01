<?php 

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

    //coneccion callcenter
    conectarDB5();
    $db5 =conectarDB5();
    //decalracion de variables 
        $p_bases = "";
        $pod = "";
        $monto = "";
        $m3 = "";
        $cbm = "";
        $frequency = "";
        $ruta = "";
        $t_transito = "";
        $validez = "";
    
    $errores = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            //DECLARACION DE VARIABLES TABLA DATOSORDENES 
            $p_bases = mysqli_real_escape_string($db, $_POST['p_bases']);
            $pod = mysqli_real_escape_string($db, $_POST['pod']);
            $monto = mysqli_real_escape_string($db, $_POST['monto']);
            $m3 = mysqli_real_escape_string($db, $_POST['m3']);
            $cbm = mysqli_real_escape_string($db, $_POST['cbm']);
            $frequency = mysqli_real_escape_string($db, $_POST['frequency']);
            $ruta = mysqli_real_escape_string($db, $_POST['ruta']);
            $t_transito = mysqli_real_escape_string($db, $_POST['t_transito']);
            $validez = mysqli_real_escape_string($db, $_POST['validez']);
            $t_carga = mysqli_real_escape_string($db, $_POST['t_carga']);
            $usuario = $_SESSION['usuario'];
            $fecha = date('y-m-d');

            if(!$p_bases) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL NOMBRE";
            }
            if(!$pod) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL APELLIDO";
            }
            if(!$monto) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA LA DIRECCION";
            }
            if(!$m3) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL CELULAR";
            }
            if(!$cbm) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL NUMERO DE CEDULA";
            }
            if(!$frequency) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL ESTADO";
            }
            if(!$ruta) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL ESTADO";
            }
            if(!$t_transito) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL ESTADO";
            }
            if(!$validez) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL ESTADO";
            }
            if(!$t_carga) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL ESTADO";
            }

            if(empty($errores)) {
                $guardar_colab = "INSERT INTO provedores (p_bases, pod, monto, m3, cbm, frequency, ruta, t_transito, validez, t_carga, fecha_c, usuario)
                                    values ('$p_bases', '$pod', '$monto', '$m3', '$cbm', '$frequency', '$ruta', '$t_transito', '$validez', '$t_carga', '$fecha', '$usuario');";
                    $guar_colab = mysqli_query($db5, $guardar_colab);
                    
                    if ($guar_colab) {
                        echo '
                            <div class="alert alert-success">
                                <a href="cotizador.php">Ingrsar otra tarifa</a>
                            </div>';
                        //header('location: usuarios.php');
                        exit();
                    }
            }


        }

?>
<body class="bg-gradient-primary">
    <div class="container">
        <!-- FORMULARIO DE ACTUALIZACION -->
            <div class="card bg-light">
                    <?php foreach($errores as $error) : ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach ?>
                <div class="card-header">
                    COTIZADOR DE CARGAS A CONSUMO
                </div>
                <form action ='' method="POST">
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Puerto de salida</label>
                        <input type ="text" class="form-control" id="exampleFormControlTextarea1" rows="3" name="p_bases"></input>              
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Puerto de Destino</label>
                        <input type ="text" class="form-control" id="exampleFormControlTextarea1" rows="3" name="pod"></input>          
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Monto</label>
                        <input type ="number" class="form-control" id="exampleFormControlTextarea1" rows="3" name="monto"></input>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">M3</label>
                        <input type ="number" class="form-control" id="exampleFormControlTextarea1" rows="3" name="m3"></input>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">CBM</label>
                        <input type ="number" class="form-control" id="exampleFormControlTextarea1" rows="3" name="cbm"></input>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Frencuencia</label>
                        <input type ="text" class="form-control" id="exampleFormControlTextarea1" rows="3" name="frequency"></input>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Ruta</label>
                        <input type ="text" class="form-control" id="exampleFormControlTextarea1" rows="3" name="ruta"></input>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Tiempo de transporte</label>
                        <input type ="text" class="form-control" id="exampleFormControlTextarea1" rows="3" name="t_transito"></input>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Validez</label>
                        <input type ="text" class="form-control" id="exampleFormControlTextarea1" rows="3" name="validez"></input>
                    </div>
                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="t_carga" aria-label=".form-select-sm example">
                            <option selected>selecciona un tipo de carga</option>
                            <option value="lcl">LCL</option>
                            <option value="fcl">FCL</option>
                        </select>
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