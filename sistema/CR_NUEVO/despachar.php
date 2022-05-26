<?php 
    $resultado1 = $_GET['resultado'] ?? null;

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    conectarDB();
    $db =conectarDB();

    conectarDB2();
    $db2 =conectarDB2();
    $auth = estaAutenticado();

    // // proteger la página
    if (!$auth) {
        header('location: index.php');
    }else{
    // var_dump($_SESSION['rol']);
    // var_dump($_SESSION['id']);
    }
    //consultar la base de datos para la actualización.
    $consulta2 = "SELECT * FROM proceso WHERE nProceso = ${id}";
    $resultado2 = mysqli_query($db, $consulta2);
    $actualizar = mysqli_fetch_assoc($resultado2);

    //TRAER LOS CAMPOS DEL FORMULARIO ANTERIOR 
    $guia = $actualizar['guia'];
    $fecha = $actualizar['fecha'];
    $distrito = $actualizar['distrito'];
    $regimen = $actualizar['regimen'];
    $agente = $actualizar['agente'];
    $nDai = $actualizar['nDai'];
    $nLiq = $actualizar['nLiq'];
    $estado = $actualizar['estado'];
    $observacion = $actualizar['observacion'];
    $editor = $_SESSION['usuario'];
    
    $errores = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //valores para appi
        $nGuia = $actualizar['idCarga'];
        $fIngreso = mysqli_real_escape_string($db, $_POST['fEntrega'] );
        $produc = mysqli_real_escape_string($db, $_POST['produc'] );
        $proveed = mysqli_real_escape_string($db, $_POST['proveed'] );
        $cCaja = mysqli_real_escape_string($db, $_POST['cCaja'] );
        $cUnidad = mysqli_real_escape_string($db, $_POST['cUnidad'] );
        $m3total = mysqli_real_escape_string($db, $_POST['m3total'] );
        $observacion = mysqli_real_escape_string($db, $_POST['observacion'] );
        $m3caja = mysqli_real_escape_string($db, $_POST['m3caja'] );
        $responsab = $_SESSION['usuario'];
        //datos para base interna
        $nDespacho = mysqli_real_escape_string($db, $_POST['nDespacho'] );
        $origen = mysqli_real_escape_string($db, $_POST['origen'] );
        $destino = mysqli_real_escape_string($db, $_POST['destino'] );
        $fSalida = mysqli_real_escape_string($db, $_POST['fSalida'] );
        $fEntrega = mysqli_real_escape_string($db, $_POST['fEntrega'] );
        $placa = mysqli_real_escape_string($db, $_POST['placa'] );
        $chofer = mysqli_real_escape_string($db, $_POST['chofer'] );
        $contacto = mysqli_real_escape_string($db, $_POST['contacto'] );
        $tVehiculo = mysqli_real_escape_string($db, $_POST['tVehiculo'] );
        $idCarga = $actualizar['idCarga'];


        //echo $idCarga;

        //validar formulario
        if(!$nDespacho) {
            $errores[] = "Codifica el número de despacho, si no sabes como pregunta.";
        }
        if(!$origen) {
            $errores[] = "El punto de partida es obligatorio haz bien ";
        }
        if(!$destino) {
            $errores[] = "el punto de entrega igual es importante, asi no se puede.";
        }
        if(!$fEntrega) {
            $errores[] = "La fecha de entrega es suuuer importante eso vamos a notifcar ";
        }
        if(!$fSalida) {
            $errores[] = "tenemos que saber cuanto se demora el transito para eso es la fecha de salida";
        }
        if(!$proveed) {
            $errores[] = "completa la empresa proveedora";
        }

        if(empty($errores)){

            //borrar el atributo despacho
            $Bdespacho = " UPDATE proceso SET despacho = '' WHERE nProceso = ${id}";
            $resultado3 = mysqli_query($db, $Bdespacho);
            
            //crear el query para guardar en la base de despachos.
            $query ="INSERT INTO despacho (nDespacho, origen, destino, fSalida, fEntrega, tVehiculo, placa, chofer, contacto, editor, idCarga) 
                    values ('$nDespacho', '$origen', '$destino', '$fSalida', '$fEntrega', '$tVehiculo', '$placa', '$chofer', '$contacto', '$responsab', '$idCarga')";
                    echo $query; 
                    $resultado = mysqli_query($db, $query);

                    if($resultado){
                        header('location: consig.php?resultado=1');
                    }
            //crear el query para guardar en la base de despachos.
            $query2 ="INSERT INTO ingresog (nGuia, fIngres, produc, proveed, cCaja, cUnidad, m3total, observac, responsab, m3caja, idCarga) 
                    values ('$nGuia', '$fIngreso', '$produc', '$proveed', '$cCaja', '$cUnidad', '$m3total', '$observac', '$responsab', '$m3caja', '$idCarga')";
                    echo $query; 
                    $resultado2 = mysqli_query($db2, $query2);

                    if($resultado2){
                        header('location: consig.php?resultado=2');
                        
                    }
            
            //enviar correo de notificacion
            $destinatario = 'mafer.fernandez@globalcargoecuador.com';
            $asunto = 'Carga por arribar';
            // configuración del mensaje
            $header = "Notificaión de arribo de carga";
            $mensajeCompleto = "Hola Mafer, Hay carga por llegar a la bodega por favor revisa tu portal en el sistema o comunicate con procesos de Global Cargo";
            mail($destinatario, $asunto, $mensajeCompleto, $header);
            echo "<script>alert('adjunto se notifico por correo ')</script>";

        }
    }
