<?php

//base de datos globalCargo
function conectarDB() : mysqli{
    $db = mysqli_connect('localhost', 'root', 'pablo1405', 'gcargo_globalcargo');

    if ($db) {
    
    } else{
        echo "Erroe no se puede contectar con la base de datos";
        exit;
    }
    return $db;
}
//base de datos bodega
function conectarDB2() : mysqli{
    $db2 = mysqli_connect('localhost', 'root', 'pablo1405', 'gcargo_bodegatrade');

    if ($db2) {
    
    } else{
        echo "Erroe no se puede contectar con la base de datos";
        exit;
    }
    return $db2;
}
//base api Rusia
function conectarDB3() : mysqli{
    $db3 = mysqli_connect('localhost', 'root', 'pablo1405', 'gcargo_admin');

    if ($db3) {
    
    } else{
        echo "Erroe no se puede contectar con la base de datos";
        exit;
    }
    return $db3;
}
//base de datos callcenter
function conectarDB4() : mysqli{
    $db4 = mysqli_connect('127.0.0.1', 'root', 'pablo1405', 'gcargo_callcenter');

    if ($db4) {
    
    } else{
        echo "Erroe no se puede contectar con la base de datos";
        exit;
    }
    return $db4;
}

//base de datos callcenter
function conectarDB5() : mysqli{
    $db5 = mysqli_connect('127.0.0.1', 'root', 'pablo1405', 'comercial');

    if ($db5) {
    
    } else{
        echo "Erroe no se puede contectar con la base de datos";
        exit;
    }
    return $db5;
}
//anñadir la clave al cambiar de computador pablo1405sss∫∫s