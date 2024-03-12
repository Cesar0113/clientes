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
    <title>Gestión - Registro</title>
    <link rel="shortcut icon" href="..\img\er.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../css/registrar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <div class="titulo">
    <a  href="../inicio.php"><i class="fas fa-home fa-lg" style="color: #f1a6f2;"></i></a>
        <h1>Registro Usuarios</h1>
    </div>

    <div class="login">
        <?php
        $correo = $_POST['correo'] ?? null;
        $usuario = $_POST['nombreUsuario'] ?? null;
        $password = $_POST['password'] ?? null;
        $rep_pass = $_POST['rep_pass'] ?? null;
        $perfil = "1";

        if (isset($_POST['btnregistrar'])) {
            $comprobarUsuario = mysqli_query($conn, "SELECT nombreUsuario, correo FROM tblusuario WHERE nombreUsuario = '$usuario' OR correo = '$correo'");
            $resultado = mysqli_num_rows($comprobarUsuario);

            if ($resultado >= 1) { ?>
                <div class="alert-fail">
                    <button class="button-fail">El nombre de usuario o correo electrónico ya se encuentra registrado. Por favor, inicie sesión o ingrese uno diferente.</button>
                </div>
            <?php
            } else if ($password != $rep_pass) { ?>
                <div class="alert-fail">
                    <button class="button-fail">Las contraseñas no coinciden.</button>
                </div>
            <?php
            } else {
                // Asegúrate de validar y filtrar el correo electrónico correctamente
                if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) { ?>
                    <div class="alert-fail">
                        <button class="button-fail">Ingrese un correo electrónico válido.</button>
                    </div>
                <?php
                } else {
                    $insertar = "INSERT INTO tblusuario (nombreUsuario, correo, password, idPerfil) values ('$usuario', '$correo', '$password', '$perfil')";
                    if (mysqli_query($conn, $insertar)) { ?>
                        <div class="alert-success">
                            <button class="button-success">Usuario registrado correctamente.</button>
                        </div>
                        <?php
                        header("Refresh:2; url=../login/login.php");
                    }
                }
            }
        }
        ?>

        <form action="" method="POST">
            <input type="text" placeholder="Nombre Usuario" name="nombreUsuario" autocomplete="off" value="" required>
            <input type="text" placeholder="Correo Electrónico" name="correo" autocomplete="off" value="" required>
            <input type="password" placeholder="Contraseña" name="password" value="" required>
            <input type="password" placeholder="Repetir contraseña" name="rep_pass" value="" required>
            <button type="submit" name="btnregistrar">Registrar</button>
            <hr />
            <a href="../login/login.php">Iniciar Sesión</a>
        </form>
    </div>

</body>
</html>
