<?php
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
//----------------DECLARAR VARIABLES DEL SISTEM Y CONSTANTES DEL SERVIDOR----------------
    $tarifa = "";
    $valor = "";
    $peso_maximo = "";
    $valor_extra = "";
    $errores = [];
    $error = '';

//----------------CAPTURA DE DATOS METODO POST----------------
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tarifa = $_POST['tarifa'];
    $valor = $_POST['valor'];
    $peso_maximo = $_POST['peso_maximo'];
    $valor_extra = $_POST['valor_extra'];
    $responsable = $_SESSION['usuario'];
    $fecha = date('y-m-d');

    if(!$tarifa) {
        $errores[] = "NOOOO!!!! POR FAVOR INGRESA UNA TARIFA.....";
    }
    if(!$valor) {
        $errores[] = "UTAAAAA!!!! FALTA EL VALOR PUES.....";
    }
    if(!$peso_maximo) {
        $errores[] = "NO SE PUEDE ASI!!!! FALTA EL PESO MAXIMO.....";
    }
    if(!$valor_extra) {
        $errores[] = "ELEEEEE QUESF!!!! PON EL VALOR EXTRA SI NO COMO?.....";
    }
    if(empty($errores)){
        $g_tarifa = "INSERT INTO tarifas (nombre, valor, peso, valor_extra, responsable, fecha)
                                    values('$tarifa', '$valor', '$peso_maximo', '$valor_extra', '$responsable', '$fecha');";
        $ej_tarifa = mysqli_query($db4, $g_tarifa);
        if ($ej_tarifa){
            $error = 1;

        }

    }
}

?>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- FORMULARIO DE ACTUALIZACION -->
            <div class="card bg-light">
                    <?php foreach($errores as $error) : ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach ?>
                    <?php if(intval($error) === 1 ): ?>
                        <p class="alert alert-success">VES!!!! FACIL ES HAGALE, HAGALE...</p>
                    <?php endif ?>
                <div class="alert alert-primary">
                    INGRESAR TARIFAS DE PAQUETERIA
                </div>
                <form action ='' method="POST" enctype="multipart/form-data">
                    <br>
                    <div class="mb-3">
                        <label for="tarifa" class="form-label">Nombre de la tarifa...</label>
                        <input type="text" placeholder="Ingresar el nombre solo en mayusculas" id="tarifa" accept="pdf" name="tarifa" class="form-control" require aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Valor $</span>
                        <input type="float" class="form-control" name="valor" aria-label="Amount (to the nearest dollar)">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Peso maximo...</span>
                        <input type="float" placeholder="Ingresar en KILOS si hay decimales con . no con , " class="form-control" name="peso_maximo" aria-label="Amount (to the nearest dollar)" >
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Valor extra por kilo...</span>
                        <input type="float" placeholder="Ingresar, si hay decimales con . no con , " class="form-control" name="valor_extra" aria-label="Amount (to the nearest dollar)">
                    </div>
                    <br>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <input type="submit" value="INGRESAR TARIFA" class="btn btn-outline-primary bi-text-center">
                    </div>
                    <br>
                </form>
            </div>
        <!-- FIN DE FORMULARIO DE ACTUALIZACION -->
    </div>
    <br>
    <br>
    <div class="container">
        <div class="alert alert-primary">
            <h4 class="">TARIFAS INGRESADAS</h4>
        </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>TARIFA</th>
                <th>VALOR</th>
                <th>PESO MAXIMO</th>
                <th>V EXTRA POR KILO</th>
                <th>FECHA DE REGISTRO</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $consulta = "SELECT * FROM tarifas";
            $eje_consulta = mysqli_query($db4, $consulta);
            while($tarifas = mysqli_fetch_assoc($eje_consulta)):?>
            <tr>
                <td><?php echo $tarifas['nombre'];?></td>
                <td><?php echo $tarifas['valor'];?></td>
                <td><?php echo $tarifas['peso'];?></td>
                <td><?php echo $tarifas['valor_extra'];?></td>
                <td><?php echo $tarifas['fecha'];?></td>
            </tr>
            <?php endwhile;?>
        </tbody>
    </table>
    </div>
    <br>
    <br>
<?php 
    incluirTemplate('fottersis');
?>