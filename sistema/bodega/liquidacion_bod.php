<?php

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    conectarDB();
    $db =conectarDB();

    conectarDB2();
    $db2 =conectarDB2();

    $auth = estaAutenticado();

    // proteger la página
    if (!$auth) {
        header('location: index.php');
    }

    $alerta = null;

    $errores = [];

    if ($_SERVER['REQUEST_METHOD']=== 'POST') {


        //echo "<pre>";
        //var_dump($_POST);
        //echo "</pre>";

            $desde = $_POST['desde'];
            $hasta = $_POST['hasta'];
            $dias  = $_POST['dias'];
            $periodo = $_POST['periodo'];
            $m3enbodega = $_POST['m3enbodega'];
            $m3despachados = $_POST['m3despachados'];
            $m3liquidar = $_POST['m3liquidar'];
            $pdia = 3.5;
            $valor2 = $m3liquidar * $pdia;
            $valor = filter_var( $valor2, FILTER_VALIDATE_FLOAT);
            $responsable = $_SESSION['usuario'];


        $query = "INSERT INTO liquidacion (desde, hasta, dias, periodo, m3enbodega, m3despachados, m3liquidar, valor, pdia, responsable) 
                VALUES ('$desde', '$hasta', '$dias', '$periodo', '$m3enbodega', '$m3despachados', '$m3liquidar', '$valor', '$pdia', '$responsable' )";
        
        $guardar = mysqli_query($db2, $query);
        if ($guardar){
            $alerta = 1;

            // email facturacion 
            $destinatario = 'andreina@globalcargoecuador.com';
            $asunto = 'LIQUIDACION DE BODEGA GENERADA';
            $header = "NUEVA LIQUIDACION PARA FACTURAR";
            $mensajeCompleto = "Se ha generado una nueva liquidación por favor ingresa al sistema y envía la factura correspondiente.";
            mail($destinatario, $asunto, $mensajeCompleto, $header);

            //mail confirmacion de creado
            $destinatario = 'francisco.rl@globalcargoecuador.com';
            $asunto = 'LIQUIDACION DE BODEGA GENERADA';
            $header = "NUEVA LIQUIDACION CREADA CON EXITO";
            $mensajeCompleto = "Haz generado una liquidación con éxito, haz el seguimiento del pago";
            mail($destinatario, $asunto, $mensajeCompleto, $header);

            //mail confirmacion Francisco
            $destinatario = 'francisco@globalcargoecuador.com';
            $asunto = 'LIQUIDACION DE BODEGA GENERADA';
            $header = "NUEVA LIQUIDACION CREADA CON EXITO";
            $mensajeCompleto = "El sistema generó una liquidación de bodega, comunicate con facturación o ingresa al sistema para ver el valor a cobrar.";
            mail($destinatario, $asunto, $mensajeCompleto, $header);
        }
    }
?>
    <h2 class="form__titulo titulo__pagina">LIQUIDACON DE BODEGA</h2>
        <p class="form__p form2--p">
            Aquí se encuentra el reporte general de las cargas ingresadas en el sistema.
        </p>

        <?php if(intval($alerta) === 1 ): ?>
        <p class="alerta2">LIQUIDACION GENERADA CON EXITO</p>
    <?php elseif(intval($alerta) === 2 ): ?>
        <p class="alerta">ALGO PASO!!! YA DAÑASTE</p>
    <?php endif ?>
