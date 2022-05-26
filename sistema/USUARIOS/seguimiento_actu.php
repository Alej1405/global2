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
    $ciudad = null;
    $filtro = null;
    //declarar el valor para la consulta de la query.
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ciudad = $_POST['ciudad'];
        $filtro ="SELECT * FROM datosordenes WHERE city = '${ciudad}' order by status DESC";
           
    }else{
        $filtro = "SELECT * FROM datosordenes order by status ASC";
    }


    $query = $filtro;
            $resultado = mysqli_query($db4, $query);
?>
<body class="bg-gradient-primary">
    <div class="container">
        <form action=" " method="POST" class="custom-file">
                <div class="card-header">
                    ACTUALIZAR ESTADOS DE ÓRDENES
                </div>
                <div class="card-body">
                    <input type="texte" name="ciudad" id="ciudad" class="form-control" require placeholder="INGRESA LA CIUDAD EN MAYUSCULAS">
                    <p class="card-text">Buscar la orden por la ciudad de envío <?php echo $ciudad; ?></p>
                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                    <input type="submit" value="FILTRAR" class="btn btn-primary">
                </div>
        </form>
        <div class="table-wrapper-scroll-y my-custom-scrollbar mt-4" style="overflow-x: auto"> 
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Orden</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>N. Visitas</th>
                        <th>Acciones</th>
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
                            <td class="fs-6">
                                <?php echo $resultadoApi['name']." ".$resultadoApi['last_name']; ?>
                            </td>
                            <td class="fs-6">
                                <?php echo $resultadoApi['order_id']; ?>
                            </td>
                            <td class="fs-6">
                                <?php echo $resultadoApi['status']; ?>
                            </td>
                            <td class="fs-6">
                                <?php echo $resultadoApi['fechaGest']; ?>
                            </td>
                            <td class="fs-6">
                                <?php echo $resultadoApi['n_visitas']; ?>
                            </td>
                            <td class="btn-group-vertical">
                                <div class="accion__actualizar" >
                                    <a  href="verorden.php?id=<?php echo $resultadoApi['id']; ?>" class="btn btn-outline-primary btn-sm">VER ORDEN</a>
                                </div>
                                <?php if($_SESSION['rol'] == "superAdmin") :?>
                                    <div class="accion__actualizar" >
                                            <a  href="actualizacion.php?id=<?php echo $resultadoApi['id']; ?>" >CONTACTAR</a>
                                    </div>
                                <?php endif?>
                                <?php if($_SESSION['rol'] == "coordinacion") :?>
                                    <div class="accion__actualizar" >
                                        <a  href="acEstado.php?id=<?php echo $resultadoApi['id']; ?>" class="btn btn-outline-success btn-sm">ACT ESTADO</a>
                                    </div>
                                <?php endif?>
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
