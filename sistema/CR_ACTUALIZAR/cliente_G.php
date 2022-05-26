<?php 

 //VALIDAR POR ID VALIDO
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('location: ../index.php');
    }

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

    //consultar la base de datos para la actualización.
    $consulta = "SELECT * FROM cliente WHERE id = ${id}";
    $resultado = mysqli_query($db, $consulta);
    $actualizar = mysqli_fetch_assoc($resultado);


    $errores = [];

    $ruc = $actualizar['ruc'];
    $nombre = $actualizar['nombre'];
    $apellido = $actualizar['apellido'];
    $cedula = $actualizar['cedula'];
    $empresa = $actualizar['empresa'];
    $telefono = $actualizar['telefono'];
    $correo = $actualizar['correo'];
    $usecuapass = $actualizar['usecuapass'];
    $contrasena = $actualizar['contrasena'];
    $editor = $_SESSION['usuario'];

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
        //$usuarioid = $_SESSION['id'];


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
                // actualizar datos en la base
                $query = " UPDATE cliente SET   ruc = '${ruc}', 
                                                nombre = '${nombre}', 
                                                apellido = '${apellido}', 
                                                cedula = '${cedula}',
                                                empresa = '${empresa}',
                                                telefono = '${telefono}',
                                                correo = '${correo}',
                                                usecuapass = '${usecuapass}',
                                                actuali= '${editor}' WHERE id = ${id}";

            $resultado = mysqli_query($db, $query);

            if ($resultado){
                //$rolpg = $_SESSION['rol'];
                //header('location: verclientes.php?resultado=1');
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
                <input type="text" name="ruc" id="ruc"class="form__input" placeholder=" " value="<?php echo $ruc;  ?>" >
                <label for="ruc" class="form__label">NUMERO DE RUC</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="nombre" id="nombre" class="form__input" placeholder=" " value="<?php echo $nombre;  ?>">
                <label for="nombre" class="form__label">Nombre</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="apellido" id="apellido" class="form__input" placeholder=" " value="<?php echo $apellido;  ?>">
                <label for="apellido" class="form__label">Apellido</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="int" name="cedula" id="cedula" class="form__input" placeholder=" " value="<?php echo $cedula;  ?>">
                <label for="cedula" class="form__label">Número de cédula</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="empresa" id="empresa"class="form__input" placeholder=" " value="<?php echo $empresa;  ?>">
                <label for="empresa" class="form__label">Nombre de la empresa</label>
                <span class="form__linea"></span>
            </div>
        </div>
        <div class="form__container form--2">
            <div class="form__grupo">
                <input type="tel" name="telefono" id="telefono" class="form__input" placeholder=" " value="<?php echo $telefono;  ?>">
                <label for="telefono" class="form__label">Ingresa el número de teléfono</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="email" name="correo" id="correo"class="form__input" placeholder=" " value="<?php echo $correo;  ?>">
                <label for="correo" class="form__label">Correo de contacto</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="usecuapass" id="usEcuapass"class="form__input" placeholder=" " value="<?php echo $usecuapass;  ?>">
                <label for="usEcuapass" class="form__label">Usuario de ecuapass</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="contrasena" id="contrasena"class="form__input" placeholder=" " value="<?php echo $contrasena;  ?>">
                <label for="contrasena" class="form__label">Contraseña de ecuapass</label>
                <span class="form__linea"></span>
            </div>
        </div>
        
    </div>
    <div class="botones">
        <input type="submit" class="form__submit" value="actualizar USUARIO">
    </div>
    <div class="boton__anidado">
        <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
    </div>
</form>

