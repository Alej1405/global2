<?php 
    require '../includes/funciones.php';
    incluirTemplate('headerGeneral');
?>
  <div class="contactos">
    <h1 class="headerDIR directorio__telf--titulo">DIRECTORIO TELEFÓNICO</h1>
    <div class="directo__telf paises--layout">
        <div class="direcctorio__datos">
          <img src="../IMG/joha.png" alt="" class="datos--foto">
          <p class="datos--departamento paises--dir">
            JOHANNA SÁNCHEZ
            </br>
            DEP. OPERACIONES
            </br>
            0969080775
          </p>
          <a href="https://wa.me/593969080775" class="contactos--whatsapp"target="blanck">CONTACTAR AHORA</a>
        </div>
        <div class="direcctorio__datos">
          <img src="../IMG/criss.png" alt="" class="datos--foto">
          <p class="datos--departamento paises--dir">
            CRISTINA PANCHI
            </br>
            DEP. COMERCIAL
            </br>
            0983758176
          </p>
          <a href="https://wa.me/593983758176" class="contactos--whatsapp" target="blanck">CONTACTAR AHORA</a>
        </div>
        <div class="direcctorio__datos">
          <img src="../IMG/andre.png" alt="" class="datos--foto">
          <p class="datos--departamento paises--dir">
            ANDREÍNA MERA
            </br>
            DEP FINANCIERO
            </br>
            0963539438
          </p>
          <a href="https://wa.me/593963539438" class="contactos--whatsapp" target="blanck">CONTACTAR AHORA</a>
        </div>
    </div>
    <div class="gc__redes">
        <div class="redes__icon">
          <a href="https://www.facebook.com/GlobalCargoEC/" target="blanck" class="link__redes">
            <img src="../IMG/facebook.png" alt="icono facebook" target="blanck" class="icon">
          </a>
        </div>
        <div class="redes__icon">
          <a href="https://instagram.com/globalcargoec?utm_medium=copy_link" target="blanck" class="link__redes">
            <img src="../IMG/instagram.png" alt="icono instagram" target="blanck" class="icon">
          </a>
        </div>
        <div class="redes__icon">
          <a href="https://noti-cargoec.blogspot.com/?m=1" target="blanck" class="link__redes">
            <img src="../IMG/blog.png" alt="icono blog" target="blanck" class="icon">
          </a>
        </div>
    </div>
</div>
<div class="contacto__form">
        <?php incluirTemplate('form_contacto') ?>
</div>
<?php 
    incluirTemplate('footer');
?>