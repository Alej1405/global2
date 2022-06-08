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
    //decalracion de variables 
        $nombre = "";
        $apellido = "";
        $direccion = "";
        $celular = "";
        $celular_2 = "";
        $numero_ci = "";
        $observacion = "";
        $estado = "";
    
    $errores = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            //DECLARACION DE VARIABLES TABLA DATOSORDENES 
            $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
            $apellido = mysqli_real_escape_string($db, $_POST['apellido']);
            $direccion = mysqli_real_escape_string($db, $_POST['direccion']);
            $celular = mysqli_real_escape_string($db, $_POST['celular']);
            $celular_2 = mysqli_real_escape_string($db, $_POST['celular_2']);
            $numero_ci = mysqli_real_escape_string($db, $_POST['numero_ci']);
            $observacion = mysqli_real_escape_string($db, $_POST['observacion']);
            $estado = mysqli_real_escape_string($db, $_POST['estado']);
            $responsable = $_SESSION['usuario'];
            $fecha = date('y-m-d');
            if(!$nombre) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL NOMBRE";
            }
            if(!$apellido) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL APELLIDO";
            }
            if(!$direccion) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA LA DIRECCION";
            }
            if(!$celular) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL CELULAR";
            }
            if(!$numero_ci) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL NUMERO DE CEDULA";
            }
            if(!$estado) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL ESTADO";
            }
            if(empty($errores)) {
                $guardar_colab = "INSERT INTO colaborador (nombre, apellido, direccion, celular, celular_2, numero_ci, observacion, estado, responsable, fecha)
                                    values ('$nombre', '$apellido', '$direccion', '$celular', '$celular_2', '$numero_ci', '$observacion', '$estado', '$responsable', '$fecha');";
                    $guar_colab = mysqli_query($db4, $guardar_colab);
                    
                    if ($guar_colab) {
                        echo '
                            <div class="alert alert-success">
                                <a href="reg_colab.php">Continuar actualizando la gestion</a>
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
                    REGISTRAR COLABORADOR
                </div>
                <form action ='' method="POST">
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">NOMBRE</label>
                        <input type ="text" class="form-control" id="exampleFormControlTextarea1" rows="3" name="nombre"></input>              
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">APELLIDO</label>
                        <input type ="text" class="form-control" id="exampleFormControlTextarea1" rows="3" name="apellido"></input>          
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">DIRECCION</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="direccion"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">CELULAR</label>
                        <input type ="number" class="form-control" id="exampleFormControlTextarea1" rows="3" name="celular"></input>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">CELULAR 2</label>
                        <input type ="number" class="form-control" id="exampleFormControlTextarea1" rows="3" name="celular_2"></input>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">NUMERO DE CEDULA</label>
                        <input type ="number" class="form-control" id="exampleFormControlTextarea1" rows="3" name="numero_ci"></input>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">OBSERVACION</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="observacion"></textarea>
                    </div>
                    <div class="mb-3">
                        <select name="estado" id="">
                            <option value=" ">Selecciona un estado</option>
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="SUSPENDIDO">SUSPENDIDO</option>
                            <option value="DESPEDIDO">DESPEDIDO</option>
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