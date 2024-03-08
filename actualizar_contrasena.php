<?php
// Iniciar la sesión y cargar la conexión
session_start();
include 'conexion.php';

// Captura de posibles errores
error_reporting(E_ERROR | E_PARSE | E_NOTICE);

// Verificar si el código de recuperación está presente en la URL
if (isset($_GET['codigo'])) {
    $codigoRecuperacion = $_GET['codigo'];

    // Verificar si el código de recuperación existe en la base de datos
    $sql_verificar_codigo = mysqli_query($conn, "SELECT * FROM tblusuario WHERE codigo_recuperacion = '$codigoRecuperacion'");
    $resultado = mysqli_num_rows($sql_verificar_codigo);

    if ($resultado == 1) {
        // Mostrar el formulario para restablecer la contraseña
        if (isset($_POST['btnRestablecer'])) {
            // Obtener la nueva contraseña y actualizar en la base de datos
            $nuevaContraseña = $_POST['nuevaContraseña'];

            $sql_actualizar_contraseña = mysqli_query($conn, "UPDATE tblusuario SET password = '$nuevaContraseña', codigo_recuperacion = NULL WHERE codigo_recuperacion = '$codigoRecuperacion'");

            if ($sql_actualizar_contraseña) {
                echo "<script> alert('Contraseña restablecida con éxito. Por favor, inicie sesión con su nueva contraseña.'); window.location='index.php' </script>";
            } else {
                echo "Error al restablecer la contraseña.";
            }
        }
    } else {
        echo "<script> alert('Código de recuperación no válido.'); window.location='index.php' </script>";
    }
} else {
    echo "<script> alert('Código de recuperación no proporcionado.'); window.location='index.php' </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión - Restablecer Contraseña</title>
    <link rel="shortcut icon" href="..\img\logo_ur_02.png" type="image/x-icon">
    <link rel="shortcut icon" type="image/x-icon" href="img/placeholder.ico">
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>

<body>

    <div class="titulo">
        <h1>Restablecer Contraseña</h1>
    </div>

    <div class="login">
        <form action="" method="POST">
            <label for="nuevaContraseña">Nueva Contraseña:</label>
            <input type="password" placeholder="Nueva Contraseña" name="nuevaContraseña" autocomplete="off" required><br /><br />
            <input type="submit" value="Restablecer Contraseña" name="btnRestablecer">
            <a style="display: flex; justify-content: center;" href="index.php">Volver a Iniciar Sesión</a>
            <br />
        </form>
    </div>

</body>

</html>
