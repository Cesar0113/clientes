<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ./login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <link rel="stylesheet" type="text/css" href="./css/dashboards.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

</head>

<body>
<div class="navbar">
    <div class="logo">
            <h1><i class="fas fa-dog"></i>M&A</h1>
        </div>
    <a href="./gestiones/clientes/clientes.php"><i class="fas fa-user"></i> Clientes</a>
    <a href="./gestiones/mascotas/mascotas.php"><i class="fas fa-dog"></i> Mascotas</a>
    <a href="./gestiones/productos/productos.php""><i class="fas fa-box-open"></i> Productos</a>
    <a href="#"><i class="fas fa-chart-line"></i> Informe de Ventas</a>
    <a class="logout" href="./salir/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
</div>

</body>
</html>
