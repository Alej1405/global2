<?php  
    $resultado = $_GET['resultado'] ?? null; 
    $id = $_GET['id'] ?? NULL;
    $id = filter_var($id, FILTER_VALIDATE_INT);
    
    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    //BASE DE DATOS GLOBAL CARGO
    conectarDB();
    $db =conectarDB();
    $auth = estaAutenticado();
    //BASE DE DATOS BODEGA 
    conectarDB2();
    $db2 =conectarDB2();

    //proteger la página
    if (!$auth) {
        header('location: ../global/index.php');
    }

    $errores = [];
    $mensaje = [];

    $query = "SELECT * FROM perchado WHERE idIngreso = ${id} ";
    $consulta = mysqli_query($db2, $query);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        

    }
?>


<h2 class="form__titulo titulo__pagina">REPORTE DE CAJAS PERCHADAS</h2>


<table class="form2 consulta__tabla">
    <thead>
        <tr>
            <th>QT Unidades</th>
            <th>QT cajas</th>
            <th>Ubicacion</th>
            <th>Fecha</th>
            <th>Quien Perchó...?</th>
        </tr>
    </thead>
    <tbody>
        <?php while($datosPercha = mysqli_fetch_assoc($consulta)):  ?>
        <tr>
            <td><?php echo $datosPercha['cUnid']; ?></td>
            <td><?php echo $datosPercha['cptotalm3']; ?></td>
            <td><?php echo $datosPercha['ubicac']; ?></td>
            <td><?php echo $datosPercha['fperchado']; ?></td>
            <td><?php echo $datosPercha['responsab']; ?></td>
        </tr>
        <?php endwhile;  ?>
    </tbody>
</table>

<div class="boton__anidado">
    <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
</div>