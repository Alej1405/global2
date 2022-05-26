<?php 
    $resultado1 = $_GET['resultado'] ?? null;

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    conectarDB();
    $db =conectarDB();
    $auth = estaAutenticado();

    // // proteger la página
    if (!$auth) {
        header('location: index.php');
    }

    //agragar la seleccion de cargas 
    $consulta = "SELECT * FROM cargas";
    $resultado = mysqli_query($db, $consulta);

    //consultar la base de datos para la actualización.
    $consulta2 = "SELECT * FROM proceso WHERE nProceso = ${id}";
    $resultado2 = mysqli_query($db, $consulta2);
    $actualizar = mysqli_fetch_assoc($resultado2);

    // echo $consulta;

    // echo $id; 

    //TRAER LOS CAMPOS DEL FORMULARIO ANTERIOR 
    $nProceso = $actualizar['nProceso'];
    $fecha = $actualizar['fecha'];
    $distrito = $actualizar['distrito'];
    $regimen = $actualizar['regimen'];
    $agente = $actualizar['agente'];
    $nDai = $actualizar['nDai'];
    $nLiq = $actualizar['nLiq'];
    $estado = $actualizar['estado'];
    $observacion = $actualizar['observacion'];
    $tAforo = $actualizar['tAforo'];
    $editor = $_SESSION['usuario'];
    $idCarga = $actualizar['idCarga'];
    
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

            //verificar la guia
            if($guia['name']){
                //eliminar imagen previa
                unlink($archivos . $actualizar['guia']);

                //generar un nombre unico

                $nombreGuia = md5( uniqid( rand(), true)).".pdf";

                //subir los archivos
                move_uploaded_file($guia['tmp_name'], $archivos . $nombreGuia);
            }else{
                $nombreGuia = $actualizar['guia']; 
            }

            //verificar la factura
            if($guia['name']){
                //eliminar imagen previa
                unlink($archivos . $actualizar['factura']);

                //generar un nombre unico

                $nombreFactura = md5( uniqid( rand(), true)).".pdf";

                //subir los archivos
                move_uploaded_file($factura['tmp_name'], $archivos . $nombreFactura);
            }else{
                $nombreFactura = $actualizar['factura'];
            }

            //verificar dcp
            if($guia['name']){
                //eliminar imagen previa
                unlink($archivos . $actualizar['dcp']);

                //generar un nombre unico
                $nombreDcp = md5( uniqid( rand(), true)).".pdf";

                //subir los archivos
                move_uploaded_file($dcp['tmp_name'], $archivos . $nombreDcp);
            }else{
                $nombreDcp = $actualizar['dcp']; 
            }

            if(empty($errores)) {
                // insertar datos en la base
                $query = " UPDATE proceso SET   nProceso = ${nProceso}, 
                                                fecha = '${fecha}', 
                                                distrito = '${distrito}', 
                                                regimen = '${regimen}',
                                                agente = '${agente}',
                                                nDai = '${nDai}',
                                                nLiq = '${nLiq}',
                                                estado = '${estado}',
                                                observacion = '${observacion}',
                                                tAforo = '${tAforo}',
                                                guia = '${nombreGuia}',
                                                factura = '${nombreFactura}',
                                                dcp = '${nombreDcp}',
                                                editor = '${editor}',
                                                idCarga= '${idCarga}' WHERE nProceso = ${nProceso}";
                                                
                $resultado = mysqli_query($db, $query);
                    var_dump($resultado); 
                    if ($resultado) {
                        header('location: verprocesos.php?resultado=1');
                        
                    }
            }
        }

    }
?>

<h2 class="form__title">ACTUALIZAR PROCESO</h2>
<p class="form__p form2--p">
    RECUERDA INGRESAR LOS DATOS CORRECTOS, PARA UNA BUENA GESTIÓN.
