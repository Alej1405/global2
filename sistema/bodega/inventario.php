<?php

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');

    conectarDB();
    $db =conectarDB();
    $auth = estaAutenticado();

    conectarDB3();
    $db3 =conectarDB3();

    conectarDB2();
    $db2 =conectarDB2();

    // proteger la página
    if (!$auth) {
        header('location: index.php');
    }

    // //agragar la seleccion del cliente 
    // $consulta = "SELECT * FROM cliente";
    // $resultado = mysqli_query($db, $consulta);

        
    $errores  =  [];

    if ($_SERVER['REQUEST_METHOD']=== 'POST') {

            $fcorte = $_POST ['fcorte'];
            $tAlmacen = $_POST ['tAlmacen'];
            $cuarentena = $_POST ['cuarentena'];
            $devoluc = $_POST ['devoluc'];
            $condicion = $_POST ['condicion'];
            $total = $_POST ['total'];

        $query = "INSERT INTO cargas (fcorte , tAlmacen , cuarentena , devoluc , condicion , total , )
          //         VALUES ('$fcorte' , '$tAlmacen' , '$cuarentena' , '$devoluc' , '$condicion' , '$total' ,)";

        // validar el formulario

        if ($fcorte) {
            $errores = 'Ingresar correcta la FECHA DE INGRESO';
        }
        if ($tAlmacen) {
            $errores = 'Ingrese el total de unidades en almacen...VERIFICAR';
        }
        if ($cuarentena) {
            $errores = 'Ingrese el total de unidades en observación...PRODUCTO SEPARADO';
        }
        if ($devoluc) {
            $errores = 'Ingrese el total de unidades en devueltas...PRODUCTO DAÑADO';
        }
        if ($condicion) {
            $errores = 'Corregir la condición escoger del menu... ESTE NO EXISTE';
        }
        if ($total) {
            $errores = 'Verificar el total de unidades... ES IGUAL A LA CANTIDAD INGRESADO';
        }

    }   
?>

<h2 class="form__titulo titulo__pagina">INVENTARIO GENERAL DE PRODUCTOS</h2>
        <h2 class="form__titulo titulo__pagina">LIQUIDACON DE BODEGA</h2>
        <p class="form__p form2--p">
            Aquí se encuentra el reporte general de las cargas ingresadas en el sistema.
        </p>

<section class="container3">
    <fieldset class="invem inventario2">
        <legend>CANTIDAD DE PRODUCTOS POR CAJAS</legend>
        <?php 
        // consultar a ingresog
        $query1 = "SELECT SUM(cCaja) FROM ingresog";
        $consulta1 = mysqli_query($db2, $query1);

        //consultar a ingresos
        $query2 = "SELECT SUM(cCaja) FROM ingreso";
        $consulta2 = mysqli_query($db2, $query2);
        ?>

        <div class="inventario">
            <table class="invem consulta__tabla">
                <thead>
                    <tr>
                        <th>CAJAS REGISTRADAS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($registog =mysqli_fetch_assoc($consulta1)):?>
                    <tr>
                        <td class="resta__td1"><?php echo $registog["SUM(cCaja)"];
                                $n1 = $registog["SUM(cCaja)"];?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="inventario">
            <table class="invem consulta__tabla">
                <thead>
                    <tr>
                        <th>CAJAS INGRESADAS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($registo =mysqli_fetch_assoc($consulta2)):?>
                    <tr>
                        <td class="resta__td1"><?php echo $registo["SUM(cCaja)"];
                                $n2 = $registo["SUM(cCaja)"];?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="inventario">
            <table class="invem consulta__tabla">
                <thead class="resta">
                    <tr>
                        <th>CAJAS POR INGRESAR</th>
                    </tr>
                </thead>
                <tbody class="resta__td">
                    <tr>
                        <td class="resta__td1"><?php 
                            $resta = $n1 - $n2;
                            echo $resta;
                            ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </fieldset>
</section>

<section class="container3">
    <fieldset class="invem inventario2">
        <legend>CANTIDAD DE PRODUCTOS POR UNIDAD</legend>
        <?php 
        // consultar a ingresog
        $query1 = "SELECT SUM(cUnidad) FROM ingresog";
        $consulta1 = mysqli_query($db2, $query1);

        //consultar a ingresos
        $query2 = "SELECT SUM(cUnid) FROM ingreso";
        $consulta2 = mysqli_query($db2, $query2);

        //consultar a ingresos
        $queryPR = "SELECT SUM(quantity) FROM order_products";
        $consultaPR = mysqli_query($db3, $queryPR);
        ?>

        <div class="inventario">
            <table class="invem consulta__tabla">
                <thead>
                    <tr>
                        <th>UNIDADES REGISTRADAS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($registog =mysqli_fetch_assoc($consulta1)):?>
                    <tr>
                        <td class="resta__td1"><?php echo $registog["SUM(cUnidad)"];
                                $n3 = $registog["SUM(cUnidad)"]; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="inventario">
            <table class="invem consulta__tabla">
                <thead>
                    <tr>
                        <th>UNIDADES INGRESADAS</th>
                    </tr>
                </thead>
                <tbody class="resta__td1">
                    <?php while($registo =mysqli_fetch_assoc($consulta2)):?>
                    <tr>
                        <td class="resta__td1"><?php echo $registo["SUM(cUnid)"];
                                $n4 = $registo["SUM(cUnid)"]; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="inventario">
            <table class="invem consulta__tabla">
                <thead class="resta">
                    <tr>
                        <th>UNIDADES POR INGRESAR</th>
                    </tr>
                </thead>
                <tbody class="resta__td1">
                    <tr>
                        <td class="resta__td1"><?php $resta2 = $n3 - $n4; 
                                echo $resta2; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="inventario">
            <table class="invem consulta__tabla">
                <thead class="resta">
                    <tr>
                        <th>UNIDADES DESPACHADAS</th>
                    </tr>
                </thead>
                <tbody class="resta__td1">
                <?php while($despachos =mysqli_fetch_assoc($consultaPR)):
                    $total_const = $despachos['SUM(quantity)'] -  2071;
                    ?>
                    <tr>
                        <td class="resta__td1"><?php echo $total_const ; ?></td>
                    </tr>
                <?php endwhile ?>
                </tbody>
            </table>
        </div>
    </fieldset>
