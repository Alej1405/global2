<?php 
    $resultado = $_GET['resultado'] ?? null; 
    //incluye el header
    require '../includes/funciones.php';
    incluirTemplate('headersis');
?>

<center><h2 class="form__titulo">HOJAS DE RUTA</h2></center>
<div class="zonaScrip">
    <script>

        function consultaReal(){
            var datos = $.ajax({
                url: "gcmensajeria/hojaruta.php",
                dataType: "text",
                async: false
            }).responseText;
            
            var contenido = document.getElementById('contenido');
            contenido.innerHTML = datos;
        }
        setInterval(consultaReal,1000);
    </script>

</div>

<div id="contenido">

</div>