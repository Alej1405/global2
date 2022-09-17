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

//declaracion de variables del sistema
$errores = [];
$nombre = '';
$prov_central = '';
$fecha = '';
$responsable = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //variable capturada des de el formulario
    $nombre = mysqli_real_escape_string($db4, $_POST['nombre']);
    $prov_central = mysqli_real_escape_string($db4, $_POST['prov_central']);
    $fecha = date('Y-m-d');
    $responsable = mysqli_real_escape_string($db4, $_POST['responsable']);
    if (!$nombre) {
        $errores[] = "Es necesario el nombre para el distrito, complete todo pues!!!!";
    }
    if (!$prov_central) {
        $errores[] = "Donde va a ser el punto central del distrito? mire bien pues!!!!";
    }
    if (!$responsable) {
        $errores[] = "A quien pedidos resultados pues!!! ponga el nombre del responsable";
    }
    if (empty($errores)) {
        //insertar datos en la base de datos
        $query = "INSERT INTO distrito (nombre, prov_central, fecha, responsable) VALUES ('${nombre}', '${prov_central}', '${fecha}', '${responsable}');";
        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            echo "<script>
                    alert('Distrito creado correctamente');
                    window.location.href='crear_distrito.php';
                  </script>";
        } else {
            echo "
                        <div class='alert alert-danger' role='alert'>
                            <strong>Error!</strong> 
                            No se pudo crear el buen distrito, vuelve a intentar pues!!!!.
                        </div>";
            exit;
        }
    }
}

?>

<body>
    <div class="container primary">
        <div class="heading">
            <h1>Crear Distritos</h1>
        </div>
        <form action="" method="post">
            <?php foreach ($errores as $error) : ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endforeach ?>
            <div class="input-group mb-3">
                <span class="input-group-text">DATOS GENERALES DEL DISTRITO</span>
                <input type="text" name="nombre" class="form-control" placeholder="Nombre del distrito" aria-label="nombre">
                <select name="prov_central" class="form-select form-select-sm" aria-label="Default select example">
                    <option value='' selected>Provincia Central</option>
                    <option value="Manabi">Manabi</option>
                    <option value="Guayas">Guayas</option>
                    <option value="Santo Domingo">Santo Domingo</option>
                    <option value="Esmeraldas">Esmeraldas</option>
                    <option value="Santa Elena">Santa Elena</option>
                    <option value="Galapagos">Galapagos</option>
                    <option value="Pichincha">Pichincha</option>
                    <option value="Loja">Loja</option>
                    <option value="Bolivar">Bolivar</option>
                    <option value="Canar">Canar</option>
                    <option value="Azuay">Azuay</option>
                    <option value="Carchi">Carchi</option>
                    <option value="Tungurahua">Tungurahua</option>
                    <option value="Cotopaxi">Cotopaxi</option>
                    <option value="Los Rios">Los Rios</option>
                    <option value="El Oro">El Oro</option>
                    <option value="Zamora Chinchipe">Zamora Chinchipe</option>
                    <option value="Sucumbios">Sucumbios</option>
                    <option value="Napo">Napo</option>
                    <option value="Chimborazo">Chimborazo</option>
                    <option value="Francisco de Orellana">Francisco de Orellana</option>
                    <option value="Pastaza">Pastaza</option>
                    <option value="Imbabura">Imbabura</option>
                    <option value="Morona Santiago">Morona Santiago</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">CARGO ASIGNADO</span>
                <select name="responsable" class="form-select form-select-sm" aria-label="Default select example">
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
            <button type="submit" class="btn btn-primary">Crear Distrito</button>
        </form>
        <br>
        <div>
            <table class="table table-hover">
                <thead>
                    <tr class="table-primary">
                        <th>Nombre</th>
                        <th>Provincia</th>
                        <th>Responsable</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //consulta de datos de la tabla usuario
                    $consulta = "SELECT * FROM distrito;";
                    $resultado = mysqli_query($db, $consulta);
                    while ($row = mysqli_fetch_assoc($resultado)) : ?>
                        <tr>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['prov_central']; ?></td>
                            <td>
                                <?php
                                $busqueda = $row['responsable'];
                                $consulta2 = "SELECT * FROM usuario WHERE id = '${busqueda}';";
                                $resultado2 = mysqli_query($db, $consulta2);
                                $nombre_responsable = mysqli_fetch_assoc($resultado2);
                                echo $nombre_responsable['nombre'] . " " . $nombre_responsable['apellido'];
                                ?></td>
                            <td>
                                <a href="ver_distrito.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Editar y Agregar Cantones</a>
                                <a href="borrar_distrito.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Eliminar</a>
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