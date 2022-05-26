<?php 
    $resultado = $_GET['resultado'] ?? null;
    //incluir el template
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    
    $auth = estaAutenticado();

    // // proteger la página
    if (!$auth) {
        header('location: index.php');
    }else{
    // var_dump($_SESSION['rol']);
    // var_dump($_SESSION['id']);
    }
    //conectar la base de datos
    require '../../includes/config/database.php';
    conectarDB();
    $db =conectarDB();
    //escribir el query
    $query = "SELECT * FROM usuario";

    //consultar la base de datos
    $resultadoConsulta = mysqli_query($db, $query);

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){
            $query = "DELETE FROM usuario WHERE id = ${id}"; 
            
            $resultado = mysqli_query($db, $query);

            if ($resultado){
                header('location: verusuarios.php?resultado=2');
            }
        }
    }

    



?>
<table class="form2 consulta__tabla">
    <h2 class="form__titulo titutlo__tabla">REGISTRAR NUEVO CLIENTE</h2>
    <p class="form__p form2--p">
        Recuerda llenar bien estos campos para poder realizar una 
        correcta operación.
    </p>

    <?php if(intval($resultado) === 1 ): ?>
        <p class="alerta2">EL USUARIO HA SIDO ACTUALIZADO CON ÉXITO</p>
    <?php elseif(intval($resultado) === 2 ): ?>
        <p class="alerta">EL USUARIO HA SIDO ELIMINADO CON ÉXITO</p>
    <?php endif ?>
    <thead>
        <tr>
            <th>cedula</th>
            <th>nombre y apellido</th>
            <th>celular</th>
            <th>convencional</th>
            <th>correo empresarial</th>
            <th>correo personal</th>
            <th>Tipo de usario</th>
            <th>acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php while( $cliente = mysqli_fetch_assoc($resultadoConsulta) ):?>
        <tr>
            <td><?php echo $cliente['cedula']; ?></td>
            <td><?php echo $cliente['nombre'] . " " . $cliente['apellido']; ?></td>
            <td><?php echo $cliente['telefono1']; ?></td>
            <td><?php echo $cliente['telefono2']; ?></td>
            <td><?php echo $cliente['correo1']; ?></td>
            <td><?php echo $cliente['correo2']; ?></td>
            <td><?php echo $cliente['tipo']; ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                    <input type="submit" class="accion__eliminar" value="eliminar">
                </form>
                <div class="accion__actualizar">
                    <a href="actusuario.php?id=<?php echo $cliente['id']; ?>" class="acciones__enlace">actualizar</a>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<div class="boton__anidado">
    <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">terminar y salir</a>
</div>

<?php mysqli_close($db); ?>