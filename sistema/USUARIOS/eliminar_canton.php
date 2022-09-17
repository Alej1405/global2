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
$id = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    //guardar cantones relacionados al distrito
    $cantones_g = "DELETE FROM cantones WHERE id = '${id}';";
    $resultado = mysqli_query($db, $cantones_g);
    if ($resultado) {
        echo "<script>
                alert('Canton borrado correctamente ');
                window.location.href='crear_distrito.php';
              </script>";
    } else {
        echo "
                    <div class='alert alert-danger' role='alert'>
                        Error al borrar el canton
                    </div>
                ";
    }

}
?>