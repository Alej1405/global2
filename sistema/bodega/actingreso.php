<?php 
    $resultado = $_GET['resultado'] ?? null;
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    
    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    //BASE DE DATOS GLOBAL CARGO
    conectarDB();
    $db =conectarDB();
    $auth = estaAutenticado();
    //BASE DE DATOS BODEGA 
    conectarDB2();
    $db2 =conectarDB2();

    //proteger la página
    if (!$auth) {
        header('location: ../global/index.php');
    }

    $errores = [];
    $mensaje = [];


    //echo $id;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";
        // exit; 
            $marca = mysqli_real_escape_string($db, $_POST['marca']);
            $notsanit  = mysqli_real_escape_string($db, $_POST['notsanit']);
            $lote = mysqli_real_escape_string($db, $_POST['lote']);
            $fElab = mysqli_real_escape_string($db, $_POST['fElab']);
            $fVenc = mysqli_real_escape_string($db, $_POST['fVenc']);
            $cCaja = mysqli_real_escape_string($db, $_POST['cCaja']);
            $cUnid = mysqli_real_escape_string($db, $_POST['cUnid']);
            $ubicac = mysqli_real_escape_string($db, $_POST['ubicac']);
            $observac = mysqli_real_escape_string($db, $_POST['observac']);
            $largo = mysqli_real_escape_string($db, $_POST['largo']);
            $ancho = mysqli_real_escape_string($db, $_POST['ancho']);
            $alto = mysqli_real_escape_string($db, $_POST['alto']);
            $editor = $_SESSION['usuario'];
            $idIngresog = $id;
            $editado = 'si';
            
            $m3entrad = $largo * $ancho * $alto;
            $m3total = $m3entrad * $cCaja;

        // validar el formulario

        if(!$marca) {
            $errores[] = "ESTA MARCA NO EXISTE O NO ESTA REGISTRADA SISTEMA....VERIFICA!!!";
        }
        if(!$fElab){
            $errores[] = "debes ingresar la fecha elaboración registrada en la etiqueta";
        }
        if(!$fVenc) {
            $errores [] = "debes ingresar la fecha vencimiento registrada en la etiqueta";
        }
        if(!$cCaja){
            $errores [] = "ingresar la cantidad de cajas total.... DEBE SER EL MISMO INGRESADO";
        }
        if(!$cUnid){
            $errores [] = "Ingrese la cantidad exacta de unidades de cada caja... CUANTAS CONTIENE CADA CAJA";
        }
        if(!$m3entrad) {
            $errores[] = "Con este campo sabemos el espacio ocupado bodega POOON!!!";
        }
        if(!$ubicac) {
            $errores [] = "Escoger bien el lugar donde ingresa... VERIFIQUE!!";
        }
        if(!$observac) {
            $errores[] = "existe algun detalle sobre la carga";
        }
        
        if(empty($errores)) {
            // insertar datos en la base
            $query = " UPDATE ingreso SET   
                                            marca = '${marca}', 
                                            notsanit = '${notsanit}', 
                                            lote = '${lote}',
                                            fElab = '${fElab}',
                                            fVenc = '${fVenc}',
                                            cCaja = '${cCaja}',
                                            cUnid = '${cUnid}',
                                            largo = '${largo}',
                                            ancho = '${ancho}',
                                            alto = '${alto}',
                                            m3entrad = '${m3entrad}',
                                            m3total = '${m3total}',
                                            ubicac = '${ubicac}',
                                            observac = '${observac}',
                                            editor = '${editor}' WHERE id = ${id}";
                    //echo $query;
            $actualizar = mysqli_query($db2, $query);
                if ($actualizar){
                    $resultado = 1; 
                }else{
                    header('location: verdetalles.php');
                }



        }
        

    }
?>

<?php 
    //consultar los datos de la tabla general
    $query2 = "SELECT * FROM ingreso WHERE id = ${id}";
    $consultaG = mysqli_query($db2, $query2);
    $datos = mysqli_fetch_assoc($consultaG);
