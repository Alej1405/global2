<?php 
    $mensaje = $_GET['resultado'] ?? null; 

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    //coneccion de sesion
    conectarDB();
    $db =conectarDB();

    //BASE DE DATOS BODEGA 
    conectarDB2();
    $db2 =conectarDB2();

    //coneccion callcenter
    conectarDB3();
    $db3 =conectarDB3();

    //coneccion callcenter
    conectarDB4();
    $db4 =conectarDB4();

    $auth = estaAutenticado();

    // proteger la página
    if (!$auth) {
        header('location: index.php');
    }

    //consulta general de datos para facturar 
    $query = "SELECT * FROM datosordenes ORDER BY created_at DESC";
    $resultado = mysqli_query($db4, $query);
    
    
?>

<fieldset class="form2 consulta__tabla">
    <legend>PRE-ORDEN DE DESPACHO</legend>
    <table class="form2 consulta__tabla" >
        <thead>
            <tr>
                <th>F Creacion</th>
                <th>Número de Orden</th>
                <th>Nombre</th>
                <th>Teleonos</th>
                <th>Provincia</th>
                <th>Ciudad</th>
                <th>Direccion de la Orden</th>
                <th>Direccion confirmada</th>
                <th>Referencia</th>
                <th>Estado</th>
                <th>Observaciones</th>
                <th>Total</th>
                <th>Forma de Pago</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php while($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <?php 
                        $idver = $resultadoApi['id'];
                        $verQuery = "SELECT id from preordenes WHERE preordenes.id = ${idver};";
                        $ejec = mysqli_query($db2, $verQuery);
                        $ejec2 = mysqli_fetch_assoc($ejec);
                        if(!$ejec2){
                            $verfi = "POR ALISTAR";
                            
                        }else{
                            $verfi = "ORDEN LISTA";
                        }
                    ?>
                    <td style="<?php if($verfi == "ORDEN LISTA"){
                        echo "background: grey";
                        }; ?>"><?php echo $resultadoApi['created_at']; ?></td>
                    <td style="<?php if($verfi == "ORDEN LISTA"){
                        echo "background: grey";
                        }; ?>"><?php echo $resultadoApi['order_id']; ?></td>
                    <td style="<?php if($verfi == "ORDEN LISTA"){
                        echo "background: grey";
                        }; ?>"><?php echo $resultadoApi['name'] . " ". $resultadoApi['last_name']. " " . $resultadoApi['nombres']; ?></td>
                    <td style="<?php if($verfi == "ORDEN LISTA"){
                        echo "background: grey"; $hidden= "telefono";
                        }else{ $hidden= "accion__actualizar"; }; ?>"><?php echo $resultadoApi['phone']."/".$resultadoApi['telefono']; ?></td>
                    <td style="<?php if($verfi == "ORDEN LISTA"){
                        echo "background: grey"; $hidden= "telefono";
                        }else{ $hidden= "accion__actualizar"; }; ?>"><?php echo $resultadoApi['province']; ?></td>
                    <td style="<?php if($verfi == "ORDEN LISTA"){
                        echo "background: grey"; $hidden= "telefono";
                        }else{ $hidden= "accion__actualizar"; }; ?>"><?php echo $resultadoApi['city']; ?></td>
                    <td style="<?php if($verfi == "ORDEN LISTA"){
                        echo "background: grey"; $hidden= "telefono";
                        }else{ $hidden= "accion__actualizar"; }; ?>"><?php echo $resultadoApi['address']; ?></td>
                    <td style="<?php if($verfi == "ORDEN LISTA"){
                        echo "background: grey"; $hidden= "telefono";
                        }else{ $hidden= "accion__actualizar"; }; ?>"><?php echo $resultadoApi['direccion']; ?></td>
                    <td style="<?php if($verfi == "ORDEN LISTA"){
                        echo "background: grey"; $hidden= "telefono";
                        }else{ $hidden= "accion__actualizar"; }; ?>"><?php echo $resultadoApi['reference']; ?></td>
                    <td style="<?php if($verfi == "ORDEN LISTA"){
                        echo "background: grey";
                        }; ?>"><?php echo $verfi;?></td>
                    <td style="<?php if($verfi == "ORDEN LISTA"){
                        echo "background: grey"; $hidden= "telefono";
                        }else{ $hidden= "accion__actualizar"; }; ?>"><?php echo $resultadoApi['observacion']; ?></td>
                    <td style="<?php if($verfi == "ORDEN LISTA"){
                        echo "background: grey"; $hidden= "telefono";
                        }else{ $hidden= "accion__actualizar"; }; ?>"><?php echo $resultadoApi['total']; ?></td>
                    <td style="<?php if($verfi == "ORDEN LISTA"){
                        echo "background: grey"; $hidden= "telefono";
                        }else{ $hidden= "accion__actualizar"; }; ?>"><?php echo $resultadoApi['metodoPago']; ?></td>
                    <td>
                        <?php if($verfi == "POR ALISTAR"): ?>
                            <div class="accion__actualizar" >
                                <a  href="bodega/generarPreorden.php?id=<?php echo $resultadoApi['id']; ?>" class="acciones__enlace"> VER DETALLE</a>
                            </div>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>

                        
                    