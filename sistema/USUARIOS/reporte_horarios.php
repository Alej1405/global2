<?php

//incluye el header
require '../../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('location: ../global/index.php');
}

require '../../includes/config/database.php';
incluirTemplate('headersis2');

//coneccion BDD Global Cargo
conectarDB();
$db = conectarDB();

//coneccion BDD Bodega Trade
conectarDB2();
$db2 = conectarDB2();

//coneccion BDD Api Rusia
conectarDB3();
$db3 = conectarDB3();

//coneccion BDD Api Rusia
conectarDB4();
$db4 = conectarDB4();

//consultar ingreso y salida de forma general
$fecha_consulta = date('Y-m-d');
$consulta = "SELECT * FROM registro_horarios WHERE fecha = '${fecha_consulta}';";
$resultado = mysqli_query($db, $consulta);


//conusulat de horario por personal con datos del formulario
$horarios_p = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($db, $_POST['id']);
    $consulta2 = "SELECT * FROM registro_horarios WHERE usuario_id = '${id}';";
    $resultado2 = mysqli_query($db, $consulta2);
    $horarios_personal = mysqli_fetch_assoc($resultado2);
    $horarios_p = $horarios_personal['id'];
}

// var_dump($resultado2);
// exit;
?>

<body>
    <div class="container">
        <div class="heading">
            <h1>Control de ingreso y salida general</h1>
        </div>
        <form action="" method="post">
            <h5 class="card-title">CONSULTAR POR PERSONA</h5>
            <p class="card-text text-muted fs-6 fst-italic">Por favor selecciona una persona para poder consultar.</p>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">CARGO ASIGNADO</span>
                <select name="id" class="form-select form-select-sm" aria-label="Default select example">
                    <option value='' selected> Selecciona un estado</option>
                    <?php
                    //consulta de datos de la tabla usuario
                    $consulta0 = "SELECT * FROM usuario;";
                    $resultado4 = mysqli_query($db, $consulta0);
                    while ($row = mysqli_fetch_assoc($resultado4)) : ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre'] . " " . $row['apellido'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">CONSULTAR HORARIO</button>
        </form>
        <!-- tabla del resultado de la consulta por persona -->
        <?php if ($horarios_p) : ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Hora de ingreso</th>
                        <th>Salida almuerzo</th>
                        <th>Ingreso Almuerzo</th>
                        <th>Hora de salida</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($horarios_personal = mysqli_fetch_assoc($resultado2)) : ?>
                        <tr>
                            <td><?php echo $horarios_personal['nombre']; ?></td>
                            <td><?php echo $horarios_personal['hora_ingreso']; ?></td>
                            <td><?php echo $horarios_personal['hora_almuerzo']; ?></td>
                            <td><?php echo $horarios_personal['hora_ingreso_almuerzo']; ?></td>
                            <td><?php echo $horarios_personal['hora_salida']; ?></td>
                            <td><?php echo $horarios_personal['fecha']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <!-- tabla que muesra los horarios de la fecha -->
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Hora de ingreso</th>
                        <th>Salida almuerzo</th>
                        <th>Ingreso Almuerzo</th>
                        <th>Hora de salida</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($hora_general = mysqli_fetch_assoc($resultado)) : ?>
                        <tr>
                            <td><?php echo $hora_general['nombre']; ?></td>
                            <td><?php echo $hora_general['hora_ingreso']; ?></td>
                            <td><?php echo $hora_general['hora_almuerzo']; ?></td>
                            <td><?php echo $hora_general['hora_ingreso_almuerzo']; ?></td>
                            <td><?php echo $hora_general['hora_salida']; ?></td>
                            <td><?php echo $hora_general['fecha']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif ?>
    </div>
    <?php
    incluirTemplate('fottersis');
    ?>