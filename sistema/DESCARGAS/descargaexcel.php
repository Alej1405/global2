<?php

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=informediario.xls");

$resultado = $_GET['resultado'] ?? null;

require '../../includes/config/database.php';
require '../../includes/funciones.php';
//coneccion de sesion
conectarDB();
$db = conectarDB();

//coneccion api
conectarDB3();
$db3 = conectarDB3();

//coneccion callcenter
conectarDB4();
$db4 = conectarDB4();

$auth = estaAutenticado();

// proteger la página
if (!$auth) {
    header('location: index.php');
}

$query = "SELECT * FROM orders ;";
$resultado = mysqli_query($db3, $query);
?>
<table class="form2 consulta__tabla">
    <thead>
        <tr>
            <th>Orden</th>
            <th>Nombre</th>
            <th>Distrito</th>
            <th>Subdistrito</th>
            <th>Provincia</th>
            <th>Canton</th>
            <th>Ciudad</th>
            <th>Direccion</th>
            <th>Telefono</th>
            <th>Estado</th>
            <th>Observacion</th>
            <th>Fecha Actualizacion</th>
            <th>Fecha Creacion</th>
            <th>Valor </th>
            <th>Intentos de Entrega</th>
        </tr>
        <?php
        //consulta de historial de estados

        ?>
        <tr>

        </tr>
    </thead>
    <tbody>
        <?php while ($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
            <?php
            //consulta de datos del cliente
            $query = "SELECT * FROM order_clients WHERE order_id = '{$resultadoApi['id']}';";
            $resultadoCliente = mysqli_query($db3, $query);
            $cliente = mysqli_fetch_assoc($resultadoCliente);

            //consulta de observacion en DISPATCHES
            $query = "SELECT * FROM dispatches WHERE order_id = '{$resultadoApi['id']}';";
            $resultadoDispatches = mysqli_query($db3, $query);
            $dispatches = mysqli_fetch_assoc($resultadoDispatches);
            $id_dispatches = $dispatches['id'];

            //consulta de observacion en DISPATCHES
            $query_statuses = "SELECT count(id)  AS visitas FROM dispatch_statuses WHERE dispatch_id = '${id_dispatches}' and status = 'undelivered';";
            $resultadoDispatchesEstatuses = mysqli_query($db3, $query_statuses);
            $dispatches_statuses = mysqli_fetch_assoc($resultadoDispatchesEstatuses);

            ?>
            <tr>
                <td>
                    <?php echo $resultadoApi['order_id']; ?>
                </td>
                <td>
                    <?php echo $cliente['name'] . " " . $cliente['last_name']; ?>
                </td>
                <td>
                    <?php 
                        $consulta_distrito = $cliente['province'];
                        $query_distrito = "SELECT * FROM distrito WHERE prov_central = '{$consulta_distrito}';";
                        $resultado_distrito = mysqli_query($db, $query_distrito);
                        $distrito = mysqli_fetch_assoc($resultado_distrito);
                        if($distrito){

                            echo $distrito['nombre'];
                        }else{
                            echo "Sin distrito";
                        }
                    ?>
                </td>
                <td>
                    <?php 
                         $consulta_subdistrito = $distrito['id'] ?? null;
                         $query_subdistrito = "SELECT * FROM sub_distrito WHERE id_distrito = '{$consulta_subdistrito}';";
                         $resultado_subdistrito = mysqli_query($db, $query_subdistrito);
                         $subdistrito = mysqli_fetch_assoc($resultado_subdistrito);
                        if($subdistrito['id'] ?? null){
                            echo $subdistrito['nombre'];
                        }else{
                            echo "Sin subdistrito"; 
                        }
                    ?>
                </td>
                <td>
                    <?php echo $cliente['province']; ?>
                </td>
                <td>
                    <?php echo $cliente['canton']; ?>
                </td>
                <td>
                    <?php echo $cliente['city']; ?>
                </td>
                <td>
                    <?php echo $cliente['address']; ?>
                </td>
                <td>
                    <?php echo $cliente['phone']; ?>
                </td>
                <td>
                    <?php echo $resultadoApi['status']; ?>
                </td>
                <td>
                    <?php echo $dispatches['observation']; ?>
                </td>
                <td>
                    <?php echo $resultadoApi['updated_at']; ?>
                </td>
                <td>
                    <?php echo $resultadoApi['created_at']; ?>
                </td>
                <td>
                    <?php 
                        $total = $resultadoApi['total']/100;
                        echo "$ ".number_format($total, 2, '.', ',');
                    ?>
                </td>
                <td>
                    <?php echo $dispatches_statuses['visitas']; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</fieldset>