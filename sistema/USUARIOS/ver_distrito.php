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

if (!$id_distrito) {
    //consultar informacion del distrito
    $consultar_distrito = "SELECT * FROM distrito;";
    $resultado_distrito = mysqli_query($db, $consultar_distrito);
} else {
    //consultar informacion del distrito
    $consultar_distrito = "SELECT * FROM distrito WHERE id = ${id_distrito};";
    $resultado_distrito = mysqli_query($db, $consultar_distrito);
}




?>

<body>
    <div class="container primary">
        <div class="heading">
            <h1>Ver informacion de Distritos</h1>
        </div>
        <?php while ($distrito = mysqli_fetch_assoc($resultado_distrito)) : ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nombre del distrito: <?php echo $distrito['nombre']; ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Punto central: <?php echo $distrito['prov_central']; ?></h6>
                    <p class="card-text">Fecha de creacion: <?php echo $distrito['fecha']; ?></p>
                    <p class="card-text">Responsable: <?php
                                                        $nombre = $distrito['responsable'];
                                                        $consultar_responsable = "SELECT * FROM usuario WHERE id = '${nombre}';";
                                                        $resultado_responsable = mysqli_query($db, $consultar_responsable);
                                                        $responsable = mysqli_fetch_assoc($resultado_responsable);
                                                        echo $responsable['nombre'] . " " . $responsable['apellido'];
                                                        ?>
                    </p>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    CANTONES RELACIONADOS CON EL DISTRITO.
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <br>
                                <table class="table table-hover">
                                    <?php
                                    $consultar_cantones = "SELECT * FROM cantones WHERE distrito = ${id_distrito};";
                                    $resultado_cantones = mysqli_query($db, $consultar_cantones);
                                    ?>
                                    <thead>
                                        <tr class="table-success">
                                            <th>Canton</th>
                                            <th>Fecha de registro</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($cantones = mysqli_fetch_assoc($resultado_cantones)) : ?>
                                            <tr>
                                                <td><?php echo $cantones['nombre_canton']; ?></td>
                                                <td><?php echo $cantones['fecha_reg']; ?></td>
                                                <td>
                                                    <form action="eliminar_canton.php" method="post">
                                                        <div class="btn-group btn-group-sm">
                                                            <input type="submit" value="Eliminar" class="btn btn-outline-secondary"></input>
                                                        </div>
                                                        <input type="text" value="<?php echo $cantones['id']; ?>" hidden name="id" id="">
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endwhile ?>
                                    </tbody>
                                </table>
                                <div class="accordion-body">La informacion de los distritos corta la asignacion de ordenes
                                    <code>Revisar y actualizar</code> Mantener actualizada es principal.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                    PERSONAL DEL DISTRITO
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <?php
                                $personal_distrito = "SELECT * FROM colaborador WHERE distrito = '${id_distrito}';";
                                $resultado_personal_distrito = mysqli_query($db4, $personal_distrito);

                                ?>
                                <br>
                                <?php while ($personal_dis = mysqli_fetch_assoc($resultado_personal_distrito)) : ?>
                                    <ul class="list-group">
                                        <li class="list-group-item"> <strong>Nombre:</strong> <?php echo $personal_dis['nombre']; ?></li>
                                        <li class="list-group-item"> <strong>Celular:</strong> <?php echo $personal_dis['celular']; ?></li>
                                    </ul>
                                    <br>
                                <?php endwhile ?>
                                <br>
                                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                            </div>
                        </div>
                    </div>
                    <a href="editar_distrito.php?id=<?php echo $distrito['id']; ?>" class="btn btn-primary">Editar</a>
                    <a href="borrar_distrito.php?id=<?php echo $distrito['id']; ?>" class="btn btn-danger">Eliminar</a>
                    <!-- Lanzar modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Agregar Cantones.
                    </button>
                </div>
            </div>
        <?php endwhile ?>
        <br>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="agregar_cantones.php" method="post">
                        <div class="input-group mb-3">
                            <input type="text" hidden name="id" value="<?php echo $id_distrito; ?>" id="">
                            <input type="text" hidden name="responsable" value="<?php echo $cantones_res; ?>" id="">
                            <input type="text" name="nombre" class="form-control" placeholder="Nombre del Canton" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">+</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Terminar</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    incluirTemplate('fottersis');
    ?>