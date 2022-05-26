<?php 
    $resultado = $_GET['resultado'] ?? null; 

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
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
         header('location: ../index.php');
    }

    //asigancion de ordenes para facturacion 
    //  VARIABLE PARA USUARIO 'CAMILA NUMEROS PARES'


            // switch ($_SESSION['usuario']){
            //             case "camila@globalcargoecuador.com":

            //                  $query = "SELECT * FROM order_clients WHERE mod(id,2) = 0 ORDER BY created_at DESC; ";
            //                         $resultado = mysqli_query($db3, $query);
            //                         $resultadoApi = mysqli_fetch_assoc($resultado);

            //                         echo 'si vale';
            //                 break;
            //         }


    $query = "SELECT * FROM order_clients ORDER BY created_at DESC; ";

            $resultado = mysqli_query($db3, $query);
            $resultadoApi = mysqli_fetch_assoc($resultado)
?>






<fieldset class="form2 consulta__tabla">
    <legend>ORDENES RECIBIDAS </legend>

    <div class="botones-fin">
        <div class="enlace--boton salir">
            <a href="callcenterAdmin.php" class="enlace">REGRESAR AL INICIO</a>
        </div>
        <div class="enlace--boton lectura">
            <a href="callcenter/datosmanual.php" class="enlace">CIERTOS DATOS GENERALES</a>
        </div>
    </div>
    <table class="form2 consulta__tabla" >
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Telefono</th>
                <th>Ciudad</th>
                <th>Numero de orden</th>
                <th>Estado de Operacion</th>
                <th>Contactar</th>
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
                            <a  href="actualizacion.php?id=<?php echo $resultadoApi['id']; ?>" class="acciones__enlace">CONTACTAR</a>
                        </div>
                        <?php endif; ?> 
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>