?>

<form action=" " class="form2" method="POST">
    <h2 class="form__titulo">REGISTRAR DESPACHO</h2>
    <p class="form__p form2--p">
        Recuerda llenar bien estos campos para realizar una 
        correcta operación.
    </p>
    <?php foreach($errores as $error) : ?>
        <div class="alerta">
            <?php echo $error; ?>
        </div>
    <?php endforeach ?>

<fieldset class="marco">
<legend class="empresa">AGREGAR DATOS DEL CHOFER</legend>
    <div class="container2">
        <div class="form__container form--2">
            <div class="form__grupo">
                <input type="text" name="nDespacho" id="nDespacho"class="form__input" placeholder=" " value="" >
                <label for="nDespacho" class="form__label">Número de Despacho</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="origen" id="origen"class="form__input" placeholder=" " value="" >
                <label for="origen" class="form__label">Punto de Inicio</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="destino" id="destino" class="form__input" placeholder=" " value="">
                <label for="destino" class="form__label">Punto de Entrega</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="date" name="fSalida" id="fSalida" class="form__input" placeholder=" " value="">
                <label for="fSalida" class="form__label">Fecha de Salida</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="date" name="fEntrega" id="fEntrega" class="form__input" placeholder=" " value="">
                <label for="fEntrega" class="form__label">Fecha de entrega</label>
                <span class="form__linea"></span>
            </div>            
        </div>
        <div class="form__container form--2">
            <div class="form__grupo">
                <input type="text" name="tVehiculo" id="tVehiculo"class="form__input" placeholder=" " value="">
                <label for="tVehiculo" class="form__label"> Tipo de Trnasporte</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="tel" name="placa" id="placa" class="form__input" placeholder=" " value="">
                <label for="placa" class="form__label">Placa</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="chofer" id="chofer"class="form__input" placeholder=" " value="">
                <label for="chofer" class="form__label">Nombre del Chofer</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="contacto" id="contacto"class="form__input" placeholder=" " value="">
                <label for="contacto" class="form__label">Empresa Proveedora</label>
                <span class="form__linea"></span>
            </div>
        </div>
    </div>
</fieldset>

<fieldset class="marco">
<legend class="empresa">DATOS A CONSIGNAR</legend>
    <div class="container2">
        <div class="form__container form--2">
            <div class="form__grupo">
                <input type="text"  readonly name="nDespacho" id="nDespacho"class="form__input" placeholder=" " value="<?php echo $actualizar['nProceso']; ?>" >
                <label for="nDespacho" class="form__label">Número de proceso/label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="proveed" id="proveed"class="form__input" placeholder=" " value="">
                <label for="proveed" class="form__label"> Proveedor</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" readonly name="observacion" id="observacion"class="form__input" placeholder=" " value="<?php echo $actualizar['observacion']; ?>">
                <label for= "observacion" class="form__label"> Observación</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text"  name="m3caja" id="m3caja" class="form__input" placeholder=" " value="">
                <label for= "m3caja" class="form__label"> Metros cúbico de la caja</label>
                <span class="form__linea"></span>
            </div>         
        </div>
        <div class="form__container form--2">
            <div class="form__grupo">
                <input type="text" name="produc" id="produc" class="form__input" placeholder=" " value="" >
                <label for="produc" class="form__label">productos</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="cCaja" id="cCaja" class="form__input" placeholder=" " value="">
                <label for="cCaja" class="form__label"> Cantidad de Cajas</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="cUnidad" id="cUnidad" class="form__input" placeholder=" " value="">
                <label for="cUnidad" class="form__label"> Cantidad de Unidades</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="m3total" id="m3total" class="form__input" placeholder=" " value="">
                <label for="m3total" class="form__label">Metros cubicos Totales</label>
                <span class="form__linea"></span>
            </div>
            
    </div>
</fieldset>
    <div class="botones">
        <input type="submit" class="form__submit" value="INGRESAR CARGA">
    </div>
</form>