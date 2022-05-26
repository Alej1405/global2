<?php 
    //incluye el header
 require '../../includes/funciones.php';
 $auth = estaAutenticado();

 if (!$auth) {
     header('location: ../../index.php');
 }
 incluirTemplate('headersis2');
 require '../../includes/config/database.php';
 conectarDB();
 $db =conectarDB(); 
 
 //BASE DE DATOS BODEGA 
 conectarDB2();
 $db2 =conectarDB2();

 //coneccion api
 conectarDB3();
 $db3 =conectarDB3();
 
 //coneccion callcenter
 conectarDB4();
 $db4 =conectarDB4();

    $errores = [];

    $cedula = '';
    $nombre = '';
    $apellido = '';
    $telefono1 = '';
    $telefono2 = '';
    $correo1 = '';
    $correo2 = '';
    $tipo = '';

    //ejecutar el codigo despues de enviar el formulario por POST

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono1 = $_POST['telefono1'];
        $telefono2 =  $_POST['telefono2'];
        $correo1 = $_POST['correo1'];
        $correo2 = $_POST['correo2'];
        $tipo = $_POST['tipo'];

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

            $query = " INSERT INTO usuario ( cedula, nombre, apellido, telefono1, telefono2, correo1, correo2, tipo ) VALUES ( '$cedula', '$nombre', '$apellido', '$telefono1', '$telefono2', '$correo1', '$correo2', '$tipo' ) ";
                //echo $query;
            $resultado = mysqli_query($db, $query);

            if ($resultado){
                $rolpg = $_SESSION['rol'];
                header('location: ../superAdmin.php?resultado=1'); 
            }

        }

        
    }   
?>
<form action=" " class="form2" method="POST">
    <h2 class="form__titulo">REGISTRO DE USUARIO / NUEVO COLABORADOR</h2>
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
                    <option value="coordinacion">TRASPORTISTA MOTORIZADO</option>
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
        <input type="submit" class="form__submit" value="CREAR USUARIO">
        <input type="submit" class="form__submit boton2" value="ELIMINAR">
        <div class="boton__anidado">
            <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
        </div>
    </div>

</form>

<?php 
    incluirTemplate('fottersis');     
?>