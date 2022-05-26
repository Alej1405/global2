<?php 
    $resultado = $_GET['resultado'] ?? null; 
      //incluye el header
      require '../../includes/funciones.php';
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
?>

<center><h1 class="titulo__pagina">CALLCENTER VERIFICACION DE DATOS</h1></center>
<div class="zonaScrip">
    <script>

        function consultaReal(){
            var datos = $.ajax({
                url: "callcenter/apiordenes2.php",
                dataType: "text",
                async: false
            }).responseText;
            
            var contenido = document.getElementById('contenido');
            contenido.innerHTML = datos;
        }
        setInterval(consultaReal,9000);
    </script>

</div>

<div id="contenido">

</div>