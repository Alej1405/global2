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
        
    
    $errores = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            //DECLARACION DE VARIABLES TABLA DATOSORDENES 
            
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
                    INGRESO DE DEPOSITOS.
                </div>
                <form action ='' method="POST">
                    <br>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Numero de Deposito / Referencia </span>
                        <input type="text" class="form-control" require aria-label="Username" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">@example.com</span>
                    </div>

                    <label for="basic-url" class="form-label">Your vanity URL</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-text">.00</span>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username">
                        <span class="input-group-text">@</span>
                        <input type="text" class="form-control" placeholder="Server" aria-label="Server">
                    </div>

                    <div class="input-group">
                        <span class="input-group-text">With textarea</span>
                        <textarea class="form-control" aria-label="With textarea"></textarea>
                    </div>
                </form>
            </div>
        <!-- FIN DE FORMULARIO DE ACTUALIZACION -->
    </div>



<?php 
    incluirTemplate('fottersis');     
?>