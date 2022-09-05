<?php
$id = $_GET['id'] ?? null;

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

//variable del sistema
$fecha_ingreso = date('Y-m-d');

//conuslta si el usuario marco correctamente el ingreso.
$consulta = "SELECT * FROM registro_horarios WHERE usuario_id = ${id} and fecha = '${fecha_ingreso}';";
$ejecutar_consulta = mysqli_query($db, $consulta);
$consulta12 = mysqli_fetch_assoc($ejecutar_consulta);
$hora_entreada = $consulta12['hora_ingreso'];

//condicional para saber si el usuario marco correctamente el ingreso.
if(!$hora_entreada){
    echo "<script>
    alert('No se puede marcar la salida, comunicate con RRHH. Seguramente llegaste tarde o no registraste tu hora de inicio');
    window.location.href='usuarios.php';
    </script>";
    exit;
}else{
    //actualizar la hora de salida al almuerzo
    date_default_timezone_set("America/Bogota");
    date_default_timezone_get();
    $hora_ingreso =  date('G:i:s');
    $query_ingreso = "UPDATE registro_horarios SET hora_ingreso_almuerzo = '${hora_ingreso}'
                                            WHERE usuario_id = '${id}' AND fecha = '${fecha_ingreso}';";
    $resultado_ingreso = mysqli_query($db, $query_ingreso);
    //veridicar si el usuario marco correctamente el ingreso.
    if ($resultado_ingreso) {
        echo
        "<script>
            alert('Muy bien, creo que si regresaste a tiempo');
            window.location.href='usuarios.php';
        </script>";
    }
}
?>