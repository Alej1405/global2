<?php

$id = $_GET['id'] ?? null;
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

//CONECCION FINANCIERO
conectarDB6();
$db6 = conectarDB6();

//-------------CONSULTA DE INFORMACION--------------


$consulta_fin = "SELECT * FROM ordenes;";
$ejecutar_consulta3 = mysqli_query($db4, $consulta_fin);



?>

<body class="bg-gradient-primary">
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>CLIENTE</th>
                    <th>NEGOCIO</th>
                    <th>DESTINO</th>
                    <th>PESO</th>
                    <th>POR COBRAR</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($array_clientes = mysqli_fetch_assoc($ejecutar_consulta3)) : ?>
                    <tr>
                        <td>
                            <?php 
                                $cedula = $array_clientes['cliente']; 
                                $consulta_fin = "SELECT * FROM clientes WHERE cedula = '${cedula}';";
                                $ejecutar_consulta = mysqli_query($db4, $consulta_fin); 
                                $ejecutar_consulta31 = mysqli_fetch_assoc($ejecutar_consulta);
                                echo $ejecutar_consulta31['nombre']." ".$ejecutar_consulta31['apellido'];    
                            ?>
                        </td>
                        <td>
                            <?php 
                                $cedula = $array_clientes['cliente']; 
                                $consulta_fin = "SELECT * FROM clientes WHERE cedula = '$cedula';";
                                $ejecutar_consulta = mysqli_query($db4, $consulta_fin);
                                $ejecutar_consulta4 = mysqli_fetch_assoc($ejecutar_consulta);
                                echo $ejecutar_consulta4['emprendimiento'];    
                            ?>
                        </td>
                        <td>
                            <?php echo $array_clientes['ciudad']; ?>
                        </td>
                        <td>
                            <?php 
                             $guia = $array_clientes['guia'];
                             $consulta_fin2 = "SELECT * FROM ingreso_gc WHERE guia = '$guia';";
                             $ejecutar_consulta2 = mysqli_query($db2, $consulta_fin2);
                             $consulta_peso = mysqli_fetch_assoc($ejecutar_consulta2);
                             echo $consulta_peso['peso'];
                            ?>
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php
    incluirTemplate('fottersis');
    ?>