<?php 
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    $guardar = $_GET['guardar'] ?? null;

    //incluye el header
    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if (!$auth) {
        header('location: index.php');
    }

    require '../../includes/config/database.php';
    incluirTemplate('headersis2');
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

    // proteger la página
    if (!$auth) {
        header('location: index.php');
    }
   
    
    $query9 = "SELECT * FROM datosordenes where id = ${id}";
            $resultado9 = mysqli_query($db4, $query9);

    $errores = [];


            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                    //CONSULTA DE ID DE DESPACHO, COHERENCIA DE HISTORIAL
                    $id_hist = "SELECT * FROM dispatches WHERE order_id = ${id}";
                    $cons_id = mysqli_query($db3, $id_hist);
                    $id_dispat = mysqli_fetch_assoc($cons_id);
                    $dispatch_id = $id_dispat['id'];

                //datos consumo de API order_clients
                $status = mysqli_real_escape_string($db3, $_POST['status']);
                $n_visitas = $_POST['n_visitas'];
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
                }
                if(!$observ_estado) {
                    $errores[] = "Justifica por que, cambio a ese estado, pero sintetiza no cuentes historias!!";
                }
                if(!$n_visitas) {
                    $errores[] = "Agrega un numero de visita, pero de forma coherente!!";
                }
                if(empty($errores)) {


                    switch ($status){
                        case "delivered":
                            //ACTUALIZACION BDD DE SISTEMA
                                $query3 = "UPDATE datosordenes SET  status = '${status}', 
                                                                    delivery_at = '${fechaGest}', 
                                                                    observacion_estado = '${observ_estado}', 
                                                                    fechaGest = '${fechaGest}', 
                                                                    n_visitas = '${n_visitas}',
                                                                    gestion_user = '${id_historial}'  
                                                                    where id=${id}";
                                $resultado2 = mysqli_query($db4, $query3);
                            //RETURN DE PROCESO
                                if ($guardar_his){
                                    echo '<a href="seguimiento.php">Actualizar mas ordenes</a>';
                                    //header('location: usuarios.php');
                                    exit();
                                }
                        break;

                        case "returnes":
                            //ACTUALIZACION BDD DE SISTEMA
                                $query3 = "UPDATE datosordenes SET  status = '${status}', 
                                                                    observacion_estado = '${observ_estado}', 
                                                                    fechaGest = '${fechaGest}', 
                                                                    n_visitas = '${n_visitas}',
                                                                    gestion_user = '${id_historial}'   
                                                                    where id=${id}";
                                $resultado2 = mysqli_query($db4, $query3);
                            //RETURN DE PROCESO
                                if ($guardar_his){
                                    echo '<a href="seguimiento.php">Actualizar mas ordenes</a>';
                                    //header('location: usuarios.php');
                                    exit();
                                }
                        break;

                        case "undelivered":
                            //ACTUALIZACION BDD DE SISTEMA
                                $query3 = "UPDATE datosordenes SET  status = '${status}', 
                                                                    observacion_estado = '${observ_estado}', 
                                                                    fechaGest = '${fechaGest}', 
                                                                    n_visitas = '${n_visitas}',
                                                                    gestion_user = '${id_historial}'  
                                                                    where id=${id}";
                                $resultado2 = mysqli_query($db4, $query3);
                            //RETURN DE PROCESO
                            if ($guardar_his){
                                echo '<a href="seguimiento.php">Actualizar mas ordenes</a>';
                                exit();
                            }
                        break;
                    }
                }
            }

?>
 <div class="container">
    <form action="" method="post">
            <table class="table table-striped" hidden>
                <thead>
                    <tr>
                        <th>NOMBRE</th>
                        <th>APELLIDO</th>
                        <th>CIUDAD</th>
                        <th>DIRECCIÓN</th>
                        <th>REFERENCIA</th>
                        <th>TELEFONO</th>
                        <th>SEGUNDO CONTACTO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($resultadoApi2 = mysqli_fetch_assoc($resultado9)) : ?>
                        <tr>
                            <td>
                                <?php echo $resultadoApi2['name']; ?>
                            </td>
                            <td>
                                <?php echo $resultadoApi2['last_name']; ?>
                            </td>
                            <td>
                                <?php echo $resultadoApi2['city']; ?>
                            </td>
                            <td>
                                <?php echo $resultadoApi2['address']; ?>
                            </td>
                            <td>
                                <?php echo $resultadoApi2['reference']; ?>
                            </td>
                            <td>
                                <?php echo $resultadoApi2['phone']; ?>
                            </td>
                            <td>
                                <?php echo $resultadoApi2['landline']; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table> 

            <h2 class="form__titulo titulo__pagina">ACTUALIZAR ESTADO DE GESTION</h2>
            <p class="form__p form2--p">
                Solicitar todos los datos para poder completar la gestión.
            </p>
            <?php foreach($errores as $error) : ?>
                <div class="alerta">
                    <?php echo $error; ?>
                </div>
            <?php endforeach ?>

        <div class="container">
            <div class="form__container form2">
                <div class="form__grupo">
                    <select name="status" aria-required="true" id="status" require class="form__input">
                        <option value=""> ---SELECCIONA EL ESTADO DE LA ORDEN--- </option>
                        <option value="undelivered">UNDELIVERED (visitado, postergado)</option>
                        <option value="delivered">DELIVERED (entregado sin novedad)</option>
                    </select>
                </div>
                <div class="form__grupo">
                    <input type="text" aria-required="true" name="observacion_estado" id="observacion_estado" class="form__input" require placeholder=" " value=""  maxlength="255">
                    <label for="telefono" class="form__label">OBSERVACION DEL ESTADO</label>
                    <span class="form__linea"></span>
                </div>
                <div class="form__grupo">
                    <input type="number" aria-required="true" name="n_visitas" id="n_visitas" class="form__input"  placeholder=" " value=""  maxlength="1">
                    <label for="telefono" class="form__label">NUMERO DE VISITA</label>
                    <span class="form__linea"></span>
                </div>
            </div>
        </div>
        </fieldset>
    </form>


 <?php 
    incluirTemplate('fottersis');     
?>