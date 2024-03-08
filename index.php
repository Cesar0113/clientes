<?php

//Inicio de la session y librerías necesarias
session_start();
include 'conexion.php';

//Captura de posibles errores
error_reporting(E_ERROR | E_PARSE | E_NOTICE);

//Si el usuario ya inició sesión, lo redirige a la pagina principal
if(isset($_SESSION['usuario']))
{
	header("Location: admin.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gestión - Inicio</title>
	<link rel="shortcut icon" href="..\img\logo_ur_02.png" type="image/x-icon">
	<link rel="shortcut icon" type="image/x-icon" href="img/placeholder.ico">
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>

<body>

	<div class="titulo">
		<h1>Iniciar Sesión</h1>
	</div>

	<div class="login">
	<form action="" method="POST">
            <label for="nombreUsuario">Usuario:</label>
            <input type="text" placeholder="Usuario" name="nombreUsuario" autocomplete="off" required><br /><br />
            <label for="pass">Contraseña:</label>
            <input type="password" placeholder="Contraseña" name="password" autocomplete="off" required><br /><br />
            <input type="submit" value="Ingresar" name="btningresar">
            <a style="display: flex; justify-content: center;" href="recuperar_contrasena.php">Restablecer Contraseña</a> <!-- Nuevo botón para restablecer contraseña -->
            <hr /><br />
            <a style="display: flex; justify-content: center;" href="registrar.php">Registrarse</a>
            <br />
        </form>

		<?php

		// Variables para las consultas
		$usuario = $_POST['nombreUsuario'] ?? null;
		$password = $_POST['password'] ?? null;

		if(isset($_POST["btningresar"]))
		{
			//Consulta sql, si el usuario existe entonces la consulta arroja el valor "1"
		    $sql_ingresar = mysqli_query($conn, "SELECT * FROM tblusuario WHERE nombreUsuario = '$usuario' and password = '$password'");
		    $resultado = mysqli_num_rows($sql_ingresar);

			//Si el resultado es "1" el usuario existe
		    if($resultado == 1) 
		    {
		    	while ($row=mysqli_fetch_array($sql_ingresar))
		    	{

		    		if($usuario = $row['nombreUsuario'] && $password = $row['password'])
		    		{
						//Se toma el nombre del usuario para la sesión y se redirige a la pagina principal
		    			$_SESSION['usuario'] = $row['nombreUsuario'];
		    			header("Location: menu.php");
		    		}
		    	}
		    //Si los datos no coinciden, muestra un mensaje
		    }else{ echo "<script> alert('Datos incorrectos o inexistentes.'); window.location='index.php' </script> ";}
		}

		?>

	</div>

</body>

</html>