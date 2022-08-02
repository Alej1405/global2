<?php

$id = $_GET['id'] ?? null;
//incluye el header
require '../../includes/funciones.php';
require '../../includes/config/database.php';

//PROTEGER PAGINA WEB
$auth = estaAutenticado();

if (!$auth) {
    header('location: index.php');
}

incluirTemplate('headersis2');

//BASE DE DATOS ADMINISTRADOR
conectarDB();
$db = conectarDB();

//BASE DE DATOS BODEGA 
conectarDB2();
$db2 = conectarDB2();

//CONECCION API
conectarDB3();
$db3 = conectarDB3();

//CONECCION CALLCENTER
conectarDB4();
$db4 = conectarDB4();

//CONECCION FINANCIERO
conectarDB6();
$db6 = conectarDB6();

//-------------CONSULTA DE INFORMACION--------------



$consulta_fin = "SELECT * FROM ingresos_egresos;";
$ejecutar_consulta = mysqli_query($db6, $consulta_fin);

//eliminar cliente
//liminar una tarifa directamente desde la tabla.
$id = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
}
//validar que esxista una tarifa con esa ida
if ($id) {
    $query = "DELETE FROM ingresos_egresos WHERE id = ${id}";
    $resultado = mysqli_query($db6, $query);
    if ($resultado) {
        $error = 1;
    }
}
?>

<?php if (intval($error) === 1) : ?>
    <p class="alert alert-success">VES!!!! FACIL ES HAGALE, HAGALE...</p>
<?php endif ?>

<body class="bg-gradient-primary">
    <div class="container">
        <h1>CONTROL DE INGRESOS Y EGRESOS</h1>
        <br>
        <div class="card alert alert-secondary">
            <div class="card-body fs-4 text-center">
                IVA GENERADO <?php 
                                $consulta_fin223 = "SELECT sum(v_iva) FROM ingresos_egresos;";
                                $ejecutar_consulta223 = mysqli_query($db6, $consulta_fin223);
                                $resultado223 = mysqli_fetch_assoc($ejecutar_consulta223);
                                echo "$" . round($resultado223['sum(v_iva)'], 2);
                                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card alert alert-success">
                    <div class="card-body">
                        <h5 class="card-title">TOTAL INGRESOS</h5>
                        <p class="card-text fw-bold fs-2"><?php
                                                            $consulta_fin22 = "SELECT sum(valor) FROM ingresos_egresos WHERE tipo = 'Ingreso';";
                                                            $ejecutar_consulta22 = mysqli_query($db6, $consulta_fin22);
                                                            $resultado22 = mysqli_fetch_assoc($ejecutar_consulta22);
                                                            $ingresos_1 = $resultado22['sum(valor)'];
                                                            echo "$" . round($resultado22['sum(valor)'], 2);
                                                            ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card alert alert-danger">
                    <div class="card-body">
                        <h5 class="card-title">TOTAL EGRESOS</h5>
                        <p class="card-text fw-bold fs-2"><?php
                                                            $consulta_fin22 = "SELECT sum(valor) FROM ingresos_egresos WHERE tipo = 'Egreso';";
                                                            $ejecutar_consulta22 = mysqli_query($db6, $consulta_fin22);
                                                            $resultado22 = mysqli_fetch_assoc($ejecutar_consulta22);
                                                            $egresos_1 = $resultado22['sum(valor)'];
                                                            echo "$" . round($resultado22['sum(valor)'], 2);
                                                            ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card alert alert-primary">
            <div class="card-body">
                <p class="card-text fw-bold fs-2 text-center">BALANCE BRUTO $<?php $balance = $ingresos_1 - $egresos_1;
                                                                                echo round($balance, 2); ?></p>
            </div>
        </div>
        <br>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>TIPO</th>
                    <th>VALOR</th>
                    <th>DETALLE</th>
                    <th>BANCO</th>
                    <th>RESPALDO</th>
                    <th>DEPOSITO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($array_clientes = mysqli_fetch_assoc($ejecutar_consulta)) : ?>
                    <tr>
                        <td><?php echo $array_clientes['tipo']; ?></td>
                        <td><?php echo $array_clientes['valor']; ?></td>
                        <td><?php echo $array_clientes['detalle']; ?></td>
                        <td><?php echo $array_clientes['banco']; ?></td>
                        <td>
                            <a target="blank" href="../../depositos/<?php echo $array_clientes['respaldo'] ?>" class="btn btn-outline-success btn-sm">
                                VER RESPALDO
                            </a>
                        </td>
                        <td>
                            <a target="blank" href="../../depositos/<?php echo $array_clientes['deposito'] ?>" class="btn btn-outline-secondary btn-sm">
                                VER DEPOSITO
                            </a>
                        </td>
                        <td>
                            <div class="btn-group">
                                <div class="col-auto">
                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?php echo $array_clientes['id']; ?>">
                                        <input type="submit" class="btn btn-outline-danger btn-sm" value="BORRAR">
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php
    incluirTemplate('fottersis');
    ?>