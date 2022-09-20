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
//---------consulta de datos------------
    $consulta = "SELECT * FROM ordenes;";
    $ejec_consulta = mysqli_query($db4, $consulta);
    $consulta2 = mysqli_fetch_assoc($ejec_consulta);
    $guia = $consulta2['guia'];
    $destin = $consulta2['nombre'];
//---------variables de confirmacion de acciones---------
$error = '';
$errores = [];
//---------variables de proceso y captura de informacion----------
    $l = "";
    $a = "";
    $h = "";
    $peso = "";
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $l = $_POST['l'];
    $a = $_POST['a'];
    $h = $_POST['h'];
    $guia1 = $guia; 
    $peso = $_POST['peso'];
    $destinatario = $destin;
    $fecha = date('y-m-d');
    $responsable = $_SESSION['nombre'];
    $volumen = $l * $a * $h;
    $estado = 'ingreso';
    if(!$l) {
        $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL LARGO";
    }
    if(!$a) {
        $errores[] = "UTAAAAA!!!! FALTA EL ANCHO, MIDE BIEN!!!";
    }
    if(!$h) {
        $errores[] = "Y EL ALTO!!!! PON BIEN SI NO, HAY TABLA!!!";
    }
    if(empty($errores)){
        $actualizar_peso = "UPDATE ordenes SET l = '$l',
                                               a = '$a',
                                               h = '$h',
                                               estado = '$estado',
                                               peso = '$peso'
                                               WHERE id = $id;";
        $eje = mysqli_query($db4, $actualizar_peso);
        $guardar_bodega = "INSERT INTO ingreso_gc(guia, fecha, responsable, destinatario, peso, volumen)
                                        values('$guia1', '$fecha', '$responsable', '$destinatario', '$peso', '$volumen');";
        $guardar_eje = mysqli_query($db2, $guardar_bodega);
        if($guardar_bodega){
            echo "  <script>
                        alert('Pesos registrados correctamente');
                        window.location.href='lista_pesos.php';
                    </script>";
            } else {
                echo "
                            <div class='alert alert-danger' role='alert'>
                                <strong>Error!</strong> 
                                No se registrar el buen peso, vuelve a intentar pues!!!!.
                            </div>";
                exit;
            }

    }
}

?>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- FORMULARIO DE ACTUALIZACION -->
        <div class="card bg-light">
            <?php foreach ($errores as $error) : ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endforeach ?>
            <div class="alert alert-primary">
                <h1>CONFIMAR MEDIDAS Y PESO</h1>
            </div>
            <?php 
                $consultar = "SELECT * FROM ordenes WHERE id = $id;";
                $eje_consulta = mysqli_query($db4, $consultar);
                $datos_orden = mysqli_fetch_assoc($eje_consulta);
            ?>
            <div class="card">
                <div class="card-header">
                    <h5>Vas actualizar el pedido de: <?php echo $datos_orden['nombre']; ?></h5> 
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Remitente (quien envia) <?php 
                    $cedula = $datos_orden['cliente'];
                    $nombre = "SELECT * FROM clientes WHERE cedula = '$cedula';";
                    $eje_nombre = mysqli_query($db4, $nombre);
                    $nombre_p = mysqli_fetch_assoc($eje_nombre);
                    echo $nombre_p['nombre']." ".$nombre_p['apellido'];
                    ?></li>
                    <li class="list-group-item">Destinatario (quien recibe) <?php echo $datos_orden['nombre']; ?></li>
                </ul>
            </div>
            <form action='' method="POST" >
                <br>

                <div class="row g-3">
                    <p class="h3">Ingresar las medias. (Los decimales registrar con . no con ,)</p>
                    <div class="col-sm">
                        <input type="text" class="form-control form-control-user" placeholder="Largo" aria-label="largo" name="l">
                    </div>
                    <div class="col-sm">
                        <input type="text" class="form-control form-control-user" placeholder="Ancho" aria-label="ancho" name="a">
                    </div>
                    <div class="col-sm">
                        <input type="text" class="form-control form-control-user" placeholder="Altura" aria-label="altura" name="h">
                    </div>
                    <div class="col-sm">
                        <input type="text" class="form-control form-control-user" placeholder="Peso" aria-label="peso" name="peso">
                    </div>
                </div>
                <br>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <input type="submit" value="REGISTRAR PESOS" class="btn btn-outline-primary bi-text-center">
                </div>
                <br>
            </form>
        </div>
        <!-- FIN DE FORMULARIO DE ACTUALIZACION -->
    </div>
    <br>
    <br>

    <?php
incluirTemplate('fottersis')
    ?>