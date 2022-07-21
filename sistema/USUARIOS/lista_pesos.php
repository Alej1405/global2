<?php 

    $nombre_ase = $_GET['nombre'] ?? null;

    //incluye el header
    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if (!$auth) {
        header('location: index.php');
    }

    require '../../includes/config/database.php';
    incluirTemplate('headersis2');
    
    //coneccion api
    conectarDB3();
    $db3 =conectarDB3();
    
    //coneccion callcenter
    conectarDB4();
    $db4 =conectarDB4();


     //ARRAY DE ERRORES PARA LA ALERTAS
        $errores = [];
    
    //query para consultar los clientes registrados
    if (empty($nombre_ase)){
        $consulta_clientes = "SELECT * FROM ordenes";
        $eje_clientes = mysqli_query($db4, $consulta_clientes);
    }else{
        $consulta_clientes = "SELECT * FROM ordenes WHERE asesor = '${nombre_ase}'";
        $eje_clientes = mysqli_query($db4, $consulta_clientes);
    }

    //eliminar cliente
        //liminar una tarifa directamente desde la tabla.
        $id = '';
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
        }
        //validar que esxista una tarifa con esa ida
            if($id){
                $query = "DELETE FROM ordenes WHERE id = ${id}"; 
                $resultado = mysqli_query($db4, $query);
                if ($resultado) {
                }
            }
            

?>
<body class="bg-gradient-primary">
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>CONSIGNATARIO</th>
                    <th>DETINARIO</th>
                    <th>FECHA DE SOLICITUD</th>
                    <th>LARGO</th>
                    <th>ANCHO</th>
                    <th>ALTURA</th>
                    <th>PESO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php while($array_clientes = mysqli_fetch_assoc($eje_clientes)):?>
                    <tr>
                        <td>
                            <?php
                                $consulta_cedula = $array_clientes['cliente'];
                                $consulta ="SELECT * FROM clientes WHERE cedula = $consulta_cedula;";
                                $ejec_consulta = mysqli_query($db4, $consulta);
                                $rest = mysqli_fetch_assoc($ejec_consulta);
                                echo $rest['nombre']." ".$rest['apellido']; 
                            ?>
                        </td>
                        <td><?php echo $array_clientes['nombre']." ".$array_clientes['apellido']; ?></td>
                        <td><?php echo $array_clientes['fecha_reg']; ?></td>
                        <td><?php echo $array_clientes['l']; ?></td>
                        <td><?php echo $array_clientes['a']; ?></td>
                        <td><?php echo $array_clientes['h']; ?></td>
                        <td><?php echo $array_clientes['peso']; ?></td>
                        <td>
                            <div class="btn-group">
                                <div class="col-auto">
                                    <a href="bodega_ingreso.php?id=<?php echo $array_clientes['id'];?>" class="btn btn-outline-success btn-sm">
                                        INGRESAR
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php 
    incluirTemplate('fottersis');     
?>