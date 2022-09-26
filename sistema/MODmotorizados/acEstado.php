<?php 
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

    $order_id = "";
    $validacion = "";
    $id = "";
    $estado = "";
    $observacion = "";

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $order_id = $_POST['order_id'] ?? null;
        $validacion = $_POST['validacion'] ?? null;
        $id = $_POST['id'] ?? null;
        date_default_timezone_set("America/Bogota");
        date_default_timezone_get();
        $fecha_update = date("Y-m-d G:i:s");
        $id_guia = $_POST['guia'] ?? null;
        

        //desde el formulario
        $estado = $_POST['estado'];
        $observacion = $_POST['comentario'];

            if ($validacion == 'cos') {

            switch ($estado){
                case "delivered":
                    //actulizacion de estado en la tabla orders
                        $query = "UPDATE orders SET       status = 'delivered',
                                                    delivery_at = '${fecha_update}',
                                                      updated_at = '${fecha_update}'                
                                                        WHERE id = '${id}';";
                        $resultado = mysqli_query($db3, $query);
                    
                    //actulizacion de estado en la tabla dispatches
                        $query2 = "UPDATE dispatches SET      status = 'delivered',
                                                        delivery_at = '${fecha_update}',
                                                          updated_at = '${fecha_update}',
                                                         observation = 'Entrega exitosa'                
                                                      WHERE order_id = '${id}';";
                        $resultado2 = mysqli_query($db3, $query2);

                    //consultar el numero de despacho
                        $query3 = "SELECT * FROM dispatches WHERE order_id = '${id}'";
                        $resultado3 = mysqli_query($db3, $query3);
                        $dispatch = mysqli_fetch_assoc($resultado3);
                        $dispatch_id = $dispatch['id'];
                        $created_at = $dispatch['created_at'];

                    //crear historial de despacho
                        $query4 = "INSERT INTO dispatch_statuses (status, comment, dispatch_id, user_id, created_at, updated_at, deleted_at) 
                                                           VALUES ('delivered', 'Entrega exitosa', '${dispatch_id}', '4', '${created_at}', '${fecha_update}', null);";
                        $resultado4 = mysqli_query($db3, $query4);
                        if ($resultado4) {
                            echo "<script>
                                    alert('Genial!! ya esta reportado sigue asi!!!');
                                    window.location.href='actualizacion.php';
                                </script>";
                        } else {
                            echo "
                                        <div class='alert alert-danger' role='alert'>
                                            <strong>Error!</strong> 
                                            No te asignaste nada, registra bien!!!!
                                        </div>";
                            exit;
                        }
                    break;
                case "undelivered":
                    //actulizacion de estado en la tabla orders
                        $query = "UPDATE orders SET       status = 'undelivered',
                                                      updated_at = '${fecha_update}'                
                                                        WHERE id = '${id}';";
                        $resultado = mysqli_query($db3, $query);

                            //actulizacion de estado en la tabla dispatches
                            $query2 = "UPDATE dispatches SET      status = 'undelivered',
                                                            updated_at = '${fecha_update}',
                                                            observation = '${observacion}'                
                                                        WHERE order_id = '${id}';";
                            $resultado2 = mysqli_query($db3, $query2);

                            //consultar el numero de despacho
                            $query3 = "SELECT * FROM dispatches WHERE order_id = '${id}'";
                            $resultado3 = mysqli_query($db3, $query3);
                            $dispatch = mysqli_fetch_assoc($resultado3);
                            $dispatch_id = $dispatch['id'];
                            $created_at = $dispatch['created_at'];

                            //crear historial de despacho
                            $query4 = "INSERT INTO dispatch_statuses (status, comment, dispatch_id, user_id, created_at, updated_at, deleted_at) 
                                                    VALUES ('undelivered', '${observacion}', '${dispatch_id}', '4', '${created_at}', '${fecha_update}', null);";
                            $resultado4 = mysqli_query($db3, $query4);
                    if ($resultado4) {
                        echo "<script>
                                alert('Genial!! ya esta reportado sigue asi!!!');
                                window.location.href='actualizacion.php';
                            </script>";
                    } else {
                        echo "
                                    <div class='alert alert-danger' role='alert'>
                                        <strong>Error!</strong> 
                                        No te asignaste nada, registra bien!!!!
                                    </div>";
                        exit;
                    }
                    break;
            }
            }else{

                //actualizar ordenes general
                $query = "UPDATE ordenes SET       estado = '${estado}',
                                     fecha_actualizacion = '${fecha_update}'                   
                                              WHERE guia = '${id_guia}';";
                $resultado = mysqli_query($db4, $query); 
                if ($resultado) {
                    echo "<script>
                            alert('Genial!! ya esta reportado sigue asi!!!');
                            window.location.href='actualizacion.php';
                        </script>";
                } else {
                    echo "
                                <div class='alert alert-danger' role='alert'>
                                    <strong>Error!</strong> 
                                    No te asignaste nada, registra bien!!!!
                                </div>";
                    exit;
                }
                
            }
    }     

?>