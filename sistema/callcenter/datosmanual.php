<?php 
    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headerGeneral');
    incluirTemplate('headersis');
    //coneccion de sesion
    conectarDB();
    $db =conectarDB();

    //coneccion api
    conectarDB3();
    $db3 =conectarDB3();

    //coneccion callcenter
    conectarDB4();
    $db4 =conectarDB4();

    $auth = estaAutenticado();

    // proteger la página
    if (!$auth) {
        header('location: index.php');
    }
?>
<header class="headerFAQ">
  <h2 class="titulo--FAQ">MANUAL DE ACCION</h2>
</header>
<div class="master">
    <div class="hedaerFAQ__des">
      <p class="des--FAQ">
        El documento contiene
        un ayuda memoria de la capacitación
        que permita tener disponibles
        ciertas herramientas.
      </p>
    </div>
    <div class="FAQ__preguntas">
        <div class="preguntas">
          <h2 class="preguntas__subtitulo">-¿Qué debemos verificar?</h2>
          <p class="respuesta">
            Los datos del cliente indicando el pedido que realizó y si la dirección proporcionada es la correcta
          </p>
          
        </div>
        <div class="preguntas">
          <h2 class="preguntas__subtitulo">-¿Qué información debo darle al cliente?</h2>
          <p class="respuesta">	
            Debe informarle al cliente que para que su pedido sea despachado se requiere emitir la factura por lo tanto debe solicitarle los siguientes datos: 
              •	Nombres y apellidos para emisión de factura
              •	Número de cédula
              •	Teléfono
              •	Correo electrónico 
              •	Dirección
          </p>
          
        </div>
        <div class="presguntas">
          <h2 class="preguntas__subtitulo">-¿Qué informo sobre el pago?</h2>
          <p class="respuesta">
            Se informa al cliente los métodos de pago que tiene para poder cancelar los pedidos y se le pregunta qué método va a utilizar. 
            Pago en efectivo, se le pregunta si va requerir cambio y de cuánto será. 
            Pago mediante Transferencia
            Cuando el cliente informa que el pago lo va a realizar mediante transferencia, se le indican los datos de la entidad bancaria.
            CTA AHORROS BANCO PRODUBANCO
            # 12040423374
            RUC: 0993138150001
            mail: contabilidad@globalcargoecuador.com
                  francisco@globalcargoecuador.com 
            Se le indica al cliente que una vez realizada la transferencia, debe enviar su comprobante de pago al número de Whatsapp: 0963539438.

          </p>
          
        </div>
        <div class="preguntas">
          <h2 class="preguntas__subtitulo">-¿Sugerencia de Speach?</h2>
          <p class="respuesta">
          -Buenas tardes/días, me estoy comunicando con el señor Juan Perez, ud ha realizado un pedido en la página web PLANETASALUD, de un suplemento natural de marca AZUVISTIN. 
          - Si, así es…………………………………
          Por favor me confirma si la dirección para la entrega es correcta: Sangolquí, calle Gral Enriquez n° 392 y pasaje bellavista cerca a la cancha de futbol.
          -¿Cuál será su método de pago? Puede realizar una transferencia o pagar en efectivo.
          - Deseo pagar por transferencia…………………….
          - Los datos son: CTA AHORROS BANCO PRODUBANCO
          # 12040423374
          RUC: 0993138150001
          mail: contabilidad@globalcargoecuador.com
                  francisco@globalcargoecuador.com 
          •	Ayúdeme con sus datos para la factura:
          Nombre y apellido
          Número de cédula o RUC
          Correo electrónico
                      Dirección 
                      Teléfono.
          •	Por favor cuando tenga el comprobante de pago lo envía  a este número
          Whasapp: 0963539438.
          Un buen día….
          </p>
        </div>
    </div>
</div>

<div class="boton__anidado">
        <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
    </div>