</p>
<form action=" " class="form2" method="POST" enctype="multipart/form-data">
            
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
                                    <option <?php echo $idCarga === $carga['id'] ? 'selected' : '';
                                    ?> value="<?php echo $carga['id']?>" ><?php echo $carga['id']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form__grupo">
                            <input type="text" name="nProceso" id="nProceso"class="form__input" placeholder=" " value="<?php echo $actualizar['nProceso']; ?>" >
                            <label for="nProceso" class="form__label">Número de Proceso</label>
                            <span class="form__linea"></span>
                        </div>
                        <div class="form__grupo">
                            <input type="date" name="fecha" id="fecha"class="form__input" placeholder=" " value="<?php echo $actualizar['fecha']; ?>" >
                            <label for="fecha" class="form__label">Fecha de Registro</label>
                            <span class="form__linea"></span>
                        </div>
                        <div class="form__grupo">
                            <select name="distrito"  class="form__input">
                                <option value="<?php echo $actualizar['distrito']; ?>" ><?php echo $actualizar['distrito']; ?></option>
                                <option value="gye" >GUAYAQUIL</option>
                                <option value="uio" >QUITO</option>
                                <option value="otro" >Otro</option>
                            </select>
                        </div>
                        <div class="form__grupo">
                            <select name="regimen"  class="form__input">
                                <option value="<?php echo $actualizar['regimen']; ?>" ><?php echo $actualizar['regimen']; ?></option>
                                <option value="r70" >REGIMEN 70</option>
                                <option value="r10par" >REGIMEN 10 PARCIAL / TOTAL</option>
                                <option value="r10" >REGIMEN 10</option>
                                <option value="otro" >Otro</option>
                            </select>
                        </div>
                        <div class="form__grupo">
                            <select name="agente"  class="form__input">
                                <option value="<?php echo $actualizar['agente']; ?>" ><?php echo $actualizar['agente']; ?></option>
                                <option value="romero" >FRANCISCO ROMERO</option>
                                <option value="yolanda" >YOLANDA ROJAS</option>
                                <option value="nora" >NORA GONZALEZ</option>
                                <option value="otro" >Otro</option>
                            </select>
                        </div>
                        <div class="form__grupo">
                            <input type="file" name="dcp" id="dcp" class="form__input" placeholder=" " value="<?php echo $actualizar['dcp']; ?>">
                            <label for="dcp" class="form__label">DCP</label>
                            <span class="form__linea"></span>
                        </div>
                    </div>
                    <div class="form__container form--2">
                        <div class="form__grupo">
                            <input type="text" name="nDai" id="nDai" class="form__input" placeholder=" " value="<?php echo $actualizar['nDai']; ?>">
                            <label for="nDai" class="form__label">Número de DAI</label>
                            <span class="form__linea"></span>
                        </div>
                        <div class="form__grupo">
                            <input type="text" name="nLiq" id="nLiq" class="form__input" placeholder=" " value="<?php echo $actualizar['nLiq']; ?>">
                            <label for="nLiq" class="form__label">Número de Liquidación</label>
                            <span class="form__linea"></span>
                        </div>
                        <div class="form__grupo">
                            <select name="estado"  class="form__input">
                                <option value="<?php echo $actualizar['estado']; ?>" ><?php echo $actualizar['estado']; ?></option>
                                <option value="observado" >OBSERVADO</option>
                                <option value="cerrado" >CERRADO</option>
                                <option value="sautorizada" >SALIDA AUTORIZADA</option>
                                <option value="profisico" >EN PROCESO DE AFORO FISICO INTRUSIVO</option>
                                <option value="afadoc" >EN PROCESO DE AFORO DOCUMENTAL</option>
                            </select>
                        </div>
                        <div class="form__grupo">
                            <select name="tAforo"  class="form__input">
                                <option value="<?php echo $actualizar['tAforo']; ?>" ><?php echo $actualizar['tAforo']; ?></option>
                                <option value="afdocumental" >EN AFORO DOCUMENTAL</option>
                                <option value="affisico" >EN AFORO FISICO</option>
                                <option value="afautomatico" >EN AFORO AUTOMÁTICO</option>
                            </select>
                        </div>
                        <div class="form__grupo">
                            <input type="text" name="observacion" id="observacion" class="form__input" placeholder=" " value="<?php echo $actualizar['observacion']; ?>">
                            <label for="observacion" class="form__label">Observación</label>
                            <span class="form__linea"></span>
                        </div>
                        
                        <div class="form__grupo">
                            <input type="file" name="factura" id="fatura" class="form__input" placeholder=" " value="<?php echo $actualizar['factura']; ?>">
                            <label for="factura" class="form__label">Numero de Factura</label>
                            <span class="form__linea"></span>
                        </div>
                        <div class="form__grupo">
                            <input type="file" name="guia" id="guia" class="form__input" placeholder=" " value="<?php echo $actualizar['guia']; ?>">
                            <label for="guia" class="form__label">Número de Guía</label>
                            <span class="form__linea"></span>
                        </div>
                    </div>        
                </div>
                <div class="botones">
                    <input type="submit" class="form__submit" value="ACTUALIZAR PROCESO">
                </div>
                <div class="boton__anidado">
                    <a href="verprocesos.php" class="enlace">salir sin guardar</a>
                </div>
        </fieldset>
</form>