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
                        $valor_pagar;
                    //calculo del valor con IVA
                        $iva = $valor_pagar * 0.12;
                        $valor_pagar2 = $valor_pagar + $iva;
                        //valor incluido el iva echo "$" . round($valor_pagar2, 2);
                } else {
                    $valor_pagar = $tarifa;
                    $valor_pagar;
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
                        $valor_pagar;
                    //calculo del valor con IVA
                        $iva = $valor_pagar * 0.12;
                        $valor_pagar2 = $valor_pagar + $iva;
                        //calculo a pagar incluido el IVA echo "$" . round($valor_pagar2, 2);
                } else {
                    $valor_pagar = $tarifa;
                    $valor_pagar;
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
    //calculo de cod con tarifa.
        if($cod == 'si'){
            if ($valor_cod <= 99.99) {
                $cod_cobrar = 2.00;
            } elseif($valor_cod <= 399.99) {
                $cod_cobrar = $valor_cod * 0.04;
            } else{
                $cod_cobrar = $valor_cod * 0.1;
            }
        } else{
            $cod_cobrar = 0;
        }
    //fin del calculo de cod con tarifa.
    $peso = $fila['peso'];
    $peso_extra = $peso_aplicar;
    $t_kgextra = substr($tarifa_nombre, 0, -3)." KG EXTRA";
    $responsable = $_SESSION['usuario'];
    $fecha_corte = date('Y-m-d');
    $estado = 'liquidado';
    $estado2 = 'liquidado';
    $n_factura = '';
    $fecha_registro = $fila['fecha_reg'];
    $id_ordenes = $id;
    $filtro_asesor = $fila['asesor'];

    // echo "<pre>
    //     $cod_cobrar;
    //     $guia;
    //     $cliente;
    //     $tarifa_nombre;
    //     $cod;
    //     $valor_cod;
    //     $peso;
    //     $peso_extra;
    //     $t_kgextra;
    //     $valor_pagar;
    //     $responsable;
    //     $fecha_corte;
    //     $estado;
    //     $n_factura;
    //     $fecha_registro;
    //     $id_ordenes;        
    // </pre>";

    //-------INSERCION DE DATOS EN LA BASE DE DATOS-------
    $actualizar_orden = "UPDATE ordenes SET estado = 'liquidado' WHERE id = '$id_ordenes';";
    $ejecutar_actualizar = mysqli_query($db4, $actualizar_orden);
    $insertar_factura = "INSERT INTO liquidacion_gc (guia, cliente, tarifa, cod, valor_cod, cod_cobrar, peso, peso_extra, t_kgextra, valor_pagar, responsable, fecha_corte, estado, n_factura, fecha_servicio, id_ordenes) 
                                    VALUES ('$guia', '$cliente', '$tarifa_nombre', '$cod', '$valor_cod', '$cod_cobrar', '$peso', '$peso_extra', '$t_kgextra', '$valor_pagar', '$responsable', '$fecha_corte', '$estado', '$n_factura', '$fecha_registro', '$id_ordenes');";
    //echo $insertar_factura;
    //exit;
    $ejecutar_insertar = mysqli_query($db6, $insertar_factura);
            if($ejecutar_insertar){
                
                echo "<script>
                guardar();
                    window.location.href='fin-gcgo.php?id=$filtro_asesor';
                </script>";
            }
}
?>

<button onclick="guardaTodo()">asdasd</button>




<?php
incluirTemplate('fottersis');
?>