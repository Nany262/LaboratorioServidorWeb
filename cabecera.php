<?php
//Genera la cabecera y el menú de navegacion para todas las paginas
function cabecera($usuario)
{
	//Instruccion de verificacion y consulta
	$instruccion = "SELECT `nombre`,`nick`,`estado`,`entradas` FROM `USUARIOS` WHERE `idUsuario`='$usuario'";
	$resultado = ejecutarConsulta($instruccion, "SELECT");

	if ($usuario == 0) {
		header("Location: administrador.php");
	}
	if ($resultado[2] == 1) {
		echo "<div class='container-fluid title'>
		  <h3>" . $resultado[0] . " (" . $resultado[1] . ")" . "</h3>
		  <h4><font color='#FFF'>Cantidad de entradas a tu perfil: " . $resultado[3] . "</font></h4>
		  </div>";

		echo <<<EOT
			<nav class="navbar navbar-default">
					<div class="container-fluid">
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li><a title="Perfil" href="inicio.php">Perfil</a></li>
							</ul>
							<form action="busqueda.php" method="GET" class="navbar-form navbar-left" role="search">
								<div class="form-group">
									<input class="form-control" type="email" name="correo" placeholder="Buscar personas">
								</div>
								<button class="btn btn-default" name="busca">Buscar</button>
							</form>
							<ul class="nav navbar-nav navbar-right">
								<li><a title="Cerrar" href="cerrar.php">Cerrar Sesión</a></li>
							</ul>
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container-fluid -->
				</nav>
		EOT;
	}
	return $resultado[2];
}
