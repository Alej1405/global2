<?php 
    $resultado = $_GET['resultado'] ?? null; 
    //incluye el header
    require '../includes/funciones.php';
    incluirTemplate('headersis');
?>


    
    <script>

        function consultaReal(){
            var datos = $.ajax({
                url: "callcenter/apiordenes1.php",
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