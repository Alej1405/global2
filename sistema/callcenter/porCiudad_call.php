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
    $ciudad = null;
    $filtro = null;
    //declarar el valor para la consulta de la query.
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ciudad = $_POST['ciudad'];
        $filtro ="WHERE city = '${ciudad}'";   
    }


    $query = "SELECT * FROM order_clients ${filtro}";


            $resultado = mysqli_query($db3, $query);
?>

<fieldset class="form2 consulta__tabla">
    <legend>FILTRO Y CONSULTA DE LLAMADAS POR FECHA</legend>
    <div class="botones-fin">
        <div class="enlace--boton salir">
            <a href="../../includes/salir.php" class="enlace">SALIR DEL SISTEMA</a>
        </div>
        <div class="enlace--boton lectura">
            <a href="../callcenterAdmin.php" class="enlace">REGRESAR AL INICIO</a>
        </div>
    </div>
    <form action=" " method="POST" class="from__filtro">

        <label for="ciudad" class="label__filtro">INGRESA LA CIUDAD EN MAYUSCULAS</label>
        <input type="texte" name="ciudad" id="ciudad" class="input__filtro" require placeholder=" ">
        <br>
        <input type="submit" value="FILTRAR" class="filtrar">
        <div>
            <p>
                ESTAS BUSCANDO DE ESTA CIUDAD <?php echo $ciudad; ?>
            </p>
        </div>
    </form>

    <table class="form2 consulta__tabla" >
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Telefono</th>
                <th>Ciudad</th>
                <th>Numero de orden</th>
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
                        <?php echo $resultadoApi['name']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['last_name']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['phone']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['city']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['order_id']; ?>
                    </td>
                    <td>
                        <?php echo $verfi; ?>
                    </td>
                    <td>
                        <div class="accion__actualizar" >
                            <a  href="verorden.php?id=<?php echo $resultadoApi['id']; ?>" class="acciones__enlace">VER ORDEN</a>
                        </div>
                        <?php if($verfi == "POR CONTACTAR") :?>
                            <div class="accion__actualizar" >
                                    <a  href="actualizacion.php?id=<?php echo $resultadoApi['id']; ?>" class="acciones__enlace">CONTACTAR</a>
                            </div>
                        <?php endif?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>
