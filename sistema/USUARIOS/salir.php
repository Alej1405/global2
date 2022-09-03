<?php
require '../../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('location: ../global/index.php');
}
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
//guardar hora de salida
    //guardar la hora de salida en la base de datos
        date_default_timezone_set("America/Bogota");
        date_default_timezone_get();
        //$hora_salida =  date('G:i:s');
        //$fecha_ingreso = date('Y-m');
        $id = $_SESSION['id'];
        $nombre = $_SESSION['nombre'];
//verificar si existe una hora de ingreso.
$hora_ingreso = "SELECT * FROM registro_horarios WHERE id = ${id} and fecha = '${fecha_ingreso}';";
$ejecutar_hora_ingreso = mysqli_query($db, $hora_ingreso);
$hora_ingreso12 = mysqli_fetch_assoc($ejecutar_hora_ingreso);

 if (!$hora_ingreso12) {

    date_default_timezone_set("America/Bogota");
    date_default_timezone_get();
    $hora_salida =  date('G:i:s');
    $hora_ingreso =  "0:00:00";
    $fecha_ingreso = date('Y-m');
    //guardar la hora de ingreso en la base de datos
    $query_ingreso = "INSERT INTO registro_horarios (hora_ingreso, hora_almuerzo, hora_ingreso_almuerzo, hora_salida, usuario_id, fecha, nombre) 
                                    VALUES ('${hora_ingreso}', '0:00:00', '0:00:00', '${hora_salida}', '${id}', '${fecha_ingreso}', '${nombre}');";
                                    echo $query_ingreso;
    $resultado_ingreso = mysqli_query($db, $query_ingreso);
}else{
//guardar la hora de ingreso en la base de datos
     $query_ingreso = "UPDATE registro_horarios SET hora_salida = '${hora_salida}'
                                             WHERE usuario_id = '${id}' AND fecha = '${fecha_ingreso}';";
     $resultado_ingreso = mysqli_query($db, $query_ingreso);
 }

//cerrar sesion
session_start();
$_SESSION = [];
header ('location: /')
?>