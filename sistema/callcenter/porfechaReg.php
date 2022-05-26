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
    $inicio = null;
    $hasta = null;
    $filtro = null;
    //declarar el valor para la consulta de la query.
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inicio = $_POST['inicio'];
        $hasta = $_POST['hasta']; 
        $filtro ="WHERE fechaGest BETWEEN '${inicio}' and '${hasta}'";   
    }


    $query = "SELECT * FROM datosordenes ${filtro}";


            $resultado = mysqli_query($db4, $query);
?>

<center><h1 class="titulo__pagina">CONSULTA DE ORDENES POR FECHA DE <b>"RECEPCION"</b></h1></center>

<fieldset class="form2 consulta__tabla">
    <legend>CONTROL DE LLAMADAS POR FECHA DE GESTION</legend>
    <div class="botones-fin">
        <div class="enlace--boton salir">
            <a href="../../includes/salir.php" class="enlace">SALIR DEL SISTEMA</a>
        </div>
        <div class="enlace--boton lectura">
            <a href="../seguimiento.php" class="enlace">REGRESAR AL INICIO</a>
        </div>
    </div>
    <form action=" " method="POST" class="from__filtro">

        <label for="inicio" class="label__filtro">FILTRAR DESDE</label>
        <input type="date" name="inicio" id="inicio" class="input__filtro" require placeholder=" ">
        <label for="hasta" class="label__filtro">FILTRAR HASTA</label>
        <input type="date" name="hasta" id="hasta" class="input__filtro"  placeholder=" ">
        <br>
        <input type="submit" value="FILTRAR" class="filtrar">
        <div>
            <p>
                ESTAS FILTRANDO DESE <?php echo $inicio; ?> HASTA <?php echo $hasta; ?>
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
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>
