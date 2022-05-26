<?php 
    //VALIDAR POR ID VALIDO
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('location: ../index.php');
    }



    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    $auth = estaAutenticado();

    //proteger la página
    if (!$auth) {
        header('location: index.php');
    }

    //conexion a la base de datos
    require '../../includes/config/database.php';
    conectarDB();
    $db =conectarDB();

    //consultar la base de datos para la actualización.
    $consulta = "SELECT * FROM usuario WHERE id = ${id}";
    $resultado = mysqli_query($db, $consulta);
    $actualizar = mysqli_fetch_assoc($resultado);

    //var_dump($actualizar); 



    $errores = [];

    $cedula = $actualizar['cedula'];
    $nombre = $actualizar['nombre'];
    $apellido = $actualizar['apellido'];
    $telefono1 = $actualizar['telefono1'];
    $telefono2 = $actualizar['telefono2'];
    $correo1 = $actualizar['correo1'];
    $correo2 = $actualizar['correo2'];
    $tipo = $actualizar['tipo'];

    //ejecutar el codigo despues de enviar el formulario por POST

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        $cedula = mysqli_real_escape_string($db,$_POST['cedula']);
        $nombre = mysqli_real_escape_string($db,$_POST['nombre']);
        $apellido = mysqli_real_escape_string($db,$_POST['apellido']);
        $telefono1 = mysqli_real_escape_string($db,$_POST['telefono1']);
        $telefono2 =  mysqli_real_escape_string($db,$_POST['telefono2']);
        $correo1 = mysqli_real_escape_string($db,$_POST['correo1']);
        $correo2 = mysqli_real_escape_string($db,$_POST['correo2']);
        $tipo = mysqli_real_escape_string($db,$_POST['tipo']);

        //VALIDAR LOS DATOS DEL FORMULARIO

        if(!$cedula) {
            $errores[] = "El número de cédula es necesario";
        }
        if(!$nombre) {
            $errores[] = "El nombre es necesario";
        }
        if(!$apellido) {
            $errores[] = "El apellido es necesario";
        }
        if(!$telefono1) {
            $errores[] = "El numero de celular es necesario";
        }
        if(!$telefono2) {
            $errores[] = "El numero de convencional es necesario";
        }
        if(!$correo1) {
            $errores[] = "Es necesario asignar un correo de trabajo";
        }
        if(!$correo2) {
            $errores[] = "El correo personal es necesario";
        }
        if(!$tipo) {
            $errores[] = "Por favor define un tipo de usuario";
        }
        
        if(empty($errores)){
            
            // INSERTAR LOS DATOS EN LA BASE

            $query = " UPDATE usuario SET   cedula = '${cedula}', 
                                            nombre = '${nombre}', 
                                            apellido = '${apellido}', 
                                            telefono1 = '${telefono1}',
                                            telefono2 = '${telefono2}',
                                            correo1 = '${correo1}',
                                            correo2 = '${correo2}',
                                            tipo = '${tipo}' WHERE id = ${id}";

            $resultado = mysqli_query($db, $query);

            if ($resultado){
                //$rolpg = $_SESSION['rol'];
                header('location: verusuarios.php?resultado=1'); 
            }

        }

        
    }   
?>
<form class="form2" method="POST">
    <h2 class="form__titulo">actualizar el regsitro</h2>
    <p class="form__p form2--p">
        Recuerda que para registrar un colaborador, es necesario llenar todos los campos 
    </p>

    <?php foreach ($errores as $error):  ?>
        <div class="alerta">
            <?php echo $error;  ?>
        </div>
    <?php endforeach;  ?>
    <div class="container2">
        <div class="form__container form--2">
            <div class="form__grupo">
                <input type="text" name="nombre" id="nombre" class="form__input" placeholder=" " value="<?php echo $nombre;  ?>">
                <label for="nombre" class="form__label">NOMBRE</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="apellido" id="apellido" class="form__input" placeholder=" " value="<?php echo $apellido;  ?>">
                <label for="apellido" class="form__label">APELLIDO</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="int" name="cedula" id="cedula"class="form__input" placeholder=" " value="<?php echo $cedula;  ?>" >
                <label for="cedula" class="form__label">CÉDULA</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <select name="tipo" id="tipo" class="form__input" placeholder=" " value="<?php echo $tipo;  ?>">
                    <option value=" " class="form__label">-- SELECCIONA UN TIPO DE USUARIO --</option>
                    <option value="superAdmin">SUPER-ADMIN</option>
                    <option value="admin">ADMINISTRADOR</option>
                    <option value="comercial">COMERCIAL</option>
                    <option value="facturacion">FACTURACION</option>
                    <option value="adminBodega">ADMIN-BODEGA</option>
                    <option value="bodega">BODEGA</option>
                    <option value="callcenter">CALLCENTER</option>
                    <option value="motorizado">TRASPORTISTA MOTORIZADO</option>
                    <option value="coordinacion">COORDINACION</option>
                    <option value="seguimiento">SEGUIMIENTO</option>
                </select>
            </div>
        </div>
        <div class="form__container form--2">
            <div class="form__grupo">
                <input type="tel" name="telefono1" id="telefono1"class="form__input" placeholder=" " value="<?php echo $telefono1;  ?>">
                <label for="telefono1" class="form__label">TELEFONO CELULAR</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="tel" name="telefono2" id="telefono2"class="form__input" placeholder=" " value="<?php echo $telefono2;  ?>">
                <label for="telefono2" class="form__label">TELEFONO CONVENCIONAL</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="email" name="correo1" id="correo1" class="form__input" placeholder=" " value="<?php echo $correo1;  ?>">
                <label for="correo1" class="form__label">CORREO ASIGNADO</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="email" name="correo2" id="correo2"class="form__input" placeholder=" " value="<?php echo $correo2;  ?>">
                <label for="correo2" class="form__label">CORREO PERSONAL</label>
                <span class="form__linea"></span>
            </div>
            
            
        </div>
    </div>
    <div class="botones">
        <input type="submit" class="form__submit boton2" value="ACTUALIZAR">
        <input type="submit" class="form__submit boton2" value="ELIMINAR">
        <div class="boton__anidado">
            <a href="verusuarios.php" class="enlace">regresar</a>
        </div>
    </div>

</form>