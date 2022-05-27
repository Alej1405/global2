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
        $ciudad = $_POST['responsable_m'];
        $filtro ="SELECT * FROM datosordenes WHERE responsable_m = '${ciudad}'";
           
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
                    CONTROL DE PAQUETES
                </div>
                <div class="card-body">
                            <div class="mb-3">
                                <select name="responsable_m" class="form-select" aria-label="Default select example">
                                    <option selected>Responsable de Provincia</option>
                                    <option value="ofiGYE">OFICINA GUAYAQUIL</option>
                                    <option value="ofiUIO">OFICINA QUITO</option>
                                    <option value="Henrry Roberto">LOS RIOS (HENRRY ROBERTO)</option>
                                    <option value="Mariana">MARIANA</option>
                                    <option value="Esteban">ESTEBAN</option>
                                    <option value="Bryan Jonathan">EL ORO (BRYAN JOATHAN)</option>
                                    <option value="Alisson">ALISSON</option>
                                    <option value="Vanessa">VANESSA</option>
                                    <option value="Francisco">DON FRANCISCO</option>
                                    <option value="Urbano">URBANO</option>
                                    <option value="Ma Eugenia">MARIA EUGENIA</option>
                                    <option value="Juan Luis">JUAN LUIS</option>
                                    <option value="Marco Cisneros">MARCO CISNEROS</option>
                                    <option value=" ">SIN ASIGNAR</option>
                                </select>
                            </div>
                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                    <input type="submit" value="FILTRAR" class="btn btn-primary">
                </div>
        </form>
        <div class="table-wrapper-scroll-y my-custom-scrollbar mt-4" style="overflow-x: auto"> 
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Responsable</th>
                        <th>Ub. Paquete</th>
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
                                <?php echo $resultadoApi['order_id']; ?>
                            </td>
                            <td class="fs-6">
                                <?php echo $resultadoApi['responsable_m']; ?>
                            </td>
                            <td class="fs-6">
                                <?php echo $resultadoApi['ubicacion_p']; ?>
                            </td>
                            <td class="btn-group-vertical">
                                <div class="accion__actualizar" >
                                    <a  href="act_seguimiento.php?id=<?php echo $resultadoApi['id']; ?>" class="btn btn-outline-primary btn-sm">ACTUALIZAR</a>
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
