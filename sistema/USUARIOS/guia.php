<?php

$id_consGeneral = $_GET['id'] ?? null;
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

$id_consGeneral
?>

<body class="bg-gradient-primary">
    <div class="container">
        <div id="printable">
        <!-- encabezado de la guia de remision -->
            <div class="row">
                <div class="card col ms-2">
                    <img src="../../IMG/gc-go.png" class="img-fluid pt-1 m-auto" alt="Logo GC-GO" style="width: 25rem;">
                    <div class="card-body">
                        <h1 class="fw-bold">GC-GO</h1>
                        <p>Una empresa del GRUPO REVILLA</p>
                        <p class="card-text">
                            Soluciones inmediatas, paqueteria facil llegamos a todo el pais.
                        </p>
                    </div>
                </div>
                <div class="card col ms-2">
                    <figure class="figure">
                        <img src="../../IMG/global.png" class="img-fluid pt-1 m-auto float-end" style="width: 15rem;">
                    </figure>
                    <div class="card-body">
                        <hr>
                        <p>
                            <strong>Matriz:</strong>
                            <span>Av. San Luis, Ed San Rafael Business Center, piso 5, oficina 5B</span>
                            <br>
                            <strong>Sucursal:</strong>
                            <span>Guayaquil, Centro Empresarial Colon, Empresarial 5, piso 2 oficina 209</span>
                            <br>
                            <strong>Telefono</strong>
                            <span>022-477-8976</span>
                            <br>
                            <strong>Correos.</strong>
                            <span>contabilidad@globalcargoecuador.com</span>
                        <fieldset>
                            <strong>R.U.C. :</strong>
                            <span>0993138150001</span>
                            <br>
                            <strong class="fs-3">GUIA DE REMISION</strong>
                            <br>
                            <strong class="fs-2">No.</strong>
                            <!-- inicio de consultas con entre tablas -->
                            <span class="fs-2">
                                <?php
                                $consulta_guia = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db4, $consulta_guia);
                                $guia = mysqli_fetch_assoc($eje_guia);
                                echo $guia['guia'];
                                ?>
                            </span>
                        </fieldset>
                        </p>
                        <hr>
                        <p>
                            <strong>Quien lleva el paquete:</strong>
                            <span>
                                <?php
                                $consulta_quien = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                $eje_quien = mysqli_query($db4, $consulta_quien);
                                $quien = mysqli_fetch_assoc($eje_quien);
                                $trans_p = $quien['transporte'];
                                //consulta de datos del motorizado
                                $mot_datos = "SELECT * FROM colaborador WHERE id = $trans_p";
                                $eje_quien2 = mysqli_query($db4, $mot_datos);
                                $m_datos = mysqli_fetch_assoc($eje_quien2);
                                $m_nombre = $m_datos['nombre'];
                                $m_apellido = $m_datos['apellido'];
                                $m_contacto = $m_datos['celular'];
                                echo $m_nombre . " " . $m_apellido;
                                ?>
                            </span>
                            <br>
                            <strong>Contacto:</strong>
                            <span><?php echo $m_contacto ?></span>
                            <br>
                            <strong>Tipo de Transporte</strong>
                            <span>Motorizado</span>
                            <br>
                            <strong>Asesorado por:</strong>
                            <span>
                                <?php
                                $consulta_asesor = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                $eje_asesor = mysqli_query($db4, $consulta_asesor);
                                $asesor = mysqli_fetch_assoc($eje_asesor);
                                $asesor_p = $asesor['asesor'];
                                echo $asesor_p;
                                ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        <!-- fin del encabezado de la guia de remision -->
        <!-- cuerpo de la guia de remision -->
            <div class="row mt-1">
                <div class="card col ms-2">
                    <h5 class="card-title mt-2">INFORMACION DE REMITENTE</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Quien me envia este paquete.</h6>
                    <div class="card-body">
                        <p class="card-text">
                            <strong>Quien envia:</strong>
                            <span>
                                <?php
                                $consulta_guia = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db4, $consulta_guia);
                                $consulta_cliente = mysqli_fetch_assoc($eje_guia);
                                $d_cliente = $consulta_cliente['cliente'];
                                $consulta_cliente2 = "SELECT * FROM clientes WHERE cedula = $d_cliente";
                                $eje_cliente = mysqli_query($db4, $consulta_cliente2);
                                $cliente = mysqli_fetch_assoc($eje_cliente);
                                $nombre_cliente = $cliente['nombre'];
                                $apellido_cliente = $cliente['apellido'];
                                $correo = $cliente['correo'];
                                $telefono = $cliente['telefono1'];
                                echo $nombre_cliente . " " . $apellido_cliente;
                                ?>
                            </span>
                            <br>
                            <strong>Telefono:</strong>
                            <span>
                                <?php
                                echo $telefono;
                                ?>
                            </span>
                            <br>
                            <strong>Ciudad de Origen</strong>
                            <span>Quito</span>
                            <br>
                            <strong>Correo</strong>
                            <span>
                                <?php
                                echo $correo;
                                ?>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="card col ms-2">
                    <h5 class="card-title mt-2">INFORMACION DE DESTINATARIO</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Quien va a recibir el paquete.</h6>
                    <div class="card-body">
                        <p class="card-text">
                            <strong>Quien recibe:</strong>
                            <span>
                                <?php
                                $consulta_guia = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db4, $consulta_guia);
                                $nombre = mysqli_fetch_assoc($eje_guia);
                                echo $nombre['nombre'];
                                ?>
                            </span>
                            <br>
                            <strong>Cedula / RUC:</strong>
                            <span>
                                <?php
                                $consulta_guia = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db4, $consulta_guia);
                                $cedula = mysqli_fetch_assoc($eje_guia);
                                echo $cedula['cedula'];
                                ?>
                            </span>
                            <br>
                            <strong>Provincia / Ciudad:</strong>
                            <span>
                                <?php
                                $consulta_guia = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db4, $consulta_guia);
                                $guia = mysqli_fetch_assoc($eje_guia);
                                $ciudad = $guia['ciudad'];
                                $provincia = $guia['provincia'];
                                echo $provincia . " / " . $ciudad;
                                ?>
                            </span>
                            <br>
                            <strong>Sector:</strong>
                            <span>
                                <?php
                                $consulta_guia = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db4, $consulta_guia);
                                $guia = mysqli_fetch_assoc($eje_guia);
                                $sector = $guia['sector'];
                                echo $sector;
                                ?>
                            </span>
                            <br>
                            <strong>Direccion:</strong>
                            <span>
                                <?php
                                $consulta_guia = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db4, $consulta_guia);
                                $guia = mysqli_fetch_assoc($eje_guia);
                                $direccion = $guia['direccion'];
                                echo $direccion;
                                ?>
                            </span>
                            <br>
                            <strong>Telefono:</strong>
                            <span>
                                <?php
                                $consulta_guia = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db4, $consulta_guia);
                                $guia = mysqli_fetch_assoc($eje_guia);
                                $telefono = $guia['telefono'];
                                echo $telefono;
                                ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        <!-- fin del cuerpo de la guia de remision -->
        <!-- pie de la guia de remision -->
            <div class="row mt-1">
                <div class="card col ms-2">
                    <h5 class="card-title mt-2">INFORMACION DEL PAQUETE</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Que hay dentro del paquete.</h6>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <strong>DETALLES DEL PESO.</strong>
                                    </th>
                                    <th>
                                        <strong>DETALLES ESPECIALES.</strong>
                                    </th>
                                    <th>
                                        <strong>FIRMA DE QUIEN RECIBE.</strong>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="card-text">
                                            <strong>Peso (kg):</strong>
                                            <span>
                                                <?php
                                                $consulta_guia = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                                $eje_guia = mysqli_query($db4, $consulta_guia);
                                                $guia = mysqli_fetch_assoc($eje_guia);
                                                $peso = $guia['peso'];
                                                echo $peso;
                                                ?>
                                            </span>
                                            <br>
                                            <strong>Peso Volumetrico:</strong>
                                            <span>
                                                <?php
                                                $consulta_guia = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                                $eje_guia = mysqli_query($db4, $consulta_guia);
                                                $array_clientes = mysqli_fetch_assoc($eje_guia);
                                                $largo = $array_clientes['l'];
                                                $ancho = $array_clientes['a'];
                                                $alto = $array_clientes['h'];
                                                $P = $array_clientes['peso'];
                                                $consultar_tarifa = $array_clientes['tarifa'];
                                                $peso_vol1 = round(($largo * $ancho * $alto) / 5000, 2);
                                                echo $peso_vol1;
                                                //consultar el valor de tarifa a aplicar
                                                $cons_tarifa = "SELECT * FROM tarifas WHERE nombre = '${consultar_tarifa}';";
                                                $eje_consT = mysqli_query($db4, $cons_tarifa);
                                                $valor_tarif = mysqli_fetch_assoc($eje_consT);
                                                $tarifa = $valor_tarif['valor'];
                                                $tarifa_extra = $valor_tarif['valor_extra'];
                                                $peso_base = $valor_tarif['peso'];
                                                ?>
                                            </span>
                                            <br>
                                            <strong class="fs-5">Peso Aplicado</strong>
                                            <span class="fs-5">
                                                <?php
                                                if ($peso_vol1 > $peso) {
                                                    echo $peso_vol1;
                                                } else {
                                                    echo $peso;
                                                }
                                                ?>
                                            </span>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="card-text">
                                            <strong>Hay que Cobrar:</strong>
                                            <span>
                                                <?php
                                                $consulta_asesor = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                                $eje_asesor = mysqli_query($db4, $consulta_asesor);
                                                $asesor = mysqli_fetch_assoc($eje_asesor);
                                                $asesor_p = $asesor['cod'];
                                                echo $asesor_p;
                                                ?>
                                            </span>
                                            <br>
                                            <strong>Cuanto cobramos:</strong>
                                            <span>
                                                <?php
                                                $consulta_asesor = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                                $eje_asesor = mysqli_query($db4, $consulta_asesor);
                                                $asesor = mysqli_fetch_assoc($eje_asesor);
                                                $asesor_p = $asesor['valor'];
                                                echo $asesor_p;
                                                ?>
                                            </span>
                                            <br>
                                            <strong>Se reempaco:</strong>
                                            <span>
                                                <?php
                                                $consulta_asesor = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                                $eje_asesor = mysqli_query($db4, $consulta_asesor);
                                                $asesor = mysqli_fetch_assoc($eje_asesor);
                                                $asesor_p = $asesor['reemparque'];
                                                echo $asesor_p;
                                                ?>
                                            </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <h5 class="card-title mt-2">DESPRENDIBLE PARA ASIGNACION</h5>
                    <strong>
                        <?php
                        $consulta_asesor = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                        $eje_asesor = mysqli_query($db4, $consulta_asesor);
                        $asesor = mysqli_fetch_assoc($eje_asesor);
                        $asesor_p = $asesor['guia'];
                        echo $asesor_p;
                        ?>
                    </strong>
                </div>
            </div>
        <!-- fin del pie de la guia de remision -->
        <!-- desprendible para asignacion -->
            <!-- <div class="row mt-1">
                <div class="card col ms-2">
                    <h5 class="card-title mt-2">DESPRENDIBLE PARA ASIGNACION</h5>
                    <strong>
                        <?php
                        $consulta_asesor = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                        $eje_asesor = mysqli_query($db4, $consulta_asesor);
                        $asesor = mysqli_fetch_assoc($eje_asesor);
                        $asesor_p = $asesor['guia'];
                        echo $asesor_p;
                        ?>
                    </strong>
                    <h6 class="card-subtitle mb-2 text-muted">Firma de responsabilidad para despacho.</h6>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <strong>NOMBRE Y FIRMA DEL MOTORIZADO</strong>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div> -->
        <!-- fin del desprendible para asignacion -->
        </div>
        <!-- informacion financiera -->
            <div class="row mt-1">
                <div class="card col ms-2">
                    <h5 class="card-title mt-2">LIQUIDACION FINANCIERA</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Esta liquidacion muestra el valor del envio pero no sustituye una factura.</h6>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <strong>TARIFA APLICADA.</strong>
                                    </th>
                                    <th>
                                        <strong>IVA.</strong>
                                    </th>
                                    <th>
                                        <strong>VALOR GENERADO.</strong>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="card-text">
                                            <strong>Tipo de tarifa:</strong>
                                            <span>
                                                <?php
                                                $consulta_guia = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                                $eje_guia = mysqli_query($db4, $consulta_guia);
                                                $guia = mysqli_fetch_assoc($eje_guia);
                                                $tarifa = $guia['tarifa'];
                                                echo $tarifa;
                                                ?>
                                            </span>
                                        </p>
                                    </td>
                                    <td>
                                        <?php
                                        $consulta_guia = "SELECT * FROM ordenes WHERE id = '$id_consGeneral';";
                                        $eje_guia = mysqli_query($db4, $consulta_guia);
                                        $array_clientes = mysqli_fetch_assoc($eje_guia);
                                        $largo = $array_clientes['l'];
                                        $ancho = $array_clientes['a'];
                                        $alto = $array_clientes['h'];
                                        $P = $array_clientes['peso'];
                                        $consultar_tarifa = $array_clientes['tarifa'];
                                        $peso_vol1 = round(($largo * $ancho * $alto) / 5000, 2);
                                        //consultar el valor de tarifa a aplicar
                                        $cons_tarifa = "SELECT * FROM tarifas WHERE nombre = '${consultar_tarifa}';";
                                        $eje_consT = mysqli_query($db4, $cons_tarifa);
                                        $valor_tarif = mysqli_fetch_assoc($eje_consT);
                                        $tarifa = $valor_tarif['valor'];
                                        $tarifa_extra = $valor_tarif['valor_extra'];
                                        $peso_base = $valor_tarif['peso'];

                                        if ($peso_vol1 > $peso) {
                                            $peso_vol1;
                                        } else {
                                            $peso;
                                        }
                                        if ($peso_vol1 > $P) {
                                            //calculo con el peso volumetrico
                                            $peso_aplicar = $peso_vol1 - $peso_base;
                                            if ($peso_aplicar > $peso_base) {
                                                $valor_extra = $peso_aplicar * $tarifa_extra;
                                                $valor_pagar = $valor_extra + $tarifa;
                                                $calculo = round($valor_pagar, 2);
                                                $iva = $calculo * 0.12;
                                                echo "$" . round($iva, 2);
                                            } else {
                                                $valor_pagar = $tarifa;
                                                $calculo = round($valor_pagar, 2);
                                                $iva = $calculo * 0.12;
                                                echo "$" . round($iva, 2);
                                            }
                                        } else {
                                            $peso_aplicar = $P - $peso_base;
                                            if ($peso_aplicar > $peso_base) {
                                                $valor_extra = $peso_aplicar * $tarifa_extra;
                                                $valor_pagar = $valor_extra + $tarifa;
                                                $calculo = round($valor_pagar, 2);
                                                $iva = $calculo * 0.12;
                                                echo "$" . round($iva, 2);
                                            } else {
                                                $valor_pagar = $tarifa;
                                                $calculo = round($valor_pagar, 2);
                                                $iva = $calculo * 0.12;
                                                echo "$" . round($iva, 2);
                                            };
                                        }
                                        ?>
                                        </span>
                                    </td>
                                    <td class="fs-4 fw-bolder">
                                        <?php
                                        $valor_final = $valor_pagar + $iva;
                                        echo "$" . round($valor_final, 2);
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        <!-- fin de informacion financiera -->
        <br>
        <button id="imprint">IMPRIMIR</button>
        <br>
        <br>
    </div>
    <br>
    <br>
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../js/jQuery.print.js"></script>
    
    <script>
        $(document).ready(()=> {
            $('#imprint').click(function(){
                $.print('#printable');
            });
        });
    </script>