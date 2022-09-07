<?php
$id = $_GET['id'] ?? null;
//Verificar si esta o no en sesion
require '../../includes/funciones.php';
$auth = estaAutenticado();
if (!$auth) {
    header('location: ../global/index.php');
}
//Incluir conexion a la base de datos
require '../../includes/config/database.php';

//Incluir template
incluirTemplate('headersis2');

//Conexion a la base de datos
conectarDB();
$db = conectarDB();

//BASE DE DATOS BODEGA 
conectarDB2();
$db2 = conectarDB2();

//coneccion api
conectarDB3();
$db3 = conectarDB3();

//coneccion callcenter
conectarDB4();
$db4 = conectarDB4();

//coneccion callcenter
conectarDB5();
$db4 = conectarDB5();

//coneccion callcenter
conectarDB6();
$db4 = conectarDB6();

//consulta para obtener el usuario
$query = "SELECT * FROM usuario;";
$resultado = mysqli_query($db, $query);

//consulta para obtener el usuario
$query2 = "SELECT * FROM usuario;";
$resultado2 = mysqli_query($db, $query2);


//Variables implicitas en el sistema
$fecha_solicitud = date('Y-m-d');
//declaracion de variables para recepcion desde el formulario
$usuario_id = "";
$a_descuento = "";
$tiempo = "";
$hora_salida = "";
$hora_ingreso = "";
$autorizado = "";
$fecha_permiso = "";
$registrado_por = "";
$tiempo_calculado = "";
$numero_documento = "";
$respaldo_salida = "";
$respaldo_ingreso = "";
$motivo = "";
$observacion = "";
$asume_actividades = "";
//numero de documento
$nuemro = "";
$numero_3 = "";
$fecha_2 = "";
$numero_doc = "";

//captura de datos metodo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //generar numero de documento
        //generar el numero de guia
        $numero_3 = mt_rand();
        $nuemro = substr($numero_3 ,4);
        $fecha_2 = date('d');
        $numero_doc = "GC"."-".$fecha_2."-".$numero_3;

    $usuario_id = $_POST['usuario_id'];
    $a_descuento = $_POST['a_descuento'];
    $tiempo = $_POST['tiempo'];
    $hora_salida = $_POST['hora_salida'];
    $hora_ingreso = '18:00:00';
    $autorizado = ''; // update para aprobacion
    //$fecha_permiso = $_POST['fecha_permiso'] declarada desde el sistema;
    $registrado_por = $_SESSION['usuario'];
    //calculo de tiempo 
        $hi = strtotime($hora_salida);
        $hf = strtotime($hora_ingreso)-strtotime('midnight');;
        $numero_documento = $numero_doc;
        $respaldo_salida = $_POST['respaldo_salida'] ?? null;
        $respaldo_ingreso = $_POST['respaldo_ingreso'] ?? null;
        $motivo = $_POST['motivo'];
        $observacion = $_POST['observacion'];
        $asume_actividades = $_POST['asume_actividades'];
        
    echo date('G:i:s',$hi+$hf);
    echo $tiempo_calculado ;
}
?>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="tittle">
            <h1>SOLICITUD DE PERMISO</h1>
        </div>
        <form method="POST" action="">
            <fieldset class="border p-3">
                <legend>Información del usuario</legend>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="a_descuento" value = "SI"id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Aplica descuento (NO REMUNERADO)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="a_descuento" value = "NO" id="flexRadioDefault2" checked>
                    <label class="form-check-label" for="flexRadioDefault2">
                        No aplica descuento (REMUNERADO)
                    </label>
                </div>
                <div class="input-group mb-3">
                    <select class="form-select form-select-sm" name="usuario_id" aria-label=".form-select-sm example">
                        <option selected>Selecciona un colaborador.</option>
                        <?php while ($row = mysqli_fetch_assoc($resultado)) : ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre'] . " " . $row['apellido']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon3">Tiempo de permiso (hora:minuto:segundo)</span>
                    <input type="time" name="tiempo"  class="form-control" id="basic-url" aria-describedby="basic-addon3">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon3">Hora de salida (hora:minuto:segundo)</span>
                    <input type="time" name="hora_salida" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon3">Fecha de aplicacion de permiso</span>
                    <input type="date" name="fecha_permiso" min="0:30" max="02:00" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                </div>
                <div class="input-group mb-3">
                    <select class="form-select form-select-sm" name="motivo" aria-label=".form-select-sm example">
                        <option selected>Selecciona un Motivo</option>
                        <option value="Cita Medica">Cita Medica</option>
                        <option value="Personal">Personal</option>
                        <option value="Actividades de la empresa">Actividades de la empresa</option>
                        <option value="Otros">Otros</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Observacion</span>
                    <textarea class="form-control" name="observacion" aria-label="With textarea"></textarea>
                </div>
                <div class="input-group mb-3">
                    <select class="form-select form-select-sm" name="asume_actividades" aria-label=".form-select-sm example">
                        <option selected>Quien asume sus funciones</option>
                        <?php while ($row = mysqli_fetch_assoc($resultado2)) : ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre'] . " " . $row['apellido']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <input type="file" name="fecha_permiso" min="0:30" max="02:00" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                </div>
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <button type="submit" class="btn btn-outline-primary">Solicitar</button>
                </div>
            </fieldset>
        </form>
    </div>
    <?php
    incluirTemplate('fottersis2');
    ?>