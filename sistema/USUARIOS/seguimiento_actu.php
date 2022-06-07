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
        $filtro ="SELECT * FROM datosordenes WHERE responsable_m = '${ciudad}'  order by status DESC";
           
    }else{
        $filtro = "SELECT * FROM datosordenes WHERE status = 'undelivered';";
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
                                        <option value="Henrry">HENRRY</option>
                                        <option value="Roberto">ROBERTO</option>
                                        <option value="Mariana">MARIANA</option>
                                        <option value="Esteban Trejo">ESTEBAN TREJO</option>
                                        <option value="Alisson">ALISSON</option>
                                        <option value="Vanessa">VANESSA</option>
                                        <option value="Francisco">DON FRANCISCO</option>
                                        <option value="Urbano">URBANO</option>
                                        <option value="Ma Eugenia">MARIA EUGENIA</option>
                                        <option value="Juan Luis">JUAN LUIS</option>
                                        <option value="Marco Cisneros">MARCO CISNEROS</option>
                                        <option value="Eloisa">ELOISA</option>
                                        <option value="Carlos Capon">CARLOS CAPON</option>
                                        <option value="Alexandra">ALEXANDRA</option>
                                        <option value="Ivan Ortega">IVAN ORTEGA</option>
                                        <option value="Xavier">XAVIER</option>
                                        <option value="Jhonathan">JHONATHAN</option>
                                        <option value="Jose">JOSE</option>
                                        <option value="Bryan">BRYAN</option>
                                        <option value="Fabricio">FABRICIO</option>
                                        <option value="Carolina">CAROLINA</option>
                                        <option value="Katherine Nogales">KATHERINE NOGALES</option>
                                        <option value="Sin despacho">SIN DESPACHO</option>
                                        <option value="DALIS">DALIS</option>
                                        <option value="Luis Arevalo">LUIS AREVALO</option>
                                        <option value="Steven">STEVEN</option>
                                        <option value="Jesus">JESUS</option>
                                        <option value="Luis Gutierres">LUIS GUTIERRES</option>
                                        <option value="Carlos Brito">CARLOS BRITO</option>
                                        <option value="Javier Jarrin">JAVIER JARRIn</option>
                                        <option value="Richard">RICHARD</option>
                                        <option value="Oficina GYE">OFICINA GYE</option>
                                        <option value="Oficina UIO">OFICINA QUITO</option>
                                        <option value="OTRO">OTRO</option>
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
                        <tr class="<?php 
                                        $comp_fecha =  date('Y-m-d');
                                        $id = $resultadoApi['id'];
                                        $fecha_G = "SELECT * FROM orders WHERE id = ${id}";
                                            $fecha_Q2 = mysqli_query($db3, $fecha_G);
                                        $fecha_consul = mysqli_fetch_assoc($fecha_Q2);
                                        $fecha_filtro = $fecha_concul['updated_at'];
                                        $fecha_final = date("d-m-Y",strtotime($fecha_filtro."+ 2 days")); 
                                        if($fecha_final > $comp_fecha){
                                            echo "p-3 mb-2 bg-danger text-white"; 
                                        }

                                    ?>">
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
