<?php

//incluye el header
require '../../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('location: ../global/index.php');
}

require '../../includes/config/database.php';
incluirTemplate('headersis2');

//coneccion BDD Global Cargo
conectarDB();
$db = conectarDB();

//coneccion BDD Bodega Trade
conectarDB2();
$db2 = conectarDB2();

//coneccion BDD Api Rusia
conectarDB3();
$db3 = conectarDB3();

//coneccion BDD Api Rusia
conectarDB4();
$db4 = conectarDB4();

//----------------------consulta de datos generales-------------------------------------
$query = "SELECT * FROM usuario WHERE id = '${_SESSION['id']}' ";
$resultado = mysqli_query($db, $query);
$usuario = mysqli_fetch_assoc($resultado);
$condicional = $usuario['cedula'];
$validar_foto = $usuario['foto'];

$errores = [];

//DECLARACION DE VARIABLES DEL PERSONAL
$cedula = "";
$nombre = "";
$apellido = "";
$telefono1 = "";
$telefono2 = "";
$correo1 = ""; //correo institucional asignado.
$correo2 = ""; //correo alternativo.
$tipo = ""; //cargo asignado realcion con las funciones asignadas.
$provincia = "";
$canton = "";
$ciudad = "";
$comentario = "";
$foto = ""; //foto de perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //----------------------VALIDACION DE DATOS-------------------------------
    $cedula = mysqli_real_escape_string($db, $_POST['cedula']);
    $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($db, $_POST['apellido']);
    $telefono1 = mysqli_real_escape_string($db, $_POST['telefono1']);
    $telefono2 = mysqli_real_escape_string($db, $_POST['telefono2']);
    $correo = mysqli_real_escape_string($db, $_POST['correo1']);
    $correo1 = $correo.'@globalcargoecuador.com';
    $correo2 = mysqli_real_escape_string($db, $_POST['correo2']);
    $tipo = mysqli_real_escape_string($db, $_POST['tipo']);
    $provincia = mysqli_real_escape_string($db, $_POST['provincia']);
    $canton = mysqli_real_escape_string($db, $_POST['canton']);
    $ciudad = mysqli_real_escape_string($db, $_POST['ciudad']);
    $comentario = mysqli_real_escape_string($db, $_POST['comentarios']);
    $sueldo_base = mysqli_real_escape_string($db, $_POST['sueldo_base']);
    $foto = null;
    $cliente = null;

    //validacion de campos vacios

    if (!$cedula) {
        $errores[] = "Empezo!!!! La cedula es mega importante pon todo...";
    }
    if (!$nombre) {
        $errores[] = "Quesf!!!! el nombre es mega importante pon todo...";
    }
    if (!$apellido) {
        $errores[] = "Y el apellido...? Pon pues, asi no se puede...";
    }
    if (!$telefono1) {
        $errores[] = "A donde te llamo!!!! Telefono celular donde te encuentro...";
    }
    if (!$telefono2) {
        $errores[] = "Otro telefono, donde mas te puedo encontrar...";
    }
    if (!$correo1) {
        $errores[] = "Asigna un correo si no, como va a entrar al sistema, no se puede asiiiiiiiii....";
    }
    if (!$correo2) {
        $errores[] = "Otrooooooooo correo aqui te enviamos el rol, del todo mismo...";
    }
    if (!$provincia) {
        $errores[] = "De donde sois, de que provincia es tu casa...";
    }
    if (!$canton) {
        $errores[] = "Especifica en que canton esa tu casa, googlea aunque sea...";
    }
    if (!$ciudad) {
        $errores[] = "Especifica en que ciudad esa tu casa, googlea aunque sea...";
    }
    if (!$comentario) {
        $errores[] = "Especifica un comentario, porque es importante...";
    }
    //actualizacion de datos
    if (empty($errores)) {

    //     //SUBIR FOTOS DE DEPOSITOS
    //     //CREAR CARPETA
    //     $fotos_personal = '../../fotos_personal/';

    //     //verificar si la carpeta existe
    //     if (!is_dir($fotos_personal)) {
    //         //crear el directorio utilizando MKDIR si no hay se crea
    //         mkdir($fotos_personal);
    //     }

    //     //crear nombre unico
    //     $foto_perfil = md5(uniqid(rand(), true)) . ".jpg";

    //     //subir el archivo
    //     move_uploaded_file($foto['tmp_name'], $fotos_personal . $foto_perfil);

        //actualizar la base de datos

        // "UPDATE usuario SET 
        //                     cedula = '$cedula',
        //                     nombre = '$nombre',
        //                     apellido = '$apellido',
        //                     telefono1 = '$telefono1',
        //                     telefono2 = '$telefono2',
        //                     correo2 = '$correo2',
        //                     provincia = '$provincia',
        //                     canton = '$canton',
        //                     ciudad = '$ciudad',
        //                     comentarios = '$comentario',
        //                     foto = '$foto_perfil'
        //                     WHERE id = '${_SESSION['id']}';";
        $query =  "INSERT INTO usuario (cedula, nombre, apellido, telefono1, telefono2, correo1, correo2, tipo, cliente, provincia, canton, ciudad, comentarios, foto, sueldo_base)
                    VALUES ('$cedula', '$nombre', '$apellido', '$telefono1', '$telefono2', '$correo1', '$correo2', '$tipo', '$cliente', '$provincia', '$canton', '$ciudad', '$comentario', '$foto', '$sueldo_base')";
                    $resultado = mysqli_query($db, $query);
        if ($resultado) {
            echo "<script>
                    guardar();
                    window.location.href='ingreso_personal.php';
                  </script>";
        } else {
            echo "
                <div class='alert alert-danger' role='alert'>
                    <strong>Error!</strong> 
                    No se pudo actualizar los datos.
                </div>";
            exit;
        }
    }
}

