<?php
function pruebaBD(): mysqli{
    $db = mysqli_connect('localhost', 'root', ' ', 'gcargo_admin');

    if (!$db) {
        echo "tenemos un error";
        exit;
    }
    return $db;
}


//base de datos bodega
function conectarDB2() : mysqli{
    $db2 = mysqli_connect('localhost', 'root', ' ', 'gcargo_bodegatrade');

    if ($db2) {
    
    } else{
        echo "Erroe no se puede contectar con la base de datos";
        exit;
    }
    return $db2;
}

//base api Rusia
function conectarDB3() : mysqli{
    $db3 = mysqli_connect('localhost', 'root', ' ', 'gcargo_admin');

    if ($db3) {
    
    } else{
        echo "Erroe no se puede contectar con la base de datos";
        exit;
    }
    return $db3;
}

//base de datos callcenter
function conectarDB4() : mysqli{
    $db4 = mysqli_connect('127.0.0.1', 'root', ' ', 'gcargo_callcenter');

    if ($db4) {
    
    } else{
        echo "Erroe no se puede contectar con la base de datos";
        exit;
    }
    return $db4;
}

//pablo1405 añadir la clave si se trabaja en la macbook∫