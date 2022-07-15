<?php 

    $cedula_cliente = $_GET['cedula'] ?? null;

    //incluye el header
    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if (!$auth) {
        header('location: index.php');
    }

    require '../../includes/config/database.php';
    incluirTemplate('headersis2');
    
    //coneccion api
    conectarDB3();
    $db3 =conectarDB3();
    
    //coneccion callcenter
    conectarDB4();
    $db4 =conectarDB4();

    //variables 
        $errores = [];
        $nombre = "";
        $apellido = "";
        $telefono1 = "";
        $telefono2 = "";
        $cedula = "";
        $direccion ="";
        $cuenta_banco = "";
        $banco = "";
        $correo = "";
        $emprendimiento = "";
        $actividad_comercial = "";
        $productos = "";
        $referencias = "";
        $vendedor = "";
        $fecha_actualizacion = "";
        $revision = "";

    //consulta de datos del cliente
        $datos_cliente = "SELECT * FROM clientes WHERE cedula = $cedula_cliente;";
        $buscar = mysqli_query($db4, $datos_cliente);

        $datos_cliente = mysqli_fetch_assoc($buscar);
        $fecha_reg = $datos_cliente['fecha_registro'];
        $id_cliente = $datos_cliente['id'];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = mysqli_real_escape_string($db4, $_POST['nombre']);
            $apellido = mysqli_real_escape_string($db4, $_POST['apellido']);
            $telefono1 = mysqli_real_escape_string($db4, $_POST['telefono1']);
            $telefono2 = mysqli_real_escape_string($db4, $_POST['telefono2']);
            $cedula = mysqli_real_escape_string($db4, $_POST['cedula']);
            $direccion =mysqli_real_escape_string($db4, $_POST['direccion']);
            $cuenta_banco = $_POST['cuenta_banco'];
            $banco = mysqli_real_escape_string($db4, $_POST['banco']);
            $correo = mysqli_real_escape_string($db4, $_POST['correo']);
            $emprendimiento = mysqli_real_escape_string($db4, $_POST['emprendimiento']);
            $actividad_comercial = mysqli_real_escape_string($db4, $_POST['actividad_comercial']);
            $productos = mysqli_real_escape_string($db4, $_POST['productos']);
            $referencias = mysqli_real_escape_string($db4, $_POST['referencias']);
            $vendedor = mysqli_real_escape_string($db4, $_POST['vendedor']);
            $fecha_actualizacion = date('y-m-d');
            $responsab_act = $_SESSION['usuario'];
            $fecha_registro = $fecha_reg;

            if(!$nombre) {
                $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
            }
            if(!$apellido) {
                $errores[] = "HEY!!!! AYUDANO CON TU APELLIDO";
            }
            if(!$telefono1) {
                $errores[] = "TE FALTO!!!! NECESITAMOS UN CONTACTO POR FAVOR AGREGA";
            }
            if(!$cedula) {
                $errores[] = "HEY FALTO ALGO!!!! IMPORTANTE MUY IMPORTANTE LA CEDULA O RUC";
            }
            if(!$correo) {
                $errores[] = "QUE HACEEEEEEEE!!!! FALTO EL CORREO ES IMPORTANTE";
            }
            if(!$productos) {
                $errores[] = "HEY!!!! POR FAVOR CUENTANOS QUE VAMOS A TRANSPORTAR";
            }
            if(empty($errores)) {
            
                //query guardar los datos en la base 
                    $G_cliente = "UPDATE clientes SET nombre = '${nombre}',
                                                      apellido = '${apellido}',
                                                      telefono1 = '${telefono1}',
                                                      telefono2 = '${telefono2}',
                                                      cedula = '${cedula}',
                                                      direccion = '${direccion}',
                                                      cuenta_banco = '${cuenta_banco}',
                                                      banco = '${banco}',
                                                      correo = '${correo}',
                                                      emprendimiento = '${emprendimiento}',
                                                      actividad_comercial = '${actividad_comercial}', 
                                                      productos = '${productos}',
                                                      referencias = '${referencias}',
                                                      vendedor = '${vendedor}',
                                                      fecha_actuaizacion = '${fecha_actualizacion}',
                                                      fecha_registro = '${fecha_registro}',
                                                      responsable = '${responsab_act}' 
                                                      WHERE id = '${id_cliente}';";
        
                    // prueba de query
                        $guardar = mysqli_query($db4, $G_cliente);
                        if ($guardar){
                            
                            echo '
                            <div class = "alert alert-success">
                                <p>cliente actualizado!!!</p>
                            </div>';
                            exit;
                        }
            }
        
        }

