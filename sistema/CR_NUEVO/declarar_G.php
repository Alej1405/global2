<?php 
    $resultado1 = $_GET['resultado'] ?? null;
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

    //agragar la seleccion de cargas 
    $consulta = "SELECT * FROM cargas";
    $resultado = mysqli_query($db, $consulta);
    
    $errores = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //var_dump($_POST);

        $nProceso = mysqli_real_escape_string($db, $_POST['nProceso'] );
        $fecha = mysqli_real_escape_string($db, $_POST['fecha'] );
        $distrito = mysqli_real_escape_string($db, $_POST['distrito'] );
        $regimen = mysqli_real_escape_string($db, $_POST['regimen'] );
        $agente = mysqli_real_escape_string($db, $_POST['agente'] );
        $nDai = mysqli_real_escape_string($db, $_POST['nDai'] );
        $nLiq = mysqli_real_escape_string($db, $_POST['nLiq'] );
        $estado = mysqli_real_escape_string($db, $_POST['estado'] );
        $observacion = mysqli_real_escape_string($db, $_POST['observacion'] );
        $tAforo = mysqli_real_escape_string($db, $_POST['tAforo'] );
        $editor = $_SESSION['usuario'];
        $idCarga = mysqli_real_escape_string($db, $_POST['idCarga'] );
        $despacho = "pendiente";
        //asignar una variable al archivo

        $guia = $_FILES['guia'];
        $factura = $_FILES['factura'];
        $dcp = $_FILES['dcp'];

        //validacion del formulario

        if(!$nProceso) {
            $errores[] = "Tienes que codificar el numero de Proceso... Del todo mismo... ";
        }
        if(!$fecha) {
            $errores[] = "Pero si la fecha es principal, pon rápido!!!";
        }
        if(!$distrito) {
            $errores[] = "Si no llenas esto de donde vamos a despachar la carga, del todo mismo";
        }
        if(!$regimen) {
            $errores[] = "Quesf!!! si no se sabe pregunte, pero llenaaaa!!!";
        }
        if(!$agente) {
            $errores[] = "Si, tambipen es necesario pon rápido ";
        }
        if(!$nDai) {
            $errores[] = "Si aún no tienes la Dai, pon NO TENGO y Ya!!! Del todo!!!";
        }
        if(!$nLiq) {
            $errores[] = "Si aún no tienes la Liquidacion, pon NO TENGO y Ya!!! Del todo!!!";
        }
        if(!$estado) {
            $errores[] = "Ni para que explicarte, llena en que ESTADO está la carga ";
        }
        if(!$observacion) {
            $errores[] = "Si aún no tienes la observacion, pon NO TENGO y Ya!!! Del todo!!!";
        }
        if(!$tAforo) {
            $errores[] = "Si aún no tienes el TITPO DE AFORO, pon NO TENGO y Ya!!! Del todo!!!";
        }
        if(!$idCarga) {
            $errores[] = "Relaciona a una carga si no de quien es este proceso, piensa un poquito jejejé";
        }

        if(empty($errores)) {

            /**SUBIR ARCHIVOS A LA BASE DE DATOS */
            // Crear carpeta

            $archivos = '../../respaldos/';

            if(!is_dir($archivos)){
                mkdir($archivos);
            }

            //generar un nombre unico

            $nombreGuia = md5( uniqid( rand(), true)).".pdf";
            $nombreFactura = md5( uniqid( rand(), true)).".pdf";
            $nombreDcp = md5( uniqid( rand(), true)).".pdf";

            //subir los archivos
            move_uploaded_file($guia['tmp_name'], $archivos . $nombreGuia);
            move_uploaded_file($factura['tmp_name'], $archivos . $nombreFactura);
            move_uploaded_file($dcp['tmp_name'], $archivos . $nombreDcp);

            // insertar datos en la base
            $query = "INSERT INTO proceso (nProceso, fecha, distrito, regimen, agente, nDai, nLiq, estado, observacion, tAforo, guia, factura, dcp, editor, despacho, idCarga) 
            VALUES ('$nProceso', '$fecha', '$distrito', '$regimen', '$agente', '$nDai', '$nLiq', '$estado', '$observacion', '$tAforo', '$nombreGuia', '$nombreFactura', '$nombreDcp', '$editor', '$despacho', '$idCarga')";

            //echo $query;

            $guardar = mysqli_query($db, $query);

            //echo "si vale";
            var_dump($guardar);

            if ($guardar){
                //var_dump($guardar);
                //header('location: ../superAdmin.php?resultado=1');
                //echo "no se borró"; 
                switch ($_SESSION['rol']){
                    case "admin":
                        header('location: ../admin.php?resultado=2');
                        break;
                    case "superAdmin":
                        header('location: ../superAdmin.php?resultado=2');
                        break;
                    case "comercial":
                        header('location: ../comercial.php?resultado=2');
                        break;
                    case "control":
                        header('location: ../control.php?resultado=2');
                        break;
                    case "adminBodega":
                        header('location: ../adminBodega.php?resultado=2');
                        break;
                    case "bodega":
                        header('location: ../bodega.php?resultado=2');
                        break;
                }
            }else{
                echo "estas duplicando el numero de proceso QUE HACE QUE HACE QUE HACEEEE!!!";
                header('location: declarar.php?resultado=3');
            }
        }

    }
?>

<h2 class="form__title">REGISTRAR PROCESO ADUANERO</h2>
<p class="form__p form2--p">
    RECUERDA INGRESAR LOS DATOS CORRECTOS, PARA UNA BUENA GESTIÓN.