<form action="" method="post">        
    <section class="container3">
        <fieldset class="form2 consulta__tabla">
        <legend>liquidacion a la fecha</legend>
        <div class="container2">
            <div class="form__container form--2">
                <div class="form__grupo">
                    <input type="date"   name="desde" id="desde" class="form__input" placeholder=" " value="" >
                    <label for="desde" class="form__label">DESDE LA FECHA</label>
                    <span class="form__linea"></span>
                </div>
            </div>
            <div class="form__container form--2">
                <div class="form__grupo">
                    <input type="text"   readonly name="hasta" id="hasta"class="form__input" placeholder=" " value="<?php $mes = date('y-m-d'); echo $mes;?>" >
                    <label for="hasta" class="form__label">HASTA LA FECHA</label>
                    <span class="form__linea"></span>
                </div>
            </div>
            <div class="form__container form--2">
                <div class="form__grupo">
                    <input type="text"   name="dias" id="dias"class="form__input" placeholder=" " value="20" >
                    <label for="dias" class="form__label">NUMERO DE DIAS</label>
                    <span class="form__linea"></span>
                </div>
            </div>
            <div class="form__container form--2">
                <div class="form__grupo">
                        <select name="periodo" class="form__input">
                            <option value=" ">...MES...</option>
                            <option value="enero">ENERO</option>
                            <option value="febrero">FEBRERO</option>
                            <option value="marzo">MARZO</option>
                            <option value="abril">ABRIL</option>
                            <option value="mayo">MAYO</option>
                            <option value="junio">JUNIO</option>
                            <option value="julio">JULIO</option>
                            <option value="agosto">AGOSTO</option>
                            <option value="septiemb">SEPTIEMBRE</option>
                            <option value="octubre">OCTUBRE</option>
                            <option value="noviemb">NOVIEMBRE</option>
                            <option value="diciemb">DICIEMBRE</option>
                        </select>
                </div>
            </div>
        </div>
        <table class="invem consulta__tabla">
            <thead >
                <tr>
                    <th>Metros 3 en bodega</th>
                    <th>Metros 3 despachados</th>
                    <th>VALOR A LIQUIDAR</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $query1 = "SELECT SUM(m3total) from ingreso";
                $valor1 = mysqli_query($db2, $query1);

                $query2 = "SELECT SUM(m3perchados) from perchado";
                $valor2 = mysqli_query($db2, $query2);
                ?>
                <tr>
                    <?php while($resultado1 = mysqli_fetch_assoc($valor1)): ?>
                    <td><?php echo $resultado1["SUM(m3total)"]; 
                                $existente1 = $resultado1["SUM(m3total)"]; ?>
                                <input type="hidden" name="m3enbodega" value="<?php echo $existente1; ?>"></td>
                    <?php endwhile; ?>
                    <?php while($resultado2 = mysqli_fetch_assoc($valor2)): ?>
                    <td><?php echo $resultado2["SUM(m3perchados)"];
                                $existente2 = $resultado2["SUM(m3perchados)"];  ?>
                                <input type="hidden" name="m3despachados" value="<?php echo $existente2; ?>"></td>
                    <?php endwhile; ?>
                    <td><?php  $liq = $existente1- $existente2;
                                $liq2 = filter_var( $liq, FILTER_VALIDATE_FLOAT);
                                echo $liq2;  ?>
                                <input type="hidden" name="m3liquidar" value="<?php echo $liq2; ?>"></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" class="form__submit" value="GUARDAR">
        </fieldset>
    </section>
</form>

<h2 class="form__titulo titulo__pagina">LIQUIDACIONES REALIZADAS</h2>
        <p class="form__p form2--p">
            <?php 
            $query7 = "SELECT SUM(valor) FROM liquidacion";
            $totalLiq = mysqli_query($db2, $query7);
            $liqTotal = mysqli_fetch_assoc($totalLiq);
            
            ?>
            valor facturado hasta la fecha $<?php echo $liqTotal["SUM(valor)"];?>
        </p>
<section class="container3">
    <fieldset class="form2 consulta__tabla">
        <table class="invem consulta__tabla">
            <thead >
                <tr>
                    <th>MES LIQUIDADO</th>
                    <th>DESDE</th>
                    <th>HASTA</th>
                    <th>M3 EN BODEGA</th>
                    <th>M3 DESPACHADOS</th>
                    <th>M3 LIQUIDADOS</th>
                    <th>POR COBRAR</th>
                    <th>RESPONSABLE</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $query8 = "SELECT * from liquidacion";
                $valor8 = mysqli_query($db2, $query8);
                ?>
                <?php while($liq9 = mysqli_fetch_assoc($valor8)):?>
                <tr>
                    <td><?php echo $liq9['periodo']; ?></td>
                    <td><?php echo $liq9['desde']; ?></td>
                    <td><?php echo $liq9['hasta']; ?></td>
                    <td><?php echo $liq9['m3enbodega']; ?></td>
                    <td><?php echo $liq9['m3despachados']; ?></td>
                    <td><?php echo $liq9['m3liquidar']; ?></td>
                    <td>$<?php echo $precio = filter_var( $liq9['valor'], FILTER_VALIDATE_FLOAT); ?></td>
                    <td><?php echo $liq9['responsable']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </fieldset>
</section>
<div class="boton__anidado">
    <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
</div>
</html>