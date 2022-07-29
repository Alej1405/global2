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
echo "ahi vamos";

//----------------------variables del sistema----------------------

$guia = '';
$cliente = '';
$tarifa = ''; 
$cod = '';
$valor_cod = '';
$valor_pagar = '';
$responsable = '';
$fecha_corte = '';
$estado = '';
$n_factura = '';
$fecha_servicio = '';

//----------------captura de datos desde el formulario----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $guia = $_POST['guia'];
    $cliente = $_POST['cliente'];
    $tarifa = $_POST['tarifa']; 
    $cod = $_POST['cod'];
    $valor_cod = $_POST['valor_cod'];
    $valor_pagar = $_POST['valor_pagar'];
    $responsable = $_SESSION['usuario'];
    $fecha_corte = date('y-m-d');
    $estado = 'facturado';
    $n_factura = '';
    $fecha_servicio = '';

    echo $guia;
    echo $cliente;
    echo $tarifa; 
    echo $cod;
    echo $valor_cod;
    echo $valor_pagar;
    echo $responsable;
    echo $fecha_corte;
    echo $estado;
    echo $n_factura;
    echo $fecha_servicio;

}
?>




<?php
incluirTemplate('fottersis');
?>