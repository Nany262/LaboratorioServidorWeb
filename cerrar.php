<?php
//Destruir la sesión cuando el usuario cierra sesion
session_start();
session_destroy();
header("Location:index.php");
?>