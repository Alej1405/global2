<?php 

    //require '../../includes/config/database.php';
    //require '../../includes/funciones.php';
    //incluirTemplate('headersis');
    //conectarDB();
    //$db =conectarDB();

    //$auth = estaAutenticado();

    // // proteger la página
    //if (!$auth) {
        //header('location: index.php');
    //}else{
    // var_dump($_SESSION['rol']);
    // var_dump($_SESSION['id']);
    //}

    //agragar la seleccion del cliente 
    //$consulta = "SELECT * FROM cliente";
    //$resultado = mysqli_query($db, $consulta);
    
    // enviar correo de autorizacion de despacho verificacion de pago ok
    $destinatario = 'mafer.fernandez@globalcargoecuador.com';
    // datos del correo

    $nombre = $_POST['nombre'];
    $empresa = $_POST['empresa'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $mensaje = $_POST['mensaje'];
    $asunto = 'Necesito contactarme con ustedes';

    // configuración del mensaje
    $header = "Mensaje enviado desde la web";
    $mensajeCompleto = "$mensaje</br>". "<br>Atentamente</br>". $nombre ."</br>$telefono". "<br>$email</br>";
    
    mail($destinatario, $asunto, $mensajeCompleto, $header);
    echo "<script>alert('Su correo se envió exitosamente')</script>";
    echo "<script> setTimeout(\"location.href='../globalcargo/globalcargo.php'\",1000)</script>";

    $errores = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        //echo "<pre>";
        //var_dump($_POST);
        //echo "</pre>";

        $n_orden = $_POST['n_orden'];
        $pagadoSiNo = $_POST['pagadoSiNo'];
        $banco = $_POST['banco'];
        $nComprobante = $_POST['nComprobante'];
        $autorizado = $_POST['autorizado'];
        //echo "<pre>";
        //var_dump($usuario);
        //echo "</pre>";

        // validar el formulario

        if(empty($errores)) {
            // insertar datos en la base
            $query = "INSERT INTO ordenes (n_orden, pagadoSiNo, banco, nComprobante, autorizado) 
                    VALUES ('$n_orden', '$pagadoSiNo', '$banco', '$nComprobante', '$autorizado')";

            echo $query;

            //$resultado = mysqli_query($db, $query);
                //echo "hasta aquí funciona";

                //if ($resultado) {
                    //header('location: ../superAdmin.php?resultado=1');
                //}
        }

    }
?>

<form action=" " class="form2" method="POST">
    <h2 class="form__titulo">COMPROBACIÓN DE PAGO</h2>
    <p class="form__p form2--p">
        Se confirma si la orden ha sido cancelada para proceder con el despacho
    </p>
    <?php foreach($errores as $error) : ?>
        <div class="alerta">
            <?php echo $error; ?>
        </div>
    <?php endforeach ?>
    
            <div class="container2">
                <div class="form__container form--2">
                    <div class="form__grupo">
                        <input type="text" name="n_orden" id="n_orden"class="form__input" placeholder=" " value="" >
                        <label for="n_orden" class="form__label">Número de Orden</label>
                        <span class="form__linea"></span>
                    </div>
                    <div class="form__grupo">
                            <select name="pagadoSiNo"  class="form__input">
                                <option value=" " >--- Selecciona una opción ---</option>
                                <option value="si" >PAGO CONFIRMADO</option>
                                <option value="no" >PAGO NO CONFIRMADO</option>
                                <option value="cancelado" >PEDIDO DECLINADO</option>
                            </select>
                    </div>
                    <div class="container2">
                <div class="form__container form--2">
                    <div class="form__grupo">
                        <input type="text" name="banco" id="banco"class="form__input" placeholder=" " value="" >
                        <label for="banco" class="form__label">Nombre del banco</label>
                        <span class="form__linea"></span>
                    </div>
                    <div class="container2">
                <div class="form__container form--2">
                    <div class="form__grupo">
                        <input type="text" name="nComprobante" id="nComprobante"class="form__input" placeholder=" " value="" >
                        <label for="nComprobante" class="form__label">Número de comprobante</label>
                        <span class="form__linea"></span>
                    </div>
                    <div class="container2">
                <div class="form__container form--2">
                    <div class="form__grupo">
                        <input type="text" name="autorizado" id="autorizado"class="form__input" placeholder=" " value="" >
                        <label for="autorizado" class="form__label">Autorizado</label>
                        <span class="form__linea"></span>
                    </div>
                </div>
    </fieldset>
            <div class="botones">
                <input type="submit" class="form__submit" value="GUARDAR">
            </div>
    
</form>