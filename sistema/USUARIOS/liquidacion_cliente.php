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

//----------------------variables del sistema----------------------

$id = '';

//----------------captura de datos desde el formulario----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //-------VARIABLES GENEREALES-------

        $id = $_POST['id'];
    //CONSULTA DE DATOS DE LA BASE DE DATOS
    $consulta_fin = "SELECT * FROM ordenes WHERE id = '$id';";
    $ejecutar_consulta3 = mysqli_query($db4, $consulta_fin);
    $fila = mysqli_fetch_array($ejecutar_consulta3);

    //-------CALCULO DE VALORES SIN IVA PARA LA FACTURACION-------
            $consultar_tarifa = $fila['tarifa'];
            //consultar el valor de tarifa a aplicar datos de la tarifa a aplicar.
                $cons_tarifa = "SELECT * FROM tarifas WHERE nombre = '${consultar_tarifa}';";
                $eje_consT = mysqli_query($db4, $cons_tarifa);
                $valor_tarif = mysqli_fetch_assoc($eje_consT);
                $tarifa = $valor_tarif['valor'];
                $tarifa_extra = $valor_tarif['valor_extra'];
                $peso_base = $valor_tarif['peso'];
            //calculo del peso real comparacion con el pesovolumetrico
            $largo = $fila['l'];
            $ancho = $fila['a'];
            $alto = $fila['h'];
            $P = $fila['peso'];
            $peso_vol1 = round(($largo * $ancho * $alto) / 5000, 2);
            //$peso_vol = $P - $peso_vol1;
            if ($peso_vol1 > $P) {
                //calculo con el peso volumetrico
                $peso_aplicar = $peso_vol1 - $peso_base;
                if ($peso_aplicar > $peso_base) {
                    $valor_extra = $peso_aplicar * $tarifa_extra;
                    //valor que captura para la facturacion
                        $valor_pagar = $valor_extra + $tarifa;
                        echo "$". round($valor_pagar, 2);
                    //calculo del valor con IVA
                        $iva = $valor_pagar * 0.12;
                        $valor_pagar2 = $valor_pagar + $iva;
                        //valor incluido el iva echo "$" . round($valor_pagar2, 2);
                } else {
                    $valor_pagar = $tarifa;
                    echo "$" . round($valor_pagar, 2);
                    //calculo del valor con IVA
                        $iva = $valor_pagar * 0.12;
                        $valor_pagar2 = $valor_pagar + $iva;
                        //valor a cobrar incluido el IVA echo "$" . round($valor_pagar2, 2);
                }
            } else {
                $peso_aplicar = $P - $peso_base;
                if ($peso_aplicar > $peso_base) {
                    $valor_extra = $peso_aplicar * $tarifa_extra;
                    //valor que captura para la facturacion
                        $valor_pagar = $valor_extra + $tarifa;
                        echo "$" . round($valor_pagar, 2);
                    //calculo del valor con IVA
                        $iva = $valor_pagar * 0.12;
                        $valor_pagar2 = $valor_pagar + $iva;
                        //calculo a pagar incluido el IVA echo "$" . round($valor_pagar2, 2);
                } else {
                    $valor_pagar = $tarifa;
                    echo "$" . round($valor_pagar, 2);
                    //caclulo del valor con IVA
                        $iva = $valor_pagar * 0.12;
                        $valor_pagar2 = $valor_pagar + $iva;
                        //calculo a pagar incluido el IVA echo "$" . round($valor_pagar2, 2);
                };
            }

    //-------VARIABLES DEL SISTEMA PARA CAPTURA-------
    $guia = $fila['guia'];
    $cliente = $fila['cliente'];
    $tarifa_nombre = $fila['tarifa'];
    $cod = $fila['cod'];
    $valor_cod = $fila['valor'];
    $responsable = $_SESSION['usuario'];
    $fecha_corte = date('Y-m-d');
    $estado = 'liquidado';
    $n_factura = '';
    $fecha_registro = $fila['fecha_reg'];
    $id_ordenes = $id;
    
    echo $guia;
    echo $cliente;
    echo $tarifa_nombre;
    echo $valor_cod;
    echo $responsable;
    echo $fecha_corte;
    echo $estado;
    echo $n_factura;
    echo $fecha_registro;
    echo $id_ordenes;
}
?>




<?php
incluirTemplate('fottersis');
?>