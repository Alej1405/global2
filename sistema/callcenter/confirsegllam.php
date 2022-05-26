<?php 
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

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
        header('location: index.php');
    }
    $query2 = "SELECT * FROM datosordenes where id = ${id}";
            $resultado2 = mysqli_query($db4, $query2);


    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $observacion = mysqli_real_escape_string($db4, $_POST['observacion']);
        $fecha_pago = mysqli_real_escape_string($db4, $_POST['fecha_pago']);
        $contactado = $id;
        $resLlamada = mysqli_real_escape_string($db4, $_POST['resLlamada']);
        $p_verificado = null;
        $estado = "no";
        $fechaGest = date('y-m-d h:i:s');

        $actualizar = "UPDATE datosordenes SET   estado = '${estado}',
                                                resLlamada = '${resLlamada}',
                                            observacion = '${observacion}',
                                            fecha_pago = '${fecha_pago}',
                                            fechaGest = '${fechaGest}'

                                        WHERE id = ${id}";
        $actualizado = mysqli_query($db4, $actualizar);
                header('location: apiosegllamadas.php');
            
        }

?>
<form action="" method="post">
    <fieldset class="form2 consulta__tabla">
        <?php
            
        ?>
        <legend>DATOS DEL CLIENTE</legend>
        <table class="form2 consulta__tabla" >
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>PROVINCIA</th>
                    <th>CIUDAD</th>
                    <th>DIRECCIÓN</th>
                    <th>REFERENCIA</th>
                    <th>TELEFONO</th>
                    <th>SEGUNDO CONTACTO</th>
                </tr>
            </thead>
            <tbody>
                <?php while($resultadoApi2 = mysqli_fetch_assoc($resultado2)) : ?>
                    <tr>
                        <td>
                            <?php echo $resultadoApi2['name']; ?>
                        </td>
                        <td>
                            <?php echo $resultadoApi2['last_name']; ?>
                        </td>
                        <td>
                            <?php echo $resultadoApi2['province']; ?>    
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
                        <td><?php echo $resultadoApi2['landline']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2 class="form__titulo titulo__pagina">LISTADO DE PAGOS</h2>
        <h2 class="form__titulo">NO CONFIRMADOS</h2>
        <p class="form__p form2--p">
            Confirmar las novedades y la posible fecha de pago
        </p>
        <?php 
        $query2 = "SELECT * FROM datosordenes where id = ${id}";
        $resultado2 = mysqli_query($db4, $query2);
        $resultadoApi2 = mysqli_fetch_assoc($resultado2); ?>
        <div class="container2">
        <div class="form__container form2">
            <div class="form__grupo">
                <input type="text" readonly name="nombres" id="nombres"class="form__input" placeholder=" " value="<?php echo $resultadoApi2['nombres']; ?>" >
                <label for="nombres" class="form__label">Nombre y Apellido factura</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" readonly name="cedula" id="cedula"class="form__input" placeholder=" " value="<?php echo $resultadoApi2['cedula']; ?>" >
                <label for="cedula" class="form__label">Número de Cédula</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <select name="metodoPago"readonly id="" class="form__input">
                    <option value="<?php echo $resultadoApi2['metodoPago']; ?>"><?php echo $resultadoApi2['metodoPago']; ?></option>
                    <option value="efectivo">Efectivo</option>
                    <option value="transferencia">Transferencia</option>
                </select>
            </div>
            <div class="form__grupo">
                <input type="text" name="observacion" id="observacion"class="form__input" placeholder=" " value="<?php echo $resultadoApi2['observacion']; ?>" >
                <label for="observacion" class="form__label">Observacion</label>
                <span class="form__linea"></span>
            </div>
        </div>
        <div class="form__container form2">
            <div class="form__grupo">
                <input type="email" readonly name="correo" id="correo"class="form__input" placeholder=" " value="<?php echo $resultadoApi2['correo']; ?>" >
                <label for="correo" class="form__label">Correo para envío de Factura</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" readonly name="telefono" id="telefono"class="form__input" placeholder=" " value="<?php echo $resultadoApi2['telefono']; ?>" >
                <label for="telefono" class="form__label">Contacto para la entrega</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" readonly name="direccion" id="direccion"class="form__input" placeholder=" " value="<?php echo $resultadoApi2['direccion']; ?>" >
                <label for="direccion" class="form__label">Dirección Alternativa</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="date" name="fecha_pago" id="fecha_pago"class="form__input" placeholder=" " value="<?php echo $resultadoApi2['fecha_pago']; ?>" >
                <label for="fecha_pago" class="form__label">Fecha de entrega</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <select name="resLlamada" id="resLlamada" require class="form__input">
                    <option value=""> ---Conclucion de la Gestion--- </option>
                    <option value="efectiva">Efectiva (Solamente si la llamada es positva en todo)</option>
                    <option value="no desea">No desa (Si el cliente no compro o no desea)</option>
                    <option value="segunda llamada">Volver a llamar (Pasa a segunda llamada)</option>
                    <option value="equivocado">Numero equivocado (Si el numero de contacto no es el correcto)</option>
                </select>
            </div>
        </div>
    </fieldset>

    <center><input type="submit" class="form__submit" value="GUARDAR PROCESO"></center>
</form>
<div class="boton__anidado">
        <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
    </div>