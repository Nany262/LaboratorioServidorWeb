<!doctype <!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Konekto</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="statics/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Orbitron:400,900' rel='stylesheet' type='text/css'>
</head>

<body>
	<?php
	//Realiza una busqueda de usuario y muestra los comentarios del usuario buscado
	require 'conexion.php';
	require 'cabecera.php';
	session_start();

	//Validación de sesión activa
	if (!isset($_SESSION["usuario"])) {
		session_destroy();
		header("Location: index.php");
	}

	//Cabecera
	$usuario = $_SESSION["usuario"];
	$correoBuscado = $_GET["correo"];
	cabecera($usuario);
	//Instruccion de verificacion y consulta
	$instruccion = "SELECT `idUsuario`,`nombre`,`nick` FROM `USUARIOS` WHERE `correo`='$correoBuscado'";
	$resultado = ejecutarConsulta($instruccion, "SELECT");

	?>
	<div class="container-fluid">
		<?php
		echo "<h4> El usuario <b>" . ucwords($resultado[1]) . " (" . strtolower($resultado[2]) . ")" . "</b> tiene los siguientes comentarios:</h4>";
		?>
	</div>

	<div class='col-md-3'>
		<h4><br>Envia un comentario<br></h4>
		<form action="comentario.php" method="get">
			<textarea type="text" name="comentario" rows="13" cols="35" placeholder="Escribe un comentario..." required></textarea><br>
			<input type="hidden" name="correo" value=<?php echo $correoBuscado ?>>
			<br><button class="btn btn-primary" name="enviar">Enviar</button>
		</form>
	</div>
	<div class='col-md-9'>
		<h4><br>Comentarios<br></h4>
		<?php
		//Instruccion de verificacion y consulta
		$instruccion = "SELECT `idUsuario`, `texto`, `fecha` FROM `COMENTARIO` WHERE `idReceptor`='$resultado[0]'";
		$resultado = ejecutarConsulta($instruccion, "+ FILA");
		if ($resultado != NULL) {
			for($i=0;$i<mysqli_num_rows($resultado);$i++){
				$fila = mysqli_fetch_row($resultado);
				$idUsuario= array_shift($fila);
				$instruccion = "SELECT `nombre`, `nick` FROM `USUARIOS` WHERE `idUsuario`='$idUsuario'";
				$usuarioComentario = ejecutarConsulta($instruccion, "SELECT");
				echo "<h5>" . ucwords($usuarioComentario[0])."(".strtolower($usuarioComentario[1]).")</h5>";
				foreach ($fila as $comentarioInfo) {
					echo $comentarioInfo."<br>";
				}
			}
		} else {
			echo "<div class='container'><h4>El usuario que buscas no tiene comentarios</h4></div>";
		}
		?>
	</div>
</body>

</html>