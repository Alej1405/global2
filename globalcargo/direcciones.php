<?php 
    require '../includes/funciones.php';
    incluirTemplate('headerGeneral');
?>
<h2 class="headerDIR">GLOBAL CARGO EN EL MUNDO</h2> 
<div class="headerDIR__paises">
    <div class="paises--layout">
      <div class="paises">
        <img src="../IMG/estadosunidos.png" alt="Bandera USA" class="paises--img">
        <p class="paises--dir">
          ESTADOS UNIDOS
          8283NW 64th ST STE6
          Zip-Code 33166-2769
          Ph: 305-4717665
          Miami-Florida 
        </p>
      </div>
      <div class="paises">
        <img src="../IMG/mexico.png" alt="Bandera México" class="paises--img">
        <p class="paises--dir">
          MÉXICO
          Retorno Rosas #18
          Col. Villa Floresta 
          Puebla-México
          TELF +53-222-12721688
        </p>
      </div>
    </div>
    <div class="paises2">
      <img src="../IMG/ecuador.png" alt="Bandera Ecuador" class="paises--img">
      <p class="paises--dir">
        Av. San Luis e Isla Genovesa
        Edif: San Rafael Bussines Center
        Teléfono: 022-477-8976
        SAN RAFAEL-ECUADOR
      </p>
    </div>
    <h2 class="headerDIR">SI TENES UNA DUDA ESCRÍBENOS</h2>
    <?php incluirTemplate('form_contacto') ?>
</div>
<?php 
    incluirTemplate('footer');
?>