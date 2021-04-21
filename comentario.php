<?php
//Funciones para guardar los comentarios realizados por los usuarios
require 'conexion.php';
session_start();

//Validación de sesión activa
if(!isset($_SESSION["usuario"])){
	session_destroy();
	header("Location: index.php");
}

if (isset($_GET["enviar"])){
	$usuario=$_SESSION["usuario"];
	$correo=$_GET["correo"];
	$texto=$_GET["comentario"];

	//Instruccion de verificacion y consulta
	$instruccion="SELECT `idUsuario` FROM `USUARIOS` WHERE `correo`='$correo'";
	$resultado = ejecutarConsulta($instruccion, "SELECT");

	if ($resultado!=NULL){
		$instruccion="INSERT INTO `COMENTARIO`(`texto`, `idUsuario`, `idReceptor`) VALUES ('$texto','$usuario','$resultado[0]')";
			$resultado = ejecutarConsulta($instruccion, "INSERT INTO");
			header("Location: busqueda.php?correo=$correo");
	}
	else{
		header("Location: inicio.php");
	}	
}
?>