?>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                INGRESO DE PERSONAL / REGISTRO .
            </div>
            <div class="card-body">
                <form method="POST" action=" " enctype="multipart/form-data">
                    <?php foreach ($errores as $error) : ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach ?>
                    <h5 class="card-title">REGISTRAR NUEVO INGRESO</h5>
                    <p class="card-text text-muted fs-6 fst-italic">Confirmar si los datos ingresados son correctos.</p>
                    <?php if (!$validar_foto) : ?>
                        <img src="../../fotos_personal/foto_ejemplo.jpeg" class="img-thumbnail pt-1 m-auto" alt="..." style="width: 25rem" ;>
                        <div class="alert alert-danger" role="alert">
                            <strong>No hay texto, jeje </strong>
                            Agregar una foto, alajito/a :v Si no, esta sera tu foto en los documentos. jejejejeje igualito/a
                        </div>
                    <?php else : ?>
                        <div class="input-group mb-3">
                            <img src="../../fotos_personal/<?php echo $validar_foto; ?>" class="img-thumbnail pt-1 m-auto" alt="..." style="width: 25rem" ;>
                        </div>
                    <?php endif; ?>
                    <label for="foto" class="form-label">Agrega foto</label>
                    <div class="input-group mb-3">
                        <input type="file" name="foto" id="foto" class="form-control text-uppercase" placeholder="cargo" aria-label="correo" value="<?php echo  $datos_personal['tipo']; ?>" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">DATOS PERSONALES</span>
                        <input type="text" name="nombre" class="form-control" placeholder="Nombres" aria-label="nombre">
                        <input type="text" name="apellido" class="form-control" placeholder="Apellidos" aria-label="apellido">
                        <input type="text" name="cedula" class="form-control" placeholder="Numero de Cedula" aria-label="cedula">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">CARGO ASIGNADO</span>
                        <select name="tipo" class="form-select form-select-sm" aria-label="Default select example">
                            <option value='' selected> Selecciona un estado</option>
                            <option value="asesor">Asesor Comercial</option>
                            <option value="gerencia_paqueteria">Gerencia Paqueteria</option>
                            <option value="recursos humanos">Recursos Humanos</option>
                            <option value="coordinacion">Coordinacion</option>
                            <option value="admin">Administrativo</option>
                            <option value="seguimiento">Seguimiento</option>
                            <option value="motorizado">Motorizado</option>
                            <option value="moto-colaborador">Moto - Colaborador</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="correo1" class="form-control" placeholder="Correo Asignado" aria-label="correo" aria-describedby="basic-addon1">
                        <span class="input-group-text" id="basic-addon1">@globalcargoecuador.com</span>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="sueldo_base" class="form-control" placeholder="Sueldo Base" aria-label="correo" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">@</span>
                        <input type="text" name="correo2" class="form-control" placeholder="Correo secundario" aria-label="correo" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Telefonos de contacto</span>
                        <input type="text" name="telefono1" class="form-control" placeholder="telefono 1" aria-label="nombre">
                        <input type="text" name="telefono2" class="form-control" placeholder="telefono 2" aria-label="apellido">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Direccion Domicialria</span>
                        <input type="text" name="provincia" class="form-control" placeholder="Provincia" aria-label="Provincia">
                        <input type="text" name="canton" class="form-control" placeholder="Canton" aria-label="Canton">
                        <input type="text" name="ciudad" class="form-control" placeholder="Direccion" aria-label="Ciudad">
                    </div>
                    <label for="basic-url" class="form-label">Primera espectativa, primer dia de trabajo</label>
                    <div class="input-group">
                        <span class="input-group-text">Primera impresion.</span>
                        <input type="text" class="form-control" name="comentarios" aria-label="With textarea">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">CREAR USUARIO</button>
                </form>
            </div>
        </div>
        <br>
    </div>

    <?php
    incluirTemplate('fottersis');
    ?>