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
        $inicio =  $_POST['inicio']; 
        $hasta = $_POST['hasta']; 
        $filtro ="WHERE created_at BETWEEN '${inicio}' and '${hasta}'";   
    }


    $query = "SELECT * FROM datosordenes ${filtro}";


            $resultado = mysqli_query($db4, $query);
?>

<center><h1 class="titulo__pagina">CONTROL Y SEGUIMIENTO DE ORDENES <b>"REPORTE Y GESTION"</b></h1></center>

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
                <th>N SEGUIMIENTO</th>
                <th>NOMBRE Y APELLIDO</th>
                <th>PROVINCIA</th>
                <th>NUEMRO DE ORDEN</th>
                <th>ESTADO REPORTADO</th>
                <th>ESTADO DE GESTION</th>
                <th>RESULTADO DE LLAMADA</th>
                <th>DETALLES DE ORDEN</th>
            </tr>
        </thead>
        <tbody>
            <?php while($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <?php 
                        
                    ?>
                    <td>
                        <?php echo $resultadoApi['id']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['name']." " .$resultadoApi['last_name']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['province']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['order_id']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['status']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['estado']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['resLlamada']; ?>
                    </td>
                    <td>
                        <div class="accion__actualizar" >
                            <a  href="../callcenter/verorden.php?id=<?php echo $resultadoApi['id']; ?>" class="acciones__enlace">VER ORDEN</a>
                        </div>
                        <div class="accion__actualizar" >
                            <a  href="../callcenter/acEstado.php?id=<?php echo $resultadoApi['id']; ?>" class="acciones__enlace">AC ESTADO</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>
