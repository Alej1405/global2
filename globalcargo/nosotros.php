<?php 
    require '../includes/funciones.php';
    incluirTemplate('headerGeneral');
?>
<h1 class="titulo1">NOSOTROS</h1>
<div class="principal">
    <div class="aside export">
        <a href="#titulo1" class="aside__link">misión</a>
        <a href="#titulo2" class="aside__link">valores corporativos</a>
        <a href="#titulo3" class="aside__link">servicios principales</a>
        <a href="globalcargo.php" class="aside__link regresar">regresar</a>       
    </div>
    <div class="expos">
            <p class="parrafo1">
                Somos una empresa dedicada a brindar servicios de
                Comercio Exterior y Logística internacional, 
                enfocados siempre en la agilidad y calidad en 
                cada uno de nuestros procesos.
            </p>  
        <h2 class="titulo2" id="titulo1">MISION</h2>
                <p class="parrafo1">
                    Brindar servicios de Comercio Exterior y Logística
                    Internacional, teniendo como eje principal la 
                    calidad y agilidad de nuestras operaciones.
                </p>   
        <h2 class="titulo1" id="titulo2">VALORES CORPORATIVOS</h2>
                <ul>
                    <li class="lista3">Honestidad</li>
                    <li class="lista3">Responsabilidad<d</li>
                    <li class="lista3">Transparencia</li>
                    <li class="lista3">Agilidad</li>
                </ul>
        <h1 class="titulo1" id="titulo3">SERVICIOS PRINCIPALES</h1>
        <h2 class="titulo1">LOGISTICA</h2>
                <ul>
                    <li class="lista3">Transporte marítimo, LCL-FCL-Courier</li>
                    <li class="lista3">Transporte aéreo</li>
                    <li class="lista3">Transporte Multimodal</li>
                    <li class="lista3">Tranposte y Distribución a nivel nacional</li>
        </ul> 
        <h2 class="titulo1">ADUANA</h2>
        <ul>
            <li class="lista3">Nacionalización de mercaderías</li>
            <li class="lista3">DCP (INEN, MIPRO, ARCSA, etc)</li>
            <li class="lista3">Regímenes Especiales</li>
            <li class="lista3">Regímenes Especiales</li>
            <li class="lista3">Menajes de casa</li>
        </ul>    
        <h2 class="titulo1">SERVICIOS ESPECIALIZADOS</h2>
        <ul>
            <li class="lista3">Consultoría en Comercio Exterior</li>
            <li class="lista3">Internacionalización de productos y servicios</li>
            <li class="lista3">Optimización de Logística</li>
            <li class="lista3">Planificación de importaciones</li>
            <li class="lista3">Búsqueda de proveedores</li>
            <li class="lista3">Misiones comerciales</li>
            <li class="lista3">Ferias internacionales</li>
        </ul>
    </div>
</div>
<?php 
    incluirTemplate('footer');
?>