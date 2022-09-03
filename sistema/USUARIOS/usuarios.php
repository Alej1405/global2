<?php 

    $guardar = $_GET['guardar'] ?? null;

    //incluye el header
    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if (!$auth) {
        header('location: index.php');
    }

    require '../../includes/config/database.php';
    incluirTemplate('headersis2');
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


    echo $time_pre = microtime(true);
    echo ("This line will be executed.\n")."<br>";
    echo $time_post = microtime(true);
    $exec_time = $time_post - $time_pre;
    echo ("The execution time is:\n");
    echo ($exec_time);

    ?>

    <h1>hola</h1>

    <?php 
     incluirTemplate('fottersis');
    ?>