?>

    
    <form action=" " class="form2" method="POST">
        <h2 class="form__titulo">ACTUALIZAR DETALLE DE INGRESO</h2>
    <p class="form__p form2--p">
        Llenar correctamente los datos del registro.
    </p>
    <?php foreach($errores as $error) : ?>
        <div class="Corregir">
            <?php echo $error; ?>
        </div>
    <?php endforeach ?>

    <?php if(intval($resultado) === 1 ): ?>
        <p class="alerta2">EL INGRESO SE ACTUALIZO BIEN!!! YA ANDA A SERGUIR TRABAJANDO JE JE JE</p>
    <?php elseif(intval($resultado) === 2 ): ?>
        <p class="alerta">EL PROCESO SE REGISTRÓ CON ÉXITO</p>
    <?php endif ?>

    <div class="container2">
        <div class="form__container form--2">
            <div class="form__grupo">
                <select name="marca"  class="form__input">
                    <option value=" " >--- Seleccionar Marca ---</option>
                    <option value="dialine" >DIALINE</option>
                    <option value="erasmin" >ERASMIN</option>
                    <option value="azuvistin">AZUVISTIN</option>
                    <option value="otros">OTROS</option>
                </select>
            </div>
            <div class="form__grupo">
                <input type="text" name="notsanit" id="notsanit" class="form__input" placeholder=" " value="<?php echo $datos['notsanit'];?>" >
                <label for="notsanit" class="form__label">Not Sanitario</label>
            </div>
            <div class="form__grupo">
                <input type="text" name="lote" id="lote" class="form__input" placeholder=" " value="<?php echo $datos['lote'];?>" >
                <label for="lote" class="form__label">Lote</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="date" name="fElab" id="fElab" class="form__input" placeholder=" " value="<?php echo $datos['fElab'];?>" >
                <label for="fElab" class="form__label">Fecha Elaboración</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="date" name="fVenc" id="fVenc" class="form__input" placeholder=" " value="<?php echo $datos['fVenc'];?>">
                <label for="fVenc" class="form__label">Fecha de Vencimiento</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="number" name="cCaja" id="cCaja" class="form__input" placeholder=" " value="<?php echo $datos['cCaja'];?>" >
                <label for="cCaja" class="form__label">Cantidad de Cajas</label>
                <span class="form__linea"></span>
            </div>
        </div>
        <div class="form__container form--2">
            <div class="form__grupo">
                <input type="text" name="cUnid" id="cUnid" class="form__input" placeholder=" " value="<?php echo $datos['cUnid'];?>" >
                <label for="cUnid" class="form__label">Cantidad de Unidades</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="number" name="largo" id="largo" class="form__input" placeholder=" " value="<?php echo $datos['largo'];?>" >
                <label for="largo" class="form__label">Largo de la Caja</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="number" name="ancho" id="ancho" class="form__input" placeholder=" " value="<?php echo $datos['ancho'];?>" >
                <label for="ancho" class="form__label">Ancho de la caja</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="number" name="alto" id="alto" class="form__input" placeholder=" " value="<?php echo $datos['alto'];?>" >
                <label for="alto" class="form__label">Alto de la caja</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <select name="ubicac" class="form__input">
                    <option value="<?php echo $datos['notsanit']?>" ><?php echo $datos['notsanit']?></option>
                    <option value="almacen">ALMACEN</option>
                    <option value="bodega">BODEGA</option>
                    <option value="otro">OTRO</option>
                </select>
            </div>
            <div class="form__grupo">
                <input type="text" name="observac" id="observac" class="form__input" placeholder=" " value="<?php echo $datos['observac'];?>" >
                <label for="observac" class="form__label">Observación</label>
                <span class="form__linea"></span>
            </div>
        </div>
    </div>
    <input type="submit" class="form__submit" value="ACTUALIZAR">

    <div class="boton__anidado">
        <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
    </div>
</form>


</html>