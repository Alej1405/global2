<?php

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=informediario.xls");
 
    $resultado = $_GET['resultado'] ?? null; 

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
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
<table class="form2 consulta__tabla" >
        <thead>
            <tr>
                <th>Numero de orden</th>
                <th>provincia</th>
                <th>ciudad</th>
                <th>Estado</th>
                <th>Resultado de llamada</th>
                <th>Observacion</th>
                <th>Fecha Actualizacion</th>
                <th>Orden Creada</th>
                <th>Valor por cobrar</th>
                <th>observacion de estado</th>
                <th>numero de visitas</th>
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
                        <?php echo $resultadoApi['resLlamada']; ?>
                    </td>
                    <td>
                        <?php echo $resultadoApi['observacion']; ?>
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
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>