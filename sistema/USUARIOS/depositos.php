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
        
        $deposito = "";
        $referencia = "";
        $cantidad = "";
        $depositante = "";
        $fecha = "";
        $fecha_g = "";
        $cuenta = "";
        $observacion = "";
        //ARRAY DE ERRORES PARA LA ALERTAS
        $errores = [];


        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //asignar informacion del archivo a la variable
            $deposito = $_FILES['deposito'];
            $referencia = $_POST['referencia'];
            $cantidad = $_POST['cantidad'];
            $depositante = $_POST['depositante'];
            $fecha = $_POST['fecha'];
            $fecha_g = date('y-m-d');
            $cuenta = $_POST['cuenta'];
            $observacion = $_POST['observacion'];
        
            //DECLARACION DE VARIABLES TABLA DATOSORDENES 
            
            if(!$referencia) {
                $errores[] = "NOOOO!!!! FALTA EL NUMERO DE DEPOSITO";
            }
            if(!$cantidad) {
                $errores[] = "QUE HACEEEEEEEE!!!! FALTA LA CATIDAD QUE SE DEPOSITO";
            }
            if(!$depositante) {
                $errores[] = "QUE HACEEEEEEEE!!!! FALTA EL NOMBRE DEL DEPOSITANTE";
            }
            if(!$fecha) {
                $errores[] = "HEY!!!! PON LA FECHA DEL DEPOSITO";
            }
            if(!$cuenta) {
                $errores[] = "ATENTOS A LOS DATOS!!!! AGREGA EL NUMERO DE CUENTA";
            }
            if(!$observacion) {
                $errores[] = "QUE HACEEEEEEEE!!!! SI NO HAY OBSERVACION AGREGA SIN NOVEDAD";
            }
            if(!$deposito['name']) {
                $errores[] = "HEY!!!! ADJUNTA EL RESPALDO DEL DEPOSITO SI NO, HAY TABLA";
            }

            if(empty($errores)) {

                //SUBIR FOTOS DE DEPOSITOS
                    //CREAR CARPETA
                    $depositos_img = '../../depositos/';

                    //verificar si la carpeta existe
                    if (!is_dir($depositos_img)){
                        //crear el directorio utilizando MKDIR si no hay se crea
                        mkdir($depositos_img);
                    }

                    //crear nombre unico

                    $nombre_deposito = md5( uniqid(rand(),true)) . ".jpg";

                    //subir la imagen
                    move_uploaded_file($deposito['tmp_name'], $depositos_img. $nombre_deposito);

                $fecha_g = date('y-m-d');
                
                $G_deposito = "INSERT INTO control_dep (deposito, referencia, cantidad, depositante, fecha, fecha_g, cuenta, observacion)
                                            values ('$nombre_deposito', '$referencia', '$cantidad', '$depositante', '$fecha', '$fecha_g', '$cuenta', '$observacion')";
                                
                                $guardar = mysqli_query($db4, $G_deposito);
                    
                    if ($guardar) {
                        echo '
                            <div class="alert alert-success">
                                <a href="depositos.php">Continuar actualizando la gestion</a>
                            </div>';
                        //header('location: usuarios.php');
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
                <form action ='' method="POST" enctype="multipart/form-data">
                    <br>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Numero de Deposito / Referencia </span>
                        <input type="text" class="form-control" name="referencia" require aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text">Valor $</span>
                        <input type="text" class="form-control" name="cantidad" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-text">.00</span>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Depositante</span>
                        <input type="text" class="form-control" name="depositante" require aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Fecha de deposito</span>
                        <input type="date" class="form-control" name="fecha" require aria-label="Username" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Observacion</span>
                        <textarea class="form-control" name="observacion" aria-label="With textarea"></textarea>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="cuenta" aria-label=".form-select-sm example">
                            <option selected>selecciona una cuenta</option>
                            <option value="Bco. Guayaquil">Banco de Guayaquil</option>
                            <option value="Bco. Producbanco">Produbanco</option>
                            <option value="Otro">Otros</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <input type="file" id="deposito" accept="image/jpeg, image/png" name="deposito" class="form-control" require aria-label="Username" value="Adjuntar Respaldo" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <input type="submit" value="Guardar Deposito" class="btn btn-outline-primary">
                    </div>
                </form>
            </div>
        <!-- FIN DE FORMULARIO DE ACTUALIZACION -->
    </div>



<?php 
    incluirTemplate('fottersis');     
?>