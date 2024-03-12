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
    <link rel="stylesheet" type="text/css" href="./css/dashboard.css">
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
    <a class="logout" href="./salir/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
</div>
<div class="contenido">
    <!-- Información general -->
    <h2>Bienvenido al Panel de Control</h2>
    <p>En esta página puedes administrar diferentes aspectos de tu aplicación, como clientes, mascotas y productos.</p>
    <p>¡Explora las opciones de la barra de navegación para empezar!</p>

    <!-- Resumen de estadísticas -->
    <h3>Estadísticas</h3>
    <ul>
        <li><i class="fas fa-users"></i> Total de clientes registrados: 100</li>
        <li><i class="fas fa-dog"></i> Total de mascotas registradas: 150</li>
        <li><i class="fas fa-box"></i> Total de productos disponibles: 50</li>
    </ul>

    <!-- Últimas actividades -->
    <h3>Últimas Actividades</h3>
    <ul>
        <li><i class="fas fa-shopping-cart"></i> Cliente: Juan Pérez realizó una compra el 10/03/2024.</li>
        <li><i class="fas fa-syringe"></i> Mascota: Luna recibió una vacuna el 08/03/2024.</li>
        <li><i class="fas fa-store-alt"></i> Producto: Comida para gatos se agotó en inventario el 05/03/2024.</li>
    </ul>

    <!-- Próximas tareas -->
    <h3>Próximas Tareas</h3>
    <ul>
        <li><i class="fas fa-bell"></i> Recordatorio: Enviar recordatorio de cita al cliente Ana Rodríguez el 15/03/2024.</li>
        <li><i class="fas fa-clipboard-check"></i> Revisar inventario de productos antes de la próxima orden de compra.</li>
    </ul>

    <!-- Otros elementos relacionados con la gestión -->
    <h3>Opciones de Gestión</h3>
    <ul>
        <li><a href="./gestiones/clientes/clientes.php"><i class="fas fa-user"></i> Administrar Clientes</a></li>
        <li><a href="./gestiones/mascotas/mascotas.php"><i class="fas fa-dog"></i> Administrar Mascotas</a></li>
        <li><a href="./gestiones/productos/productos.php"><i class="fas fa-box-open"></i> Administrar Productos</a></li>
    </ul>
</div>
</body>
</html>
