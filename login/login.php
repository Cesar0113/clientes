<?php
session_start();
include '../conexion.php';

error_reporting(E_ERROR | E_PARSE | E_NOTICE);

if (isset($_SESSION['usuario'])) {
    header("Location: ../dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión - Inicio</title>
    <link rel="shortcut icon" href="..\img\logo_ur_02.png" type="image/x-icon">
    <link rel="shortcut icon" type="image/x-icon" href="img/placeholder.ico">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
   
    <div class="titulo">
    <a  href="../inicio.php"><i class="fas fa-home fa-lg" style="color: #f1a6f2;"></i></a>
        <h1>Iniciar Sesión</h1>
    </div>

    <div class="login">
        <form action="" method="POST">
            <label for="nombreUsuario">Usuario o Correo:</label>
            <input type="text" placeholder="Usuario o Correo" name="nombreUsuario" autocomplete="off" required><br />
            <label for="pass">Contraseña:</label>
            <input type="password" placeholder="Contraseña" name="password" autocomplete="off" required><br />
            <input type="submit" value="Ingresar" name="btningresar">
            <a href="../recuperacion/recuperar_contrasena.php">¿Olvidé la Contraseña?</a>
            <hr />
            <a href="../registrar/registrar.php">Registrarse</a>
        </form>

        <?php
        if (isset($_POST["btningresar"])) {
            $usuario = $_POST['nombreUsuario'] ?? null;
            $password = $_POST['password'] ?? null;
            $correo = $_POST['correo'] ?? null;
            
            // Validaciones básicas
            if (empty($usuario) || empty($password)) {
                echo "<p style='color: red;'>Ambos campos son requeridos.</p>";
            } else {
                $sql_ingresar = mysqli_query($conn, "SELECT * FROM tblusuario WHERE nombreUsuario = '$usuario' OR correo = '$usuario' AND password = '$password'");
                $resultado = mysqli_num_rows($sql_ingresar);

                if ($resultado == 1) {
                    while ($row = mysqli_fetch_array($sql_ingresar)) {
                        if (($usuario == $row['nombreUsuario'] || $usuario == $row['correo']) && $password == $row['password']) {
                            $_SESSION['usuario'] = $row['nombreUsuario'];
                            header("Location: ../dashboard.php");
                        }
                    }
                } else {
                    echo "<p style='color: red;'>Datos incorrectos o inexistentes.</p>";
                }
            }
        }
        ?>
    </div>
</body>
</html>
