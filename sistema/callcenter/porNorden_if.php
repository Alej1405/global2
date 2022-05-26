<?php 
    $resultado = $_GET['resultado'] ?? null; 

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    //coneccion de sesion
    conectarDB();
    $db =conectarDB();

    //coneccion api
    conectarDB3();
    $db3 =conectarDB3();

    //coneccion callcenter
    conectarDB4();
    $db4 =conectarDB4();

    $auth = estaAutenticado();

    // proteger la página
    if (!$auth) {
        header('location: index.php');
    }
    $orden = null;
    $filtro = null;
    //declarar el valor para la consulta de la query.
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $orden = $_POST['orden'];
        $filtro ="WHERE order_id = ${orden}";   
    }

    //filtro de busqueda por numero de orden
    $query = "SELECT * FROM datosordenes ${filtro}";
            $resultado = mysqli_query($db4, $query);
            
            
            
?>

<fieldset class="form2 consulta__tabla">
    <legend>FILTRO Y CONSULTA DE LLAMADAS POR FECHA</legend>
    <div class="botones-fin">
        <div class="enlace--boton salir">
            <a href="../../includes/salir.php" class="enlace">SALIR DEL SISTEMA</a>
        </div>
        <div class="enlace--boton lectura">
            <a href="../admin.php" class="enlace">REGRESAR AL INICIO</a>
        </div>
    </div>
    <form action=" " method="POST" class="from__filtro">

        <label for="orden" class="label__filtro">INGRESA EL NUMERO DE ORDEN</label>
        <input type="number" name="orden" id="orden" class="input__filtro" require placeholder=" ">
        <br>
        <input type="submit" value="FILTRAR" class="filtrar">
        <div>
            <p>
                ESTAS BUSCANDO EL NUEMERO DE ORDEN <?php echo $orden; ?> 
            </p>
        </div>
    </form>

    <table class="form2 consulta__tabla" >
        <thead>
            <tr>
                <th>NUMERO DE ORDEN</th>
                <th>ESTADO</th>
                <th>FECHA DE CREACION</th>
                <th>RESULTADO DE LLAMADA</th>
                <th>OBSERVACION</th>
                <th>Estado de Operacion</th>
                <th>Contactar</th>
            </tr>
        </thead>
        <tbody>
            <?php while($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <?php 
                        $idver = $resultadoApi['id'];
                        $verQuery = "SELECT contactado from verificacion WHERE contactado =${idver};";
                        $ejec = mysqli_query($db4, $verQuery);
                        $ejec2 = mysqli_fetch_assoc($ejec);
                        if(!$ejec2){
                            $verfi = "POR CONTACTAR";
                        }else{
                            $verfi = "CONTACTO VERIFICADO";
                        }
                        
                    ?>
                    <td>
                        <?php echo $resultadoApi['order_id']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['status']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['fechaGest']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['resLlamada']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['observacion']; ?>
                    </td>
                    <td>
                        <?php echo $verfi; ?>
                    </td>
                    <td>
                        <div class="accion__actualizar" >
                            <a  href="verorden.php?id=<?php echo $resultadoApi['id']; ?>" class="acciones__enlace">VER ORDEN</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>
