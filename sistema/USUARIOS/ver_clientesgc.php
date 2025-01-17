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
            $consulta_clientes = "SELECT * FROM clientes";
            $eje_clientes = mysqli_query($db4, $consulta_clientes);
        }else{
            $consulta_clientes = "SELECT * FROM clientes WHERE vendedor = '${nombre_ase}'";
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
                $query = "DELETE FROM clientes WHERE id = ${id}"; 
                $resultado = mysqli_query($db4, $query);
                if ($resultado) {
                }
            }

?>
<body class="bg-gradient-primary">
    <h1><?php echo $nombre_ase; ?></h1>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>CEDULA / RUC</th>
                    <th>CONTACTOS</th>
                    <th>ASESOR</th>
                    <th>CORREO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php while($array_clientes = mysqli_fetch_assoc($eje_clientes)):?>
                    <tr>
                        <td><?php echo $array_clientes['nombre']." ".$array_clientes['apellido']; ?></td>
                        <td><?php echo $array_clientes['cedula']; ?></td>
                        <td><?php echo $array_clientes['telefono1']." ".$array_clientes['telefono2']; ?></td>
                        <td><?php echo $array_clientes['vendedor']; ?></td>
                        <td><?php echo $array_clientes['correo']; ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="actualizar_cliente.php?cedula=<?php echo $array_clientes['cedula'];?>" class="btn btn-outline-success btn-sm">ACTUALIZAR</a>
                                <form method="POST">
                                    <input type="hidden" name="id" value="<?php echo $array_clientes['id']; ?>">
                                    <input type="submit" class="btn btn-outline-danger btn-sm" value="BORRAR">
                                </form>
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