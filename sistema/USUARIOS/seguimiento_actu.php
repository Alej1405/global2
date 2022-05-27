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
        $filtro ="SELECT * FROM datosordenes WHERE responsable_m = '${ciudad}' order by status DESC";
           
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
                    CONTROL GENERAL DE ORDENES
                </div>
                <div class="card-body">
                            <select name="ciudad" class="form-select" aria-label="Default select example">
                                        <option value=" ">Seleccionar Responsable</option>
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
                                        <option value="Eloisa">ELOISA</option>
                                        <option value="Carlos">CARLOS</option>
                                        <option value="Alexandra">ALEXANDRA</option>
                                        <option value="Ivan">IVAN</option>
                                        <option value="Xavier">XAVIER</option>
                                        <option value="Jhonathan">JHONATHAN</option>
                                        <option value="Jose">JOSE</option>
                                        <option value="Bryan">BRYAN</option>
                                        <option value="Fabricio">FABRICIO</option>
                                        <option value="Esteban">ESTEBAN</option>
                                        <option value="Carolina">CAROLINA</option>
                                        <option value="Carolina">Sin Responsable</option>
                            </select>
                </div>
                <input type="submit" value="FILTRAR">
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
                        <th>S. Paquete</th>
                        <th>R. de Gestion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
                        <tr>
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
                            <td class="fs-6">
                                <?php echo $resultadoApi['ubicacion_p']; ?>
                            </td>
                            <td class="fs-6">
                                <?php echo $resultadoApi['responsable_m']; ?>
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
