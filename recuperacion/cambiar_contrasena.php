<?php
session_start();
include '../conexion.php';

if (!isset($_SESSION['correo_recuperacion'])) {
    header("Location: recuperar_contrasena.php");
    exit();
}

if (isset($_POST['btncambiar'])) {
    $nueva_contrasena = $_POST['nueva_contrasena'] ?? null;
    $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? null;
    $correo_recuperacion = $_SESSION['correo_recuperacion'];

    // Verificar si las contraseñas coinciden
    if ($nueva_contrasena != $confirmar_contrasena) {
        $mensaje_error = "Las contraseñas no coinciden.";
    } else {
        // Actualizar la contraseña en la base de datos sin cifrar
        $update_contrasena = mysqli_query($conn, "UPDATE tblusuario SET password = '$nueva_contrasena', codigo_recuperacion = NULL WHERE correo = '$correo_recuperacion'");

        if ($update_contrasena) {
            // Contraseña cambiada con éxito, redirigir a la página de inicio de sesión
            header("Location: ../login/login.php");
            exit();
        } else {
            $mensaje_error = "Error al cambiar la contraseña. Inténtelo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión - Cambiar Contraseña</title>
    <link rel="shortcut icon" href="..\img\er.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../css/cambiar_contrasena.css">
</head>

<body>

    <div class="titulo">
        <h1>Cambiar Contraseña</h1>
    </div>

    <div class="cambiar">
        <form action="" method="POST">
            <p>Ingrese su nueva contraseña:</p>
            <input type="password" placeholder="Nueva Contraseña" name="nueva_contrasena" required>
            <input type="password" placeholder="Confirmar Contraseña" name="confirmar_contrasena" required>
            <button type="submit" name="btncambiar">Cambiar Contraseña</button>
            <a href="../inicio.php">Iniciar Sesión</a>
        </form>

        <?php if (isset($mensaje_error)) { ?>
            <div class="alert-fail">
                <button class="button-fail"><?php echo $mensaje_error; ?></button>
            </div>
        <?php } ?>
    </div>

</body>
</html>

