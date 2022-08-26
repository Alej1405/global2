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
                <h5 class="card-title"><?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido']; ?></h5>
                <p class="card-text">Confirmar si los datos proporcionados se encuentran correctos.</p>
                <form class="form-floating">
                    <input type="nombre" class="form-control" id="floatingInputValue" placeholder="Nombre" value="test@example.com">
                    <label for="floatingInputValue">Nombre</label>
                    <a href="#" class="btn btn-primary">ACTUALIZAR</a>
                </form>
            </div>
        </div>
        <br>
    </div>

<?php
    incluirTemplate('fottersis2');
?>