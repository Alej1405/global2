<?php

$guardar = $_GET['guardar'] ?? null;

//incluye el header
require '../../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('location: index.php');
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


?>

<body>
        <script>
            swal({
                title: 'Bienvenido',
                text: "<?= $_SESSION['usuario'] ?>",
                icon: 'success',
                confirmButtonText: 'Cool'
            })
        </script>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Panel de Control</h1>
            <div class="btn-group" role="group" aria-label="Basic example">
                <div class="btn-group">
                    <a href="../DESCARGAS/excell_gcgo.php" class="btn btn-primary">
                        <i class="fas fa-download fa-sm text-white-50"></i>
                        General
                    </a>
                    <a href="../DESCARGAS/descargaexcel.php" class="btn btn-primary">
                        <i class="fas fa-download fa-sm text-white-50"></i>
                        Cosmetics
                    </a>
                </div>
            </div>
        </div>
        <div>
            <img src="../../IMG/imgtra.jpeg" alt="trabajando">
        </div>
    </div>

    </div>
    <?php
    incluirTemplate('fottersis');
    ?>