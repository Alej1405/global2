<?php 
    $destinatario = 'johanna@globalcargoecuador.com';
    // datos del correo

    $nombre = $_POST['nombre'];
    $empresa = $_POST['empresa'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $mensaje = $_POST['mensaje'];
    $asunto = 'Necesito contactarme con ustesdes';

    // configuración del mensaje
    $header = "Mensaje enviado desde la web";
    $mensajeCompleto = "$mensaje</br>". "<br>Atentamente</br>". $nombre ."</br>$telefono". "<br>$email</br>";
    
    mail($destinatario, $asunto, $mensajeCompleto, $header);
    echo "<script>alert('Su correo se envió exitosamente')</script>";
    echo "<script> setTimeout(\"location.href='../globalcargo/globalcargo.php'\",1000)</script>";
?>