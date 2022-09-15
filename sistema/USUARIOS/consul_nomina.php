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
$consulta = "SELECT * FROM usuario;";
$resultado = mysqli_query($db, $consulta);

// variables del sistema 
$errores = [];

?>

<body>
    <div class="container">
        <div class="heading">
            <h1>Consulta General de Personal Activo en la Empresa</h1>
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
                        <th>Nombre</th>
                        <th>Cedula de Identidad</th>
                        <th>Telefono 1</th>
                        <th>Correo Asigando</th>
                        <th>Cargo</th>
                        <th>Provincia</th>
                        <th>Sueldo Base</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($resultado_colaborador = mysqli_fetch_assoc($resultado)) : ?>
                        <tr>
                            <td>
                                <?php echo $resultado_colaborador['nombre'] . " " . $resultado_colaborador['apellido']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['cedula']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['telefono1']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['correo1']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['tipo']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['provincia']; ?>
                            </td>
                            <td>
                                <?php echo $resultado_colaborador['sueldo_base']; ?>
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