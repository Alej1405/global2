<?php 
    $filtro = $_POST['filtro'] ?? null;

    $guardar = $_GET['guardar'] ?? null;

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

    

    if ($filtro == 1) {

        

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //flujo de informacion desde la base de datos
                $id_primary = $_POST['id_primary'];
                $ubicacion_p = $_POST['direccion'];
                $responsable_m = $_POST['responsable_m'];
                $asesor = $_POST['asesor'];
            //datos del formulario
                $obervacion = $_POST['observacion_estado'];
                $estado = $_POST['status'];
                $fecha = date('y-m-d');
            //guardar historial de paquetes
                $historial_envios = "INSERT INTO historial_paquetes(id_primary, estado, responsable_m, ubicacion_p, observacion, res_ubp, fecha)
                                    VALUES('$id_primary',  '$estado', '$responsable_m', '$ubicacion_p', '$obervacion','$asesor', '$fecha');";
                    $guardar_historial = mysqli_query($db4, $historial_envios);
                    if($guardar_historial){
                        //actualizar en la base de datos de reportes
                        $actualizar = "UPDATE ordenes SET estado = '${estado}' WHERE guia = '$id_primary';";
                            $update = mysqli_query($db4, $actualizar);
                            if($update){
                                //enviar correo de notificacion primer MENSAJE 
                                $destinatario = 'mafer.fernandez@globalcargoecuador.com';
                                $asunto = 'NUEVA ENTREGA REALIZADA';
                                
                                // configuración del mensaje
                                    $header = "Un proceso a finalizado";
                                    $mensajeCompleto = "Hola Mafer, un nuevo envio se ha entregado,
                                                        por favor verificar en el sistema.";
                                    mail($destinatario, $asunto, $mensajeCompleto, $header);
                                    
                                    header('location: actualizacion.php?error=3');
                                exit;
                            }
                           
                    }
        }

    }else{

        //echo $filtro;
        exit;
    $query2 = "SELECT * FROM order_clients where order_id = ${id}";
            $resultado2 = mysqli_query($db3, $query2);

    $query = "SELECT * FROM orders where id = ${id}";
            $resultado = mysqli_query($db3, $query);
    
    $query9 = "SELECT * FROM datosordenes where id = ${id}";
            $resultado9 = mysqli_query($db4, $query9);
            $resultado99 = mysqli_fetch_assoc($resultado9);
            $suma_vistia = $resultado99['n_visitas'] + 1 ;

    // generar la fecha de cracion correcta
        $id_hist2 = "SELECT * FROM datosordenes WHERE id = ${id}";
        $cons_id2 = mysqli_query($db4, $id_hist2);
        $id_dispat2 = mysqli_fetch_assoc($cons_id2);
        $created_at = $id_dispat2['created_at'];
        //echo $created_at;
    //generar historial completo incluyendo comparamos si existe el id de despacho
    // si no existe, crear el despacho
        $id_hist = "SELECT * FROM dispatches WHERE order_id = ${id}";
        $cons_id = mysqli_query($db3, $id_hist);
        $id_dispat = mysqli_fetch_assoc($cons_id);
        if (empty($id_dispat)){
            //echo "la orden  no tiene despacho";
            //denifir varuables para la generacion del despacho
            $carrier_name = "NO ASIGNADO";
            $delivery_at = null;
            $transport_type = "LOGISTA GC";
            $observation = "En proceso";
            $deleted_at = null;
            $status = "collected"; // fecha capturada como parte del historial
            $fechaGest = date('y-m-d h:i:s'); // fecha capturada como parte del historial
            //insert para generar el despacho si, aun no esta generado
            $queryHIS = "INSERT INTO dispatches ( carrier_name, transport_type, status, observation, order_id, 
                        created_at, updated_at ) 
                        VALUES ('$carrier_name', '$transport_type', '$status', '$observation', '$id', 
                        '$created_at', '$fechaGest' )";
                        $hisrotial = mysqli_query($db3, $queryHIS);
        }
        //-- FIN DE LA ACTUALIZACION DE HISTORIAL--

        $errores = [];


            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                
                        //CONSULTA DE ID DE DESPACHO, COHERENCIA DE HISTORIAL
                        $id_hist = "SELECT * FROM dispatches WHERE order_id = ${id}";
                        $cons_id = mysqli_query($db3, $id_hist);
                        $id_dispat = mysqli_fetch_assoc($cons_id);
                        $dispatch_id = $id_dispat['id'];

                    //datos consumo de API order_clients
                    $status = mysqli_real_escape_string($db3, $_POST['status']);
                    $n_visitas = $suma_vistia; //$_POST['n_visitas'];
                    $observ_estado = mysqli_real_escape_string($db3, $_POST['observacion_estado']);
                    //datos para el cambio en la verificacion
                    $contactado = $id;
                    $facturado = null;
                    $filtro = "no";
                    $fechaGest = date('y-m-d h:i:s');
                    //id de despacho para actualizacion
                    $seg_despacho = $id_dispat['id'];
                    //resonsable de la actualizacion
                    $usuario_act = $_SESSION['usuario']; //base de datos sitema
                    $id_historial = 5;
                    //asignar transporte especifico
                    $carrier_name = "motorizado GC";
                    //fecha de creacion
                    $created_at = $id_dispat2['created_at'];
                    

                    if(!$status) {
                        $errores[] = "No hay un estado registrado no se puede guardar, haz bien!!!!";
                        header('location: actualizacion.php?error=1');
                    }
                    if(!$observ_estado) {
                        $errores[] = "Justifica por que, cambio a ese estado, pero sintetiza no cuentes historias!!";
                        header('location: actualizacion.php?error=2');
                    }
                    if(empty($errores)) {


                        switch ($status){
                            case "delivered":
                                //ACTUALIZACION EN API
                                    $query4 = "UPDATE orders SET    status = '${status}', 
                                                                    delivery_at = '${fechaGest}', 
                                                                    updated_at = '${fechaGest}' 
                                                                    where id=${id}";
                                    $resultado1 = mysqli_query($db3, $query4);
                                //ACTUALIZACION BDD DE SISTEMA
                                    $query3 = "UPDATE datosordenes SET  status = '${status}', 
                                                                        delivery_at = '${fechaGest}', 
                                                                        observacion_estado = '${observ_estado}', 
                                                                        fechaGest = '${fechaGest}', 
                                                                        n_visitas = '${n_visitas}',
                                                                        gestion_user = '${id_historial}'  
                                                                        where id=${id}";
                                    $resultado2 = mysqli_query($db4, $query3);
                                //ACTUALIZACION HISTORIAL DESPACHOS 
                                    $query3 = "UPDATE dispatches SET  status = '${status}', 
                                                                        carrier_name = '${carrier_name}',
                                                                        delivery_at = '${fechaGest}',
                                                                        updated_at = '${fechaGest}', 
                                                                        observation = '${observ_estado}'  
                                                                        where order_id=${id}";
                                    $resultado4 = mysqli_query($db3, $query3);
                                //GUARDAR DATOS DEL HISTORIAL 
                                    $queryHIS = "INSERT INTO dispatch_statuses ( status, comment, dispatch_id, user_id, created_at, updated_at ) 
                                                                VALUES ('$status', '$observ_estado', '$dispatch_id', '5', '$created_at', '$fechaGest')";
                                    $guardar_his = mysqli_query($db3, $queryHIS);
                                    //echo $guardar_his;
                                
                                //RETURN DE PROCESO
                                    if ($guardar_his){
                                        // echo '<div class="alert alert-success">
                                        //             <a href="seguimiento.php">Actualizar mas ordenes</a>
                                        //         </div>';
                                        header('location: actualizacion.php?error=3');
                                        exit();
                                    }
                            break;

                            case "returnes":
                                //ACTUALIZACION EN API
                                    $query4 = "UPDATE orders SET    status = '${status}', 
                                                                    updated_at = '${fechaGest}' 
                                                                    where id=${id}";
                                    $resultado1 = mysqli_query($db3, $query4);
                                //ACTUALIZACION BDD DE SISTEMA
                                    $query3 = "UPDATE datosordenes SET  status = '${status}', 
                                                                        observacion_estado = '${observ_estado}', 
                                                                        fechaGest = '${fechaGest}', 
                                                                        n_visitas = '${n_visitas}',
                                                                        gestion_user = '${id_historial}'   
                                                                        where id=${id}";
                                    $resultado2 = mysqli_query($db4, $query3);
                                //ACTUALIZACION HISTORIAL DESPACHOS 
                                    $query3 = "UPDATE dispatches SET  status = '${status}', 
                                                                        carrier_name = '${carrier_name}',
                                                                        updated_at = '${fechaGest}', 
                                                                        observation = '${observ_estado}'  
                                                                        where order_id=${id}";
                                    $resultado2 = mysqli_query($db3, $query3);
                                //GUARDAR DATOS DEL HISTORIAL 
                                    $queryHIS = "INSERT INTO dispatch_statuses ( status, comment, dispatch_id, user_id, created_at, updated_at ) 
                                                                VALUES ('$status', '$observ_estado', '$dispatch_id', '$id_historial', '$created_at', '$fechaGest')";
                                    $guardar_his = mysqli_query($db3, $queryHIS);
                                //RETURN DE PROCESO
                                    if ($guardar_his){
                                        // echo '<div class="alert alert-success">
                                        //         <a href="seguimiento.php">Actualizar mas ordenes</a>
                                        //     </div>';
                                        header('location: actualizacion.php?error=3');
                                        exit();
                                    }
                            break;

                            case "undelivered":
                                //ACTUALIZACION EN API
                                    $query4 = "UPDATE orders SET    status = '${status}', 
                                                                    updated_at = '${fechaGest}' 
                                                                    where id=${id}";
                                    $resultado1 = mysqli_query($db3, $query4);
                                //ACTUALIZACION BDD DE SISTEMA
                                    $query3 = "UPDATE datosordenes SET  status = '${status}', 
                                                                        observacion_estado = '${observ_estado}', 
                                                                        fechaGest = '${fechaGest}', 
                                                                        n_visitas = '${n_visitas}',
                                                                        gestion_user = '${id_historial}'  
                                                                        where id=${id}";
                                    $resultado2 = mysqli_query($db4, $query3);
                                //ACTUALIZACION HISTORIAL DESPACHOS 
                                    $query3 = "UPDATE dispatches SET  status = '${status}', 
                                                                        carrier_name = '${carrier_name}',
                                                                        updated_at = '${fechaGest}', 
                                                                        observation = '${observ_estado}'  
                                                                        where order_id=${id}";
                                    $resultado2 = mysqli_query($db3, $query3);
                                //GUARDAR DATOS DEL HISTORIAL 
                                    $queryHIS = "INSERT INTO dispatch_statuses ( status, comment, dispatch_id, user_id, created_at, updated_at ) 
                                                                VALUES ('$status', '$observ_estado', '$dispatch_id', '$id_historial', '$created_at', '$fechaGest')";
                                    $guardar_his = mysqli_query($db3, $queryHIS);
                                //RETURN DE PROCESO
                                if ($guardar_his){
                                    // echo '  <div class="alert alert-success">
                                    //             <a href="seguimiento.php">Actualizar mas ordenes</a>
                                    //         </div>';
                                    header('location: actualizacion.php?error=3');
                                    exit();
                                }
                            break;
                        }
                    }
                }
            }

?>