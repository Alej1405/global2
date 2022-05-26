<?php 

 //incluye el header
 require '../../includes/funciones.php';
 $auth = estaAutenticado();

 if (!$auth) {
     header('location: ../../index.php');
 }
 incluirTemplate('headersis2');
 require '../../includes/config/database.php';
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

//agragar la seleccion del cliente 
$consulta = "SELECT * FROM cliente";
$resultado = mysqli_query($db, $consulta);

//VARIABLES DE FORMULARIO
    $id = " ";
    $ingreso = " ";
    $doc = " ";
    $nFactura = " ";
    $coEur1 = " ";
    $flete = " ";
    $mrn = " ";
    $bodegaAduana = " ";
    $provedor = " ";
    $usuario = $_SESSION['usuario'];
    $idCliente = " ";

//ARRAY DE ERROES
$errores = [];
$guardar = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    //echo "<pre>";
    //var_dump($_POST);
    //echo "</pre>";

    $id = mysqli_real_escape_string($db, $_POST['id'] );
    $ingreso = mysqli_real_escape_string($db, $_POST['ingreso'] );
    $doc = mysqli_real_escape_string($db, $_POST['doc'] );
    $nFactura = mysqli_real_escape_string($db, $_POST['nFactura'] );
    $coEur1 = mysqli_real_escape_string($db, $_POST['coEur1'] );
    $flete = mysqli_real_escape_string($db, $_POST['flete'] );
    $mrn = mysqli_real_escape_string($db,  $_POST['mrn'] );
    $bodegaAduana = mysqli_real_escape_string($db, $_POST['bodegaAduana'] );
    $provedor = mysqli_real_escape_string($db, $_POST['provedor'] );
    $usuario = $_SESSION['usuario'];
    $idCliente = mysqli_real_escape_string($db, $_POST['idCliente'] );

    //echo "<pre>";
    //var_dump($usuario);
    //echo "</pre>";

    // validar el formulario

    if(!$id) {
        $errores[] = "El Número de documento es super necesario, COMPLETAAAAA!!!";
    }
    if(!$ingreso) {
        $errores[] = "Hay que registrar la fecha en la que estás guardando, ASI NO SE PUEDE!!";
    }
    if(!$doc) {
        $errores[] = "El tipo de documento es necesario, PON TODO!!!";
    }
    if(!$nFactura) {
        $errores[] = "Si no hay el número de factura como declaramos...? HAZ BIEN!!!!";
    }
    if(!$coEur1) {
        $errores[] = "Si no hay certificado de origen escribe --NO ES NECESARIO--";
    }
    if(!$mrn) {
        $errores[] = "Si no lo tienes pon --A ESPERA DE MRN--";
    }
    if(!$bodegaAduana) {
        $errores[] = "Con este campo sabemos como facturar POOON!!!";
    }
    if(!$idCliente) {
        $errores[] = "Que haceeeee como sabemos de quién es la carga";
    }
    if(!$flete) {
        $errores[] = "Hay que agregar el velor del Flete POOON!!!";
    }
    
    if(empty($errores)) {
        // insertar datos en la base
        $query = "INSERT INTO cargas (id, ingreso, doc, nFactura, coEur1, flete, mrn, bodegaAduana, provedor, usuario, idCliente) 
                VALUES ('$id', '$ingreso', '$doc', '$nFactura', '$coEur1', '$flete', '$mrn', '$bodegaAduana', '$provedor', '$usuario', '$idCliente')";

        //echo $query;

        $resultado = mysqli_query($db, $query);
            //echo "hasta aquí funciona";

            if ($resultado) {
                //header('location: ../superAdmin.php?resultado=1');
                header('location: /superAdmin2.php');
            }
    }

}
?>

                <!-- /.container-fluid -->
<!-- TARJETA PARA CONJUNTO DE APLICACIONES -->
<div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">REGISTRO DE CARGAS</h6>
            </div>
            <div class="card-body">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">NUEVA IMPORTACION!</h1>
                            </div>
                            <?php foreach($errores as $error) : ?>
                                <div class="alerta">
                                    <?php echo $error; ?>
                                </div>
                            <?php endforeach ?>
                            <?php if($guardar=== 1):?>
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">CARGA INGRESADA CON EXITO!</h1>
                                </div>
                            <?php endif; ?>
                            <form action=" " method="POST" class="user">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user"  name="id" id="id"
                                            placeholder="BL / GUIA">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" name="nFactura" id="nFactura"
                                            placeholder="NUMERO DE FACTURA">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" class="form-control form-control-user"  name="flete" id="flete" 
                                        placeholder="VALOR DEL FLETE">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" name="provedor" id="provedor" 
                                        placeholder="PROVEEDOR">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" name="coEur1" id="coEur1" 
                                        placeholder="CERTIFICADO DE ORIGEN">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" name="mrn" id="mrn" 
                                        placeholder="MRN Numero de Carga">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="date" class="form-control form-control-user" name="ingreso" id="ingreso" 
                                        placeholder="FECHA DE REGISTRO">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" name="bodegaAduana" id="bodegaAduana" 
                                        placeholder="BODEGA ASIGNADA">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <!-- <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email Address"> -->
                                    <select name="idCliente"  class="form-control form-control-user">
                                        <option value="13" >--- Selecciona el cliente  ---</option>
                                        <?php while($cliente = mysqli_fetch_assoc($resultado) ): ?>
                                            <option value="<?php echo $cliente['id']?>"><?php echo $cliente['nombre']. " " . $cliente['apellido']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="doc"  class="form-control form-control-user">
                                        <option value=" " >--- Selecciona el tipo de documento ---</option>
                                        <option value="aereo" >Guía Aérea</option>
                                        <option value="maritimo" >BL Marítimo</option>
                                        <option value="terrestre" >Carta de Porte Terrestre</option>
                                    </select>
                                </div>
                    <!-- botones del crud  -->
                                <!-- <a href="login.html" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </a> -->
                                <input type="submit" class="btn btn-primary btn-user btn-block" value="INGRESAR CARGA">
                                <hr>
                    <!-- fin de botonoes del crud  -->
                            </form>
                            <!-- <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.html">Already have an account? Login!</a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- End of Main Content -->

            

<?php 
    incluirTemplate('fottersis');     
?>