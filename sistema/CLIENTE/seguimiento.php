<?php 

    $resultado = $_GET['resultado'] ?? null;

    //incluye el header
    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if (!$auth) {
        header('location: ../index.php');
    }

    require '../../includes/config/database.php';
    incluirTemplate('headersis_cliente');
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

    //CONSULTAR DATOS DE LA TABLA
    $query = "SELECT * FROM cargas";
    $resultadoConsulta = mysqli_query($db, $query);

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){
            $query = "DELETE FROM cargas WHERE id = '${id}'"; 
            //echo $query;
            //exit; 

            $resultado = mysqli_query($db, $query);

            if ($resultado){
                $_SESSION['rol'];
                header('location: CLIENTE/cliente.php');
            }
        }
    }
?>

    <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Consulta General de Cargas</h1>
            <p class="mb-4">Esta es una consulta de todos lo ingresos realizados.s</a>.</p>
    <!-- DataTales Example -->
            <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="dataTable_length">
                                            <label>Show 
                                                <select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select> entries
                                            </label>
                                        </div>
                                    </div>
    
                                    <div class="col-sm-12 col-md-6">
                                        <div id="dataTable_filter" class="dataTables_filter">
                                            <label>Search:
                                                <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- CARGA DE INFORMACION DE LA PAGINA EN PROCESO -->
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <?php if(intval($resultado) === 1 ): ?>
                                        <p class="alerta2">la carga HA SIDO ACTUALIZADO CON ÉXITO</p>
                                    <?php elseif(intval($resultado) === 2 ): ?>
                                        <p class="alerta">lacarga HA SIDO ELIMINADO CON ÉXITO</p>
                                    <?php elseif(intval($resultado) === 3 ): ?>
                                        <p class="alerta">ANTES DE BORRAR UNA CARGA POR FAVOR ELIMINA EL PROCESO.</p>
                                    <?php endif ?>
                                    <thead>
                                        <tr>
                                            <th>Numero de orden</th>
                                            <th>provincia</th>
                                            <th>ciudad</th>
                                            <th>Estado reportado</th>
                                            <th>Fecha Actualizacion</th>
                                            <th>Orden Creada</th>
                                            <th>Valor por cobrar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php while($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
                                        <tr>
                                        <?php 
                                            $idver = $resultadoApi['id'];
                                            $verQuery = "SELECT contactado from verificacion WHERE contactado =${idver};";
                                            $ejec = mysqli_query($db4, $verQuery);
                                            $ejec2 = mysqli_fetch_assoc($ejec);
                                            if(!$ejec2){
                                                $verfi = "SIN PROCESAR";
                                            }else{
                                                $verfi = "PROCESADA";
                                            }
                                        ?>
                                            <td><?php echo $cliente['id']; ?></td>
                                            <td><?php echo $cliente['ingreso']; ?></td>
                                            <td><?php echo $cliente['doc']; ?></td>
                                            <td><?php echo $cliente['nFactura']; ?></td>
                                            <td><?php echo $cliente['coEur1']; ?></td>
                                            <td><?php echo $cliente['flete']; ?></td>
                                            <td><?php echo $cliente['mrn']; ?></td>
                                            <td><?php echo $cliente['bodegaAduana']; ?></td>
                                            <td><?php echo $cliente['provedor']; ?></td>
                                            <td>
                                                    <form method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                                                    <input type="submit" class="accion__eliminar" value="eliminar">
                                                </form>
                                                <div class="accion__actualizar">
                                                    <a href="actcargas.php?id=<?php echo $cliente['id']; ?>" class="acciones__enlace">actualizar</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5">
                                            <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                                                Showing 1 to 10 of 57 entries
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-7">
                                            <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                                <ul class="pagination">
                                                    <li class="paginate_button page-item previous disabled" id="dataTable_previous">
                                                        <a href="#" aria-controls="dataTable" data-dt-idx="0" tabindex="0" class="page-link">
                                                            Previous
                                                        </a>
                                                    </li>
                                                    <li class="paginate_button page-item active">
                                                        <a href="#" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link">
                                                            1
                                                        </a>
                                                    </li>
                                                    <li class="paginate_button page-item ">
                                                        <a href="#" aria-controls="dataTable" data-dt-idx="2" tabindex="0" class="page-link">
                                                            2
                                                        </a>
                                                    </li>
                                                    <li class="paginate_button page-item ">
                                                        <a href="#" aria-controls="dataTable" data-dt-idx="3" tabindex="0" class="page-link">
                                                            3
                                                        </a>
                                                    </li>
                                                    <li class="paginate_button page-item ">
                                                        <a href="#" aria-controls="dataTable" data-dt-idx="4" tabindex="0" class="page-link">
                                                            4
                                                        </a>
                                                    </li>
                                                    <li class="paginate_button page-item ">
                                                        <a href="#" aria-controls="dataTable" data-dt-idx="5" tabindex="0" class="page-link">
                                                            5
                                                        </a>
                                                    </li>
                                                    <li class="paginate_button page-item ">
                                                        <a href="#" aria-controls="dataTable" data-dt-idx="6" tabindex="0" class="page-link">
                                                            6
                                                        </a>
                                                    </li>
                                                    <li class="paginate_button page-item next" id="dataTable_next">
                                                        <a href="#" aria-controls="dataTable" data-dt-idx="7" tabindex="0" class="page-link">
                                                            Next
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </table>
                            </div>
                        </div>
            </div>        