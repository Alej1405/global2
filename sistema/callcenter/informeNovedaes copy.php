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
        <div class="enlace--boton lectura">
            <a href="descargaexcel.php" class="enlace">DESCARGAR INFORME</a>
        </div>
    </form>

    <table class="form2 consulta__tabla" >
        <thead>
            <tr>
                <th>Numero de orden</th>
                <th>provincia</th>
                <th>ciudad</th>
                <th>Estado reportado</th>
                <th>Fecha Actualizacion</th>
                <th>Orden Creada</th>
                <th>Valor por cobrar</th>
                <th>observacion de estado</th>
                <th>NUEMRO DE VISITAS</th>
                <th>Detalles</th>
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
                            $verfi = "SIN PROCESAR";
                        }else{
                            $verfi = "PROCESADA";
                        }
                    ?>
                    <td>
                        <?php echo $resultadoApi['order_id']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['province']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['city']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['status']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['fechaGest']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['created_at']; ?>
                    </td>
                    <td>
                        $<?php echo $resultadoApi['total']; ?>,00
                    </td>
                    <td>
                        <?php echo $resultadoApi['observacion_estado']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['n_visitas']; ?>
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
