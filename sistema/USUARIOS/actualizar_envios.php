<?php 

    $id_envio = $_GET['id'] ?? null;

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


     //ARRAY DE ERRORES PARA LA ALERTAS
        $errores = [];
     //variables del sistema
        $nombre = "";
        $cedula = "";
        $correo = "";
        $provincia = "";
        $ciudad = "";
        $sector = "";
        $direccion = "";
        $direccion_recoleccion = "";
        $telefono = "";
        $cod = "";
        $valor = "";
        $fragil = "";
        $reempaque = "";
        $l = "";
        $a = "";
        $h = "";
        $peso = "";
        $estado = "";
        $fecha_reg = "";
        $asesor = "";
        $guia = "";
        $cliente = "";
        $fecha_actualizacion = "";
        $responsable = "";
        $transporte = "";

        //consulta de datos entre tablas
            $consulta_datos = "SELECT * from ordenes WHERE id = $id_envio";
            $consulta_d = mysqli_query($db4, $consulta_datos);
            $array_ordenes = mysqli_fetch_assoc($consulta_d);

            $consulta_colab = "SELECT * from colaborador;";
            $consulta_c2 = mysqli_query($db4, $consulta_colab);

            $nombre_cl = $array_ordenes['cliente'];
            $nombre_cl1 = "SELECT * FROM clientes WHERE cedula = $nombre_cl;";
            $query_cl = mysqli_query($db4, $nombre_cl1);
            $cons_cliente = mysqli_fetch_assoc($query_cl);
        
        //actualizacion de informacion
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $nombre = mysqli_real_escape_string($db4, $_POST['nombre']);
                        $cedula = mysqli_real_escape_string($db4, $_POST['cedula']);
                        $correo = mysqli_real_escape_string($db4, $_POST['correo']);
                        $provincia = mysqli_real_escape_string($db4, $_POST['provincia']);
                        $ciudad = mysqli_real_escape_string($db4, $_POST['ciudad']);
                        $sector = mysqli_real_escape_string($db4, $_POST['sector']);
                        $direccion = mysqli_real_escape_string($db4, $_POST['direccion']);
                        $direccion_recoleccion = mysqli_real_escape_string($db4, $_POST['direccion_recoleccion']);
                        $cod = mysqli_real_escape_string($db4, $_POST['cod']);
                        $valor = mysqli_real_escape_string($db4, $_POST['valor']);
                        $telefono = mysqli_real_escape_string($db4, $_POST['telefono']);
                        $fragil = $_POST['fragil'];
                        $reempaque = $_POST['reempaque'];
                        $l = mysqli_real_escape_string($db4, $_POST['l']);
                        $a = mysqli_real_escape_string($db4, $_POST['a']);
                        $h = mysqli_real_escape_string($db4, $_POST['h']);
                        $peso = mysqli_real_escape_string($db4, $_POST['peso']);
                        $estado = "recolectar";
                        $fecha_actualizacion = date('y-m-d');
                        $const_nom = $array_ordenes['asesor'];
                        $cliente = mysqli_real_escape_string($db4, $_POST['cedula']);
                        $asesor = $const_nom;
                        $guia = mysqli_real_escape_string($db4, $_POST['guia_paq']);
                        $responsable = $_SESSION['usuario'];
                        $transporte = $_POST['transporte'];

                        //validacion de ingreso de datos.
                        if(!$nombre) {
                            $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
                        }
                        if(!$cedula) {
                            $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
                        }
                        if(!$correo) {
                            $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
                        }
                        if(!$provincia) {
                            $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
                        }
                        if(!$ciudad) {
                            $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
                        }
                        if(!$sector) {
                            $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
                        }
                        if(!$direccion) {
                            $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
                        }
                        //query para guardar
                            $guardar_servicio = "UPDATE ordenes SET nombre = '$nombre',
                                                                    cedula = '$cedula',
                                                                    correo = '$correo',
                                                                    provincia = '$provincia',
                                                                    ciudad = '$ciudad', 
                                                                    sector = '$sector',
                                                                    direccion = '$direccion',
                                                                    direccion_recoleccion = '$direccion_recoleccion',
                                                                    telefono = '$telefono',
                                                                    cod = '$cod',
                                                                    valor = '$valor',
                                                                    fragil = '$fragil',
                                                                    reemparque = '$reempaque',
                                                                    l = '$l',
                                                                    a = '$a',
                                                                    h = '$h',
                                                                    peso = '$peso',
                                                                    estado = '$estado',
                                                                    asesor = '$asesor',
                                                                    cliente = '$cliente',
                                                                    guia = '$guia',
                                                                    fecha_actualizacion = '$fecha_actualizacion',
                                                                    responsable ='$responsable',
                                                                    transporte ='$transporte'
                                                                    WHERE id = $id_envio;";
                            
                            $actualizar_envio = mysqli_query($db4, $guardar_servicio);
                        if ($actualizar_envio){
                            
                            echo '
                            <div class = "alert alert-success">
                                <p>pedido actualizazo actualizado!!!</p>
                            </div>';
                            exit;
                        }
                                                             
        }
