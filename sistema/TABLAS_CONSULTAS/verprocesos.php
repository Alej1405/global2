<?php 
    $resultado = $_GET['resultado'] ?? null;
    //conectar la base de datos
    require '../../includes/config/database.php';
    conectarDB();
    $db =conectarDB();
    //escribir el query
    $query = "SELECT * FROM  proceso    INNER join cargas  ON proceso.idCarga = cargas.id 
                                        INNER JOIN cliente ON cliente.id = cargas.idCliente ORDER BY proceso.tAforo DESC";

    //consultar la base de datos
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
            $query = "DELETE FROM proceso WHERE id = ${id}"; 
            //echo $query;
            $resultado = mysqli_query($db, $query);

            //var_dump($resultado);

            if ($resultado){
                //header('location: verclientes.php?resultado=2');
                //echo "no se borró"; 
                switch ($_SESSION['rol']){
                    case "admin":
                        header('location: ../admin.php?resultado=1');
                        break;
                    case "superAdmin":
                        header('location: ../superAdmin.php?resultado=1');
                        break;
                    case "comercial":
                        header('location: ../comercial.php?resultado=1');
                        break;
                    case "control":
                        header('location: ../control.php?resultado=1');
                        break;
                    case "adminBodega":
                        header('location: ../adminBodega.php?resultado=1');
                        break;
                    case "bodega":
                        header('location: ../bodega.php?resultado=1');
                        break;
                }
            }else{
                //echo "el cliente registra carga";
                header('location: verclientes.php?resultado=3');
            }
        }
    }

    



?>

<table class="form2 consulta__tabla">
    <h2 class="form__titulo titutlo__tabla">VER PROCESOS </h2>
    <p class="form__p form2--p">
        Recuerda llenar bien estos campos para poder realizar una 
        correcta operación.
    </p>
    <?php if(intval($resultado) === 1 ): ?>
        <p class="alerta2">EL USUARIO HA SIDO ACTUALIZADO CON ÉXITO</p>
    <?php elseif(intval($resultado) === 2 ): ?>
        <p class="alerta">EL USUARIO HA SIDO ELIMINADO CON ÉXITO</p>
    <?php elseif(intval($resultado) === 3 ): ?>
        <p class="alerta">EL USUARIO tiene cargas en proceso</p>
    <?php endif ?>
    <thead>
        <tr>
            <th>Cliente </th>
            <th>Fecha de ingreso</th>
            <th>Numero de Guia</th>
            <th>numero de factura</th>
            <th>MRN </th>
            <th>Estado</th>
            <th>tipo de aforo</th>
            <th>Observacion</th>
            <th>AGREGAR</th>
            <!-- <th>ACCIONES</th> -->

        </tr>
    </thead>

    <tbody>
        <?php while( $cliente = mysqli_fetch_assoc($resultadoConsulta) ):?>
        <tr>
            <td><?php echo $cliente['nombre'] . " " . $cliente['apellido']; ?></td>
            <td><?php echo $cliente['fecha']; ?></td>
            <td>
                <a href="../../respaldos/<?php echo $cliente['guia']; ?>#toolbar=1&navpanes=1&scrollbar=0" target="blanck" class="tabla__archivos"><?php echo $cliente['idCarga']; ?> ↓</a>
            </td>
            <td>
                <a href="../../respaldos/<?php echo $cliente['factura']; ?>#toolbar=1&navpanes=1&scrollbar=0" target="blanck" class="tabla__archivos"><?php echo $cliente['nFactura']; ?> ↓</a>
            </td>
            <td><?php echo $cliente['mrn']; ?></td>
            <td><?php echo $cliente['estado']; ?></td>
            <td><?php echo $cliente['tAforo']; ?></td>
            <td><?php echo $cliente['observacion']; ?></td>
            <td>
                <div class="accion__actualizar">
                    <a href="partidas.php?id=<?php echo $cliente['nProceso']; ?>" class="acciones__enlace">PARTIDAS</a>
                </div>
                <div class="accion__actualizar">
                    <a href="actproceso.php?id=<?php echo $cliente['nProceso']; ?>" class="acciones__enlace">ACT ESTADO</a>
                </div>
                <div class="accion__actualizar">
                    <a href="dcp.php?id=<?php echo $cliente['nProceso']; ?>" class="acciones__enlace">DCP</a>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<div class="boton__anidado">
    <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">Terminar y salir</a>
</div>

<?php mysqli_close($db); ?>