?>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- FORMULARIO DE ACTUALIZACION -->
            <!-- <v class="card bg-light"> -->
                    <?php foreach($errores as $error) : ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach ?>
                <hr>
                <div class="alert alert-success fs-5">
                        <h1 class="fs-4">
                            Vas a editar la informacion del cliente: "
                            <?php 
                                //$nombre = mysqli_fetch_assoc($buscar);
                                echo $datos_cliente['nombre']." ".$datos_cliente['apellido']; 
                            ?>
                        </h1>
                </div>
                <form class="user" method="post">
                <?php //$datos_cliente=mysqli_fetch_assoc($buscar);?>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" require name="nombre" class="form-control form-control-user" id="exampleFirstName"
                                            value="<?php echo $datos_cliente['nombre']?>" maxlength="79">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="int"  require name="apellido" class="form-control form-control-user" id="exampleLastName"
                                            value="<?php echo $datos_cliente['apellido']?>" maxlength="79">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="number"  require name="telefono1" class="form-control form-control-user"
                                            id="exampleRepeatPassword" value="<?php echo $datos_cliente['telefono1']?>" maxlength="10">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" name="telefono2" class="form-control form-control-user"
                                            id="exampleInputPassword" value="<?php echo $datos_cliente['telefono2']?>" maxlength="10">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" minlength="10" maxlength="13" require name="cedula" class="form-control form-control-user"
                                            id="exampleInputPassword" value="<?php echo $datos_cliente['cedula']?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="email" require name="correo" class="form-control form-control-user"
                                            id="exampleRepeatPassword" value="<?php echo $datos_cliente['correo']?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" name="cuenta_banco" class="form-control form-control-user"
                                            id="exampleInputPassword" value="<?php echo $datos_cliente['cuenta_banco']?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" minlength="8" maxlength="80" name="banco" class="form-control form-control-user"
                                            id="exampleRepeatPassword" value="<?php echo $datos_cliente['banco']?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text"  require name="direccion" minlength="3" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        value="<?php echo $datos_cliente['direccion']?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="actividad_comercial" minlength="8" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        value="<?php echo $datos_cliente['actividad_comercial']?>">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="emprendimiento" class="form-control form-control-user"
                                            id="exampleInputPassword" value="<?php echo $datos_cliente['emprendimiento']?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" minlength="8" maxlength="200" require name="productos" class="form-control form-control-user"
                                            id="exampleRepeatPassword" value="<?php echo $datos_cliente['productos']?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" require name="referencias" class="form-control form-control-user"
                                            id="exampleInputPassword" value="<?php echo $datos_cliente['referencias']?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <select type="text" minlength="8" maxlength="200" require name="vendedor" class="form-control form-control-user"
                                            id="exampleRepeatPassword">
                                                <option value = "<?php echo $datos_cliente['vendedor']?>" selected ><?php echo $datos_cliente['vendedor']?></option>
                                                <option value="Katherine Perez">Katherine Perez</option>
                                                <option value="Bryan Ramos">Bryan Ramos</option>
                                                <option value="Luis Revilla">Luis Revilla</option>
                                                <option value="Domenica Fajardo">Domenica Fajardo</option>
                                                <option value="Camila Pazmino">Camila Pazmino</option>
                                                <option value="Krystel Quintong">Krystel Quintong</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <button class="btn btn-primary btn-user btn-block" title="REGISTRAR CLIENTE">registrar</button>
                <?php ?>
                </form>
    </div>



<?php 
    incluirTemplate('fottersis');     
?>