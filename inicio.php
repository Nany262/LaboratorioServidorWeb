<!doctype <!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Konekto</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="statics/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Orbitron:400,900' rel='stylesheet' type='text/css'>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>

<body>
	<?php
	//Pagina principal
	require 'conexion.php';
	require 'cabecera.php';

	//Funcion para manejar sesiones en la plataforma y no permitir ingresos a las otras paginas
	session_start();

	//Validación de sesión activa
	if (!isset($_SESSION["usuario"])) {
		session_destroy();
		header("Location: index.php");
	}

	$usuario = $_SESSION["usuario"];
	if (cabecera($usuario) == 1) {
	?>
		<div class="row">
			<div class="col-md-12">
				<div class="container-fluid center">
					<?php
					//Instruccion de verificacion y consulta
					$instruccion = "SELECT `idUsuario`, `texto` , `fecha` FROM `COMENTARIO` WHERE `idReceptor`='$usuario'";
					$resultado = ejecutarConsulta($instruccion, "+ FILA");
					$tmp = 0;
					if (mysqli_num_rows($resultado) == 0) {
						$resultado = ejecutarConsulta($instruccion, "+ FILA");
					}
					if ($resultado != NULL) {
						echo "<h6><center>Mira lo que te han comentado...</center></h6>";
						do {
							if ($tmp != 0) {
								//Instruccion de verificacion y consulta
								$instruccion = "SELECT `nombre`, `nick` FROM `USUARIOS` WHERE `idUsuario`='$fila[0]'";
								$resultadoUsuario = ejecutarConsulta($instruccion, "SELECT");
								echo "<h5>" . ucwords($resultadoUsuario[0]) . " (" . strtolower($resultadoUsuario[1]) . ")</h5>" . $fila[1] . "<br>" . $fila[2];
							}
							$tmp = 1;
						} while ($fila = mysqli_fetch_row($resultado));
					} else {
						echo "<br><center><h6>No tienes ningun comentario</h6></div>";
					}
					?>
				</div>
			</div>
		<?php

	} else {
		echo <<<EOT
			<div class='container-fluid title'>
		  	<h3><font color=''>Error de Login</font></h3><br>
		  	</div><br>
			<div class='container'>
				<div class='panel panel-default'>
					<table class= 'table table-striped table-bordered'>
					<tr>
						<div class= 'panel-heading p'><center><h2>Lo sentimos...</h2></center></div>
					</tr>
		<tr><p><br>Querido usuario:<br>Esta notificacion le informa que su cuenta ha sido inhabilitada en Konekto, para quejas o reclamos porfavor contactarse con el equipo de desarrollo</p></tr>
		<tr><br><center><a href='index.php'>Volver</center><br></tr>
		EOT;
	}
		?>
</body>

</html>