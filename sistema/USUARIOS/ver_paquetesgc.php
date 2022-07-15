<?php 

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
            $consulta_clientes = "SELECT * FROM ordenes";
            $eje_clientes = mysqli_query($db4, $consulta_clientes);

?>
<body class="bg-gradient-primary">
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>CONSIGNATARIO</th>
                    <th>CEDULA / RUC</th>
                    <th>CONTACTOS</th>
                    <th>PROVINCIA</th>
                    <th>CIUDAD</th>
                    <th>CORREO</th>
                    <th>COD</th>
                    <th>ESTADO</th>
                </tr>
            </thead>
            <tbody>
                <?php while($array_clientes = mysqli_fetch_assoc($eje_clientes)):?>
                    <tr>
                        <td><?php echo $array_clientes['nombre']." ".$array_clientes['apellido']; ?></td>
                        <td><?php echo $array_clientes['cedula']; ?></td>
                        <td><?php echo $array_clientes['telefono']; ?></td>
                        <td><?php echo $array_clientes['provincia']; ?></td>
                        <td><?php echo $array_clientes['ciudad']; ?></td>
                        <td><?php echo $array_clientes['correo']; ?></td>
                        <td><?php echo $array_clientes['cod']; ?></td>
                        <td><?php echo $array_clientes['estado']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php 
    incluirTemplate('fottersis');     
?>