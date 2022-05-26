<?php 
    $resultado = $_GET['resultado'] ?? null;
    //conectar la base de datos
    require '../../includes/config/database.php';
    conectarDB();
    $db =conectarDB();
    //escribir el query
    $query = "SELECT * FROM cargas";
    $resultadoConsulta = mysqli_query($db, $query);

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

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){
            $query = "DELETE FROM cargas WHERE id = '${id}'"; 
            //echo $query;
            //exit; 

            $resultado = mysqli_query($db, $query);

            var_dump($resultado);

            if ($resultado){
                //header('location: verclientes.php?resultado=2');
                //echo "no se borró"; 
                $_SESSION['rol'];
                //var_dump($resultado);
                switch ($_SESSION['rol']){
                    case "admin":
                        header('location: ../admin.php?resultado=2');
                        break;
                    case "superAdmin":
                        header('location: ../superAdmin.php?resultado=2');
                        break;
                    case "comercial":
                        header('location: ../comercial.php?resultado=2');
                        break;
                    case "control":
                        header('location: ../control.php?resultado=2');
                        break;
                    case "adminBodega":
                        header('location: ../adminBodega.php?resultado=2');
                        break;
                    case "bodega":
                        header('location: ../bodega.php?resultado=2');
                        break;
                }
            }else{
                echo "el cliente registra carga";
                header('location: vercargas.php?resultado=3');
                
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
        <p class="alerta2">la carga HA SIDO ACTUALIZADO CON ÉXITO</p>
    <?php elseif(intval($resultado) === 2 ): ?>
        <p class="alerta">lacarga HA SIDO ELIMINADO CON ÉXITO</p>
    <?php elseif(intval($resultado) === 3 ): ?>
        <p class="alerta">ANTES DE BORRAR UNA CARGA POR FAVOR ELIMINA EL PROCESO.</p>
    <?php endif ?>
    <thead>
        <tr>
            <th>numero de documento</th>
            <th>fecha de ingreso</th>
            <th>documento de transporte</th>
            <th>numero de factura</th>
            <th>cert orginen o EUR1</th>
            <th>valor del flete</th>
            <th>mrn</th>
            <th>bodega asignada</th>
            <th>proveedor</th>
            <th>acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php while( $cliente = mysqli_fetch_assoc($resultadoConsulta) ):?>
        <tr>
            <td><?php echo $cliente['id']; ?></td>
            <td><?php echo $cliente['ingreso']; ?></td>
            <td><?php echo $cliente['doc']; ?></td>
            <td><?php echo $cliente['nFactura']; ?></td>
            <td><?php echo $cliente['coEur1']; ?></td>
            <td><?php echo $cliente['flete']; ?></td>
            <td><?php echo $cliente['mrn']; ?></td>
            <td><?php echo $cliente['bodegaAduana']; ?></td>
            <td><?php echo $cliente['provedor']; ?></td>
            <td>
                    <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                    <input type="submit" class="accion__eliminar" value="eliminar">
                </form>
                <div class="accion__actualizar">
                    <a href="actcargas.php?id=<?php echo $cliente['id']; ?>" class="acciones__enlace">actualizar</a>
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