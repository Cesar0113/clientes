<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title> Recuperar Contraseña</title>
    <link rel="stylesheet" type="text/css" href="css/recuperar_contraseña.css">
</head>
<body>
    <div class="container">
        <h2>Recuperar Contraseña</h2>
        <form action="logica_recuperar.php" method="POST" onsubmit="return validarFormulario()">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit" name="submit">Recuperar Contraseña</button>
        </form>
        <p>¿Recordaste tu contraseña? <a href="index.php">Iniciar Sesión</a></p>
    </div>
  

</body>
</html>


