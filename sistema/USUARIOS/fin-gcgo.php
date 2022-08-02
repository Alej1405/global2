<?php

$id = $_GET['id'] ?? null;
//incluye el header
require '../../includes/funciones.php';
require '../../includes/config/database.php';

//PROTEGER PAGINA WEB
$auth = estaAutenticado();

if (!$auth) {
    header('location: ../index.php');
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

//-------------variable de filtro----------------------
$filtro = $_SESSION['rol'];

//-------------MACRO FILTRO POR ASESOR (ASESOR)----------------------
if (empty($id)) {
    $buscar = "WHERE NOT estado = 'recolectar';";
} else {
    $buscar = "WHERE asesor = '$id' AND NOT estado = 'recolectar';";
}

//-------------captura de datos----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $buscar = $_POST['buscar'];
}

//-------------CONSULTA DE INFORMACION--------------
$consulta_fin = "SELECT * FROM ordenes ${buscar};";
$ejecutar_consulta3 = mysqli_query($db4, $consulta_fin);
?>

<body class="bg-gradient-primary">
    <div class="container">
        <h1>ESTADO DE CUENTA</h1>
        <?php if ($filtro === 'gerencia_paqueteria') : ?>
            <form action="" method="post">
                <div class="card">
                    <div class="card-body">
                        <h4>FILTRAR POR CLIENTE</h4>
                        <select class="form-select" name="buscar" aria-label="Default select example">
                            <option selected>SELECCIONA UN CLIENTE</option>
                            <option value="WHERE estado = 'delivered' ORDER BY cliente;">Ver todo</option>
                            <?php
                            $buscar_cliente = "SELECT * FROM clientes;";
                            $ejecutar_buscar_cliente = mysqli_query($db4, $buscar_cliente);
                            while ($fila = mysqli_fetch_array($ejecutar_buscar_cliente)) :
                            ?>
                                <option value="WHERE cliente = <?php echo $fila['cedula']; ?> AND NOT estado = 'recolectar';"><?php echo $fila['nombre'] . ' ' . $fila['apellido'] . '/' . $fila['emprendimiento']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <br>
                        <button class="btn btn-outline-primary" title="REGISTRAR CLIENTE">Buscar</button>
                    </div>
                </div>
            </form>
        <?php endif; ?>
        <?php if ($filtro === 'asesor') : ?>
            <div class="alert alert-danger" role="alert">
                LOS SIGUIENTES VALORES NO INCLUYEN IVA.
            </div>
        <?php endif; ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>CLIENTE</th>
                    <th>DESTINATARIO</th>
                    <th>TIPO TARIFA</th>
                    <th>COD</th>
                    <th>VALOR COD</th>
                    <th>VALOR COBRAR</th>
                    <th>ESTADO</th>
                    <th>PESO</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($array_clientes = mysqli_fetch_assoc($ejecutar_consulta3)) : ?>
                    <form action="liquidacion_cliente.php" method="post">
                        <tr>
                            <td>
                                <?php
                                $cedula = $array_clientes['cliente'];
                                $consulta_fin = "SELECT * FROM clientes WHERE cedula = '${cedula}';";
                                $ejecutar_consulta = mysqli_query($db4, $consulta_fin);
                                $ejecutar_consulta31 = mysqli_fetch_assoc($ejecutar_consulta);
                                echo $ejecutar_consulta31['nombre'] . " " . $ejecutar_consulta31['apellido'];
                                ?>
                                <input hidden type="text" name="cliente" id="" value="<?php echo $ejecutar_consulta31['nombre'] . " " . $ejecutar_consulta31['apellido']; ?>">
                            </td>
                            <td>
                                <?php
                                $cedula = $array_clientes['cliente'];
                                $consulta_fin = "SELECT * FROM clientes WHERE cedula = '$cedula';";
                                $ejecutar_consulta = mysqli_query($db4, $consulta_fin);
                                $ejecutar_consulta4 = mysqli_fetch_assoc($ejecutar_consulta);
                                echo $cedula = $array_clientes['nombre'];
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $array_clientes['tarifa'];
                                ?>
                            </td>
                            <td>
                                <?php
                                $consultar_tarifa = $array_clientes['tarifa'];
                                //consultar el valor de tarifa a aplicar
                                $cons_tarifa = "SELECT * FROM tarifas WHERE nombre = '${consultar_tarifa}';";
                                $eje_consT = mysqli_query($db4, $cons_tarifa);
                                $valor_tarif = mysqli_fetch_assoc($eje_consT);
                                $tarifa = $valor_tarif['valor'];
                                $tarifa_extra = $valor_tarif['valor_extra'];
                                $peso_base = $valor_tarif['peso'];
                                echo $array_clientes['cod'];
                                ?>
                            </td>
                            <td>
                                <?php echo $array_clientes['valor']; ?>
                            </td>
                            <td>
                                <?php
                                $consultar_tarifa = $array_clientes['tarifa'];
                                //consultar el valor de tarifa a aplicar
                                // $cons_tarifa = "SELECT * FROM tarifas WHERE nombre = '${consultar_tarifa}';";
                                // $eje_consT = mysqli_query($db4, $cons_tarifa);
                                // $valor_tarif = mysqli_fetch_assoc($eje_consT);
                                // $tarifa = $valor_tarif['valor'];
                                // $tarifa_extra = $valor_tarif['valor_extra'];
                                // $peso_base = $valor_tarif['peso'];
                                //calculo del peso real comparacion con el pesovolumetrico
                                $largo = $array_clientes['l'];
                                $ancho = $array_clientes['a'];
                                $alto = $array_clientes['h'];
                                $P = $array_clientes['peso'];
                                $peso_vol1 = round(($largo * $ancho * $alto) / 5000, 2);
                                //$peso_vol = $P - $peso_vol1;
                                if ($peso_vol1 > $P) {
                                    //calculo con el peso volumetrico
                                    $peso_aplicar = $peso_vol1 - $peso_base;
                                    if ($peso_aplicar > $peso_base) {
                                        $valor_extra = $peso_aplicar * $tarifa_extra;
                                        $valor_pagar = $valor_extra + $tarifa;
                                        echo "$" . round($valor_pagar, 2);
                                    } else {
                                        $valor_pagar = $tarifa;
                                        echo "$" . round($tarifa, 2);
                                    }
                                } else {
                                    $peso_aplicar = $P - $peso_base;
                                    if ($peso_aplicar > $peso_base) {
                                        $valor_extra = $peso_aplicar * $tarifa_extra;
                                        $valor_pagar = $valor_extra + $tarifa;
                                        echo "$" . round($valor_pagar, 2);
                                    } else {
                                        $valor_pagar = $tarifa;
                                        echo "$" . round($tarifa, 2);
                                    };
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $estado_filtro = $array_clientes['estado'];
                                if ($estado_filtro === "delivered" || $estado_filtro === "ingresado") {
                                    echo "<span class='badge badge-success'>POR FACTURAR</span>";
                                } else {
                                    echo "<span class='badge badge-danger'>EN PROCESO</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <!-- <button class="btn btn-outline-success" title="REGISTRAR CLIENTE">LIQUIDAR</button> -->
                                <?php echo $array_clientes['peso']; ?>
                            </td>
                        </tr>
                    </form>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php
    incluirTemplate('fottersis');
    ?>