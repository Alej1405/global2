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
$horas_extra = ""; //desde el formulario 
$comisiones = ""; //desde el formulario
$bono_alimentacion = ""; //desde el formulario
$errores = [];

//consulata de datos

$query2 = "SELECT * FROM usuario;";
$resultado2 = mysqli_query($db, $query2);

//-----------------inicio de proceso-----------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = mysqli_real_escape_string($db, $_POST['usuario']);
    $horas_extra = mysqli_real_escape_string($db, $_POST['horas_extra']);
    $comisiones = mysqli_real_escape_string($db, $_POST['comisiones']);
    $bono_alimentacion = mysqli_real_escape_string($db, $_POST['bono_alimentacion']);
    $anticipos = mysqli_real_escape_string($db, $_POST['anticipos']);
    $responsable_reg = $_SESSION['usuario'];
    $fecha_reg = date('Y-m-d');
    //validacion de datos
    if (!$horas_extra) {
        $errores[] = "Las horas extra son obligatorias, no puede estar vacio!!!! Si no hay pon cero 0";
    }
    if (!$comisiones) {
        $errores[] = "Las comisiones son obligatorias, no puede estar vacio!!!! Si no hay pon cero 0";
    }
    if (!$bono_alimentacion) {
        $errores[] = "El bono de alimentacion es obligatorio, no puede estar vacio!!!! Si no hay pon cero asi 0";
    }
    if (empty($errores)) {
        //actualizar base de datos
        $query = "INSERT INTO ingresos_extras (horas_extra, comisiones, bono_alimentacion, usuario, anticipos, responsable_reg, fecha_reg) 
                values ('${horas_extra}', '${comisiones}', '${bono_alimentacion}', '${usuario}', '${anticipos}', '${responsable_reg}', '${fecha_reg}');";
        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            echo "<script>
                    alert('Ingresos extras actualizados correctamente');
                    window.location.href='usuarios.php';
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
                <h1 class="text-center">REGISTRAR COMISIONES O ANTICIPOS</h1>
                <?php foreach ($errores as $error) : ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

        <form action="" method="post">
            <select class="form-select form-select-sm" name="usuario" aria-label=".form-select-sm example">
                <option selected>Selecciona un Usuario</option>
                <?php while ($datos_ingresos = mysqli_fetch_assoc($resultado2)) : ?>
                    <option value="<?php echo $datos_ingresos['id'];?>"><?php echo $datos_ingresos['nombre']." ".$datos_ingresos['apellido'];?></option>
                <?php endwhile; ?>
            </select>
            <br>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">HORAS EXTRA</label>
                <input type="text" name="horas_extra" class="form-control" value="0.00" placeholder="HORAS EXTRA">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">COMISIONES</label>
                <input type="text" name="comisiones" class="form-control" value="0.00" placeholder="COMISIONES">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">BONO DE ALIMENTACION</label>
                <input type="text" name="bono_alimentacion" class="form-control" value="0.00" placeholder="BONO DE ALIMENTACION">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">ANTICIPOS</label>
                <input type="text" hidden name="anticipos" class="form-control" value="0.00" placeholder="ANTICPOS">
            </div>
            <input type="submit" class="btn btn-primary" value="AGREGAR">
        </form>
    </div>
    <?php
    incluirTemplate('fottersis');
    ?>