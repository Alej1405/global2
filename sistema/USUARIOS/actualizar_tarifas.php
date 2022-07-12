<?php 
    //captura de datos metodo GET
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
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

    //----------variables-----------
        //ARRAY DE ERRORES PARA LA ALERTAS
            $errores = [];
    
    //consultar informacion de la base de datos para actualizar
        $consulta_t = "SELECT * FROM provedores WHERE id = ${id}";
        $ejecutar_con = mysqli_query($db5, $consulta_t);
        $tarifa = mysqli_fetch_assoc($ejecutar_con);

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
                <div class="alert alert-warning fs-5">
                    VAS A ACTUALIZAR LA TARIFA <p class="text-uppercase fst-italic fs-4 h2"><?php echo $tarifa['p_bases'];?></p>
                </div>
                <form class="user" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" require name="nombres" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Entregar a..." minlength="8" maxlength="79">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="int"  require name="cedula" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Numero de cedula " minlength="10" maxlength="13">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="number"  require name="telefono" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Numero contacto...">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="landline" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Numero segundo contacto...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email"  require name="correo" minlength="8" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Tiene correo o email...">
                                </div>

                                <div class="form-group">
                                    <input type="text"  require name="province" minlength="3" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Que provincia vamos...">
                                </div>
                                <div class="form-group">
                                    <input type="text"  require  name="direccion" minlength="8" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Direccion para la entrega...">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="date" name="fecha_pago" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Cuando entregamos...">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" minlength="8" maxlength="200" require name="city" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="En que ciudad...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" require  name="reference" minlength="8" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Referencia del lugar...">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="text" require  name="cod" class="form-control form-control-user"
                                            id="exampleRepeatPassword" maxlength="2" placeholder="Debemos cobrar...">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" require name="total" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Cuanto debemos cobrar...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" require  name="metodoPago" minlength="8" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Como pagara el cliente...">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="observacion" minlength="8" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Hay algun detalle...">
                                </div>
                                <hr>
                                <input type="submit"  class="btn btn-primary btn-user btn-block" value="Crear envio">
                                </input>
                            </form>

<?php 
    incluirTemplate('fottersis');     
?>