<?php 
    require '../includes/funciones.php';
    incluirTemplate('header_gl');
?>
    <main class="main">
      <!-- modal de servicios -->
        <div class="main__servicios" id="ser">
              <div class="servicios__impexp">
                    <div class="impexp--encabezado">  
                      <h3 class="impexp__titulo">EXPORTACIÓN</h3>
                      <svg class="titulo--icon" viewBox="439.45 179.44 39.577 34.273">
                        <path  d="M 458.9805908203125 191.3681640625 L 439.4500122070312 179.4400024414062 L 459.2385559082031 179.4400024414062 L 479.027099609375 179.4400024414062 L 469.1337890625 196.5765686035156 L 459.2385559082031 213.713134765625 L 458.9805908203125 191.3681640625 Z">
                        </path>
                      </svg>
                    </div>
                  <p class="impexp__dest">
                    Acompañamiento integral
                    desde la búsqueda del
                    proveedor hasta la entrega 
                    de la carga en el país
                  </p>
                  <ul class="impexp__li">
                    <li class="li__esp">CARGA SUELTA</li>
                    <li class="li__esp">FULL CONTENEDOR</li>
                    <li class="li__esp">CONSOLIDACIÓN</li>
                    <li class="li__esp">COURIER</li>
                  </ul>
                  <div class="botones">
                      <a href="mas.php" class="masinfo">MÁS INFO...</a>
                  </div>
              </div>
              <div class="servicios__impexp">
                    <div class="impexp--encabezado">  
                      <h3 class="impexp__titulo">EXPORTACIÓN</h3>
                      <svg class="titulo--icon" viewBox="439.45 179.44 39.577 34.273">
                        <path  d="M 458.9805908203125 191.3681640625 L 439.4500122070312 179.4400024414062 L 459.2385559082031 179.4400024414062 L 479.027099609375 179.4400024414062 L 469.1337890625 196.5765686035156 L 459.2385559082031 213.713134765625 L 458.9805908203125 191.3681640625 Z">
                        </path>
                      </svg>
                    </div>
                  <p class="impexp__dest">
                    Asesoría, capacitación 
                    y búsqueda de posibles 
                    clientes y primer contacto 
                    internacional            
                    </p>
                  <ul class="impexp__li">
                    <li class="li__esp">PRODUCTOS AGRICOLAS</li>
                    <li class="li__esp">ARTESANÍAS</li>
                    <li class="li__esp">TEXTILES</li>
                    <li class="li__esp">OTROS PRODUCTOS</li>
                  </ul>
                  <div class="botones">
                      <a href="mas.php" class="masinfo">MÁS INFO...</a>
                  </div>
              </div>
        </div>
          <!-- fin de modal de servicios    -->
          <!-- inicio del contenedor de mision y contacto -->
        <div class="main__contactos">
          <div class="contacto__misión">
            <p class="mision--parrafo"> 
                Somos una empresa dedicada a brindar
                servicios de Comercio Exterior 
                y Logística internacional,
                enfocados siempre en la Agilidad y calidad 
                en cada uno de nuestros procesos.
            </p>
          </div>
          <div class="contacto__form">
              <?php incluirTemplate('form') ?>
          </div>
        </div>
      <!-- fin del contenedor de contacto y misión  -->
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
