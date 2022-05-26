<?php 
    $resultado = $_GET['resultado'] ?? null;
    $agregarDcp = $_GET['id'] ?? null;

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
    INNER JOIN cliente ON cliente.id = cargas.idCliente WHERE proceso.nProceso = '${agregarDcp}'";

    //consultar la base de datos
    $resultadoConsulta2 = mysqli_query($db, $query);

    $errores = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //var_dump($_POST);

        $id = mysqli_real_escape_string($db, $_POST['id'] );
        $ministerio = mysqli_real_escape_string($db, $_POST['ministerio'] );
        $nombreDoc = mysqli_real_escape_string($db, $_POST['nombreDoc'] );
        $requisitos = mysqli_real_escape_string($db, $_POST['requisitos'] );
        $estado = mysqli_real_escape_string($db, $_POST['estado'] );
        $fecha = mysqli_real_escape_string($db, $_POST['fecha'] );
        $editor = $_SESSION['usuario'];
        $idProceso = mysqli_real_escape_string($db, $_POST['idCarga'] );

        //validacion del formulario

        
        if(!$id) {
            $errores[] = "Quesfffff!!! mira bien el numero del proceso que iras ";
        }
        if(!$ministerio) {
            $errores[] = "Quesf!! otra vez pon todo, que sordo ";
        }
        if(!$requisitos) {
            $errores[] = "Pon los requisitos, del todo mismo!!!!";
        }
        
        if(!$estado) {
            $errores[] = "Ves que piensatas cosas, como sabemos en que paso vamos pooooon el estado pues!!!";
        }

        if(!$fecha) {
            $errores[] = "Y sigue, LA FECHA pues!!! pon pon ";
        }

        if(!$nombreDoc) {
            $errores[] = "Ves ves por eso se te habla, NOMBRE DEL DOCUMENTO si no que sacas mal mal, tu mamá te llama corre!!!!";
        }

        if(empty($errores)) {

            // insertar datos en la base
            $query = "INSERT INTO dcp (id, ministerio, nombreDoc, requisitos, estado, fecha, editor, idProceso) 
            VALUES ('$id', '$ministerio', '$nombreDoc', '$requisitos', '$estado', '$fecha', '$editor', '$idProceso')";

            echo $query;

            $guardar = mysqli_query($db, $query);
            if($guardar){
                header('location: verprocesos.php?resultado=1');
            }else{
                $resultado = 2;
                var_dump($guardar); 
            }
        }
    }
?>
<table class="form2 consulta__tabla">
<h2 class="form__titulo titutlo__tabla">INFORMACION GENERAL DEL PROCESO</h2>
    <p class="form__p form2--p">
        Recuerda agregar el numero de proceso guarda solamente cuando el DCP esta aprobado.
    </p>
    <?php if(intval($resultado) === 1 ): ?>
        <p class="alerta2">DCP AGREGADO CON ÉXITO</p>
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
            <th>Número de Carga</th>
            <!-- <th>ACCIONES</th> -->

        </tr>
    </thead>

    <tbody>
        <?php while( $cliente = mysqli_fetch_assoc($resultadoConsulta2) ):?>
            <?php //consulta para ver las partidas agregadas
            $consultaFactura = $cliente['idCarga'];
            $query = "SELECT * FROM  dcp WHERE dcp.idProceso = '${consultaFactura}'";
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
            <td><?php echo $cliente['idCarga']; ?></td>
        </tr>
        
        
    </tbody>
</table>
        
    </tbody>
</table>

<form action=" " class="form2" method="POST">
        <fieldset class="marco">
            <legend class="empresa">Documento de Control Previo</legend>
            <input type="text" hidden name="idCarga" id="id" class="form__input" placeholder=" " value="<?php echo $cliente['idCarga']; ?>">
                <div class="container2">
                    <div class="form__container form--2">
                        <div class="form__grupo">
                            <input type="text" name="id" id="id" class="form__input" placeholder=" " value="">
                            <label for="id" class="form__label">Número de Proceso</label>
                            <span class="form__linea"></span>
                        </div>
                        <div class="form__grupo">
                            <select name="ministerio"  class="form__input">
                                <option value=" " >--- Selecciona un Ministerio ---</option>
                                <option value="inen" >INEN</option>
                                <option value="arcsa" >ARCSA</option>
                                <option value="mipro" >MIPRO</option>
                                <option value="agro" >AGROCALIDAD</option>
                                <option value="otro" >Otro</option>
                            </select>
                        </div>
                        <div class="form__grupo">
                            <select name="nombreDoc"  class="form__input">
                                <option value=" " >--- Selecciona un Documento ---</option>
                                <option value="inen" >INEN</option>
                                <option value="arcsa" >REGISTRO SANITARIO</option>
                                <option value="mipro" >CERTIFICADO MIPRO</option>
                                <option value="agro" >CERTIFICADO FITO SANITARIO</option>
                                <option value="otro" >Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class="form__container form--2">
                        <div class="form__grupo">
                            <input type="textarea" name="requisitos" id="requisitos" class="form__input" placeholder=" " value="">
                            <label for="requisitos" class="form__label">Rquisitos</label>
                            <span class="form__linea"></span>
                        </div>
                        <div class="form__grupo">
                            <select name="estado"  class="form__input">
                                <option value=" " >--- Selecciona un estado final ---</option>
                                <option value="inen" >INEN</option>
                                <option value="arcsa" >REGISTRO SANITARIO</option>
                                <option value="mipro" >CERTIFICADO MIPRO</option>
                                <option value="agro" >CERTIFICADO FITO SANITARIO</option>
                                <option value="otro" >Otro</option>
                            </select>
                        </div>
                        <div class="form__grupo">
                            <input type="date" name="fecha" id="fecha" class="form__input" placeholder=" " value="">
                            <label for="fecha" class="form__label">fecha de registro</label>
                            <span class="form__linea"></span>
                        </div>
                    </div>    
                </div>
                <div class="botones">
                    <input type="submit" class="form__submit" value="AGREGAR DCP">
                </div>
        </fieldset>
        <fieldset class="marco2">
                    <legend class="titulo__anidado">DCP AGREAGDOS AL PROCESO</legend>
                    <table class="tabla__anidada">
                        <thead>
                            <tr>
                                <th class="cab__anidada">NOMBRE DCP</th>
                                <th class="cab__anidada">NUMERO DE SOLICITUD</th>
                                <th class="cab__anidada">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while( $partidas = mysqli_fetch_assoc($resultadoConsultaF) ):?>
                                    <tr>
                                        <td><?php echo $partidas['nombreDoc']; ?></td>
                                        <td><?php echo $partidas['id']; ?></td>
                                        <td><?php echo $partidas['estado']; ?></td>
                                    </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </fieldset>
        <div class="boton__anidado">
            <a href="verprocesos.php" class="enlace">terminar y salir</a>
        </div>
    <?php endwhile; ?>
</form>

<?php 
    incluirTemplate('fottersis');     
?>