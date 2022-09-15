<?php 
    //incluye el header
    require '../../includes/funciones.php';
    $auth = estaAutenticado();
    
    if (!$auth) {
        header('location: index.php');
    }

    require '../../includes/config/database.php';

    //coneccion api
    conectarDB3();
    $db3 =conectarDB3();
    
    //coneccion callcenter
    conectarDB4();
    $db4 =conectarDB4();

     //ARRAY DE ERRORES PARA LA ALERTAS
        $errores = [];
        $usuario = $_SESSION['usuario'];
        $tipo_as = $_SESSION['rol'];
    
    //consulta de datos ordenes recibidas
        $consulta_ordenes = "SELECT * FROM orders WHERE status = 'requested' order by created_at desc;";
        $eje_ordenes = mysqli_query($db3, $consulta_ordenes);

?>
        <table class="table table-hover">
            <thead hidden>
                <tr>
                    <th>CONSIGNATARIO</th>
                    <th>DETINARIO</th>
                    <th>FECHA DE SOLICITUD</th>
                    <th>CONTACTOS</th>
                    <th>CIUDAD / PROVINCIA</th>
                    <th>ASESOR</th>
                    <th>ESTADO</th>
                    <th>TARIFA APLICADA</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php while($array_clientes = mysqli_fetch_assoc($eje_ordenes)):?>
                    <tr>
                        <td>
                            Smart Cosmetics
                        </td>
                        <td>
                            <?php
                                //Consulta de datos del destinatario
                                $consulta_destinatario = $array_clientes['id'];
                                $consulta ="SELECT * FROM order_clients WHERE order_id = $consulta_destinatario;";
                                $ejec_consulta = mysqli_query($db3, $consulta);
                                $rest = mysqli_fetch_assoc($ejec_consulta);
                                echo $rest['name']." ".$rest['last_name']; 
                            ?>
                        </td>
                        <td><?php echo $array_clientes['created_at']; ?></td>
                        <td>
                            <?php
                                //Consulta de datos del contactos
                                $consulta_destinatario = $array_clientes['id'];
                                $consulta ="SELECT * FROM order_clients WHERE order_id = $consulta_destinatario;";
                                $ejec_consulta = mysqli_query($db3, $consulta);
                                $rest = mysqli_fetch_assoc($ejec_consulta);
                                echo $rest['phone']." / ".$rest['landline'];  
                            ?></td>
                        <td>
                            <?php
                            //buscar provincia y ciudad
                            $consulta_destinatario = $array_clientes['id'];
                            $consulta ="SELECT * FROM order_clients WHERE order_id = $consulta_destinatario;";
                            $ejec_consulta = mysqli_query($db3, $consulta);
                            $rest = mysqli_fetch_assoc($ejec_consulta);
                            echo $rest['city']." / ".$rest['province'];
                            ?></td>
                        <td>
                            CLIENTE GENERAL GC-GO
                        </td>
                        <td><?php echo $array_clientes['status']; ?></td>
                        <td><?php echo "Estandar"; ?></td>
                        <td>
                            <?php if ($tipo_as === 'motorizado'): ?>
                                    <div class="col-auto">
                                        <a href="guia.php?id=<?php echo $array_clientes['id']; ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-download fa-sm text-white-50"></i> Guia
                                        </a>
                                    </div>
                            <?php elseif ($tipo_as === 'coordinacionP'): ?>
                                <div class="btn-group">
                                    <div class="col-auto">
                                        <a href="guia.php?id=<?php echo $array_clientes['id']; ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-download fa-sm text-white-50"></i> Guia
                                        </a>
                                    </div>
                            <?php elseif ($tipo_as === 'gerencia_paqueteria'): ?>
                                <div class="btn-group">
                                    <div class="col-auto">
                                        <a href="guia.php?id=<?php echo $array_clientes['id']; ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-download fa-sm text-white-50"></i> Guia
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <a href="actualizar_envios.php?id=<?php echo $array_clientes['id'];?>" class="btn btn-outline-success btn-sm">
                                            ACTUALIZAR
                                        </a>
                                    </div>
                                    <form method="POST" class="col-auto">
                                        <input type="hidden" name="id" value="<?php echo $array_clientes['id']; ?>">
                                        <input type="submit" class="btn btn-outline-danger btn-sm" value="BORRAR">
                                    </form>
                            <?php elseif ($tipo_as === 'asesor'): ?>
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
    if ($tipo_as == 'asesor'){
        incluirTemplate('fottersis');
    }     
?>