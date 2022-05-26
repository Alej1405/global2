<?php 
    //$id = $_GET['id'];
    //$id = filter_var($id, FILTER_VALIDATE_INT);

    //incluye el header
    require '../../includes/funciones.php';

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

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $buscar = $_POST['orden'];
    } 
        //bloqueo de ordenes para delivered y returnes
            $queryBloq = "SELECT * FROM datosordenes where order_id = ${buscar}";
            $r_bloq = mysqli_query($db4, $queryBloq);
            $bloq = mysqli_fetch_assoc($r_bloq);

            if ($bloq['status'] == "delivered" ){
                header('location: actualizacion.php?error=4');
            }

            if ($bloq['status'] == "returnes" ){
                header('location: actualizacion.php?error=4');
            }
        //fin de bloqueo de ordenes, segmento de condiciones.
    
    $query2 = "SELECT * FROM datosordenes where order_id = ${buscar}";
           $resultado2 = mysqli_query($db4, $query2);
           

    $query = "SELECT * FROM orders where order_id = ${buscar}";
             $resultado = mysqli_query($db3, $query);

    // condicion para evaluar habilitar o bloquear una orden, por el estado
    

?>

<!-- inicio de formulario de actualizacion -busqueda de ordenes- -->
    <!DOCTYPE html>
        <html lang="en">

        <head>

            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="">
            <meta name="author" content="">

            <title>GLOBAL CARGO SYS</title>

            <!-- Custom fonts for this template-->
            <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
            <link
                href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
                rel="stylesheet">

            <!-- Custom styles for this template-->
            <link href="../../css2/sb-admin-2.min.css" rel="stylesheet">

        </head>
<!-- fin de inicio de formulario de actualizacion -busqueda de ordenes- -->

