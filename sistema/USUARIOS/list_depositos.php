<?php 
    $nombre = $_GET['nom'] ?? null;

    //incluye el header
    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if (!$auth) {
        header('location: ../index.php');
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

    // proteger la página
    if (!$auth) {
        header('location: index.php');
    }

    //CONSULTA DE DEPOSITOS LISTADO GENERAL FILTRO POR NOMBRE.

        $filtro_nombre ="SELECT * from control_dep where depositante = '$nombre' GROUP BY referencia;";
        $query_nom = mysqli_query($db4, $filtro_nombre);
        //echo $filtro_nombre;

    

?>
<body class="bg-gradient-primary">
        <div class="table-wrapper-scroll-y my-custom-scrollbar mt-4" style="overflow-x: auto"> 
            <div class="accordion" id="accordionExample">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Depositante</th>
                            <th>Valor</th>
                            <th>N de Deposito</th>
                            <th>Banco</th>
                            <th>Fecha</th>
                            <th>Observacion</th>
                            <th>Comprobante</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($reultado_nombre = mysqli_fetch_assoc($query_nom)) : ?>
                            <tr>
                                <td>
                                    <?php echo $reultado_nombre['depositante']; ?>
                                </td>
                                <td>
                                    <?php echo $reultado_nombre['cantidad']; ?>
                                </td>
                                <td>
                                    <?php echo $reultado_nombre['referencia']; ?>
                                </td>
                                <td>
                                    <?php echo $reultado_nombre['cuenta']; ?>
                                </td>
                                <td>
                                    <?php echo $reultado_nombre['fecha']; ?>
                                </td>
                                <td>
                                    <?php echo $reultado_nombre['observacion']; ?>
                                </td>
                                <td>
                                    <a href="../../depositos/<?php echo $reultado_nombre['deposito']; ?>" target="blanck">
                                        Ver comprobante
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php 
    incluirTemplate('fottersis');     
?>
