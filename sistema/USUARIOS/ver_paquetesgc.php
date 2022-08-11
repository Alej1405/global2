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
        $tipo_as = $_SESSION['rol'];
    
    //query para consultar los clientes registrados
    if (empty($nombre_ase)){
        $consulta_clientes = "SELECT * FROM ordenes WHERE estado = 'recolectar' and estado = 'ingreso';";
        $eje_clientes = mysqli_query($db4, $consulta_clientes);
    }else{
        $consulta_clientes = "SELECT * FROM ordenes WHERE asesor = '$nombre_ase' and estado = 'recolectar' and estado = 'ingreso';";
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
    <h1>SEGUIMIENTO DE PAQUETES</h1>
            <p>En este listado solo se encuentran los paquetes que estan en proceso de entrega.</p>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>CONSIGNATARIO</th>
                    <th>DETINARIO</th>
                    <th>FECHA DE SOLICITUD</th>
                    <th>CONTACTOS</th>
                    <th>CIUDAD DIRECCION</th>
                    <th>ASESOR</th>
                    <th>ESTADO</th>
                    <th>TARIFA APLICADA</th>
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
                        <td><?php echo $array_clientes['telefono']; ?></td>
                        <td><?php echo $array_clientes['ciudad']." / ".$array_clientes['provincia']; ?></td>
                        <td><?php echo $array_clientes['asesor']; ?></td>
                        <td><?php echo $array_clientes['estado']; ?></td>
                        <td><?php echo $array_clientes['tarifa']; ?></td>
                        <td>
                            <?php if ($tipo_as === 'motorizado'): ?>
                                    <div class="col-auto">
                                        <a href="guia.php?id=<?php echo $array_clientes['id']; ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-download fa-sm text-white-50"></i> Guia
                                        </a>
                                    </div>
                            <?php else: ?>
                                <div class="btn-group">
                                    <div class="col-auto">
                                        <a href="actualizar_envios.php?id=<?php echo $array_clientes['id'];?>" class="btn btn-outline-success btn-sm">
                                            ACTUALIZAR
                                        </a>
                                    </div>
                                    <form method="POST" class="col-auto">
                                        <input type="hidden" name="id" value="<?php echo $array_clientes['id']; ?>">
                                        <input type="submit" class="btn btn-outline-danger btn-sm" value="BORRAR">
                                    </form>
                                    <div class="col-auto">
                                        <a href="guia.php?id=<?php echo $array_clientes['id']; ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-download fa-sm text-white-50"></i> Guia
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php 
    incluirTemplate('fottersis');     
?>