</p>
<form action=" " class="form2" method="POST" enctype="multipart/form-data">
            <div class="usuario__enlaces anidados">
                <div class="boton__anidado">
                    <a href="dcp.php" class="enlace">AGREGAR DCP</a>
                </div>
            </div>
    <?php foreach($errores as $error) : ?>
    <div class="alerta">
        <?php echo $error; ?>
    </div>
    <?php endforeach ?>
    <?php if(intval($resultado1) === 3 ): ?>
        <p class="alerta">QUÉ HACEEEE QUE HACEEEEE, no estas usando un numero de proceso que ya existe... no mismo!!!</p>
    <?php endif ; ?>
    <fieldset class="marco">
            <legend class="empresa">INICIO DE PROCESO</legend>
                <div class="container2">
                    <div class="form__container form--2">
                        <div class="form__grupo">
                            <select name="idCarga"  class="form__input">
                                <option value=" " >--- Selecciona una carga ---</option>
                                <?php while($carga = mysqli_fetch_assoc($resultado) ): ?>
                                    <option value="<?php echo $carga['id']?>" ><?php echo $carga['id']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form__grupo">
                            <input type="text" name="nProceso" id="nProceso"class="form__input" placeholder=" " value="" >
                            <label for="nProceso" class="form__label">Número de Proceso</label>
                            <span class="form__linea"></span>
                        </div>
                        <div class="form__grupo">
                            <input type="date" name="fecha" id="fecha"class="form__input" placeholder=" " value="" >
                            <label for="fecha" class="form__label">Fecha de ingreso</label>
                            <span class="form__linea"></span>
                        </div>
                        <div class="form__grupo">
                            <select name="distrito"  class="form__input">
                                <option value=" " >--- Selecciona un Distrito ---</option>
                                <option value="gye" >GUAYAQUIL</option>
                                <option value="uio" >QUITO</option>
                                <option value="otro" >Otro</option>
                            </select>
                        </div>
                        <div class="form__grupo">
                            <select name="regimen"  class="form__input">
                                <option value=" " >--- Selecciona un Régimen ---</option>
                                <option value="r70" >REGIMEN 70</option>
                                <option value="r10par" >REGIMEN 10 PARCIAL / TOTAL</option>
                                <option value="r10" >REGIMEN 10</option>
                                <option value="otro" >Otro</option>
                            </select>
                        </div>
                        <div class="form__grupo">
                            <select name="agente"  class="form__input">
                                <option value=" " >--- Selecciona un Agente ---</option>
                                <option value="romero" >FRANCISCO ROMERO</option>
                                <option value="yolanda" >YOLANDA ROJAS</option>
                                <option value="nora" >NORA GONZALEZ</option>
                                <option value="otro" >Otro</option>
                            </select>
                        </div>
                        <div class="form__grupo">
                            <input type="file" name="dcp" id="dcp" class="form__input" placeholder=" " value="">
                            <label for="dcp" class="form__label">Adjunta el DCP si es necesario</label>
                            <span class="form__linea"></span>
                        </div>
                    </div>
                    <div class="form__container form--2">
                        <div class="form__grupo">
                            <input type="text" name="nDai" id="nDai" class="form__input" placeholder=" " value="">
                            <label for="nDai" class="form__label">Número de DAI</label>
                            <span class="form__linea"></span>
                        </div>
                        <div class="form__grupo">
                            <input type="text" name="nLiq" id="nLiq" class="form__input" placeholder=" " value="">
                            <label for="nLiq" class="form__label">Número de LIQUIDACIÓN</label>
                            <span class="form__linea"></span>
                        </div>
                        <div class="form__grupo">
                            <select name="estado"  class="form__input">
                                <option value=" " >--- Selecciona un Estado ---</option>
                                <option value="observado" >OBSERVADO</option>
                                <option value="cerrado" >CERRADO</option>
                                <option value="sautorizada" >SALIDA AUTORIZADA</option>
                                <option value="profisico" >EN PROCESO DE AFORO FISICO INTRUSIVO</option>
                                <option value="afadoc" >EN PROCESO DE AFORO DOCUMENTAL</option>
                            </select>
                        </div>
                        <div class="form__grupo">
                            <select name="tAforo"  class="form__input">
                                <option value=" " >--- Selecciona un AFORO ---</option>
                                <option value="afdocumental" >EN AFORO DOCUMENTAL</option>
                                <option value="affisico" >EN AFORO FISICO</option>
                                <option value="afautomatico" >EN AFORO AUTOMÁTICO</option>
                            </select>
                        </div>
                        <div class="form__grupo">
                            <input type="text" name="observacion" id="observacion" class="form__input" placeholder=" " value="">
                            <label for="observacion" class="form__label">Ingresa una observación</label>
                            <span class="form__linea"></span>
                        </div>
                        
                        <div class="form__grupo">
                            <input type="file" name="factura" id="fatura" class="form__input" placeholder=" " value="">
                            <label for="factura" class="form__label">Sube la factura de la carga</label>
                            <span class="form__linea"></span>
                        </div>
                        <div class="form__grupo">
                            <input type="file" name="guia" id="guia" class="form__input" placeholder=" " value="">
                            <label for="guia" class="form__label">Sube la guía de la carga</label>
                            <span class="form__linea"></span>
                        </div>
                    </div>        
                </div>
                <div class="botones">
                    <input type="submit" class="form__submit" value="GUARDAR PROCESO">
                </div>
                <div class="boton__anidado">
                    <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
                </div>
        </fieldset>
</form>

<?php 
    incluirTemplate('fottersis');     
?>