<?php  

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
    $orden=null;
    $filtro = null;
    //declarar el valor para la consulta de la query.
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $orden = $_POST['status'];
        $filtro ="WHERE resLlamada = '${orden}'";   
    }


    $query = "SELECT * FROM datosordenes ${filtro}";
    $resultado = mysqli_query($db4, $query);
?>

    <div class="datosactuales">
        <div class="cajastotales">
            <?php 
                $query6 = "SELECT COUNT(resLlamada) FROM datosordenes WHERE resLlamada = '${orden}';";
                $cargasT = mysqli_query($db4, $query6);
                $cargastotales = mysqli_fetch_assoc($cargasT);
                // echo "<pre>";
                // var_dump($cargastotales);
                // echo "</pre>";
            ?>
            <p style="text-transform: uppercase;">TRAMITES EN ESTADO <?php echo $orden ." ". $cargastotales["COUNT(resLlamada)"];?></p>
        </div>
        
    </div>

<fieldset class="form2 consulta__tabla">
    <legend>FILTRO Y CONSULTA DE LLAMADAS POR ESTADO</legend>
    <div class="botones-fin">
        <div class="enlace--boton salir">
            <a href="../../includes/salir.php" class="enlace">SALIR DEL SISTEMA</a>
        </div>
        <div class="enlace--boton lectura">
            <a href="../seguimiento.php" class="enlace">REGRESAR AL INICIO</a>
        </div>
    </div>
    <form action=" " method="POST" class="from__filtro">
            <div class="label__filtro">
                <select name="status" id="status" require class="form__input">
                    <option value="efectiva">Efectiva (Solamente si la llamada es positva en todo)</option>
                    <option value="no desea">No desa (Si el cliente no compro o no desea)</option>
                    <option value="no desea">Volver a llamar (Pasa a segunda llamada)</option>
                    <option value="equivocado">Numero equivocado (Si el numero de contacto no es el correcto)</option>
                </select>
            </div>
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
                <th>FECHA DE PROCESO</th>
                <th>FECHA DE CREACION</th>
                <th>NUMERO DE SEGUIMIENTO</th>
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
                        <?php echo $resultadoApi['created_at']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['id']; ?>
                    </td>
                    <td>
                        <?php echo $verfi; ?>
                    </td>
                    <td>
                        <div class="accion__actualizar" >
                            <a  href="verorden.php?id=<?php echo $resultadoApi['id']; ?>" class="acciones__enlace">VER ORDEN</a>
                        </div>
                        <?php if($verfi == "CONTACTO VERIFICADO") :?>
                            <div class="accion__actualizar" >
                                <a  href="acEstado.php?id=<?php echo $resultadoApi['id']; ?>" class="acciones__enlace">AC ESTADO</a>
                            </div>
                        <?php endif?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>
