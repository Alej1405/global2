<?php
//incluye el header
require '../../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('location: ../index.php');
}

require '../../includes/config/database.php';
incluirTemplate('headersis2');
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

//----------------------consulta de datos generales-------------------------------------
$query = "SELECT * FROM usuario WHERE id = '${_SESSION['id']}' ";
$resultado = mysqli_query($db, $query);

?>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Informacion General.
            </div>
            <div class="card-body">
                <form>
                    <h5 class="card-title"><?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido']; ?></h5>
                    <p class="card-text text-muted fs-6 fst-italic">Confirmar si los datos ingresados son correctos.</p>
                    <div class="input-group mb-3">
                        <img src="../../fotos_personal/bryan.jpeg" class="img-thumbnail pt-1 m-auto" alt="..." style="width: 25rem";>
                    </div>
                    <label for="foto" class="form-label">Agrega o cambia tu foto</label>
                    <div class="input-group mb-3" >
                        <input type="file" accept=".jpeg/.jpg" name="foto" id="foto" class="form-control text-uppercase" placeholder="cargo" aria-label="correo" value="<?php echo  $datos_personal['tipo']; ?>" aria-describedby="basic-addon1">
                    </div>
                    <?php
                    $consulta_personal = $_SESSION['id'];
                    $query = "SELECT * FROM usuario WHERE id = '${consulta_personal}' ";
                    $resultado = mysqli_query($db, $query);
                    $datos_personal = mysqli_fetch_assoc($resultado);
                    ?>
                    <div class="input-group mb-3">
                        <span class="input-group-text">DATOS PERSONALES</span>
                        <input type="text" name="nombre" class="form-control" placeholder="nombre" value="<?php echo $datos_personal['nombre']; ?>" aria-label="nombre">
                        <input type="text" name="apellido" class="form-control" placeholder="apellido" value="<?php echo  $datos_personal['apellido']; ?>" aria-label="apellido">
                        <input type="text" name="cedula" class="form-control" placeholder="apellido" value="<?php echo  $datos_personal['cedula']; ?>" aria-label="cedula">
                    </div>
                    <div class="input-group mb-3" >
                        <span class="input-group-text" id="basic-addon1">CARGO OTORGADO</span>
                        <input type="text" disabled name="correo1" class="form-control text-uppercase" placeholder="cargo" aria-label="correo" value="<?php echo  $datos_personal['tipo']; ?>" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">@</span>
                        <input type="text" name="correo1" class="form-control" placeholder="Correo institucional" aria-label="correo" value="<?php echo  $datos_personal['correo1']; ?>" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">@</span>
                        <input type="text" name="correo2" class="form-control" placeholder="Correo secundario" aria-label="correo" value="<?php echo  $datos_personal['correo2']; ?>" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Telefonos de contacto</span>
                        <input type="text" name="telefono1" class="form-control" placeholder="telefono 1" value="<?php echo $datos_personal['telefono1']; ?>" aria-label="nombre">
                        <input type="text" name="telefono2" class="form-control" placeholder="telefono 2" value="<?php echo  $datos_personal['telefono2']; ?>" aria-label="apellido">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Direccion Domicialria</span>
                        <input type="text" name="provincia" class="form-control" placeholder="Provincia" value="<?php echo $datos_personal['provincia']; ?>" aria-label="Provincia">
                        <input type="text" name="canton" class="form-control" placeholder="Canton" value="<?php echo $datos_personal['canton']; ?>" aria-label="Canton" >
                        <input type="text" name="ciudad" class="form-control" placeholder="Ciudad" value="<?php echo $datos_personal['ciudad']; ?>" aria-label="Ciudad">
                    </div>

                    <label for="basic-url" class="form-label">Queremos conocer un poco mas</label>
                    <div class="input-group">
                        <span class="input-group-text">Haz una descripcion breve de ti.</span>
                        <textarea class="form-control" name="comentarios" aria-label="With textarea"></textarea>
                    </div>
                    <a href="#" class="btn btn-primary">ACTUALIZAR</a>
                </form>
            </div>
        </div>
        <br>
    </div>

    <?php
    incluirTemplate('fottersis2');
    ?>