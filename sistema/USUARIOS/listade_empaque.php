<?php
//caracteriacion de la pagina, especialmente para poder cambiar los estados, tanto para la gestion como para coordinacion.
$nombre_ase = $_GET['nombre'] ?? null;

//incluye el header
require '../../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('location: index.php');
}

require '../../includes/config/database.php';
incluirTemplate('headersis2');
//coneccion api
conectarDB();
$db = conectarDB();

//coneccion api
conectarDB3();
$db3 = conectarDB3();

//coneccion callcenter
conectarDB4();
$db4 = conectarDB4();

//consultar datos de ordenes con estado requested
$ordenes_requested = "SELECT * FROM orders WHERE status = 'requested'";
$eje_ordenes_requested = mysqli_query($db3, $ordenes_requested);
?>

<body class="bg-gradient-primary">
    <div class="container">
        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Numero de Orden</th>
                        <th>Fecha de creacion</th>
                        <th>Distrito</th>
                        <th>Sub Distrito</th>
                        <th>Direccion</th>
                        <th>Ver productos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($orders = mysqli_fetch_assoc($eje_ordenes_requested)) : ?>
                        <tr>
                            <td><?php echo $orders['order_id']; ?></td>
                            <td><?php echo $orders['order_at']; ?></td>
                            <td>
                                <?php
                                //buscar el nombre del canton
                                $canton = $orders['id'];
                                $buscar_distrito = "SELECT * FROM order_clients WHERE order_id = '${canton}';";
                                $eje_buscar_distrito = mysqli_query($db3, $buscar_distrito);
                                $distrito3 = mysqli_fetch_assoc($eje_buscar_distrito);
                                $consulta_distrito = $distrito3['canton'];

                                //consultar el nombre del distrito
                                $buscar_distrito = "SELECT * FROM cantones WHERE nombre_canton = '${consulta_distrito}';";
                                $eje_buscar_distrito = mysqli_query($db, $buscar_distrito);
                                $distrito = mysqli_fetch_assoc($eje_buscar_distrito);
                                $n_distrito = $distrito['distrito'];

                                //nombre del distrito
                                $nombre_distrito = "SELECT * FROM distrito WHERE id = '${n_distrito}';";
                                $eje_nombre_distrito = mysqli_query($db, $nombre_distrito);
                                $distrito2 = mysqli_fetch_assoc($eje_nombre_distrito);
                                echo $distrito2['nombre'];
                                ?>
                            </td>
                            <td>
                                <?php
                                //buscar el nombre del canton
                                $canton = $orders['id'];
                                $buscar_distrito = "SELECT * FROM order_clients WHERE order_id = '${canton}';";
                                $eje_buscar_distrito = mysqli_query($db3, $buscar_distrito);
                                $distrito3 = mysqli_fetch_assoc($eje_buscar_distrito);
                                $consulta_distrito = $distrito3['canton'];
                                //consultar el nombre del distrito
                                $buscar_distrito = "SELECT * FROM cantones WHERE nombre_canton = '${consulta_distrito}';";
                                $eje_buscar_distrito = mysqli_query($db, $buscar_distrito);
                                $distrito = mysqli_fetch_assoc($eje_buscar_distrito);
                                $n_distrito = $distrito['sub_distrito'];

                                //nombre del distrito
                                $nombre_distrito = "SELECT * FROM sub_distrito WHERE id = '${n_distrito}';";
                                $eje_nombre_distrito = mysqli_query($db, $nombre_distrito);
                                $distrito2 = mysqli_fetch_assoc($eje_nombre_distrito);

                                if ($distrito2 == null) {
                                    echo "No hay sub distrito";
                                } else {
                                    $sub_distrito = $distrito2['nombre'];
                                    echo $sub_distrito;
                                }
                                ?>

                            </td>
                            <td>
                                <?php
                                //buscar el nombre del canton
                                $canton = $orders['id'];
                                $buscar_distrito = "SELECT * FROM order_clients WHERE order_id = '${canton}';";
                                $eje_buscar_distrito = mysqli_query($db3, $buscar_distrito);
                                $distrito3 = mysqli_fetch_assoc($eje_buscar_distrito);
                                $consulta_provincia = $distrito3['address'];
                                echo $consulta_provincia;
                                ?>
                            </td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $orders['order_id']; ?>">
                                    Productos
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop<?php echo $orders['order_id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Listado de Productos</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <?php $productos =  $orders['id'];
                                                $buscar_productos = "SELECT * FROM order_products WHERE order_id = '${productos}';";
                                                $eje_buscar_productos = mysqli_query($db3, $buscar_productos);
                                                while ($productos = mysqli_fetch_assoc($eje_buscar_productos)) : ?>
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                            <strong>Producto: </strong> <?php echo $productos['name']; ?>
                                                            <br><strong>Cantidad: </strong> <?php echo $productos['quantity']; ?>
                                                        </li>
                                                    </ul>
                                                <?php endwhile; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Listo</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <form action="empacar.php" method="POST">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <input type="text" hidden name="id" value="<?php echo $orders['id'];?>" id="">
                                        <input type="text" hidden name="created_at" value="<?php echo $orders['created_at'];?>" id="">
                                        <button type="submit" class="btn btn-success">Empacar</button>
                                        
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php 
incluirTemplate('fottersis')
?>