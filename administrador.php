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
<body background-color="#616161">

<?php
//Pagina de usuario administrador, permite ver el listado de los usuarios registrados y activarlos o inactivarlos (segun sea el caso)
require 'conexion.php';

session_start();

//Validación de sesión activa
if(!isset($_SESSION["usuario"])){
	session_destroy();
	header("Location: index.php");
}
$usuario=$_SESSION["usuario"];
//Instruccion de verificacion y consulta
$instruccion="SELECT `nombre`,`nick`,`estado`FROM `USUARIOS` WHERE `idUsuario`='$usuario'";
$resultado=ejecutarConsulta($instruccion, "SELECT");

echo "<div class='container-fluid title'>
		  <h3><font color=''>".$resultado[0]." (".$resultado[1].")"."</font></h3><br>
		  </div>";
?>
<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	      	<li><a title="Cerrar" href="cerrar.php">Cerrar Sesión</a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	 </div><!-- /.container-fluid -->
</nav>


<?php


function estado(){
	//Funcion para cambiar de estado activo/inactivo a cualquier usuario registrado
	if(isset($_POST["cambio"])){
		$cambiar = $_POST["id_usuario"];
		$estado = $_POST["estado"];
		if($estado==1){
			$instruccion = "UPDATE `USUARIOS` SET `estado`=0 WHERE `idUsuario`='$cambiar'";
		}
		elseif($estado==0){
				$instruccion = "UPDATE `USUARIOS` SET `estado`=1 WHERE `idUsuario`='$cambiar'";
		}
		$resultado=ejecutarConsulta($instruccion, "UPDATE");
	}
}	


function usuarios(){
	//Función para listar y presentar todos los usuarios registrados en la plataforma
	$instruccion="SELECT `nombre`, `nick`, `correo`,`estado`,`idUsuario` FROM `USUARIOS` WHERE `idUsuario`!=0";
	$resultado=ejecutarConsulta($instruccion, "+ FILA");
	while($fila=mysqli_fetch_row($resultado)){
		if($fila!=NULL){
			if($fila[3]==1){
				$tmp='Activo';
			}
			else
			{
				$tmp='Inactivo';
			}
		echo "<tr>";
		echo "<td>".$fila[0]."</td>";
		echo "<td>".$fila[1]."</td>";
		echo "<td>".$fila[2]."</td>";
		echo "<form action='administrador.php' method=POST>
				<input type='hidden' name='id_usuario' value='$fila[4]'>
				<input type='hidden' name='estado' value='$fila[3]'>
				<td><button class='btn btn-default' name='cambio'>".$tmp."</button></td>
				</form></tr>";
		}
		}
}
?>

<div class="container">
<div class="panel panel-default">
		<table class= "table table-striped table-bordered">
			<tr>
				<div class= "panel-heading p"><center><h2>Usuarios</h2></center></div>
			</tr>

			<tr>
				<th>Nombre</th>
				<th>Nick</th>
				<th>Correo</th>
				<th>Estado</th>
			</tr>
			<?php estado();
			usuarios(); ?>
		</table>
	</div>
</div>

</body>
</html>