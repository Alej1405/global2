<?php
$id_subdistrito = $_GET['id'] ?? null;
$id_distrito = $_GET['id_distrito'] ?? null;

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
//borrar subdistrito del canton al que se relaciono.
$actualizar_cantones = "UPDATE cantones SET sub_distrito = null WHERE sub_distrito = '${id_subdistrito}';";
$resultado = mysqli_query($db, $actualizar_cantones);


$borrar = "DELETE FROM sub_distrito WHERE id = '${id_subdistrito}';";
$resultado = mysqli_query($db, $borrar);
if ($resultado) {
    echo "<script>
            alert('Sub-Distrito borrado correctamente pues!!!');
            window.location.href='sub_distritos.php?id=${id_distrito}';
          </script>";
} else {
    echo "
                <div class='alert alert-danger' role='alert'>
                    <strong>Error!</strong> 
                    No se pudo borrar el buen Sus-distrito, vuelve a intentar pues!!!!.
                </div>";
    exit;
}

?>

