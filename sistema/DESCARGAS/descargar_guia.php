<?php
ob_start();
//generear documento en xlml
//header("Content-Type: application/xls");
//header("Content-Disposition: attachment; filename=informediario.xls");

$guia = $_GET['guia'] ?? null;

require '../../includes/config/database.php';
require '../../includes/funciones.php';
//coneccion de sesion
conectarDB();
$db = conectarDB();

//coneccion api
conectarDB3();
$db3 = conectarDB3();

//coneccion callcenter
conectarDB4();
$db4 = conectarDB4();

$auth = estaAutenticado();

// proteger la página
if (!$auth) {
    header('location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GLOBAL CARGO SYS</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css2/sb-admin-2.min.css" rel="stylesheet">

</head>

<body>
    <br>
    <div class="container">
        <div class="row g-2">
            <div class="col border m-1">
                <br>
                <img src="../../IMG/global.png" class="img-fluid align-center" alt="...">
                <h2 class="fw-bolder text-dark">GLOBALCARGO-EC CIA. LTDA.</h2>
                <p class="fs-2">
                <h5 class="text-dark">Matriz: <span>Av. San Luis, Ed. San Rafael Business Center, piso 5, oficina 5B</span></h5>
                <br>
                <h5 class="text-dark">Sucursal:</h5><br>
                <h5 class="text-dark">Telefono: <span>0224778976</span></h5>
                <br>
                <h5 class="text-dark">Correos: <span>contabilidad@globalcargoecuador.com</span></h5>
                <br>
                <h5 class="text-dark">Obligado a llevar contabilidad: <span>Si.</span></h5>
                <br>
                </p>
            </div>
            <div class="col border m-1">
                <br>
                <h2 class="fw-bolder">GLOBALCARGO-EC CIA. LTDA.</h2>

                <h5 class="text-dark">R.U.C.:</h5>
                <p>0993138150001</p><br>
                <h5 class="text-dark">GUIA DE REMISION</h5>
                <h5 class="text-dark">NUMERO: </h5>
                <p><?php echo $guia; ?></p><br>
                <br>
                <br>
                <h5 class="text-dark">AMBIENTE: <span>PRODUCCION</span></h5> <br>
                <h5 class="text-dark">EMISION: <span>NORMAL</span></h5> <br>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col ">
                <div class="card">
                    <div class="card-header">
                        INFORMACION DEL REMITENTE (Remitente, Quien envia el paquete)
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php  ?></h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col ">
                <div class="card">
                    <div class="card-header">
                        INFORMACION DEL CONSIGNATARIO (Destinatario, Quien Recibe el paquete)
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php  ?></h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col ">
                <div class="card">
                    <div class="card-header">
                        INFORMACION DEL TRANSPORTE
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php  ?></h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col ">
                <div class="card">
                    <div class="card-header">
                        INFORMACION DE LA CARGA
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>sdfsdf</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>sdfsfd</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col ">
                <div class="card">
                    <div class="card-header">
                        ESPACIO PARA CONFIRMACION DE RECEPCION (Firma quien recibe la carga)
                    </div>
                    <div class="card-body">
                        <br>
                        <br>
                        <br>
                        <br>
                        <p class="card-text">Yo, </p>
                        <h5 class="card-title"><?php  ?></h5>
                        <p class="card-text">Firmo en conformidad a la entrega de la encomienda que se detalla en el presente documento.</p>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <hr>
        <div class="row">
            <div class="col ">
                <div class="card">
                    <div class="card-header">
                        DESPRENDIBLE DE RESPONSABILIDAD
                    </div>
                    <div class="card-body">
                        <br>
                        <br>
                        <p class="card-text">Asignado a: </p>
                        <h5 class="card-title"><?php  ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <hr>
</body>
</html>
<?php 
    $doc = ob_get_clean();
    echo $doc;

    //cargar en el proyecto la libreria dompdf
    require_once '../../includes/dompdf/autoload.inc.php';

    //crear el objeto parametros de convercion 
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();

    //opcion para mostrar imagenes 
    $options = $dompdf->getOptions();
    $options->set(array('isRemoteEnable' => true));
    $dompdf->setOptions($options);

    //cargar el contenido del buffer
    $dompdf->loadHtml($doc);

    //configurar el tamano del papel
    $dompdf->setPaper('letter');

    //renderizar o visualuzar el documento
    $dompdf->render();

    //dar nombre al archivo y prederminar si se desacarga o no directamente
    $dompdf->stream("guia.pdf", array("Attachment" => false));
?>