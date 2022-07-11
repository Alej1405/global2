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
            $deposito = "";
            $detalle = "";
            $banco = "";
            $cuenta = "";
            $factura = "";
            $v_iva = "";
            $responsable = "";
            $f_ingreso = "";
            $valorSV = "";

        //ARRAY DE ERRORES PARA LA ALERTAS
            $errores = [];

    //----------------CAPTURA DE DATOS METODO POST----------------

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //asignar informacion del archivo a la variable
                $tipo = $_POST['tipo'];
                $valor = $_POST['valor'];
                $valor_SV = $_POST['valor_SV'];
                $respaldo = $_FILES['respaldo'];
                $deposito = $_FILES['deposito'];
                $detalle = $_POST['detalle'];
                $banco = $_POST['banco'];
                $cuenta = $_POST['cuenta'];
                $factura = $_POST['factura'];
                $responsable = $_SESSION['usuario'];
                $f_ingreso = date('y-m-d');

                //--------------- calculo del valor IVA solo cuando la condicion de la factura sea si caso contrario no se realiza el proceso
                    switch ($factura){
                        case "si":
                            //constantes de la formula
                                //calculo del valor sin iva
                                    $valor1 = $valor - $valor_SV;
                                //fin del calculo del valor sin iva
                                $constante = 1.12;
                                $valor_2 = number_format($valor1, 2);
                                $constante_2 = number_format($constante, 2);
                                $v_iva_1 = $valor_2 / $constante;
                                $v_iva_2 = $valor1 - $v_iva_1;
                                $v_iva = round($v_iva_2, 2);
                            break;

                        case "no":
                                $v_iva = 0;
                            break;
                    }
                            
            //DECLARACION DE VARIABLES TABLA DATOSORDENES 
            
                    if(!$tipo) {
                        $errores[] = "NOOOO!!!! SELECCIONA UN TIPO DE MOVIENTO";
                    }
                    if(!$valor) {
                        $errores[] = "QUE HACEEEEEEEE!!!! FALTA EL VALOR, RECUERDA QUE ES SIN CEROS.";
                    }
                    if(!$detalle) {
                        $errores[] = "HEY!!!! SELECCIONA UN DETALLE";
                    }
                    if(!$banco) {
                        $errores[] = "ATENTA A LOS DATOS!!!! POR FAVOR REGISTRA UNA CUENTA DE DESTINO ";
                    }
                    if(!$cuenta) {
                        $errores[] = "QUE HACEEEEEEEE!!!! SELECCIONA UNA CUENTA CONTABLE";
                    }
                    if(!$factura) {
                        $errores[] = "QUE HACEEEEEEEE!!!! SELECCIONA SI ES O NO FACTURA";
                    }
                    if(!$respaldo['name']) {
                        $errores[] = "HEY!!!! ADJUNTA LA FACTURA O DEPOSITO DEL MOVIENTO";
                    }
                    if(!$deposito['name']) {
                        $errores[] = "HEY NOOOOOOOO!!!! ADJUNTA EL COMPROBANTE DE PAGO O COBRO";
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
                    $nombre_deposito = md5( uniqid(rand(),true)) . ".pdf";

                    //subir el archivo
                    move_uploaded_file($respaldo['tmp_name'], $depositos_img. $nombre_respaldo);
                    move_uploaded_file($deposito['tmp_name'], $depositos_img. $nombre_deposito);

                $fecha_g = date('y-m-d');
                
                $G_deposito = "INSERT INTO ingresos_egresos (tipo, valor, respaldo, detalle, banco, cuenta, factura, v_iva, responsable, f_ingreso, deposito)
                                            values ('$tipo', '$valor', '$nombre_respaldo', '$detalle', '$banco', '$cuenta', '$factura', '$v_iva', '$responsable', '$f_ingreso', '$nombre_deposito')";
                                
                                $guardar = mysqli_query($db6, $G_deposito);
                    
                    if ($guardar) {
                        echo '
                            <div class="alert alert-success">
                                <a href="registro_fin.php">Registrar mas movimientos</a>
                            </div>';
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
                        <input type="float" class="form-control" name="valor" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-text"></span>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Valor sin IVA $</span>
                        <input type="float" class="form-control" name="valor_SV" aria-label="Amount (to the nearest dollar)" value="0">
                        <span class="input-group-text"></span>
                    </div>

                    <div class="mb-3">
                        <label for="respaldo" class="form-label">Factura o Respaldo</label>
                        <input type="file" id="respaldo" accept="pdf" name="respaldo" class="form-control" require aria-label="Username" value="Adjuntar Respaldo" aria-describedby="basic-addon1">
                    </div>

                    <div class="mb-3">
                        <label for="deposito" class="form-label">Comprobanto o Respaldo</label>
                        <input type="file" id="deposito" accept="pdf" name="deposito" class="form-control" require aria-label="Username" value="Adjuntar Respaldo" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="detalle" aria-label=".form-select-sm example">
                            <option selected>selecciona un detalle</option>
                            <option value="anticipo">Anticipo</option>
                            <option value="pago proveedores">Pago de proveedores</option>
                            <option value="servicios basicos uio">Servicios Basicos UIO</option>
                            <option value="servicios basicos gye">Servicios Basicos GYE</option>
                            <option value="gastos administrativos">Gastos Administrativos</option>
                            <option value="viaticos">Viaticos</option>
                            <option value="gastos varios">Gastos Varios</option>
                            <option value="insumos de oficina">Insumos de Oficina</option>
                            <option value="gasto operativo">Gasto Operativo</option>
                            <option value="transporte">Transporte</option>
                            <option value="gasto administrativo">Gasto Administrativo</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="banco" aria-label=".form-select-sm example">
                            <option selected>selecciona una cuenta BANCARIA</option>
                            <option value="bco. de guayaquil">Bco. Guayaquil</option>
                            <option value="bco produbanco">Bco. Produbanco</option>
                            <option value="otra cuenta">Otra Cuenta</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="cuenta" aria-label=".form-select-sm example">
                            <option selected>selecciona una cuenta contable</option>
                            <option value="c. por pagar">C. Por Pagar</option>
                            <option value="c. por cobrar">C. Por Cobrar</option>
                            <option value="gasto operativo">Gasto Operativo</option>
                            <option value="caja chica">Caja Chica</option>
                            <option value="caja general">Caja General</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="factura" aria-label=".form-select-sm example">
                            <option selected>Es una factura..?</option>
                            <option value="si">Si</option>
                            <option value="no">No</option>
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