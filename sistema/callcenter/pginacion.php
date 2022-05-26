<?php
    
    $pagina = $_GET['pagina'] ?? null;

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis2');
    //coneccion de sesion
    conectarDB();
    $db =conectarDB();

    //coneccion api
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
    // seleccion de todos los campos de la base de datos 
    $query = "SELECT * FROM order_clients ORDER BY created_at DESC; ";

            $resultado = mysqli_query($db3, $query);
    // ---inicio de paginacion de ordenes---//
    $n_orden = 50;

    //contar ordenes de la base de datos
    $t_ordenes = "SELECT COUNT(order_id)  FROM orders;";
    $tOrdenes = mysqli_query($db3, $t_ordenes);
    $ordenes = mysqli_fetch_assoc($tOrdenes);
    $n_ordenes = $ordenes["COUNT(order_id)"];
    
    //crear el numero de paginas 
    $paginas = $n_ordenes / 50;
    $paginas2 = ceil($paginas);
?>

<center><h1 class="titulo__pagina">RECEPCION GENERAL DE ORDENES NACIONALES</h1></center>


<div class="botones-fin">
    <div class="enlace--boton salir">
        <a href="../callcenterAdmin.php" class="enlace">REGRESAR AL INICIO</a>
    </div>
    <div class="enlace--boton lectura">
        <a href="callcenter/datosmanual.php" class="enlace">CIERTOS DATOS GENERALES</a>
    </div>
    <div class="enlace--boton lectura">
        <a href="segundallamada.php" class="enlace">
            <?php
            $seg = "SELECT COUNT(estado)  FROM datosordenes WHERE estado = 'sinPago';";
            $segCot = mysqli_query($db4, $seg);
            $total = mysqli_fetch_assoc($segCot);
            ?>
            REGISTROS SEGUNDA <?php echo $total["COUNT(estado)"]?></a>
        </div>
</div>

            <ul class="pagination">
                <li>
                    <a href="ordenesgenerales.php?pagina=<?php echo $_GET['pagina']-1; ?>" >
                            Anterior
                    </a>
                </li>

                <?php for($i=0; $i<$paginas2; $i++): ?>
                    <li><a href="ordenesgenerales.php?pagina=<?php echo $i+1; ?>"><?php echo $i+1; ?></a></li>
                <?php endfor ?>

                <li><a href="ordenesgenerales.php?pagina=<?php echo $_GET['pagina']+1; ?>">siguiente</a></li>
            </ul>



<fieldset class="form2 consulta__tabla fijar">
    <legend>ORDENES RECIBIDAS </legend>
    <div class="tabla_scroll">
        <?php 
            $iniciar = ($_GET['pagina']-1) * 50;
            $ciudad = '';
            $query = "SELECT * FROM order_clients ${ciudad} ORDER BY id DESC LIMIT ${iniciar}, ${n_orden} ;";
            $resultado = mysqli_query($db3, $query);
        ?>
        <table class="tabla_scroll" >
            <div>
                <p>
                    <?php 
                        $ciudad 
                    ?>
                </p>
            </div>
            <thead>
                <tr>
                    <th class="inmivilizar">Nombre</th>
                    <th class="inmivilizar">Apellido</th>
                    <th class="inmivilizar">Telefono</th>
                    <th class="inmivilizar">Ciudad</th>
                    <th class="inmivilizar">Numero de orden</th>
                    <th class="inmivilizar">Estado de Operacion</th>
                    <th class="inmivilizar">Contactar</th>
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
                        <td style="<?php if($verfi == "CONTACTO VERIFICADO"){
                            echo "background: grey";
                            }; ?>"><?php echo $resultadoApi['name']; ?></td>
                        <td style="<?php if($verfi == "CONTACTO VERIFICADO"){
                            echo "background: grey";
                            }; ?>"><?php echo $resultadoApi['last_name']; ?></td>
                        <td style="<?php if($verfi == "CONTACTO VERIFICADO"){
                            echo "background: grey";
                            }; ?>"><?php echo $resultadoApi['phone']; ?></td>
                        <td style="<?php if($verfi == "CONTACTO VERIFICADO"){
                            echo "background: grey";
                            }; ?>"><?php echo $resultadoApi['city']; ?></td>
                        <td style="<?php if($verfi == "CONTACTO VERIFICADO"){
                            echo "background: grey"; $hidden= "ocultar";
                            }else{ $hidden= "accion__actualizar"; }; ?>"><?php echo $resultadoApi['order_id']; ?></td>
                        
                        <td style="<?php if($verfi == "CONTACTO VERIFICADO"){
                            echo "background: grey";
                            }; ?>"><?php echo $verfi; ?></td>
                        <td>
                            <?php if($verfi == "POR CONTACTAR"):?>
                            <div class="accion__actualizar" >
                                <a  href="callcenter/actualizacion.php?id=<?php echo $resultadoApi['id']; ?>" class="acciones__enlace">CONTACTAR</a>
                            </div>
                            <?php endif; ?> 
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</fieldset>
