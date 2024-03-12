<?php
session_start();
include '../conexion.php';

if (!isset($_SESSION['correo_recuperacion'])) {
    header("Location: recuperar_contrasena.php");
    exit();
}


if (isset($_POST['btnverificar'])) {
    $codigo_ingresado = $_POST['codigo'] ?? null;
    $correo_recuperacion = $_SESSION['correo_recuperacion'];

    // Verificar si el código ingresado coincide con el almacenado en la base de datos
    $sql_verificar_codigo = mysqli_query($conn, "SELECT * FROM tblusuario WHERE correo = '$correo_recuperacion' AND codigo_recuperacion = '$codigo_ingresado'");
    $resultado = mysqli_num_rows($sql_verificar_codigo);

    if ($resultado == 1) {
        // Código válido, redirigir a cambiar contraseña
        header("Location: cambiar_contrasena.php");
        exit();
    } else {
        $mensaje_error = "Código incorrecto. Inténtelo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código</title>
    <link rel="shortcut icon" href="..\img\logo.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../css/verificar_codigo.css">
</head>

<body>

    <div class="titulo">
        <h1>Verificar Código</h1>
    </div>

    <div class="verificar">
        <form action="" method="POST">
            <p>Se ha enviado un código de verificación al correo proporcionado. Ingréselo a continuación:</p>
            <input type="text" placeholder="Código de Verificación" name="codigo" autocomplete="off" required>
            <button type="submit" name="btnverificar">Verificar Código</button>
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
