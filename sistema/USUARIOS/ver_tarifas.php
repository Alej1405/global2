<?php 

    //incluye el header
    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if (!$auth) {
        header('location: index.php');
    }

    require '../../includes/config/database.php';
    incluirTemplate('headersis2');
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

    //coneccion callcenter
    conectarDB5();
    $db5 =conectarDB5();

    //coneccion callcenter
    conectarDB6();
    $db6 =conectarDB6();

     //ARRAY DE ERRORES PARA LA ALERTAS
        $errores = [];

    //query para consulta general de datos.
        $consulta_t = "SELECT * FROM provedores";
            $ejecutar_con = mysqli_query($db5, $consulta_t);
    
    //-------DECLARACION DE VARIABLES-------

    $id = "";
    
    //liminar una tarifa directamente desde la tabla.
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
    }
    //validar que esxista una tarifa con esa ida
        if($id){
            $query = "DELETE FROM provedores WHERE id = ${id}"; 
            $resultado = mysqli_query($db5, $query);
            if ($resultado) {
                echo '
                    <div class="alert alert-success">
                        <p>Ya ves que es facil!!!! YA BORRASTE LA TARIFA, BIEN BIEN, SIGA DURMIENDO.</p>
                        <a href="ver_tarifas.php">Quieres revisar mas tarifas?? Dale aqui...</a>
                    </div>';
                exit;
            }
        }
?>
<body class="bg-gradient-primary">
    <div class="container">
        <!-- FORMULARIO DE ACTUALIZACION -->
            <div class="card bg-light">
                    <?php foreach($errores as $error) : ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach ?>
                <div class="card-header h2">
                    VER Y ACTUALIZAR TARIFAS
                </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>P. BASE</th>
                        <th>P. DESTINO</th>
                        <th>Monto / Tarifa</th>
                        <th>M3</th>
                        <th>CBM</th>
                        <th>RUTA</th>
                        <th>T. Transito</th>
                        <th>Valido Desde / Hasta</th>
                        <th>T. Carga</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($tarifa = mysqli_fetch_assoc($ejecutar_con)):?>
                        <tr>
                            <td>
                                <?php 
                                    echo $tarifa['p_bases'];
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo $tarifa['pod'];
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo $tarifa['monto'];
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo $tarifa['m3'];
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo $tarifa['cbm'];
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo $tarifa['ruta'];
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo $tarifa['t_transito'];
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo $tarifa['validez_desde']." "."/"." ".$tarifa['validez_hasta'];
                                ?>
                            </td>
                            <td class="text-uppercase">
                                <?php 
                                    echo $tarifa['t_carga'];
                                ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="actualizar_tarifas.php?id=<?php echo $tarifa['id'];?>" class="btn btn-outline-success btn-sm">ACTUALIZAR</a>
                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?php echo $tarifa['id']; ?>">
                                        <input type="submit" class="btn btn-outline-danger btn-sm" value="BORRAR">
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>


<?php 
    incluirTemplate('fottersis');     
?>