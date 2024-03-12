<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/SMTP.php';

session_start();
include '../conexion.php';
error_reporting(E_ERROR | E_PARSE | E_NOTICE);

$mensaje_error = ""; // Inicializar mensaje de error

if (isset($_POST['btnrecuperar'])) {
    $correo = $_POST['correo'] ?? null;

    // Verificar si el correo existe en la base de datos
    $verificarCorreo = mysqli_query($conn, "SELECT * FROM tblusuario WHERE correo = '$correo'");
    $existeCorreo = mysqli_num_rows($verificarCorreo);

    if ($existeCorreo > 0) {
        // Generar un código de recuperación
        $codigoRecuperacion = bin2hex(random_bytes(8));
    
    
        // Guardar el código en la base de datos junto con el correo del usuario
        $guardarCodigo = mysqli_query($conn, "UPDATE tblusuario SET codigo_recuperacion = '$codigoRecuperacion' WHERE correo = '$correo'");
 
        if ($guardarCodigo) {
            $_SESSION['correo_recuperacion'] = $correo;
            // Configuración de PHPMailer
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'richardzambrano403@gmail.com';
            $mail->Password = 'gflvgmnuflvjftwv';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Resto del código para enviar el correo
            $mail->setFrom('richardzambrano403@gmail.com', 'Mascotas & Alimentación');
            $mail->addAddress($correo);
            $mail->Subject = 'Recuperación de Contraseña';
            $mail->isHTML(true);
            $mail->Body = '
            <html>
            <head>
                <title>Recuperación de Contraseña</title>
            </head>
            <body>
                <h1>Recuperación de Contraseña</h1>
                <p>Se ha solicitado la recuperación de contraseña. Utiliza el siguiente código para continuar:</p>
                <p style="font-size: 24px; font-weight: bold;">Tu código de recuperación es: ' . $codigoRecuperacion . '</p>
                <p>Ingresa este código en la página de verificación para completar el proceso.</p>
                <img src="../img/logo.png" alt="Logo" style="max-width: 100px; max-height: 100px;">
            </body>
            </html>';

            // Envía el correo
            if ($mail->send()) {
                echo "<p style='color: green;'>Se ha enviado un correo con el código de recuperación. Revisa tu bandeja de entrada o spam.</p>";
                echo "<script>window.location.href = 'verificar_codigo.php';</script>";
            } else {
                echo "<p style='color: red;'>Error al enviar el correo. Por favor, inténtalo de nuevo más tarde.</p>";
            }
        } else {
            echo "<p style='color: red;'>Error al generar el código de recuperación. Por favor, inténtalo de nuevo más tarde.</p>";
        } 
        
    } else {
        $mensaje_error = "El correo ingresado no existe en la base de datos.";
    }
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="shortcut icon" href="..\img\logo.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../css/recuperar_contrasena.css">
</head>

<body>

    <div class="titulo">
        <h1>Recuperar Contraseña</h1>
    </div>

    <div class="recuperar">
        <form action="" method="POST">
            <input type="text" placeholder="Correo Electrónico" name="correo" autocomplete="off" required>
            <button type="submit" name="btnrecuperar">Recuperar Contraseña</button>
   
        </form>

        <?php if (!empty($mensaje_error)) { ?>
            <div class="alert-fail">
                <button class="button-fail"><?php echo $mensaje_error; ?></button>
            </div>
        <?php } ?>
    </div>
    <a href="../inicio.php">Iniciar Sesión</a>
</body>
</html>
