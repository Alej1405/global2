<?php
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

//variables de la pagina
$id = ""; //desde el formulario 
$sueldo_base = ""; //desde el formulario
$errores = []; 

//consulata de datos

$query2 = "SELECT * FROM usuario;";
$resultado2 = mysqli_query($db, $query2);



//-----------------inicio de proceso-----------------
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $sueldo_base = $_POST['sueldo_base'];
        //validacion de datos
        if(!$sueldo_base) {
            $errores[] = "El sueldo es obligatorio, no puede estar vacio!!!! no se puede asi";
        }
    if (empty($errores)) {
        //actualizar base de datos
        $query = "UPDATE usuario SET sueldo_base = '${sueldo_base}' WHERE id = '${id}';";
        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            echo "<script>
                    alert('Sueldo actualizado correctamente');
                    location.reload();
                  </script>";
        } else {
            echo "
                <div class='alert alert-danger' role='alert'>
                    <strong>Error!</strong> 
                    No se pudo actualizar los datos.
                </div>";
                exit;
        }
    }
}

?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Editar o Registrar Sueldos</h1>
                    <?php foreach ($errores as $error) : ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach ?>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="table-primary">Nombre</th>
                    <th class="table-primary">Cargo</th>
                    <th class="table-primary">Sueldo base</th>
                    <th class="table-primary">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($datos_ingresos=mysqli_fetch_assoc($resultado2)):?>
                <tr>
                    <td>
                        <?php echo $datos_ingresos['nombre'].$datos_ingresos['apellido']; ?>
                    </td>
                    <td>
                        <?php echo $datos_ingresos['tipo']; ?>
                    </td>
                    <form action="" method="post">
                        <td>
                            <input type="text" name="sueldo_base" class="form-control" value = "<?php echo $datos_ingresos['sueldo_base']?>" placeholder="Sueldo base">
                        </td>
                        <td>
                            <input type="hidden" name="id" class="form-control" value = "<?php echo $datos_ingresos['id']?>" placeholder="Sueldo base">
                            <input type="submit" class="btn btn-primary" value="EDITAR AGREGAR">
                        </td>
                    </form>
                </tr>
                <?php endwhile;?>
            </tbody>
        </table>
    </div>