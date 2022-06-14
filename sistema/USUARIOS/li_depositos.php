<?php 

    //incluye el header
    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if (!$auth) {
        header('location: index.php');
    }

    require '../../includes/config/database.php';
    incluirTemplate('headersis2');
    conectarDB();
    $db =conectarDB(); 
    
    //BASE DE DATOS BODEGA 
    conectarDB2();
    $db2 =conectarDB2();

    //coneccion api
    conectarDB3();
    $db3 =conectarDB3();
    
    //coneccion callcenter
    conectarDB4();
    $db4 =conectarDB4();

    $query2 = "SELECT * FROM control_dep GROUP BY depositante";
    $buscar_query2 = mysqli_query($db4, $query2); 

?>
<body class="bg-gradient-primary">
    <div class="container">
            <h1 class="text-primary fs-3 text-center">CONTROL DE DEPOSITOS</h1>
            
        <!-- detalles generales de las ordenes agrupadas INICIO DE INFORMACION -->
        <div class="accordion" id="accordionExample">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Colaborador</th>
                        <th>Valor</th>
                        <th>QT Ordenes</th>
                        <th>QT Entregados</th>
                        <th>QT Reingresos</th>
                        <th>Devoluciones P</th>
                        <th>Deficit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($dinan = mysqli_fetch_assoc($buscar_query2)): ?>
                        <tr>
                            <td>
                                <a href="list_depositos.php?nom=<?php echo $dinan['depositante'];?>">
                                    <?php echo $dinan['depositante'];?>
                                </a>
                            </td>
                            <td>
                                <?php 
                                    $nombre_dep = $dinan['depositante'];
                                    $total_cantidad = "SELECT sum(cantidad) FROM control_dep WHERE depositante = '$nombre_dep';"; 
                                    $query_total = mysqli_query($db4, $total_cantidad);
                                    $total_valor = mysqli_fetch_assoc($query_total);
                                    $total_dec = $total_valor['sum(cantidad)'] / 100;
                                    $total_dec2 = number_format($total_dec, 2);
                                    echo "$".$total_dec2;
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $nombre_dep = $dinan['depositante'];
                                    $qt_ordenes = "SELECT count(id) FROM datosordenes WHERE responsable_m = '$nombre_dep'; ";
                                    $qt_ordenesQ = mysqli_query($db4, $qt_ordenes);
                                    $qtOrdenes = mysqli_fetch_assoc($qt_ordenesQ);
                                    echo $qtOrdenes["count(id)"]. " " .'ORDENES';
                                ?>
                            </td>
                            <td>
                            <?php 
                                    $nombre_dep = $dinan['depositante'];
                                    $qt_ordenes = "SELECT count(id) FROM datosordenes WHERE responsable_m = '$nombre_dep' AND status = 'delivered'; ";
                                    $qt_ordenesQ = mysqli_query($db4, $qt_ordenes);
                                    $qtOrdenes = mysqli_fetch_assoc($qt_ordenesQ);
                                    $qt_ordenes2 = "SELECT sum(total) FROM datosordenes WHERE responsable_m = '$nombre_dep' AND status = 'delivered'; ";
                                    $qt_ordenesQ2 = mysqli_query($db4, $qt_ordenes2);
                                    $qtOrdenes2 = mysqli_fetch_assoc($qt_ordenesQ2);
                                    $total_delive = number_format($qtOrdenes2['sum(total)'], 2);
                                    echo "N". " ".$qtOrdenes["count(id)"]." "."Valor"." "."$". $total_delive;
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $nombre_dep = $dinan['depositante'];
                                    $qt_ordenes = "SELECT count(id) FROM datosordenes WHERE responsable_m = '$nombre_dep' AND status = 'returnes'; ";
                                    $qt_ordenesQ = mysqli_query($db4, $qt_ordenes);
                                    $qtOrdenes = mysqli_fetch_assoc($qt_ordenesQ);

                                    //consulta de id comparacion
                                        $nombre_dep = $dinan['depositante'];
                                        $qt_ordenes_reing = "SELECT * FROM datosordenes WHERE responsable_m = '$nombre_dep' AND status = 'returnes'; ";
                                        $qt_ordenesQ_reing = mysqli_query($db4, $qt_ordenes_reing);
                                        $qtOrdenes_reing = mysqli_fetch_assoc($qt_ordenesQ_reing);
                                        $id_reingresos = $qtOrdenes_reing['id'];

                                    //consulta de bdd de reingresos
                                        $id_reing = $id_reingresos;
                                        $qt_ordenes123 = "SELECT count(id) FROM datosordenes WHERE responsable_m = '$nombre_dep' AND ubicacion_p = 'Ingreso a bodega'; ";
                                        $qt_ordenesQ123 = mysqli_query($db4, $qt_ordenes123);
                                        $qtOrdenes123 = mysqli_fetch_assoc($qt_ordenesQ123);

                                    //comparacion de ingresos vs returnes
                                        echo "Solicitado"." ".$qtOrdenes["count(id)"]." "." Qt Ingresada"." ". $qtOrdenes123['count(id)'];
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $qt_total_regin = $qtOrdenes["count(id)"] - $qtOrdenes123['count(id)'];
                                    echo $qt_total_regin;
                                ?>
                            </td>
                            <td>
                                <?php
                                    $resultado_t = $total_dec2 - $total_delive;
                                    echo "$"." ".$resultado_t;
                                ?>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
    </div>



<?php 
    incluirTemplate('fottersis');     
?>