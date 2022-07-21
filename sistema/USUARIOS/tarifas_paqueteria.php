<?php
//incluye el header
require '../../includes/funciones.php';
require '../../includes/config/database.php';

//PROTEGER PAGINA WEB
$auth = estaAutenticado();

if (!$auth) {
    header('location: index.php');
}

incluirTemplate('headersis2');

//BASE DE DATOS ADMINISTRADOR
conectarDB();
$db = conectarDB();

//BASE DE DATOS BODEGA 
conectarDB2();
$db2 = conectarDB2();

//CONECCION API
conectarDB3();
$db3 = conectarDB3();

//CONECCION CALLCENTER
conectarDB4();
$db4 = conectarDB4();

?>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- FORMULARIO DE ACTUALIZACION -->
            <div class="card bg-light">
                    <?php //foreach($errores as $error) : ?>
                        <div class="alert alert-danger">
                            <?php //echo $error; ?>
                        </div>
                    <?php //endforeach ?>
                <div class="card-header">
                    REGISTRO Y MOVIMIENTO FINANCIERO
                </div>
                <form action ='' method="POST" enctype="multipart/form-data">
                    <br>
                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="tipo" aria-label=".form-select-sm example">
                            <option selected>selecciona un tipo de Transaccion</option>
                            <option value="Ingreso">Ingreso</option>
                            <option value="Egreso">Egreso</option>
                        </select>
                    </div>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text">Valor $</span>
                        <input type="float" class="form-control" name="valor" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-text"></span>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Valor sin IVA $</span>
                        <input type="float" class="form-control" name="valor_SV" aria-label="Amount (to the nearest dollar)" value="0">
                        <span class="input-group-text"></span>
                    </div>

                    <div class="mb-3">
                        <label for="respaldo" class="form-label">Factura o Respaldo</label>
                        <input type="file" id="respaldo" accept="pdf" name="respaldo" class="form-control" require aria-label="Username" value="Adjuntar Respaldo" aria-describedby="basic-addon1">
                    </div>

                    <div class="mb-3">
                        <label for="deposito" class="form-label">Comprobanto o Respaldo</label>
                        <input type="file" id="deposito" accept="pdf" name="deposito" class="form-control" require aria-label="Username" value="Adjuntar Respaldo" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="detalle" aria-label=".form-select-sm example">
                            <option selected>selecciona un detalle</option>
                            <option value="anticipo">Anticipo</option>
                            <option value="pago proveedores">Pago de proveedores</option>
                            <option value="servicios basicos uio">Servicios Basicos UIO</option>
                            <option value="servicios basicos gye">Servicios Basicos GYE</option>
                            <option value="gastos administrativos">Gastos Administrativos</option>
                            <option value="viaticos">Viaticos</option>
                            <option value="gastos varios">Gastos Varios</option>
                            <option value="insumos de oficina">Insumos de Oficina</option>
                            <option value="gasto operativo">Gasto Operativo</option>
                            <option value="transporte">Transporte</option>
                            <option value="gasto administrativo">Gasto Administrativo</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="banco" aria-label=".form-select-sm example">
                            <option selected>selecciona una cuenta BANCARIA</option>
                            <option value="bco. de guayaquil">Bco. Guayaquil</option>
                            <option value="bco produbanco">Bco. Produbanco</option>
                            <option value="otra cuenta">Otra Cuenta</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="cuenta" aria-label=".form-select-sm example">
                            <option selected>selecciona una cuenta contable</option>
                            <option value="c. por pagar">C. Por Pagar</option>
                            <option value="c. por cobrar">C. Por Cobrar</option>
                            <option value="gasto operativo">Gasto Operativo</option>
                            <option value="caja chica">Caja Chica</option>
                            <option value="caja general">Caja General</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select form-select-sm" name="factura" aria-label=".form-select-sm example">
                            <option selected>Es una factura..?</option>
                            <option value="si">Si</option>
                            <option value="no">No</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Observacion</span>
                        <textarea class="form-control" name="observacion" aria-label="With textarea"></textarea>
                    </div>

                    <div class="input-group mb-3">
                        <input type="submit" value="Guardar Deposito" class="btn btn-outline-primary">
                    </div>
                </form>
            </div>
        <!-- FIN DE FORMULARIO DE ACTUALIZACION -->
    </div>
<?php 
    incluirTemplate('fottersis');
?>