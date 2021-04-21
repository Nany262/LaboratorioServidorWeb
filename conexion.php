<?php
//Funciones relacionadas con la BD y la conexión a la misma
	function conexionBD()
	{
		//Datos necesarios para conectar la base de datos con php
		$db_host = "localhost";
		$db_nombre = "konekto";
		$db_usuario = "root";
		$db_password = "";

		//Funcion que realiza la conexion y su respectivo error si no se logra la conexion 
		$conexion = mysqli_connect($db_host, $db_usuario, $db_password, $db_nombre);
		if (mysqli_connect_errno()) {
			echo "No se puede conectar";
			exit();
		}
		return $conexion;
	}

	//Funcion para ejecutar las consultas que se realicen a la BD
	function ejecutarConsulta($instruccionSQL, $tipo)
	{
		$conexion = conexionBD();
		$resultado = mysqli_query($conexion, $instruccionSQL);
		switch ($tipo){
			case "SELECT":
				$fila = mysqli_fetch_row($resultado);
				return $fila;
			case "UPDATE" or "INSERT INTO" or "DELETE":
				return $resultado;
			case "+ FILAS":
				return $resultado;
			default:
				break;
		}
		
		mysqli_close($conexion);
	}
?>
