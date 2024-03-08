<?php

//Inicio de la session y librerías necesarias
session_start();
include 'conexion.php';

//Captura de posibles errores
error_reporting(E_ERROR | E_PARSE | E_NOTICE);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gestión - Registro</title>
	<link rel="shortcut icon" href="..\img\er.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/registrar.css">
</head>

<body>

	<div class="titulo">
		<h1>Registro Usuarios</h1>
	</div>

	<div class="login">
		<?php
            //Campos para registrar el usuario
			$usuario = $_POST['nombreUsuario'] ?? null;
			$password = $_POST['password'] ?? null;
			$rep_pass = $_POST['rep_pass'] ?? null;
            $perfil = "1";

			if (isset($_POST['btnregistrar'])){

                //Se comprueba primero que el nombre de usuario no exista anteriormente
				$comprobarUsuario = mysqli_query($conn, "SELECT nombreUsuario FROM tblusuario WHERE nombreUsuario = '$usuario'");
				$resultado = mysqli_num_rows($comprobarUsuario);

                //Si el nombre de usuario no existe, entonces lo inserta en la base de datos
				$insertar = ("INSERT INTO tblusuario (nombreUsuario, password, idPerfil) values ('$usuario', '$password', '$perfil') ");

                //Si al consultar si el usuario existia arrojó "1" muestra el mensaje que ya existe
				if ($resultado >= 1){ ?>
					<div class="alert-fail">
						<button type="button" class="button-fail">El nombre de usuario ya se encuentra registrado, por favor inicie sesión o ingrese uno diferente.</button>
					</div>

					<?php
                    //Si las contraseñas no coinciden
				}else if ($password != $rep_pass){ ?>
					<div class="alert-fail">
						<button type="button" class="button-fail">Las contraseñas no coinciden.</button>
					</div>

					<?php
                    //Si el usuario se registra correctamente
				}else if(mysqli_query($conn, $insertar)){ ?>
					<div class="alert-success">
						<button type="button" class="button-success">Usuario registrado correctamente.</button>
					</div>
					<?php
                    //Se recarga la página 2 segundos después
					header("Refresh:2; url=index.php");
				}
			}
		?>

		<form class= "" action="" method="POST">
			<input type="text" placeholder="Nombre Usuario" name="nombreUsuario" autocomplete="off" value="" required ><br /><br />
			<input type="password" placeholder="Contraseña" name="password" value="" required><br /><br />
			<input type="password" placeholder="Repetir contraseña" name="rep_pass" value="" required ><br /><br />
			<button type="submit" name="btnregistrar">Registrar</button>
			<button href= "recuperar_contrasena.php" type="submit" name="btnregistrar">Olvidé la Contraseña</button>

			<hr /><br />
			<a style="display: flex; justify-content: center;" href="index.php">Iniciar Sesión</a>
			<br />
		</form>
		

	</div>

</body>

</html>