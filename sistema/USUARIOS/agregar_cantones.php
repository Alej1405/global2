<?php
$id_distrito = $_GET['id'] ?? null;

//incluye el header
require '../../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('location: ../index.php');
}

require '../../includes/config/database.php';
incluirTemplate('headersis2');
conectarDB();
$db = conectarDB();

//BASE DE DATOS BODEGA 
conectarDB2();
$db2 = conectarDB2();

//coneccion api
conectarDB3();
$db3 = conectarDB3();

//coneccion callcenter
conectarDB4();
$db4 = conectarDB4();

//variables del sistema

$nombre = '';
$resp_id = '';
$sub_distrito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $fecha = date('Y-m-d');
    $responsable = $_POST['responsable'];
    $sub_distrito = null;

    //guardar cantones relacionados al distrito
    $cantones_g = "INSERT INTO cantones (nombre_canton, fecha_reg, distrito, resp_id, sub_distrito) values ('${nombre}', '${fecha}', '${id}', '${resp_id}', null);";
    $resultado = mysqli_query($db, $cantones_g);
    if ($resultado) {
        echo "<script>
                alert('Canton creado correctamente ');
                window.location.href='crear_distrito.php';
              </script>";
    } else {
        echo "
                    <div class='alert alert-danger' role='alert'>
                        Error al crear el canton
                    </div>
                ";
    }

}
?>