<?php 

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    
    conectarDB();
    $db =conectarDB();

    $auth = estaAutenticado();

    // proteger la página
    if (!$auth) {
        header('location: index.php');
    }else{
        // var_dump($_SESSION['rol']);
        // var_dump($_SESSION['id']);
    }


    $errores = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        $ruc = mysqli_real_escape_string($db, $_POST['ruc'] );
        $nombre = mysqli_real_escape_string($db, $_POST['nombre'] );
        $apellido = mysqli_real_escape_string($db, $_POST['apellido'] );
        $cedula = mysqli_real_escape_string($db, $_POST['cedula'] );
        $empresa = mysqli_real_escape_string($db, $_POST['empresa'] );
        $telefono = mysqli_real_escape_string($db,  $_POST['telefono'] );
        $correo = mysqli_real_escape_string($db, $_POST['correo'] );
        $usecuapass = mysqli_real_escape_string($db, $_POST['usecuapass'] );
        $contrasena = mysqli_real_escape_string($db, $_POST['contrasena'] );
        $usuarioid = $_SESSION['id'];


        // validar el formulario

        if(!$ruc) {
            $errores[] = "El número de cédula es necesario";
        }
        if(!$nombre) {
            $errores[] = "El nombre es necesario";
        }
        if(!$apellido) {
            $errores[] = "El apellido es necesario";
        }
        if(!$cedula) {
            $errores[] = "El numero de celular es necesario";
        }
        if(!$empresa) {
            $errores[] = "El numero convencional es necesario";
        }
        if(!$telefono) {
            $errores[] = "Es necesario asignar un correo de trabajo";
        }
        if(!$correo) {
            $errores[] = "El correo personal es necesario";
        }
        if(!$usecuapass) {
            $errores[] = "Por favor define un tipo de usuario";
        }
        if(!$contrasena) {
            $errores[] = "El correo personal es necesario";
        }
        // if(!$usuarioid) {
        //     $errores[] = "El correo personal es necesario";
        // }

        if(empty($errores)) {
                // insertar datos en la base
                $query = "INSERT INTO cliente (ruc, nombre, apellido, cedula, empresa, telefono, correo, usecuapass, contrasena, usuarioid) VALUES ('$ruc', '$nombre', '$apellido', '$cedula', '$empresa', '$telefono', '$correo', '$usecuapass', '$contrasena', '$usuarioid')";

                // echo $query;

                $resultado = mysqli_query($db, $query);

                if ($resultado) {
                    //header('location: ../superAdmin.php?resultado=1');
                    switch ($_SESSION['rol']){
                        case "admin":
                            header('location: ../admin.php?resultado=1');
                            break;
                        case "superAdmin":
                            header('location: ../superAdmin.php?resultado=1');
                            break;
                        case "comercial":
                            header('location: ../comercial.php?resultado=1');
                            break;
                        case "control":
                            header('location: ../control.php?resultado=1');
                            break;
                        case "adminBodega":
                            header('location: ../adminBodega.php?resultado=1');
                            break;
                        case "bodega":
                            header('location: ../bodega.php?resultado=1');
                            break;
                    }
                }
        }

    }   


        
    
?>



<form action=" " class="form2" method="POST">
    <h2 class="form__titulo">REGISTRAR NUEVO CLIENTE</h2>
    <p class="form__p form2--p">
        RECUERDA QUE PARA REGISTRAR UN NUEVO CLIENTE ES NECESARIO LLENAR TODOS LOS CAMPOS, SUERTE...!!
    </p>

    <div class="container2">
        <div class="form__container form--2">
            <div class="form__grupo">
                <input type="text" name="ruc" id="ruc"class="form__input" placeholder=" " value="" >
                <label for="ruc" class="form__label">NUMERO DE RUC</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="nombre" id="nombre" class="form__input" placeholder=" " value="">
                <label for="nombre" class="form__label">Nombre</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="apellido" id="apellido" class="form__input" placeholder=" " value="">
                <label for="apellido" class="form__label">Apellido</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="int" name="cedula" id="cedula" class="form__input" placeholder=" " value="">
                <label for="cedula" class="form__label">Número de cédula</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="empresa" id="empresa"class="form__input" placeholder=" " value="">
                <label for="empresa" class="form__label">Nombre de la empresa</label>
                <span class="form__linea"></span>
            </div>
        </div>
        <div class="form__container form--2">
            <div class="form__grupo">
                <input type="tel" name="telefono" id="telefono" class="form__input" placeholder=" " value="">
                <label for="telefono" class="form__label">Ingresa el número de teléfono</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="email" name="correo" id="correo"class="form__input" placeholder=" " value="">
                <label for="correo" class="form__label">Correo de contacto</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="usecuapass" id="usecuapass"class="form__input" placeholder=" " value="">
                <label for="usecuapass" class="form__label">Usuario de ecuapass</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="contrasena" id="contrasena"class="form__input" placeholder=" " value="">
                <label for="contrasena" class="form__label">Contraseña de ecuapass</label>
                <span class="form__linea"></span>
            </div>
        </div>
        
    </div>
    <div class="botones">
        <input type="submit" class="form__submit" value="CREAR USUARIO">
    </div>
    <div class="boton__anidado">
        <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
    </div>
</form>

