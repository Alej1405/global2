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
    $hora_salida =  date('G:i:s');
    $query_ingreso = "UPDATE registro_horarios SET hora_almuerzo = '${hora_salida}'
                                            WHERE usuario_id = '${id}' AND fecha = '${fecha_ingreso}';";
    $resultado_ingreso = mysqli_query($db, $query_ingreso);
    //veridicar si el usuario marco correctamente el ingreso.
    if ($resultado_ingreso) {
        $almuerzo = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GLOBAL CARGO SYS</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css2/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary m-0 vh-100 row justify-content-center align-items-center">
        <div class = "col-auto p-5 text-center">
            <?php if ($almuerzo):?>
                <div class="alert alert-primary ">
                    BUEN PROVECHO JOVEN, ALIMENTECE BIEN Y NOS VEMOS EN UNA HORA.
                    PARA REGISTRAR TU ENTRADA DALE CLICK AHI 
                    <br>
                    <a href="entrada_almuerzo.php?id=<?php echo $id ?>" class="btn btn-primary">ENTRADA ALMUEZO</a>
                </div>
            <?php endif ?>
        </div>

</body>
</html>