<body class="bg-gradient-primary">
    <div class="container">
            <h1 class="text-primary fs-3 text-center">CONSULTAR DETALLES DE LAS ORDENES</h1>
            
        <!-- informacion del cliente para actualizar -->
            <div class="accordion" id="accordionExample">
                <!-- INFORMACION COMPILADA DE LA API -->
                    <div class="accordion-item">
                        <h2 class="fs-3 fw-light text-danger" id="headingOne">
                            INFORMACION DEL CLIENTE
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php while($resultadoApi2 = mysqli_fetch_assoc($resultado2)) : 
                                $id_buscar = $resultadoApi2['id']; ?>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <strong>Nombre Apellido</strong>
                                    <?php echo $resultadoApi2['name']." ".$resultadoApi2['last_name']; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Numero de Orden</strong>
                                    <?php echo $resultadoApi2['order_id']; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Por cobrar</strong>
                                    $<?php echo $resultadoApi2['total']; ?>
                                </li>
                            </ul>
                            <?php endwhile; ?>
                        </div>
                        </div>
                    </div>
                <!-- FIN COMPILADA DE LA API -->
            </div>
        <!-- FIN informacion del cliente para actualizar -->
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">REPORTES</h1>
            </div>
                <!-- formulario de actualizacion  -->
                    <form action="acEstado.php" method="post" class="user">
                    
                            
                            <table class="table table-striped" hidden>
                                <thead>
                                    <tr>
                                        <th>NOMBRE</th>
                                        <th>APELLIDO</th>
                                        <th>CIUDAD</th>
                                        <th>DIRECCIÓN</th>
                                        <th>REFERENCIA</th>
                                        <th>TELEFONO</th>
                                        <th>SEGUNDO CONTACTO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($resultadoApi2 = mysqli_fetch_assoc($resultado2)) : ?>
                                        <tr>
                                            <td>
                                                <?php echo $resultadoApi2['name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $resultadoApi2['last_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $resultadoApi2['city']; ?>
                                            </td>
                                            <td>
                                                <?php echo $resultadoApi2['address']; ?>
                                            </td>
                                            <td>
                                                <?php echo $resultadoApi2['reference']; ?>
                                            </td>
                                            <td>
                                                <?php echo $resultadoApi2['phone']; ?>
                                            </td>
                                            <td>
                                                <?php echo $resultadoApi2['landline']; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                                    <select name="status" id="status" require class="form-select" aria-label="Default select example">
                                        <option value=""> ---SELECCIONA EL ESTADO DE LA ORDEN--- </option>
                                        <option value="undelivered">NO ENTREGADO</option>
                                        <option value="delivered">ENTREGADO</option>
                                    </select>

                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">OBSERVACION</label>
                                        <textarea class="form-control" name="observacion_estado" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                    <!-- <input type="text" aria-required="true" name="observacion_estado" id="observacion_estado" class="form__input" require placeholder=" " value=""  maxlength="255">
                                    <label for="telefono" class="form__label">OBSERVACION DEL ESTADO</label>
                                    <span class="form__linea"></span> -->
                                <div class="form__grupo" hidden>
                                    <input type="number" aria-required="true" name="n_visitas" id="n_visitas" class="form__input"  placeholder=" " value=""  maxlength="1">
                                    <label for="telefono" class="form__label">NUMERO DE VISITA</label>
                                    <span class="form__linea"></span>
                                </div>

                                <input type="submit" class="btn btn-success btn-user btn-block" value="REPORTAR">
                    

                        <fieldset class="form2 consulta__tabla" hidden>
                            <?php
                                
                            ?>
                            <!-- datos en hidden  -->
                            <legend hidden>DATOS GENERALES DE LA ORDEN</legend>
                            <table class="form2 consulta__tabla" >
                                <thead>
                                    <tr>
                                        <th>NNÚMERO DE ORDEN</th>
                                        <th>FECHA DE CREACION</th>
                                        <th>FECHA ESTIMADA DE ENTEGA</th>
                                        <th>TOTAL A PAGAR</th>
                                        <th>ESTADO DE LA ORDEN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
                                        <tr>
                                            <td>
                                                <?php echo $resultadoApi['order_id']; //numero de la orden emitida en Rusia?>
                                                <input type="hidden" name="order_id" value="<?php echo $resultadoApi['order_id'];?>">
                                            </td>
                                            <td>
                                                <?php echo $resultadoApi['order_at']; ?>
                                                <input type="hidden" name="order_at" value="<?php echo $resultadoApi['order_at'];?>" >
                                            </td>
                                            <td>
                                                <?php echo $resultadoApi['delivery_at']; ?>
                                                <input type="hidden" name="delivery_at" value="<?php echo $resultadoApi['delivery_at'];?>">
                                            </td>
                                            <td>
                                                $<?php $total = $resultadoApi['total']/100; $total2 =filter_var( $total, FILTER_VALIDATE_FLOAT); echo $total2;?>
                                                
                                                <input type="hidden" name="total" value="<?php echo $total2;?>">
                                            </td>
                                            <td>
                                                <?php echo $resultadoApi['status'];
                                                $resultadoApi['created_at']; ?>
                                                <input type="hidden" name="status1" value="<?php echo $resultadoApi['status'];?>">
                                                <input type="hidden" name="created_at" value="<?php echo $resultadoApi['created_at'];?>">
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </fieldset>

                        <fieldset class="form2 consulta__tabla" hidden>
                            <?php

                                $query2 = "SELECT * FROM datosordenes where order_id = ${buscar}";
                                $resultado2 = mysqli_query($db4, $query2);
                                $resultadoApi31 = mysqli_fetch_assoc($resultado2);
                                $id_er = $resultadoApi31['id'];
                                $query3 = "SELECT * FROM order_products where order_id = ${id_er}";
                                $resultado3 = mysqli_query($db3, $query3);
                            ?>
                            <legend hidden>DETALLES DE PRODUCTOS</legend>
                            <table class="form2 consulta__tabla">
                                <thead>
                                    <tr>
                                        <th>PRODUCTO</th>
                                        <th>PRECIO UNITARIO</th>
                                        <th>CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($resultadoApi3 = mysqli_fetch_assoc($resultado3)) : ?>
                                        <tr>
                                            <td><?php echo $resultadoApi3['name']; ?></td>
                                            <td>
                                                $<?php $total = $resultadoApi3['unit_price']/100; $total4 =filter_var( $total, FILTER_VALIDATE_FLOAT); echo $total4;?>
                                                </td>
                                            <td><?php echo $resultadoApi3['quantity']; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                            <input type="hidden" name="id_her" value="<?php echo $id_er;?>">
                            <div class="botones-fin">
                                
                            </div>
                        </fieldset>
                        <div class="d-grid gap-2">
                            
                        </div>
                    </form>
                <!-- formulario de actualizacion  -->
        </div>
    </div>
</body>