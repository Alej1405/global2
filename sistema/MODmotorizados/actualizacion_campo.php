<?php 
    //$id = $_GET['id'];
    //$id = filter_var($id, FILTER_VALIDATE_INT);

    //incluye el header
    require '../../includes/funciones.php';

    require '../../includes/config/database.php';
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

    $errores = [];
    $buscar = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $buscar = $_POST['orden'];
        if (empty($buscar)){
            header('location: actualizacion.php?error=5');
            exit();
        }
    } 
        $filtro_base = "SELECT * FROM orders WHERE order_id = '${buscar}';";
        $resultado_base = mysqli_query($db3, $filtro_base);
        $resultado_base_group = mysqli_fetch_assoc($resultado_base);

        //condional maestra para el filtro de tablas
        if ($resultado_base_group == null){
            
            $validacion = 'gc';


            $query2 = "SELECT * FROM ordenes where guia = '${buscar}'";
            $resultado2 = mysqli_query($db4, $query2);
            $resultado2_group2 = mysqli_fetch_assoc($resultado2);
            $nombre = $resultado2_group2['nombre'];
            


            // validacion con variable aleatoria
            $reporte = 1;
        }else{
            //esto es rusia 
            //bloqueo de ordenes para delivered y returnes
            $queryBloq = "SELECT * FROM orders where order_id = ${buscar}";
            $r_bloq = mysqli_query($db3, $queryBloq);
            $bloq = mysqli_fetch_assoc($r_bloq);

            $validacion = 'cos';

                if ($bloq['status'] == "delivered") {
                    header('location: actualizacion.php?error=4');
                }

                if ($bloq['status'] == "returnes") {
                    header('location: actualizacion.php?error=4');
                }
                //fin de bloqueo de ordenes, segmento de condiciones.

                //informacion del cliente, busacar el order_id en la tabla orders

                $query = "SELECT * FROM orders where order_id = ${buscar}";
                $resultado = mysqli_query($db3, $query);
                $cliente = mysqli_fetch_assoc($resultado);
                $cliente_id = $cliente['id'];
                $cliente_name = $cliente['order_id'];

                $query2 = "SELECT * FROM order_clients  where order_id = ${cliente_id}";
                $resul = mysqli_query($db3, $query2);
                ;

                $reporte = 2;
        }

?>

<!-- inicio de formulario de actualizacion -busqueda de ordenes- -->
    <!DOCTYPE html>
        <html lang="en">

        <head>

            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="">
            <meta name="author" content="">

            <title>GLOBAL CARGO SYS</title>

            <!-- Custom fonts for this template-->
            <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
            <link
                href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
                rel="stylesheet">

            <!-- Custom styles for this template-->
            <link href="../../css2/sb-admin-2.min.css" rel="stylesheet">

        </head>
<!-- fin de inicio de formulario de actualizacion -busqueda de ordenes- -->
<!-- consulta de informacion de la orden -->
<?php if ($reporte == 1): //esto es gc-go?>
<body class="bg-gradient-primary">
    <div class="container">
    <br>
        <h2>Vas a reportar</h2>
        <strong>Orden: </strong> <?php echo $nombre; ?>
        <br>
        <br>
        <?php
        $query20 = "SELECT * FROM ordenes where guia = '${buscar}'";
        $resultado20 = mysqli_query($db4, $query20); 
        while($resultado2_group = mysqli_fetch_assoc($resultado20)): ?>
            <lu class="list-grouplist-group">
                <li class="list-group-item"><strong>Nombre: </strong><?php echo $resultado2_group['nombre']; ?></li>
                <li class="list-group-item">
                    <strong>Valor a Cobrar:</strong>
                    <?php echo "$".$resultado2_group['valor'];?>
                </li>
                <li class="list-group-item">
                    <strong>Estado Actual:</strong>
                    <?php echo $resultado2_group['estado'];?>
                </li>
            </lu>
        <?php endwhile; ?>
        <form action="acEstado.php" method="post">
            <input type="text" name="guia" value="<?php echo $buscar; ?>" hidden id="">
            <select name="estado" id="">
                <option value="delivered">Entregado</option>
                <option value="undelivered">No entregado</option>
            </select>
            <input type="text" name="comentario" id="">
            <input type="submit" value="ok">
        </form>
    </div>
<?php else: //esto es por API?>
<body class="bg-gradient-light">
    <div class="container">
        <br>
        <h2>Vas a reportar</h2>
        <strong>Orden: </strong> <?php echo $cliente_name; ?>
        <br>
        <br>
        <?php while($resultado2 = mysqli_fetch_assoc($resul)): ?>
            <lu class="list-grouplist-group">
                <li class="list-group-item"><strong>Nombre: </strong><?php echo $resultado2['name']." ".$resultado2['last_name']; ?></li>
                <li class="list-group-item">
                    <strong>Valor a Cobrar:</strong>
                    <?php 
                    $query = "SELECT * FROM orders where order_id = ${buscar}";
                    $resultado = mysqli_query($db3, $query);
                    $cliente = mysqli_fetch_assoc($resultado);
                    $total = $cliente['total'] / 100;
                    $cobrar = number_format($total, 2, ',', '.');
                    echo $cobrar;
                    ?>
                </li>
                <li class="list-group-item">
                    <strong>Estado Actual:</strong>
                    <?php 
                    $query = "SELECT * FROM orders where order_id = ${buscar}";
                    $resultado = mysqli_query($db3, $query);
                    $cliente = mysqli_fetch_assoc($resultado);
                    echo $cliente['status'];
                    ?>
                </li>
            </lu>
        <?php endwhile; ?>
        <form action="acEstado.php" method="post">
            <input type="text" name="order_id" value="<?php echo $cliente_name; ?>" hidden id="">
            <input type="text" name="id" value="<?php echo $cliente_id; ?>" hidden id="">
            <input type="text" name="validacion" value = "<?php echo $validacion ;?>" hidden id="">
            <select name="estado" id="">
                <option value="delivered">Entregado</option>
                <option value="undelivered">No entregado</option>
            </select>
            <input type="text" name="comentario" id="">
            <input type="submit" value="ok">
        </form>
    </div>
<?php endif; ?>