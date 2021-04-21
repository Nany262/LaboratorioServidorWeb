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

<body class="fondoPrincipal">

	<div class="container-fluid title">
		<h1>Konekto</h1>
	</div>

	<div class="container">
		<h2>Iniciar sesión</h2>
		<form action="index.php" method="post">
			<label><input class="form-control" type="email" name="correo" placeholder="Correo Electronico"></label><br>
			<label><input class="form-control" type="password" name="pass" placeholder="Contraseña"></label><br>
			<br><button class="btn btn-primary" name="datos">Entrar</button>
		</form>
	</div>

	<?php
	//Pagina ´de inicio 
	require 'conexion.php';
	session_start();

	if (isset($_POST["datos"])) {
		//Toma los datos del formulario creado en html y los guarda en variables para manejarlos en php
		$correo = $_POST["correo"];
		$pass = $_POST["pass"];
		//Instruccion de verificacion y consulta
		$instruccion = "SELECT `idUsuario`,`entradas` FROM `USUARIOS` WHERE `correo`='$correo' and `clave`='$pass'";
		$resultado = ejecutarConsulta($instruccion, "SELECT");
		//Si en la base de datos no existe el usuario se devuelve a la pagina de index.php
		if ($resultado== NULL) {
			header("Location: index.php"); // envia de nuevo a la pagina index
		} else {
			$_SESSION["usuario"] = $resultado[0];
			$entrada = $resultado[1] + 1;
			$instruccion = "UPDATE `USUARIOS` SET `entradas`='$entrada' WHERE `idUsuario`='$resultado[0]'";
			$resultado = ejecutarConsulta($instruccion, "UPDATE");

			header("Location: inicio.php"); // envia a la pagina de inicio
		}
	}
	?>

	<!--Formulario Registro de usuario-->
	<div class="container">
		<h2>Registrarse</h2>
		<form action="index.php" method="post">
			<label><input class="form-control" type="email" name="correoreg" placeholder="Correo Electronico" pattern="{1,}" required></label><br>
			<label><input class="form-control" type="text" name="nombre" placeholder="Nombre" pattern="[a-zA-Z]{1,20}" required title="No se permiten caracteres numericos"></label><br>
			<label><input class="form-control" type="text" name="nick" placeholder="Nick" pattern="[a-zA-Z0-9]{1,10}" required title="Maximo 10 caracteres"></label><br>
			<label><input class="form-control" type="password" name="passreg" placeholder="Contraseña" pattern="{4,}" required></label><br>
			<br><button class="btn btn-primary" name="registro">Registrarse</button>
	</div>
	<?php

	if (isset($_POST["registro"])) {
		//Toma los datos del formulario registro creado en html y los guarda en variables para manejarlos en php
		$correo = $_POST["correoreg"];
		$nom = $_POST["nombre"];
		$nick = $_POST["nick"];
		$pass = $_POST["passreg"];
		//Instruccion de verificacion y consulta
		$instruccion = "SELECT `correo` FROM `USUARIOS` WHERE `correo`='$correo'";
		$resultado = ejecutarConsulta($instruccion, "SELECT");
		if ($resultado == NULL) {
		//Instruccion de verificacion y consulta
			$instruccion = "INSERT INTO `USUARIOS`(`correo`, `nombre`, `nick`, `clave`, `entradas`, `estado`) VALUES ('$correo','$nom','$nick','$pass',0,1)";
			$resultado = ejecutarConsulta($instruccion, "INSERT INTO");
			echo "<div class='container'><h4>Registro exitoso</h4></div>";
		} else {
			echo "<div class='container'><font size=5>El usuario ya se encuentra registrado</font></div>";
		}
	}
	?>

</body>

</html>