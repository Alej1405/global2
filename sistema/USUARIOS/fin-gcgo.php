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


$consulta_fin = "SELECT * FROM ordenes;";
$ejecutar_consulta3 = mysqli_query($db4, $consulta_fin);



?>

<body class="bg-gradient-primary">
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>CLIENTE</th>
                    <th>NEGOCIO</th>
                    <th>DESTINO</th>
                    <th>T. TARIFA</th>
                    <th>PESO</th>
                    <th>TARIFA</th>
                    <th>V. EXTRA</th>
                    <th>POR COBRAR</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($array_clientes = mysqli_fetch_assoc($ejecutar_consulta3)) : ?>
                    <tr>
                        <td>
                            <?php 
                                $cedula = $array_clientes['cliente']; 
                                $consulta_fin = "SELECT * FROM clientes WHERE cedula = '${cedula}';";
                                $ejecutar_consulta = mysqli_query($db4, $consulta_fin); 
                                $ejecutar_consulta31 = mysqli_fetch_assoc($ejecutar_consulta);
                                echo $ejecutar_consulta31['nombre']." ".$ejecutar_consulta31['apellido'];    
                            ?>
                        </td>
                        <td>
                            <?php 
                                $cedula = $array_clientes['cliente']; 
                                $consulta_fin = "SELECT * FROM clientes WHERE cedula = '$cedula';";
                                $ejecutar_consulta = mysqli_query($db4, $consulta_fin);
                                $ejecutar_consulta4 = mysqli_fetch_assoc($ejecutar_consulta);
                                echo $ejecutar_consulta4['emprendimiento'];    
                            ?>
                        </td>
                        <td>
                            <?php echo $array_clientes['ciudad']; ?>
                        </td>
                        <td>
                            <?php 
                              echo $array_clientes['tarifa'];
                            ?>
                        </td>
                        <td>
                            <?php 
                              echo $array_clientes['peso'];
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
                              echo $tarifa;
                            ?>
                        </td>
                        <td>
                            <?php echo $tarifa_extra; ?>
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
                                if ($peso_vol1 > $P){
                                    //calculo con el peso volumetrico
                                    $peso_aplicar = $peso_vol1 - $peso_base;
                                    if($peso_aplicar > $peso_base){
                                        $valor_extra = $peso_aplicar * $tarifa_extra;
                                        $valor_pagar = $valor_extra + $tarifa;
                                        echo $valor_pagar;
                                    }else{
                                        $valor_pagar = $tarifa;
                                        echo $tarifa;
                                    }
                                }else{
                                    $peso_aplicar = $P - $peso_base;
                                    if($peso_aplicar > $peso_base){
                                        $valor_extra = $peso_aplicar * $tarifa_extra;
                                        $valor_pagar = $valor_extra + $tarifa;
                                        echo $valor_pagar;
                                    }else{
                                        $valor_pagar = $tarifa;
                                        echo $tarifa;
                                    };
                                }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php
    incluirTemplate('fottersis');
    ?>