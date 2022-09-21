<?php
// genera la guia que se va a impprimir, dato requerido id de la orden enviado por get.
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
?>

<body class="bg-gradient-primary">
    <div class="container">
        <div id="printable">
        <!-- encabezado de la guia de remision -->
            <div class="row">
                <div class="card col ms-2">
                    <img src="../../IMG/gc-go.png" class="img-fluid pt-1 m-auto" alt="Logo GC-GO" style="width: 20rem;">
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
                            <!-- inicio de consultas con entre tablas NUMERO DE GUIA -->
                            <span class="fs-2">
                                <?php
                                $numero_guia = "SELECT * FROM orders WHERE id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db3, $numero_guia);
                                $guia = mysqli_fetch_assoc($eje_guia);
                                echo $guia['order_id'];
                                ?>
                            </span>
                            <br>
                            <strong>Fecha de emision:</strong>
                            <span>
                                <?php
                                $consulta_guia = "SELECT * FROM order_clients WHERE order_id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db3, $consulta_guia);
                                $guia = mysqli_fetch_assoc($eje_guia);
                                $sector = $guia['created_at'];
                                echo $sector;
                                ?>
                            </span>
                            <br>
                        </fieldset>
                        </p>
                        <hr>
                        <p>
                            <strong>Quien lleva el paquete:</strong>
                            <span>
                                Transporte autorizado por la empresa
                            </span>
                            <br>
                            <strong>Contacto:</strong>
                            <span>022-477-8977</span>
                            <br>
                            <strong>Tipo de Transporte</strong>
                            <span>Motorizado</span>
                            <br>
                            <strong>Asesorado por:</strong>
                            <span>
                                GC-GO PAQUETERIA FACIL
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
                                Smart Cosmetics
                            </span>
                            <br>
                            <strong>Telefono:</strong>
                            <span>
                                +593 99 999 9999
                            </span>
                            <br>
                            <strong>Ciudad de Origen</strong>
                            <span>Quito</span>
                            <br>
                            <strong>Correo</strong>
                            <span>
                                info@cosmetics.org
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
                                $consulta_guia = "SELECT * FROM order_clients WHERE order_id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db3, $consulta_guia);
                                $nombre = mysqli_fetch_assoc($eje_guia);
                                echo $nombre['name']." ".$nombre['last_name'];
                                ?>
                            </span>
                            <br>
                            <strong>Provincia / Ciudad:</strong>
                            <span>
                                <?php
                                $consulta_guia = "SELECT * FROM order_clients WHERE order_id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db3, $consulta_guia);
                                $guia = mysqli_fetch_assoc($eje_guia);
                                $ciudad = $guia['city'];
                                $provincia = $guia['province'];
                                echo $provincia . " / " . $ciudad;
                                ?>
                            </span>
                            <br>
                            <strong>Referencia:</strong>
                            <span>
                                <?php
                                $consulta_guia = "SELECT * FROM order_clients WHERE order_id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db3, $consulta_guia);
                                $cedula = mysqli_fetch_assoc($eje_guia);
                                echo $cedula['reference'];
                                ?>
                            </span>
                            <br>
                            <strong>Direccion:</strong>
                            <span>
                                <?php
                                $consulta_guia = "SELECT * FROM order_clients WHERE order_id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db3, $consulta_guia);
                                $guia = mysqli_fetch_assoc($eje_guia);
                                $direccion = $guia['address'];
                                echo $direccion;
                                ?>
                            </span>
                            <br>
                            <strong>Telefono:</strong>
                            <span>
                                <?php
                                $consulta_guia = "SELECT * FROM order_clients WHERE order_id = '$id_consGeneral';";
                                $eje_guia = mysqli_query($db3, $consulta_guia);
                                $guia = mysqli_fetch_assoc($eje_guia);
                                $telefono = $guia['phone']." / ".$guia['landline'];
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
                                            <strong>Detalle de Productos:</strong><br>
                                            <?php
                                                $consulta_guia = "SELECT * FROM order_products WHERE order_id = '$id_consGeneral';";
                                                $eje_guia = mysqli_query($db3, $consulta_guia);
                                                 while ($productos = mysqli_fetch_assoc($eje_guia)):?>
                                            <span><?php echo $productos['name']." - ".$productos['quantity']." Unidad/es";?></span><br>
                                            <?php endwhile; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="card-text">
                                            <strong>Hay que Cobrar:</strong>
                                            <span>
                                                Si
                                            </span>
                                            <br>
                                            <strong>Cuanto cobramos:</strong>
                                            <span>
                                                <?php
                                                $consulta_asesor = "SELECT sum(unit_price) as total FROM order_products WHERE order_id = '$id_consGeneral';";
                                                $eje_asesor = mysqli_query($db3, $consulta_asesor);
                                                $cobrar = mysqli_fetch_assoc($eje_asesor);
                                                $a_pagar = $cobrar['total'];
                                                $por_cobrar = $a_pagar/100;
                                                $cobrar_total = number_format($por_cobrar, 2, '.', '');
                                                echo "$ ".$cobrar_total;
                                                ?>
                                            </span>
                                            <br>
                                            <strong>Se reempaco:</strong>
                                            <span>
                                                Empacado en su caja original.
                                            </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <h5 class="card-title mt-2">DESPRENDIBLE PARA ASIGNACION</h5>
                    <strong>
                        <?php
                        $consulta_asesor = "SELECT * FROM orders WHERE id = '$id_consGeneral';";
                        $eje_asesor = mysqli_query($db3, $consulta_asesor);
                        $asesor = mysqli_fetch_assoc($eje_asesor);
                        $asesor_p = $asesor['order_id'];
                        echo $asesor_p;
                        ?>
                    </strong>
                    <br>
                    <strong>Dinero por regresar:</strong>
                                            <span>
                                                <?php
                                                $consulta_asesor = "SELECT sum(unit_price) as total FROM order_products WHERE order_id = '$id_consGeneral';";
                                                $eje_asesor = mysqli_query($db3, $consulta_asesor);
                                                $cobrar = mysqli_fetch_assoc($eje_asesor);
                                                $a_pagar = $cobrar['total'];
                                                $por_cobrar = $a_pagar/100;
                                                $cobrar_total = number_format($por_cobrar, 2, '.', '');
                                                echo "$ ".$cobrar_total;
                                                ?>
                                            </span>
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