?>

<body class="bg-gradient-primary">
        <div class="container">
        <hr>
        <form class="user" method="post">
                <div class="alert alert-success fs-5">
                        <h1 class="fs-4">VAS A EDITAR EL PEDIDO DE: <?php echo $array_ordenes['nombre'];?> SOLICITADO POR EL CLIENTE: <?php echo  $cons_cliente['nombre']." ".$cons_cliente['apellido'];?></h1>
                </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" require name="guia_paq" class="form-control form-control-user" id="exampleFirstName"
                        value = "<?php echo $array_ordenes['guia'];?>"  maxlength="79">
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <select name="transporte"  class="form-control form-control-user">
                        <option value=" " >--- Selecciona el cliente  ---</option>
                        <?php while($array_colaborador = mysqli_fetch_assoc($consulta_c2) ): ?>
                            <option value="<?php echo $array_colaborador['id']; ?>"><?php echo $array_colaborador['nombre']." ".$array_colaborador['apellido']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" require name="cliente" class="form-control form-control-user" id="exampleFirstName"
                        value = "<?php echo $array_ordenes['cliente'];?>" placeholder="Por favor ingresar el codigo de cliente..."  maxlength="79">
                </div>
                <div class="col-sm-6">
                    <input type="email"  require name="correo" class="form-control form-control-user" id="exampleLastName"
                    value = "<?php echo $array_ordenes['correo'];?>" maxlength="70">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" require name="nombre" class="form-control form-control-user" id="exampleFirstName"
                    value = "<?php echo $array_ordenes['nombre'];?>" maxlength="79">
                </div>
                <div class="col-sm-6">
                    <input type="number"  require name="cedula" class="form-control form-control-user" id="exampleLastName"
                    value = "<?php echo $array_ordenes['cedula'];?>" maxlength="13">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" require name="provincia" class="form-control form-control-user" id="exampleFirstName"
                    value = "<?php echo $array_ordenes['provincia'];?>" maxlength="79">
                </div>
                <div class="col-sm-6">
                    <input type="text"  require name="ciudad" class="form-control form-control-user" id="exampleLastName"
                    value = "<?php echo $array_ordenes['ciudad'];?>" maxlength="79">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" require name="sector" class="form-control form-control-user" id="exampleFirstName"
                    value = "<?php echo $array_ordenes['sector'];?>" maxlength="79">
                </div>
                <div class="col-sm-6">
                    <input type="text"  require name="direccion" class="form-control form-control-user" id="exampleLastName"
                    value = "<?php echo $array_ordenes['direccion'];?>" maxlength="79">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="number" require name="telefono" class="form-control form-control-user" id="exampleFirstName"
                    value = "<?php echo $array_ordenes['telefono'];?>" maxlength="10">
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <select require name="cod" class="form-control form-control-user" id="exampleFirstName">
                        <option value = "<?php echo $array_ordenes['cod'];?>" selected>Necesitas que cobremos </option>
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" require name="valor" class="form-control form-control-user" id="exampleFirstName"
                    value = "<?php echo $array_ordenes['valor'];?>" maxlength="79">
                </div>
                <div class="col-sm-6">
                    <select require name="fragil" class="form-control form-control-user" id="exampleFirstName">
                        <option value = "<?php echo $array_ordenes['fragil'];?>" selected>Es fragil...?</option>
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-sm">
                    <input type="text" class="form-control form-control-user" value = "<?php echo $array_ordenes['l'];?>" aria-label="largo" name="l">
                </div>
                <div class="col-sm">
                    <input type="text" class="form-control form-control-user" value = "<?php echo $array_ordenes['a'];?>" aria-label="ancho" name="a">
                </div>
                <div class="col-sm">
                    <input type="text" class="form-control form-control-user" value = "<?php echo $array_ordenes['h'];?>" aria-label="altura" name="h">
                </div>
                <div class="col-sm">
                    <input type="text" class="form-control form-control-user" value = "<?php echo $array_ordenes['peso'];?>" aria-label="peso" name="peso">
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" require name="direccion_recoleccion" class="form-control form-control-user" id="exampleFirstName"
                    value = "<?php echo $array_ordenes['direccion_recoleccion'];?>" maxlength="79">
                </div>
                <div class="col-sm-6">
                    <select require name="reempaque" class="form-control form-control-user" id="exampleFirstName">
                        <option value = "<?php echo $array_ordenes['direccion_recoleccion'];?>" selected>Lo volvemos a empacar...?</option>
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                </div>
            </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button class="btn btn-primary btn-user btn-block" title="REGISTRAR CLIENTE">ACTUALIZAR ENVIO</button>
                </div>
        </form>
        <hr>

<?php 
    incluirTemplate('fottersis');     
?>