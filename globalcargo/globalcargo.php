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
      <div class="opciones">
          <div class="botones2">
              <a href="imporacion.php" class="opc">COTIZAR IMPORTACIÓN</a>
              <a href="imporacion.php" class="opc">COTIZAR EXPORTACIÓN</a>
          </div>
          <div class="imgopc">
              <img src="../IMG\Barco.png" alt="transporte maritimo de carga" class="imgopc1">
          </div>
      </div>
    </main>
    <footer class="final">
      <!-- formulario insertado desde el CRM -->
      <div class="cont">
        <div class="contacto">
          <?php incluirTemplate('form') ?>
        </div>
        <div class="ubicacion">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7619577206556!2d-78.45564398524667!3d-0.30454899977779953!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d5bd871b7edfaf%3A0x1c1e60c2f02a3597!2sSan%20Rafael%20Business%20Center!5e0!3m2!1ses!2sec!4v1632519679475!5m2!1ses!2sec" style="border:0;" allowfullscreen="" loading="lazy" class="mapa"></iframe>
        </div>
      </div>
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
