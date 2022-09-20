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

//informacion del distrito que se va anclar con el sub distrito
$consulta_distrito = "SELECT * FROM distrito WHERE id = '${id_distrito}';";
$resultado_distrito = mysqli_query($db, $consulta_distrito);
$distrito = mysqli_fetch_assoc($resultado_distrito);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $responsable = $_POST['responsable'];
    $observaciones = $_POST['observaciones'];
    $id = $id_distrito;
    $fecha_reg = date('Y-m-d');
    $fecha_actua = null;

    //guardar cantones relacionados al distrito
    $cantones_g = "INSERT INTO sub_distrito (nombre, responsable, observaciones, id_distrito, fecha_reg, fecha_actua) 
                                     values ('${nombre}', '${responsable}', '${observaciones}', '${id}', '${fecha_reg}', null);";
    $resultado = mysqli_query($db, $cantones_g);
    if ($resultado) {
        echo "<script>
                alert('Sub-Distrito creado correctamente ');
                window.location.href='sub_distritos.php?id=${id}';
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

<body>
    <div class="container primary">
        <div class="heading">
            <h1>Crear Sub-Distritos</h1>
            <p>
                Recuerda que, para crear un subdistrito debes de tener el distrito principal creado. Podras agregar solo los cantones que pertenezcan a este distrito.
            </p>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">DISTRITO PRINCIPAL</h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $distrito['nombre']; ?></h6>
                <p class="card-text">
                    Vas agregar un sub-distrito. Ten en cuanta que, es una direccion a la cual envaremos paquetes y/o productos, con responsabilidad de <strong>PERSONAL DE NOMINA</strong>
                </p>

                <p class="card-text">
                    Por favor revisa que tengas todo lo necesario para crearlo.
                    este tipo de cargos no lo puede llevar un <code>MOTO-COLABORADOR</code>
                </p>
                <div class="card-text">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>PROVINCIA CENTRAL</strong>
                            <?php echo $distrito['prov_central']; ?>
                        </li>
                        <li class="list-group-item">
                            <strong>RESPONSABLE DEL DISTRITO</strong>
                            <?php
                            $responsable = "SELECT * FROM usuario WHERE id = '${distrito['responsable']}';";
                            $resultado_responsable = mysqli_query($db, $responsable);
                            $responsable = mysqli_fetch_assoc($resultado_responsable);
                            echo $responsable['nombre'] . " " . $responsable['apellido'];
                            ?>
                        </li>
                    </ul>
                    <br>
                    <span>Cantones Relacionados</span>
                    <ul class="list-group">
                        <?php
                        $cantones = "SELECT * FROM cantones WHERE distrito = '${id_distrito}';";
                        $resultado_cantones = mysqli_query($db, $cantones);
                        while ($canton = mysqli_fetch_assoc($resultado_cantones)) :
                        ?>
                            <li class="list-group-item"><?php echo $canton['nombre_canton'] ?></li>
                        <?php endwhile ?>
                    </ul>
                </div>
                <br>
                <a href="crear_distrito.php" class="card-link">Crear un Distrito.</a>
                <!-- <a href="ver_distrito.php?id=<?php echo $id_distrito; ?>" class="card-link">Editar un Distrito.</a> -->
            </div>
        </div>
        <br>
        <form action="" method="post">
            <div class="input-group mb-3">
                <span class="input-group-text">Nombre del Sub-distrito</span>
                <input class="form-control" type="text" name="nombre" id="">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Responsable
                    <code> Los responsables solo pueden ser personal de nomina.</code> </span>
                <select name="responsable" class="form-select form-select-sm" aria-label="Default select example">
                    <option value='' selected> Selecciona un responsable</option>
                    <?php
                    //consulta de datos de la tabla usuario
                    $consulta0 = "SELECT * FROM usuario;";
                    $resultado4 = mysqli_query($db, $consulta0);
                    while ($row = mysqli_fetch_assoc($resultado4)) : ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre'] . " " . $row['apellido'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Observaciones o creiterios adicional.</span>
                <input class="form-control" type="text" name="observaciones" id="">
            </div>
            <button type="submit" class="btn btn-primary">Agregar Sub-Distrito</button>
        </form>
        <br>
        <div>
            <table class="table table-hover">
                <thead>
                    <tr class="table-primary">
                        <th>Nombre</th>
                        <th>Asignar Canton</th>
                        <th>Cantones Asignados</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //consulta de datos de la tabla usuario
                    $consulta = "SELECT * FROM sub_distrito WHERE id_distrito = '${id_distrito}';";
                    $resultado = mysqli_query($db, $consulta);
                    while ($row = mysqli_fetch_assoc($resultado)) : ?>
                        <tr>
                            <td><?php echo $row['nombre']; ?></td>
                            <td>
                                <form action="asignar_cantones.php" method="post">
                                    <div class="input-group mb-3">
                                        <input type="text" hidden name="id_subdistrito" value="<?php echo $row['id']; ?>" id="">
                                        <input type="text" hidden name="id_distrito" value="<?php echo $id_distrito; ?>" id="">
                                        <select class="form-select form-select-sm" name="canton" id="">
                                            <option value="" selected>Selecciona un canton</option>
                                            <?php
                                            $cantones = "SELECT * FROM cantones WHERE distrito = '${id_distrito}';";
                                            $resultado_cantones = mysqli_query($db, $cantones);
                                            while ($canton = mysqli_fetch_assoc($resultado_cantones)) :
                                            ?>
                                                <?php if (!$canton['sub_distrito']): ?>
                                                    <option value="<?php echo $canton['id']; ?>"><?php echo $canton['nombre_canton']; ?></option>
                                                <?php endif ?>
                                            <?php endwhile; ?>
                                        </select>
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">+</button>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <p>
                                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample<?php echo $row['id']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        Ver Cantones asignados
                                    </a>
                                </p>
                                <div class="collapse" id="collapseExample<?php echo $row['id']; ?>">
                                    <div class="card card-body">
                                    <?php
                                        $cons_cantones = $row['id']; 
                                        $cantones = "SELECT * FROM cantones WHERE sub_distrito = '${cons_cantones}';";
                                        $resultado_cantones = mysqli_query($db, $cantones);
                                        while ($canton = mysqli_fetch_assoc($resultado_cantones)) :
                                    ?>
                                        <p><?php echo $canton['nombre_canton'];
                                        ?></p>
                                    <?php endwhile?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="borrar_subdistrito.php?id=<?php echo $row['id']; ?>&id_distrito=<?php echo $id_distrito; ?>" class="btn btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>





    <?php
    incluirTemplate('fottersis');
    ?>