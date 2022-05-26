<?php 
    $resultado = $_GET['resultado'] ?? null;
    $agregarPartidas = $_GET['id'];
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
    //JOIN PARA INFORMACION GENERAL
    //escribir el query
    $query = "SELECT * FROM  proceso    INNER join cargas  ON proceso.idCarga = cargas.id 
    INNER JOIN cliente ON cliente.id = cargas.idCliente WHERE proceso.nProceso = ${agregarPartidas}";

    //consultar la base de datos
    $resultadoConsulta = mysqli_query($db, $query);


    $errores = [];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //var_dump($_POST);
        
        $nFactura = mysqli_real_escape_string($db, $_POST['nFactura'] );
        $itemFact = mysqli_real_escape_string($db, $_POST['itemFact'] );
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion'] );
        $partida = mysqli_real_escape_string($db, $_POST['partida'] );
        $editor = $_SESSION['usuario'];
        $idCarga = mysqli_real_escape_string($db, $_POST['idCarga'] );

        //validacion del formulario

        
        if(!$itemFact) {
            $errores[] = "con esto tendremos mas detalles ";
        }
        if(!$descripcion) {
            $errores[] = "Quesf!! otra vez pon todo, que sordo ";
        }
        if(!$partida) {
            $errores[] = "Pona la Partida si no sabes cual es pide ayuda a Joha...";
        }
        
        if(!$idCarga) {
            $errores[] = "Reacciona, pon un numero de factura que estás clasificando";
        }

        if(empty($errores)) {

            // insertar datos en la base
            $query = "INSERT INTO declaracion (nFactura, itemFact, descripcion, partida, idCarga) 
            VALUES ('$nFactura', '$itemFact', '$descripcion', '$partida', '$idCarga')";

            //echo $query;

            $guardar = mysqli_query($db, $query);

            //echo "si vale";
            //$_SESSION['rol'];

            if ($guardar) {
                $resultado = 1;
            }else{
                header('location: partidas.php?resultado=2');
            }
        }
    }
?>
<table class="form2 consulta__tabla">
    <h2 class="form__titulo titutlo__tabla">INFORMACION GENERAL DEL PROCESO</h2>
    <p class="form__p form2--p">
        Recuerda llenar bien estos campos para poder realizar una 
        correcta operación.
    </p>
    <?php if(intval($resultado) === 1 ): ?>
        <p class="alerta2">PARTIDA AGREGADA CON ÉXITO</p>
    <?php elseif(intval($resultado) === 2 ): ?>
        <p class="alerta">COMUNICATE CON UN SUPER ADMIN, LA PARTIDA NO SE GUARDO, SIEMPRE DAÑAS TODO!!!</p>
    <?php endif ?>
    <thead>
        <tr>
            <th>Cliente </th>
            <th>Numero de Factura</th>
            <th>Numero de Guia</th>
            <th>MRN </th>
            <th>distrito</th>
            <!-- <th>ACCIONES</th> -->

        </tr>
    </thead>

    <tbody>
        <?php while( $cliente = mysqli_fetch_assoc($resultadoConsulta) ):?>
            <?php //consulta para ver las partidas agregadas
            $consultaFactura = $cliente['nFactura'];

            $consultaFactura; 
            $query = "SELECT * FROM  declaracion WHERE declaracion.nFactura = ${consultaFactura}";
            //consultar la base de datos
            $resultadoConsultaF = mysqli_query($db, $query);?>
        <tr>
            <td><?php echo $cliente['nombre'] . " " . $cliente['apellido']; ?></td>
            <td>
                <a href="../../respaldos/<?php echo $cliente['guia']; ?>#toolbar=1&navpanes=1&scrollbar=0" target="blanck" class="tabla__archivos"><?php echo $cliente['idCarga']; ?> ↓</a>
            </td>
            <td>
                <a href="../../respaldos/<?php echo $cliente['factura']; ?>#toolbar=1&navpanes=1&scrollbar=0" target="blanck" class="tabla__archivos"><?php echo $cliente['nFactura']; ?> ↓</a>
            </td>
            <td><?php echo $cliente['mrn']; ?></td>
            <td><?php echo $cliente['distrito']; ?></td>
        </tr>
        
    </tbody>
</table>

<form action=" " class="form2" method="POST">
    <h2 class="form__titulo">REGISTRAR PARTIDAS</h2>
        <p class="form__p form2--p">
            Recuerda llenar bien estos campos para poder realizar una 
            correcta operación.
        </p>
        <fieldset class="marco">
            <legend class="empresa">DETALLE DE DECLARACIÓN Y PARTIDAS</legend>
                <div class="container2">
                    <div class="form__container form--2">
                        <div class="form__grupo">
                        <input type="hidden" name="idCarga" value="<?php echo $cliente['idCarga']; ?>" >
                        </div>
                        <div class="form__grupo">
                            <input type="text" readonly name="nFactura" id="nFactura"class="form__input" placeholder=" " value="<?php echo $cliente['nFactura']; ?>" >
                            <label for="nFactura" class="form__label">Número de Factura</label>
                            <span class="form__linea"></span>
                        </div>
                        <div class="form__grupo">
                            <input type="text" name="itemFact" id="itemFact"class="form__input" placeholder=" " value="" >
                            <label for="itemFact" class="form__label">Item en la Factura</label>
                            <span class="form__linea"></span>
                        </div>
                    </div>
                    <div class="form__container form--2">
                        <div class="form__grupo">
                            <input type="text" name="partida" id="partida"class="form__input" placeholder=" " value="" >
                            <label for="partida" class="form__label">Número de Partida</label>
                            <span class="form__linea"></span>
                        </div>
                        <div class="form__grupo">
                            <input type="text" name="descripcion" id="descripcion" class="form__input" placeholder=" " value="">
                            <label for="descripcion" class="form__label">Descripcion</label>
                            <span class="form__linea"></span>
                        </div>
                    </div>
                </div>
                <div class="botones">
                    <input type="submit" class="form__submit agregar__boton" value="AGREGAR PARTIDA">
                </div>
                <fieldset class="marco2">
                    <legend class="titulo__anidado">PARTIDAS AGREGADAS A ESTA FACTURA</legend>
                    <table class="tabla__anidada">
                        <thead>
                            <tr>
                                <th class="cab__anidada">NUMERO DE ITEM</th>
                                <th class="cab__anidada">PARTIDA</th>
                                <th class="cab__anidada">Descripcion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while( $partidas = mysqli_fetch_assoc($resultadoConsultaF) ):?>
                                    <tr>
                                        <td><?php echo $partidas['itemFact']; ?></td>
                                        <td><?php echo $partidas['partida']; ?></td>
                                        <td><?php echo $partidas['descripcion']; ?></td>
                                    </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </fieldset>
        </fieldset>
        <div class="boton__anidado">
            <a href="verprocesos.php" class="enlace">terminar y salir</a>
        </div>
        <?php endwhile; ?>
        <?php foreach($errores as $error) : ?>
            <div class="alerta">
                <?php echo $error; ?>
            </div>
        <?php endforeach ?>
</form>

<?php 
    incluirTemplate('fottersis');     
?>