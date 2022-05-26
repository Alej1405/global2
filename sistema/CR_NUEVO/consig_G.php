<?php 
    $resultado = $_GET['resultado'] ?? null;
   //incluye el header
 require '../../includes/funciones.php';
 $auth = estaAutenticado();

 if (!$auth) {
     header('location: ../../index.php');
 }
 incluirTemplate('headersis2');
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
    //escribir el query
    $query = "SELECT * FROM  proceso    INNER join cargas  ON proceso.idCarga = cargas.id 
                                        INNER JOIN cliente ON cliente.id = cargas.idCliente AND NOT proceso.despacho = '' AND NOT cargas.idCliente = 25";

    //consultar la base de datos
    $resultadoConsulta = mysqli_query($db, $query);
    

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
    <h2 class="form__titulo titutlo__tabla">DESPACHO GENERAL DE CARGAS </h2>
    <p class="form__p form2--p">
        Genial Terminamos el proceso.
    </p>
    <?php if(intval($resultado) === 1 ): ?>
        <p class="alerta2">LA CARGA HA SIDO CONSIGNADA CON ÉXITO</p>
    <?php elseif(intval($resultado) === 2 ): ?>
        <p class="alerta2">LA NOTIFICACIÓN FUE ENVIADA CON ÉXITO</p>
    <?php elseif(intval($resultado) === 3 ): ?>
        <p class="alerta">EL USUARIO tiene cargas en proceso</p>
    <?php endif ?>
    <thead>
        <tr>
            <th>Cliente </th>
            <th>Numero de Guia</th>
            <th>numero de factura</th>
            <th>observacion </th>
            <th>proveedor</th>
            <th>FECHA</th>
            <th>AGREGAR</th>
            <!-- <th>ACCIONES</th> -->

        </tr>
    </thead>

    <tbody>
        <?php while( $cliente = mysqli_fetch_assoc($resultadoConsulta) ):?>
        <tr>
            <td><?php echo $cliente['empresa']; ?></td>
            <td>
                <a href="../../respaldos/<?php echo $cliente['guia']; ?>#toolbar=1&navpanes=1&scrollbar=0" target="blanck" class="tabla__archivos"><?php echo $cliente['idCarga']; ?> ↓</a>
            </td>
            <td>
                <a href="../../respaldos/<?php echo $cliente['factura']; ?>#toolbar=1&navpanes=1&scrollbar=0" target="blanck" class="tabla__archivos"><?php echo $cliente['nFactura']; ?> ↓</a>
            </td>
            <td><?php echo $cliente['observacion']; ?></td>
            <td><?php echo $cliente['provedor']; ?></td>
            <td><?php echo $cliente['fecha']; ?></td>
            <td>
                <div class="accion__actualizar">
                    <a href="despachar_G.php?id=<?php echo $cliente['nProceso']; ?>" class="acciones__enlace">CONSIGNAR</a>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<div class="boton__anidado">
    <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">Terminar y salir</a>
</div>

