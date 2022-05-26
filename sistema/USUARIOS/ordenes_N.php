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
    //declarar el valor para la consulta de la query.
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ciudad = $_POST['ciudad'];
        $filtro ="SELECT * FROM datosordenes WHERE city = '${ciudad}' order by status DESC";
           
    }else{
        $filtro = "SELECT * FROM datosordenes order by status ASC";
    }

    
    //ASIGNACION DE ORDENES DE ACUERDO AL USUARIO CRITERIO (PARES E IMPARES DOS EQUIPOS)
        // punto de partida por la tabla de ordenes filtro por estado de orden.
                    $query = "SELECT * FROM orders WHERE status = '${consulta_v}' order by created_at desc;";
                            $resultado = mysqli_query($db3, $query);
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