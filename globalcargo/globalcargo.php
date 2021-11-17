<?php 
    require '../includes/funciones.php';
    incluirTemplate('header_gl');
?>
    <main class="captura">
      <div class="imporex" id="ser">
          <div class="impexp">
              <div class="flecha">
                <img src="../IMG/flecha.png" alt="Flecha del logo" class="flecha1">
                <h3 class="titulo">IMPORTACIÓN</h3>
              </div>
              <p class="dest">
                ACOMPAÑAMIENTO INTEGRAL DESDE LA
                BÚSQUEDA DEL PROVEEDOR HASTA LA
                ENTREGA DE LA CARGA EN EL PAÍS
              </p>
              <ul class="deser">
                <li class="deser1">CARGA SUELTA</li>
                <li class="deser1">FULL CONTENEDOR</li>
                <li class="deser1">CONSOLIDACIÓN</li>
                <li class="deser1">COURIER</li>
              </ul>
              <div class="botones">
                  <a href="mas.php" class="masinfo">MÁS INFO...</a>
              </div>
          </div>
          <div class="impexp">
              <div class="flecha">
                <img src="../IMG\flecha.png" alt="Flecha del logo" class="flecha1">
                <h3 class="titulo">EXPORTACIÓN</h3>
              </div>
              <p class="dest">
                ASESORÍA, CAPACITACIÓN Y BUSQUEDA
                DE POSIBLES CLIENTES Y PRIMER
                CONTACTO INTERNACIONAL
              </p>
              <ul class="deser">
                <li class="deser1">PRODUCTOS AGRÍCOLAS</li>
                <li class="deser1">ARTESANÍAS</li>
                <li class="deser1">TEXTILES</li>
                <li class="deser1">OTROS PRODUCTOS</li>
              </ul>
              <div class="botones">
                <a href="mas.php" class="masinfo">MÁS INFO...</a>
              </div>
          </div>
      </div>
      <div>
        <div class="contacto">
          <p> 
            Somos una empresa dedicada a brindar
            servicios de Comercio Exterior 
            y Logística internacional,
            enfocados siempre en la Agilidad y calidad 
            en cada uno de nuestros procesos.
          </p>
        </div>
        <div class="contacto">
            <?php incluirTemplate('form') ?>
        </div>
      </div>
    </main>
    <footer class="final">
      <div class="pie">
        <div class="logopie">
          <a href="index.php"><img src="../IMG\global.png" alt="logo global cargo" class="logop"></a>
        </div>
          <div class="derechospie">
            <p class="drechosp">
                GLOBAL CARGO ECUADOR 2021-2022 TODOS LOS DERECHOS RESERVADOS THEME GLOBAL BY MAHSA CORP SEO.
            </p>
          </div>
        </div>
      </div>
    </footer>
    <div class="wats">
      <a href="https://wa.me/message/2FIFVJQAVMN7F1" target="_blank">
        <img src="IMG\whatsapp.png" alt="" class="logowp">
      </a>
    </div>
  </body>
</html>
