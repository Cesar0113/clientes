<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PICUR - Inicio de Sesión</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="body">
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form action="../includes/login.php" method="POST" onsubmit="return validarFormulario()">
            <label for="usuario">Usuario:</label>
            <input type="text"  placeholder="Usuario" id="usuario" name="usuario" required>

            

            <label for="contrasena" class="form-label" >Contraseña:</label>
            <input type="password" placeholder="Contraseña" id="contrasena" name="contrasena" required>

            <button type="submit">Iniciar Sesión</button>
        </form>
       
        <p>¿Olvidaste tu contraseña? <a href="recuperar_contrasena.php">Recuperar Contraseña</a></p>

        <!-- Agrega un enlace para registrarse -->
        <p>¿No tienes una cuenta? <a href="../includes/registro.php">Registrarse</a></p>
    </div>
</body>
</html>
