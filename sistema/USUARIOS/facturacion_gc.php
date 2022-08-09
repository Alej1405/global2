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




?>
<!-- realiza la consulta de los datos de la base de datos iterando los clintes -->
<div class="container">
    <h2>FACTURACION Y REPORTE</h2>
            <div class="alert alert-info" role="alert">
                <img src="../../IMG/gc-go.png" class="img-fluid pt-1 m-auto end" alt="Logo GC-GO" style="width: 3.5rem;">
                 LISTA DE FACTURAS PENDIENTES, PARA VER LA LIQUIDACION SELECCIONA UN CLIENTE.
            </div>
            <div class="alert alert-secondary" role="alert">
                    Ingreso total bruto por servivicios <strong> <?php 
                    $suma_ingreso = "SELECT SUM(valor_pagar) FROM liquidacion_gc;";
                    $eje_suma = mysqli_query($db6, $suma_ingreso);
                    $valor_suma = mysqli_fetch_assoc($eje_suma);
                    echo '$'.' '.round($valor_suma['SUM(valor_pagar)'], 2);
                    ?>.</strong>
                            Valor recolectado por COD <?php 
                    $suma_ingreso2 = "SELECT SUM(valor_cod) FROM liquidacion_gc WHERE estado = 'liquidado';";
                    $eje_suma2 = mysqli_query($db6, $suma_ingreso2);
                    $valor_suma2 = mysqli_fetch_assoc($eje_suma2);
                    echo '$'.' '.round($valor_suma2['SUM(valor_cod)'], 2);
                    ?>.
                          Valor por COBRAR <?php 
                    $suma_ingreso3 = "SELECT SUM(valor_cod) FROM liquidacion_gc WHERE estado = 'liquidado';";
                    $eje_suma3 = mysqli_query($db6, $suma_ingreso3);
                    $valor_suma3 = mysqli_fetch_assoc($eje_suma3);
                    echo '$'.' '.round($valor_suma3['SUM(valor_cod)'], 2);
                    ?>.
                            Ingresos COBRADO <?php 
                    $suma_ingreso4 = "SELECT SUM(valor_cod) FROM liquidacion_gc WHERE estado = 'liquidado';";
                    $eje_suma4 = mysqli_query($db6, $suma_ingreso4);
                    $valor_suma4 = mysqli_fetch_assoc($eje_suma4);
                    echo '$'.' '.round($valor_suma4['SUM(valor_cod)'], 2);
                    ?>.
            </div>
        <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
            LISTA DE CLIENTES POR FACTURAR
        </a>
        <?php
        $listar_clientes = "SELECT COUNT(id), cliente FROM ordenes WHERE estado = 'liquidado' GROUP BY cliente;";
        $ejecutar_listar_clientes = mysqli_query($db4, $listar_clientes);
        while ($ver_c = mysqli_fetch_assoc($ejecutar_listar_clientes)) :;
        ?>
            <a href="#" class="list-group-item list-group-item-action">
                <?php echo $ver_c['cliente']; 
                $consultar_cliente = $ver_c['cliente'];
                $consultar_cliente_id = "SELECT * FROM clientes WHERE cedula = '$consultar_cliente';";
                $ejecutar_cliente_id = mysqli_query($db4, $consultar_cliente_id);
                $ver_cliente_id = mysqli_fetch_assoc($ejecutar_cliente_id);

                $contar_facturas = "SELECT COUNT(id) FROM liquidacion_gc WHERE cliente = '$consultar_cliente';";
                $ejecutar_contar_facturas = mysqli_query($db6, $contar_facturas);
                $ver_contar_facturas = mysqli_fetch_assoc($ejecutar_contar_facturas);

                echo ' - ' . $ver_cliente_id['nombre'].' '.$ver_cliente_id['apellido'].' / '.$ver_cliente_id['emprendimiento'];
                ?>
                <strong><?php echo 'FACTURAS POR REALIZAR'.' '. $ver_contar_facturas['COUNT(id)'];?></strong>
            </a>
        <?php endwhile; ?>
    </div>
</div>

<?php
incluirTemplate('fottersis2');
?>