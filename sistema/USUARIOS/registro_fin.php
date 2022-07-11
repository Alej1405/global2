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

    //coneccion callcenter
    conectarDB6();
    $db6 =conectarDB6();

    //----------------VARIABLES----------------

        //decalracion de variables 
            
            $tipo = "";
            $valor = "";
            $respaldo = "";
            $detalle = "";
            $banco = "";
            $cuenta = "";
            $factura = "";
            $v_iva = "";
            $responsable = "";
            $f_ingreso = "";

        //ARRAY DE ERRORES PARA LA ALERTAS
            $errores = [];

    //----------------CAPTURA DE DATOS METODO POST----------------

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //asignar informacion del archivo a la variable
            $tipo = $_POST['tipo'];
            $valor = $_POST['valor'];
            $respaldo = $_FILES['respaldo'];
            $detalle = $_POST['detalle'];
            $banco = $_POST['banco'];
            $cuenta = $_POST['cuenta'];
            $factura = $_POST['factura'];
            $v_iva = $_POST['v_iva'];
            $responsable = $_SESSION['usuario'];
            $f_ingreso = date('y-m-d');
        
            //DECLARACION DE VARIABLES TABLA DATOSORDENES 
            
                    if(!$tipo) {
                        $errores[] = "NOOOO!!!! FALTA EL NUMERO DE DEPOSITO";
                    }
                    if(!$valor) {
                        $errores[] = "QUE HACEEEEEEEE!!!! FALTA LA CATIDAD QUE SE DEPOSITO";
                    }
                    if(!$detalle) {
                        $errores[] = "HEY!!!! PON LA FECHA DEL DEPOSITO";
                    }
                    if(!$banco) {
                        $errores[] = "ATENTOS A LOS DATOS!!!! AGREGA EL NUMERO DE CUENTA";
                    }
                    if(!$cuenta) {
                        $errores[] = "QUE HACEEEEEEEE!!!! SI NO HAY OBSERVACION AGREGA SIN NOVEDAD";
                    }
                    if(!$factura) {
                        $errores[] = "QUE HACEEEEEEEE!!!! SI NO HAY OBSERVACION AGREGA SIN NOVEDAD";
                    }
                    if(!$respaldo['name']) {
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

                    $nombre_respaldo = md5( uniqid(rand(),true)) . ".pdf";

                    //subir el archivo
                    move_uploaded_file($respaldo['tmp_name'], $depositos_img. $nombre_respaldo);

                $fecha_g = date('y-m-d');
                
                //$G_deposito = "INSERT INTO control_dep (deposito, referencia, cantidad, depositante, fecha, fecha_g, cuenta, observacion)
                                            //values ('$nombre_deposito', '$referencia', '$cantidad', '$depositante', '$fecha', '$fecha_g', '$cuenta', '$observacion')";
                                
                                //$guardar = mysqli_query($db4, $G_deposito);
                    
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
                    REGISTRO Y MOVIMIENTO FINANCIERO
                </div>
                <form action ='' method="POST" enctype="multipart/form-data">
                    <br>
                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="tipo" aria-label=".form-select-sm example">
                            <option selected>selecciona un tipo de Transaccion</option>
                            <option value="Ingreso">Ingreso</option>
                            <option value="Egreso">Egreso</option>
                        </select>
                    </div>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text">Valor $</span>
                        <input type="text" class="form-control" name="valor" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-text"></span>
                    </div>

                    <div class="mb-3">
                        <label for="respaldo" class="form-label">Factura o Respaldo</label>
                        <input type="file" id="respaldo" accept="file/pdf" name="respaldo" class="form-control" require aria-label="Username" value="Adjuntar Respaldo" aria-describedby="basic-addon1">
                    </div>

                    <div class="mb-3">
                        <label for="deposito" class="form-label">Comprobanto o Respaldo</label>
                        <input type="file" id="deposito" accept="image/jpeg, image/png, pdf" name="deposito" class="form-control" require aria-label="Username" value="Adjuntar Respaldo" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="detalle" aria-label=".form-select-sm example">
                            <option selected>selecciona un detalle</option>
                            <option value="Ingreso">Anticipo</option>
                            <option value="Egreso">Pago de proveedores</option>
                            <option value="Egreso">Servicios Basicos UIO</option>
                            <option value="Egreso">Servicios Basicos GYE</option>
                            <option value="Egreso">Gastos Administrativos</option>
                            <option value="Egreso">Viaticos</option>
                            <option value="Egreso">Gastos Varios</option>
                            <option value="Egreso">Insumos de Oficina</option>
                            <option value="Egreso">Gasto Operativo</option>
                            <option value="Egreso">Transporte</option>
                            <option value="Egreso">Gasto Administrativo</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="banco" aria-label=".form-select-sm example">
                            <option selected>selecciona una cuenta BANCARIA</option>
                            <option value="Ingreso">Bco. Guayaquil</option>
                            <option value="Egreso">Bco. Produbanco</option>
                            <option value="Egreso">Otra Cuenta</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="cuenta" aria-label=".form-select-sm example">
                            <option selected>selecciona una cuenta contable</option>
                            <option value="Ingreso">C. Por Pagar</option>
                            <option value="Egreso">C. Por Cobrar</option>
                            <option value="Egreso">Gasto Operativo</option>
                            <option value="Egreso">Caja Chica</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="factura" aria-label=".form-select-sm example">
                            <option selected>Es una factura..?</option>
                            <option value="Ingreso">Si</option>
                            <option value="Egreso">No</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Observacion</span>
                        <textarea class="form-control" name="observacion" aria-label="With textarea"></textarea>
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