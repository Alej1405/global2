<?php
//$id_subdistrito = $_GET['id'] ?? null;

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

$sub_distrito = '';
$canton = '';
$id_distrito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_subdistrito = $_POST['id_subdistrito'];
    $id = $_POST['canton'];
    $fecha_actua = date('Y-m-d');
    $id_distrito = $_POST['id_distrito'];
    //guardar cantones relacionados al distrito
    $cantones_g = "UPDATE cantones SET sub_distrito = '${id_subdistrito}',
                                        fecha_actua = '${fecha_actua}'
                                           WHERE id = '${id}';";
    $resultado = mysqli_query($db, $cantones_g);
    if ($resultado) {
        echo "<script>
                alert('Canton creado correctamente ');
                window.location.href='sub_distritos.php?id=${id_distrito}';
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