<?php 

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    conectarDB();
    $db =conectarDB();

    $auth = estaAutenticado();

    // // proteger la página
    if (!$auth) {
        header('location: index.php');
    }else{
    // var_dump($_SESSION['rol']);
    // var_dump($_SESSION['id']);
    }

    //agragar la seleccion del cliente 
    $consulta = "SELECT * FROM cliente";
    $resultado = mysqli_query($db, $consulta);
    

    $errores = [];

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
                    switch ($_SESSION['rol']){
                        case "admin":
                            header('location: ../admin.php?resultado=1');
                            break;
                        case "superAdmin":
                            header('location: ../superAdmin.php?resultado=1');
                            break;
                        case "comercial":
                            header('location: ../comercial.php?resultado=1');
                            break;
                        case "control":
                            header('location: ../control.php?resultado=1');
                            break;
                        case "adminBodega":
                            header('location: ../adminBodega.php?resultado=1');
                            break;
                        case "bodega":
                            header('location: ../bodega.php?resultado=1');
                            break;
                    }
                }
        }

    }
?>

<form action=" " class="form2" method="POST">
    <div class="container2">
        <div class="form__container form--2">
            <div class="form__grupo">
                <!-- <input type="text" name="id" id="id"class="form__input" placeholder=" " value="" > -->
                <!-- <label for="id" class="form__label">Número de GUIA/BL.</label>
                <span class="form__linea"></span> -->
            </div>
            <div class="form__grupo">
                <!-- <select name="doc"  class="form__input">
                    <option value=" " >--- Selecciona el tipo de documento ---</option>
                    <option value="aereo" >Guía Aérea</option>
                    <option value="maritimo" >BL Marítimo</option>
                    <option value="terrestre" >Carta de Porte Terrestre</option>
                </select> -->
            </div>
            <div class="form__grupo">
                <!-- <input type="date" name="ingreso" id="ingreso" class="form__input" placeholder=" " value="">
                <label for="ingreso" class="form__label">Fecha de Registro.</label>
                <span class="form__linea"></span> -->
            </div>
            <div class="form__grupo">
                <!-- <input type="text" name="nFactura" id="nFactura" class="form__input" placeholder=" " value="">
                <label for="nFactura" class="form__label">Número de Factura</label>
                <span class="form__linea"></span> -->
            </div>
            <div class="form__grupo">
                <!-- <input type="text" name="coEur1" id="coEur1"class="form__input" placeholder=" " value="">
                <label for="coEur1" class="form__label"> Número de Certificado de Origen / EUR1</label>
                <span class="form__linea"></span> -->
            </div>
            
        </div>
        <div class="form__container form--2">
            <div class="form__grupo">
                <!-- <select name="idCliente"  class="form__input">
                    <option value="13" >--- Selecciona el cliente  ---</option>
                    <?php while($cliente = mysqli_fetch_assoc($resultado) ): ?>
                        <option value="<?php echo $cliente['id']?>"><?php echo $cliente['nombre']. " " . $cliente['apellido']; ?></option>
                    <?php endwhile; ?>
                </select> -->
            </div>
            <div class="form__grupo">
                <!-- <input type="tel" name="flete" id="flete" class="form__input" placeholder=" " value="">
                <label for="flete" class="form__label">Valor del flete</label>
                <span class="form__linea"></span> -->
            </div>
            <div class="form__grupo">
                <!-- <input type="tel" name="mrn" id="mrn" class="form__input" placeholder=" " value="">
                <label for="mrn" class="form__label">MRN de la Carga</label>
                <span class="form__linea"></span> -->
            </div>
            <div class="form__grupo">
                <!-- <input type="text" name="bodegaAduana" id="bodegaAduana"class="form__input" placeholder=" " value="">
                <label for="bodegaAduana" class="form__label">Bodega Asignada por SENAE</label>
                <span class="form__linea"></span> -->
            </div>
            <div class="form__grupo">
                <!-- <input type="text" name="provedor" id="provedor"class="form__input" placeholder=" " value="">
                <label for="provedor" class="form__label">Empresa Proveedora</label>
                <span class="form__linea"></span> -->
            </div>
            
        </div>
        
    </div>
    <div class="botones">
        <input type="submit" class="form__submit" value="INGRESAR CARGA">
    </div>
    <div class="boton__anidado">
        <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
    </div>
</form>