</section>

<section class="container3">
    <fieldset class="form2 consulta__tabla">
        <legend>UNIDADES POR UBICACIÓN EN BODEGA Y PERCHA</legend>
        <?php 
        // consultar a ingresog
        $query1 = "SELECT SUM(cUnid), ubicac FROM perchado GROUP BY ubicac";
        $consulta1 = mysqli_query($db2, $query1);
        ?>

        <div class="inventario3">
            <table class="invem consulta__tabla">
                <thead>
                    <tr>
                        <th>UBICACION</th>
                        <th>CANTIDAD DE UNIDADES</th>
                    </tr>
                </thead>
                <tbody class="resta__td1">
                    <?php while($registog =mysqli_fetch_assoc($consulta1)):?>
                    <tr >
                        <td class="resta__td1"><?php echo $registog["ubicac"];?></td>
                        <td class="resta__td1"><?php echo $registog["SUM(cUnid)"];?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <?php 
        // consultar a reingresos
        $query1 = "SELECT SUM(unidades), marca FROM reingreso GROUP BY marca";
        $consulta1 = mysqli_query($db2, $query1);
        ?>

        <div class="inventario3">
            <table class="invem consulta__tabla">
                <thead>
                    <tr>
                        <th>MARCA</th>
                        <th>QT REINGRESOS</th>
                    </tr>
                </thead>
                <tbody class="resta__td1"> 
                    <?php while($registog =mysqli_fetch_assoc($consulta1)):?>
                    <tr >
                        <td class="resta__td1"><?php echo $registog["marca"];?></td>
                        <td class="resta__td1"><?php echo $registog["SUM(unidades)"];
                                    $stotal = $registog["SUM(unidades)"]; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <?php 
        // consultar a ingreso
        $query1 = "SELECT SUM(cUnid) FROM perchado";
        $consulta1 = mysqli_query($db2, $query1);
        ?>

        <div class="inventario3">
            <table class="invem consulta__tabla">
                <thead class="resta">
                    <tr>
                        <th>UNIDADES TOTALES UBICADAS</th>
                    </tr>
                </thead>
                <tbody class="resta__td">
                    <?php while($registog =mysqli_fetch_assoc($consulta1)):?>
                    <tr >
                        <td class="resta__td1"><?php $unitotal = $stotal + $registog["SUM(cUnid)"];
                                    echo $unitotal; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </fieldset>
</section>

<section class="container3">
    <fieldset class="form2 consulta__tabla">
        <legend>UNIDADES DISPOBLES POR MARCA</legend>
        <?php 
        // consultar a ingresog
        $query1 = "SELECT SUM(cUnid), marca FROM perchado GROUP BY marca";
        $consulta1 = mysqli_query($db2, $query1);
        ?>

        <div class="inventario3">
            <table class="invem consulta__tabla">
                <thead>
                    <tr>
                        <th>MARCA</th>
                        <th>UNIDADES DISPONIBLES</th>
                        <th>ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($registog =mysqli_fetch_assoc($consulta1)):?>
                    <tr>
                        <td class="resta__td1"><?php echo $registog["marca"];?></td>
                        <td class="resta__td1"><?php echo $registog["SUM(cUnid)"];?></td>
                        <td class="resta__td1" style="<?php if($registog["SUM(cUnid)"] < 100){
                            echo "background: red; color: white;";
                        }?>"><?php  if($registog["SUM(cUnid)"] > 100){
                                                echo "TODO BIEN";
                                                }else{
                                                    echo "PILAS YA CASI NO HAY!!";
                                                }?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="inventario3">
            <table class="invem consulta__tabla">
            <?php 
            // consultar a ingresog
            $query1 = "SELECT SUM(cUnid) FROM perchado";
            $consulta1 = mysqli_query($db2, $query1);
            ?>
                <thead class="resta">
                    <tr>
                        <th>TOTAL DE UNIDADES DISPONIBLES</th>
                    </tr>
                </thead>
                <tbody class="resta__td">
                    <?php while($registog =mysqli_fetch_assoc($consulta1)):?>
                    <tr>
                        <td class="resta__td1"><?php echo $registog["SUM(cUnid)"];?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </fieldset>
</section>

<div class="boton__anidado">
    <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
</div>