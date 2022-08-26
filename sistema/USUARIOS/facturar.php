<?php 
    $resultado = $_GET['resultado'] ?? null;

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

    //consulta para los colaboradores

    
    //declarar el valor para la consulta de la query.
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ciudad = $_POST['ciudad'];
        $filtro ="SELECT * FROM datosordenes WHERE city = '${ciudad}' order by status DESC";
           
    }else{
        $filtro = "SELECT * FROM datosordenes order by status ASC";
    }

    
    //ASIGNACION DE ORDENES DE ACUERDO AL USUARIO CRITERIO (PARES E IMPARES DOS EQUIPOS)
        // punto de partida por la tabla de ordenes filtro por estado de orden.
        switch ($_SESSION['usuario']){
            // USUARIO DE NUMEROS PARES
                case "camila@globalcargoecuador.com": 
                    $query = "SELECT * FROM orders WHERE mod(id,2) = 0 AND status = 'requested' order by created_at desc;";
                            $resultado = mysqli_query($db3, $query);
                            $resultadoApi = mysqli_fetch_assoc($resultado);
                break;
            
                case "celia@globalcargoecuador.com":
                    $query = "SELECT * FROM orders WHERE mod(id,2) = 0 AND status = 'requested' order by created_at desc;";
                        $resultado = mysqli_query($db3, $query);
                        $resultadoApi = mysqli_fetch_assoc($resultado);
                break;
            // USUARIO DE NUMEROS IMPARES 
                case "mailee@globalcargoecuador.com":
                    $query = "SELECT * FROM orders WHERE mod(id,2) <> 0 AND status = 'requested' order by created_at desc;";
                        $resultado = mysqli_query($db3, $query);
                        $resultadoApi = mysqli_fetch_assoc($resultado);
                break;
        
                case "andreina@globalcargoecuador.com":
                    $query = "SELECT * FROM orders WHERE mod(id,2) <> 0 AND status = 'requested' order by created_at desc;";
                        $resultado = mysqli_query($db3, $query);
                        $resultadoApi = mysqli_fetch_assoc($resultado);
                break;
                case "luis@globalcargoecuador.com":
                    $query = "SELECT * FROM orders WHERE status = 'requested' order by created_at desc;";
                        $resultado = mysqli_query($db3, $query);
                        $resultadoApi = mysqli_fetch_assoc($resultado);
                break;
        }
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
                            <td class="btn-group-vertical">
                                <div class="accion__actualizar" >
                                    <a  href="mov_fin.php?id=<?php echo $resultadoApi['id']; ?>" class="acciones__enlace">PROCESAR</a>
                                </div>
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