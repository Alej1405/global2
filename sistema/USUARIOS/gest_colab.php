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


//declaracion de errores
$errores = [];
$estado = '';
$id = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //variable capturada des de el formulario
    $id = mysqli_real_escape_string($db4, $_POST['id']);
    $estado = mysqli_real_escape_string($db4, $_POST['estado']);

    //validacion de campos
    if (!$estado) {
        $errores[] = "Si vas a cambiar el estado, asegurate de seleccionar uno";
    }
    //validacion de errores
    if (empty($errores)) {
        //actualizar datos en la base de datos
        $query = "UPDATE colaborador SET estado = '${estado}' WHERE id = '${id}';";
        $resultado = mysqli_query($db4, $query);
        if ($resultado) {
            echo "<script>
                    alert('Estado actualizado correctamente');
                    window.location.href='gest_colab.php';
                  </script>";
        }
    }
}


?>

<body>
    <div class="container primary">
        <div class="heading">
            <h1>Gestion Realizada por Motorizado y Moto-colaborador</h1>
        </div>
        <br>
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
                        <th>Distrito</th>
                        <th>Guias Recibidas</th>
                        <th>Guias Entregados</th>
                        <th>Guias Proceso</th>
                        <th>Guias Pendientes</th>
                        <th>Estado</th>
                        <th>Cambiar Estado</th>
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
                                <?php echo $resultado_colaborador['distrito']; ?>
                            </td>
                            <td>
                                <?php
                                //conuslta guias recibidas asignadas en general
                                $consulta_guias_recibidas = "SELECT COUNT(*) AS total FROM ordenes WHERE transporte = " . $resultado_colaborador['id'] . ";";
                                $resultado_guias_recibidas = mysqli_query($db4, $consulta_guias_recibidas);
                                $resultado_guias_recibidas = mysqli_fetch_assoc($resultado_guias_recibidas);
                                echo $resultado_guias_recibidas['total'];
                                ?>
                            </td>
                            <td>
                                <?php
                                //consulta guias entregadas
                                $consulta_guias_entreg1 = "SELECT COUNT(*) AS total FROM ordenes WHERE transporte = " . $resultado_colaborador['id'] . " AND estado = 'facturado';";
                                $resultado_guias_entreg = mysqli_query($db4, $consulta_guias_entreg1);
                                $resultado_guias_entregadas = mysqli_fetch_assoc($resultado_guias_entreg);
                                $facturadas = $resultado_guias_entregadas['total'];

                                $consulta_guias_entreg_de = "SELECT COUNT(*) AS total FROM ordenes WHERE transporte = " . $resultado_colaborador['id'] . " AND estado = 'delivered';";
                                $resultado_guias_entreg_1 = mysqli_query($db4, $consulta_guias_entreg_de);
                                $resultado_guias_delivered = mysqli_fetch_assoc($resultado_guias_entreg_1);
                                $delivered = $resultado_guias_delivered['total'];

                                echo $facturadas + $delivered;

                                ?>
                            </td>
                            <td>
                                <?php
                                //consulta guias en proceso
                                $consulta_guias_entreg1 = "SELECT COUNT(*) AS total FROM ordenes WHERE transporte = " . $resultado_colaborador['id'] . " AND estado = 'recolectar';";
                                $resultado_guias_entreg = mysqli_query($db4, $consulta_guias_entreg1);
                                $resultado_guias_entregadas = mysqli_fetch_assoc($resultado_guias_entreg);
                                $facturadas = $resultado_guias_entregadas['total'];

                                $consulta_guias_entreg_de = "SELECT COUNT(*) AS total FROM ordenes WHERE transporte = " . $resultado_colaborador['id'] . " AND estado = 'ingreso';";
                                $resultado_guias_entreg_1 = mysqli_query($db4, $consulta_guias_entreg_de);
                                $resultado_guias_delivered = mysqli_fetch_assoc($resultado_guias_entreg_1);
                                $delivered = $resultado_guias_delivered['total'];

                                echo $facturadas + $delivered;
                                ?>
                            </td>
                            <td>
                                <?php
                                $consulta_guias_entreg1 = "SELECT COUNT(id) AS total FROM ordenes WHERE transporte = " . $resultado_colaborador['id'] . " AND estado = 'undelivered';";
                                $resultado_guias_entreg = mysqli_query($db4, $consulta_guias_entreg1);
                                $resultado_guias_entregadas = mysqli_fetch_assoc($resultado_guias_entreg);
                                echo $facturadas = $resultado_guias_entregadas['total'];
                                ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['estado']; ?>
                            </td>
                            <td>
                                <form action="" method="POST">
                                    <div class="btn-group " role="group" aria-label="Button group with nested dropdown">
                                        <select name="estado" class="form-select form-select-sm" aria-label="Default select example">
                                            <option value='' selected> Selecciona un estado</option>
                                            <option value="ACTIVO">REACTIVAR</option>
                                            <option value="SUSPENDIDO">SUSPENDER</option>
                                            <option value="OBSERVACION">PROCESO AJUSTE</option>
                                        </select>
                                        <input type="text" hidden name="id" value= "<?php echo $resultado_colaborador['id'];?>"></input>
                                        <button type="submit" class="btn btn-primary">GUARDAR</button>
                                    </div>
                                </form>
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