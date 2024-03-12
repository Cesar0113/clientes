<?php
session_start();
include '../../conexion.php';

error_reporting(E_ERROR | E_PARSE | E_NOTICE);

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../inicio.php");
    header("Location: ../../dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" type="text/css" href="../../css/cliente.css">
    <link rel="stylesheet" type="text/css" href="../../css/dashboards.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

</head>
<body>
<div class="navbar">
       <div class="logo">
            <h1><i class="fas fa-dog"></i>M&A</h1>
        </div>
    <a href="clientes.php"><i class="fas fa-user"></i> Clientes</a>
    <a href="../mascotas/mascotas.php"><i class="fas fa-dog"></i> Mascotas</a>
    <a href="../productos/productos.php"><i class="fas fa-box-open"></i> Productos</a>
    <a href="#"><i class="fas fa-chart-line"></i> Informe de Ventas</a>
    <a class="logout" href="../../dashboard.php"><i class="fas fa-sign-out-alt"></i>Atras</a>
</div>

    <header>
    <h1>Gestión de Clientes</h1>
    </header>

    <div class="container">
        <div class="formInfo">
            <form action="accionesCliente.php" method="POST" id="form">
                <div class="textboxes">
                    <input type="text" placeholder="Primer Nombre" id="nombre1" name="nombre1" value="" required>
                    <input type="text" placeholder="Segundo Nombre" id="nombre2" name="nombre2" value=""><br /><br />
                    <input type="text" placeholder="Primer Apellido" id="apellido1" name="apellido1" value="" required>
                    <input type="text" placeholder="Segundo Apellido" id="apellido2"  name="apellido2"  value=""><br /><br />
                    <input type="text" placeholder="Dirección" id="direccion" name="direccion" value="" required>
                    <input type="text" placeholder="Móvil" id="movil" name="movil" value="" required><br /><br />
                    <input type="email" placeholder="Email" id="email" name="email" value="" required>
                    <input style="display:none; opacity: 60%;" type="number" placeholder="ID" id="idtext" name="idtext" value="" readonly>
                </div>

                <div class="buttons">
                    <button type="submit" name="btnconsultar" id="btnconsultar">Consultar</button>
                    <button type="submit" name="btncrear" id="btncrear">Crear</button>
                    <button type="button" name="btneliminar" id="btneliminar">Eliminar</button>
                    <button type="submit" name="btnmodificar" id="btnmodificar">Modificar</button>
                    <button type="submit" name="btnguardar" id="btnguardar">Guardar Cambios</button>
                </div>
            </form>
        </div>

        <div class="tableContainer">
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM tblcliente ORDER BY idCliente");
            ?>
            <table id="table">
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Primer Nombre</th>
                    <th>Segundo Nombre</th>
                    <th>Primer Apellido</th>
                    <th>Segundo Apellido</th>
                    <th>Dirección</th>
                    <th>Móvil</th>
                    <th>Email</th>
                </tr>
                <?php
                while($consulta = mysqli_fetch_array($sql)){
                ?>
                <tr>
                    <td><input class="checkbox" type="checkbox" /></td>
                    <td class="idcliente"><?php echo  $consulta['idCliente'];?></td>
                    <td class="nombre1"><?php echo  $consulta['nombre1'];?></td>
                    <td class="nombre2"><?php echo  $consulta['nombre2'];?></td>
                    <td class="apellido1"><?php echo  $consulta['apellido1'];?></td>
                    <td class="apellido2"><?php echo  $consulta['apellido2'];?></td>
                    <td class="direccion"><?php echo  $consulta['direccion'];?></td>
                    <td class="movil"><?php echo  $consulta['movil'];?></td>
                    <td class="email"><?php echo  $consulta['email'];?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <script type="text/javascript" src='clientes.js'></script>
</body>
</html>
