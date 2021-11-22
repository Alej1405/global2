<?php 
    require 'includes/funciones.php';
    incluirTemplate('header');
?>
<body>
    <nav class="barra1">
      <div class="imagen">
        <a href="globalcargo/globalcargo.php"><img src="IMG/global.png" alt="logo global cargo" class="logoglobal"></a>
      </div>
      <div class="imagen">
        <a href="gcbox.php"><img src="IMG/gc.png" alt="logo gc-box" class="logogc"></a>
      </div>
    </nav>
    <section class="presen">
      <div class="baner">
          <div class="encab">
              <img src="IMG/ico1.png" alt="Fecha Global Cargo" class="ico2">
              <h1 class="tgc">GLOBAL CARGO </h1>
          </div>
          <p class="desc">
            Herramientas integrales de comercio
            exterior, para la importación y exportación. 
            Logista nacional, contamos con alianzas estratégicas
            que garantizan la entrega a tiempo y con rapidéz.
          </p>
          <button type="button" name="ingresar" class="botgc" >
            <a class="boton" href="globalcargo/globalcargo.php">INGRESAR</a>
          </button>
      </div>
      <div class="baner">
          <div class="encab">
              <img src="IMG/ico2.png" alt="Fecha Global Cargo" class="ico2">
              <h1 class="tgc">GC-BOX Courier</h1>
          </div>
          <p class="desc">
            Paquetería rápida, ágil y confiable.
            Compras asistidas desde las principales tiendas del mundo
            AMAZON, EBAY, TARGET.
            No solo compras para uso personal sino, también
            aquellos detalles que marcan la diferencia en el emprendimiento.
          </p>
          <button type="button" name="ingresar" class="botgc">
            <a class="boton" href="gcbox.php">INGRESAR</a>
          </button>
      </div>
    </section>
</body>
</html>
