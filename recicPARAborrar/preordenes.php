<?php 
    $resultado = $_GET['resultado'] ?? null; 
    //incluye el header
    require '../includes/funciones.php';
    incluirTemplate('headersis');
?>

<center><h1 class="titulo__pagina">LISTADO DE PREORDENES PARA DESPACHO</h1></center>
<div class="zonaScrip">
    <script>

        function consultaReal(){
            var datos = $.ajax({
                url: "bodega/preorden.php",
                dataType: "text",
                async: false
            }).responseText;
            
            var contenido = document.getElementById('contenido');
            contenido.innerHTML = datos;
        }
        setInterval(consultaReal,6000);
    </script>

</div>

<div id="contenido">

</div>