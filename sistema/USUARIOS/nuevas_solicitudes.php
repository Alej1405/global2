<?php

//incluye el header
require '../../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('location: ../global/index.php');
}

require '../../includes/config/database.php';
incluirTemplate('headersis2');

//coneccion BDD Global Cargo
conectarDB();
$db = conectarDB();

//coneccion BDD Bodega Trade
conectarDB2();
$db2 = conectarDB2();

//coneccion BDD Api Rusia
conectarDB3();
$db3 = conectarDB3();

//coneccion BDD Api Rusia
conectarDB4();
$db4 = conectarDB4();

?>

<body class="bg-gradient-primary">
    <div class="container">
        <h1>SEGUIMIENTO GENERAL DE PAQUETES</h1>
        <p>En este listado solo se encuentran los paquetes que estan en proceso de entrega.</p>
        <div id='gc-go'>
            <!-- coneccion de datos en tiempo real nuevos GC-GO pedidos. -->
            <script>
                function consultaReal() {
                    var datos = $.ajax({
                        url: "ver_paquetesgc.php",
                        dataType: "text",
                        async: false
                    }).responseText;

                    var contenido = document.getElementById('gc-go');
                    contenido.innerHTML = datos;
                }
                setInterval(consultaReal, 9000);
            </script>
        </div>
        <?php 
            //consultar si hay o no ordenes nuevas
            
        ?>
        <div id='rusia'>
            <!-- coneccion de datos en tiempo real nuevos API pedidos. -->
            <script>
                function consultaReal2() {
                    var datos = $.ajax({
                        url: "ver_cosmetics.php",
                        dataType: "text",
                        async: false
                    }).responseText;

                    var contenido = document.getElementById('rusia');
                    contenido.innerHTML = datos;
                }
                setInterval(consultaReal2, 10000);
            </script>
        </div>
    </div>
    <?php
    incluirTemplate('fottersis');
    ?>