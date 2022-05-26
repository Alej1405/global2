<?php 
    $consulta_v = $_GET['consulta_v'] ?? null;

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

    //conexion api
    conectarDB3();
    $db3 =conectarDB3();
    
    //coneccion callcenter
    conectarDB4();
    $db4 =conectarDB4();
    $ciudad = null;
    $filtro = null;
                    $query = "SELECT * FROM datosordenes WHERE estado = '${consulta_v}' ";
                            $resultado = mysqli_query($db4, $query);
                            $resultadoApi = mysqli_fetch_assoc($resultado);
        
    //FIN SE ASIGNACION DE ORDENES.
?>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="table-wrapper-scroll-y my-custom-scrollbar mt-4" style="overflow-x: auto"> 
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>N. Seguimiento</th>
                        <th>Orden</th>
                        <th>Valor</th>
                        <th>F. Creacion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
                        <tr>
                            <td class="fs-6">
                                <?php echo $resultadoApi['id']; ?>
                            </td>
                            <td class="fs-6">
                                <?php echo $resultadoApi['order_id']; ?>
                            </td>
                            <td class="fs-6">
                                <?php 
                                    $precio = $resultadoApi['total'] / 100;
                                    echo "$".$precio.",00";
                                ?>
                            </td>
                            <td class="fs-6">
                                <?php echo $resultadoApi['created_at']; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
    incluirTemplate('fottersis');     
?>