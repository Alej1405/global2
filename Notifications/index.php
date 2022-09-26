<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Notificaciones web</title>
	<script src="js/push.min.js"></script>
</head>
<body>
	<?php
		echo '<script>
		Push.create("Hola mundo",{
			body: "Este es el cuerpo de la notificacion",
			icon: "img/logo.png",
			timeout: 4000,
			onClick: function () {
				window.location="https://nickersoft.github.io/push.js/";
				this.close();
			}
		});
	</script>';
	?>
</body>
</html>