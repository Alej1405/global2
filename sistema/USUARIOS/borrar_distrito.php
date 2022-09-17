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

$borrar = "DELETE FROM distrito WHERE id = ${id_distrito};";
$resultado = mysqli_query($db, $borrar);
if ($resultado) {
    echo "<script>
            alert('Distrito borrado correctamente pues!!!');
            window.location.href='ver_distrito.php';
          </script>";
} else {
    echo "
                <div class='alert alert-danger' role='alert'>
                    <strong>Error!</strong> 
                    No se pudo borrar el buen distrito, vuelve a intentar pues!!!!.
                </div>";
    exit;
}

?>

