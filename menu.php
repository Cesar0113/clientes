<?php

//Inicio de la session y librerías necesarias
session_start();
include 'conexion.php';

//Captura de posibles errores
error_reporting(E_ERROR | E_PARSE | E_NOTICE);

//Si se intenta acceder a la página sin iniciar sesión, se redirige al login
if(!isset($_SESSION['usuario']))
{
	header("Location: admin.php");
}

?>
<html>
  <head>
    <title> Mascotas  </title>
    <link rel="stylesheet" type="text/css" href="css/menu.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
   </head>
<body>
  <nav>
    <div class="menu">
      <div class="logo">
        <a href="#">CM</a>
      </div>
      <ul>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="admin.php">Gestion Clientes</a></li>
        <li><a href="mascotas.php">Gestion Mascotas</a></li> 
        <li><a href="razas.php">Gestion Razas</a></li>
        <li><a href="informe.php">Gestion Informe </a></li>
        <li><a href="index.php">Salir</a></li>
        
    </div>
  </nav>
  <div class="img"></div>
  <div class="center">
    <div class="title"> Las mascotas domésticas y de compañía </div>
    <div class="sub_title"></div>
  </div>
</body>
</html>
