<?php 

    $id_colaborador = $_GET['id'] ?? null;

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
    
    //consultar datos de colaboradores
    $consulta_colab = "SELECT * FROM colaborador WHERE id = '${id_colaborador}';";
    $resultado_colab = mysqli_query($db4, $consulta_colab);
    $colaborador = mysqli_fetch_assoc($resultado_colab);

    //decalracion de variables 
        $nombre = "";
        $apellido = "";
        $direccion = "";
        $celular = "";
        $celular_2 = "";
        $numero_ci = "";
        $observacion = "";
        $estado = "";
        $distrito = ""; 
        $errores = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            //DECLARACION DE VARIABLES TABLA DATOSORDENES 
            $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
            $apellido = mysqli_real_escape_string($db, $_POST['apellido']);
            $direccion = mysqli_real_escape_string($db, $_POST['direccion']);
            $celular = mysqli_real_escape_string($db, $_POST['celular']);
            $celular_2 = mysqli_real_escape_string($db, $_POST['celular_2']);
            $numero_ci = mysqli_real_escape_string($db, $_POST['numero_ci']);
            $observacion = mysqli_real_escape_string($db, $_POST['observacion']);
            $estado = mysqli_real_escape_string($db, $_POST['estado']);
            $distrito = mysqli_real_escape_string($db, $_POST['distrito']);
            $responsable = $_SESSION['usuario'];
            $fecha = date('y-m-d');
            if(!$nombre) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL NOMBRE";
            }
            if(!$apellido) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL APELLIDO";
            }
            if(!$direccion) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA LA DIRECCION";
            }
            if(!$celular) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL CELULAR";
            }
            if(!$numero_ci) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL NUMERO DE CEDULA";
            }
            if(!$estado) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL ESTADO";
            }
            if(!$distrito) {
                $errores[] = "QUE HACEEEEEEEE!!!! AGREGA EL DISTRITO";
            }
            if(empty($errores)) {
                $guardar_colab = "UPDATE colaborador SET    nombre = '${nombre}',
                                                            apellido = '${apellido}',
                                                            direccion = '${direccion}',
                                                            celular = '${celular}',
                                                            celular_2 = '${celular_2}',
                                                            numero_ci = '${numero_ci}',
                                                            observacion = '${observacion}',
                                                            estado = '${estado}',
                                                            responsable = '${responsable}',
                                                            fecha = '${fecha}',
                                                            distrito= '${distrito}'
                                                            WHERE id = ${id_colaborador};";
                    $guar_colab = mysqli_query($db4, $guardar_colab);
                    
                    if ($guar_colab) {
                        echo "
                        <script>
                            alert('Dastos actualizados correctamente');
                            window.location.href='consul_colab.php';
                        </script>";
                    }
            }


        }

?>
<body class="bg-gradient-primary">
    <div class="container">
    <div class="heading">
            <h1>Actualizar de Motorizados y Moto-colaborador</h1>
        </div>
        <!-- FORMULARIO DE ACTUALIZACION -->
            <div class="card bg-light">
                    <?php foreach($errores as $error) : ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach ?>
                <div class="card-header">
                    REGISTRAR COLABORADOR
                </div>
                <form action ='' method="POST">
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">NOMBRE</label>
                        <input type ="text" class="form-control" value="<?php echo $colaborador['nombre'] ?? null; ?>" id="exampleFormControlTextarea1" rows="3" name="nombre"></input>              
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">APELLIDO</label>
                        <input type ="text" class="form-control" value="<?php echo $colaborador['apellido'] ?? null; ?>" id="exampleFormControlTextarea1" rows="3" name="apellido"></input>          
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">DIRECCION</label>
                        <input type="text" class="form-control" id="exampleFormControlTextarea1" value="<?php echo $colaborador['direccion'] ?? null; ?>" rows="3" name="direccion"></input>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">CELULAR</label>
                        <input type ="number" class="form-control" value="<?php echo $colaborador['celular'] ?? null; ?>" id="exampleFormControlTextarea1" rows="3" name="celular"></input>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">CELULAR 2</label>
                        <input type ="number" class="form-control" value="<?php echo $colaborador['celular_2'] ?? null; ?>" id="exampleFormControlTextarea1" rows="3" name="celular_2"></input>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">NUMERO DE CEDULA</label>
                        <input type ="number" class="form-control" value="<?php echo $colaborador['numero_ci'] ?? null; ?>" id="exampleFormControlTextarea1" rows="3" name="numero_ci"></input>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">OBSERVACION</label>
                        <input type="text" class="form-control" value="<?php echo $colaborador['observacion'] ?? null; ?>" id="exampleFormControlTextarea1"  rows="3" name="observacion"></input>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" name="distrito" id="">
                            <option value="<?php echo $colaborador['distrito'] ?? null; ?>"selected><?php echo $colaborador['distrito'] ?? 'NO TIENE DISTRITO'; ?></option>
                            <?php 
                                $distritos = "SELECT * FROM distrito";
                                $distritos = mysqli_query($db, $distritos);
                                while($distrito = mysqli_fetch_assoc($distritos)) : ?>
                                    <option value="<?php echo $distrito['id']; ?>"><?php echo $distrito['nombre']; ?></option>
                                <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" name="estado" id="">
                            <option value="<?php echo $colaborador['estado'] ?? null; ?>" selected><?php echo $colaborador['estado'] ?? null; ?></option>
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="SUSPENDIDO">SUSPENDIDO</option>
                            <option value="DESPEDIDO">DESPEDIDO</option>
                        </select>
                    </div>
                    <div>
                        <input type="submit" class="btn btn-primary aling-c" value='GUARDAR'>
                    </div>
                </form>
            </div>
        <!-- FIN DE FORMULARIO DE ACTUALIZACION -->
    </div>



<?php 
    incluirTemplate('fottersis');     
?>