<?php

//Inicio de la session y librerías necesarias
session_start();
include 'conexion.php';

//Captura de posibles errores
error_reporting(E_ERROR | E_PARSE | E_NOTICE);

//Si se intenta acceder a la página sin iniciar sesión, se redirige al login
if(!isset($_SESSION['usuario']))
{
	header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gestión - Mascotas</title>
	<link rel="shortcut icon" href="..\img\logo_ur_02.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/razas.css">
    <script type="text/javascript" src='funciones.js'></script>
</head>

<body>

    <header>
        <div></div>
        <h1>Gestión de Mascotas</h1>
        <div class="logout">
            <h4>Salir</h4>
            <svg onclick="salir()" style="cursor: pointer; fill:#ffff;" id="Layer_1" data-name="Layer 1"  xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 89.6 122.88"><title>exit-sign</title><path d="M66.4,68.67H40.29a7.23,7.23,0,0,1,0-14.45H66.4l-8.48-9.47a7.25,7.25,0,0,1,.51-10.16,7.07,7.07,0,0,1,10.05.51L87.76,56.62a7.27,7.27,0,0,1-.06,9.72L68.48,87.78a7.05,7.05,0,0,1-10.05.51,7.25,7.25,0,0,1-.51-10.16l8.48-9.46ZM40.11.14a7.22,7.22,0,0,1,2.83,14.17L39.55,15c-16.33,3.24-25.1,5.09-25.1,27.69V82.25c0,21,9.34,22.76,24.8,25.65l3.63.68a7.21,7.21,0,1,1-2.71,14.17l-3.57-.68C13.78,117.81,0,115.23,0,82.25V42.67C0,8.24,12.84,5.56,36.74.82L40.11.14Z"/></svg>
        </div>
    </header> 


    <div class="container">
        <div class="formInfo">
            <form action="acciones.php" method="POST" id="form">
                <div class="textboxes">
                <input type="text" placeholder="Primer Nombre" id="nombre1" name="nombre1" value=""  >
                <input type="text" placeholder="Segundo Nombre" id="nombre2" name="nombre2" value="" ><br /><br />
                <input type="text" placeholder="Primer Apellido" id="apellido1" name="apellido1" value=""   >
                <input type="text" placeholder="Segundo Apellido" id="apellido2"  name="apellido2"  value="" ><br /><br />
                <input type="text" placeholder="Direccion" id="direccion" name="direccion" value=""  >
                <input style="display:none; opacity: 60%;" type="number" placeholder="ID" id="idtext" name="idtext" value="" readonly >
                </div>

                <div class="buttons">
                <button type="submit" name="btnconsultar" id="btnconsultar">Consultar</button>
                <button type="submit" name="btncrear" id="btncrear">Crear</button>
                <button type="submit" name="btneliminar" id="btneliminar">Eliminar</button>
                <button type="submit" name="btnmodificar" id="btnmodificar">Modificar</button>
                <button type="submit" name="btnguardar" id="btnguardar">Guardar Cambios</button>
                </div>

            </form>
        </div>

        <div class="tableContainer">

                <?php

                $sql = mysqli_query($conn, "SELECT * FROM tblcliente ORDER BY idCliente");
                ?>
                <table id="table">
                <tr>
                    <th></th>
                    <th>Id</th>
                    <th> Nombre</th>
                    <th>Edad</th>
                    <th>Raza</th>
                    <th>Tipo</th>
                    <th>Dueño</th>
                    
                </tr>
                <?php
                while($consulta = mysqli_fetch_array($sql)){
                ?>
                <tr>
                    <td><input class="checkbox" type="checkbox" /></td>
                    <td class="idcliente"><?php echo  $consulta['idCliente'];?></td>
                    <td class="nombre"><?php echo  $consulta['nombre'];?></td>
                    <td class="edad"><?php echo  $consulta['edad'];?></td>
                    <td class="raza"><?php echo  $consulta['raza'];?></td>
                    <td class="tipo"><?php echo  $consulta['tipo'];?></td>
                    <td class="dueño"><?php echo  $consulta['dueño'];?></td>
                    <td class="tipo"><?php echo  $consulta['tipo'];?></td>
                    <td class="dueño"><?php echo  $consulta['dueño'];?></td>
                    
                </tr>
                <?php } ?>
                </table>
            </div>

    </div>

</body>

</html>