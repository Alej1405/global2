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

//consulta datos de colaborador
$consulta = "SELECT * FROM colaborador;";
$resultado = mysqli_query($db4, $consulta);

// variables del sistema 
$errores = [];
$id ="";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = mysqli_real_escape_string($db4, $_POST['id']);

    $borrar = "DELETE FROM colaborador WHERE id = $id";
    $resultado = mysqli_query($db4, $borrar);
    if ($resultado) {
        echo "<script>
                guardar();
                window.location.href='consul_colab.php';
              </script>";
    } else {
        echo "
            <div class='alert alert-danger' role='alert'>
                <strong>Error!</strong> 
                No se pudo borrar a esa buena persona.
            </div>";
        exit;
    }
}


?>

<body>
    <div class="container primary">
        <div class="heading">
            <h1>Datos Generales de Motorizados y Moto-colaborador</h1>
        </div>
        <fieldset>
            <?php foreach ($errores as $error) : ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endforeach ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Cedula de Identidad</th>
                        <th>Distrito</th>
                        <th>Telefono 1</th>
                        <th>Telefono 2</th>
                        <th>Direccion</th>
                        <th>Observacion</th>
                        <th>Estado</th>
                        <th>Fecha de registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($resultado_colaborador = mysqli_fetch_assoc($resultado)) : ?>
                        <tr>
                            <td>
                                <?php echo $resultado_colaborador['id']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['nombre'] . " " . $resultado_colaborador['apellido']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['numero_ci']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['distrito']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['celular']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['celular_2']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['direccion']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['observacion']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['estado']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['fecha']; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-primary" href="act_colab.php?id=<?php echo $resultado_colaborador['id']; ?>">ACTUALIZAR</a>
                                    <form action="" method="POST">
                                        <div class="btn-group " role="group" aria-label="Button group with nested dropdown">
                                            <input type="text" hidden name="id" value="<?php echo $resultado_colaborador['id']; ?>"></input>
                                            <button type="submit" class="btn btn-danger">ELIMINAR</button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </fieldset>
    </div>

    <?php
    incluirTemplate('fottersis');
    ?>