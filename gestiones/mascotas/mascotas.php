<?php
session_start();
include '../../conexion.php';

error_reporting(E_ERROR | E_PARSE | E_NOTICE);

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../inicio.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Mascotas</title>
    <link rel="stylesheet" type="text/css" href="../../css/mascota.css">
    <link rel="stylesheet" type="text/css" href="../../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

</head>
<body>
<div class="navbar">
       <div class="logo">
            <h1><i class="fas fa-dog"></i>M&A</h1>
        </div>
    <a href="../clientes/clientes.php"><i class="fas fa-user"></i> Clientes</a>
    <a href="mascotas.php"><i class="fas fa-dog"></i> Mascotas</a>
    <a href="../productos/productos.php"><i class="fas fa-box-open"></i> Productos</a>
    <a class="logout" href="../../dashboard.php"><i class="fas fa-sign-out-alt"></i>Atras</a>
</div>
    <header>
        <h1>Gestión de Mascotas</h1>
    </header>

    <div class="container">
        <div class="formInfo">
            <form action="accionesMascota.php" method="POST" id="form">
                <div class="textboxes">
                    <input type="text" placeholder="Nombre Mascota" id="nombreMascota" name="nombreMascota" value="" required>
                    <input type="number" placeholder="Edad Mascota" id="edadMascota" name="edadMascota" value="" required>
                    <input type="text" placeholder="Tipo Mascota" id="tipoMascota" name="tipoMascota" value="" required>
                    <input type="text" placeholder="Raza" id="raza" name="raza" value="" required>
                    
                    <label for="cliente">Dueño:</label>
                    <select id="cliente" name="cliente" required>
                        <?php
                        $clientes = mysqli_query($conn, "SELECT * FROM tblcliente");
                        while ($cliente = mysqli_fetch_array($clientes)) {
                            echo "<option value='{$cliente['idCliente']}'>{$cliente['nombre1']} {$cliente['apellido1']}</option>";
                        }
                        ?>
                    </select>

                    <input style="display:none; opacity: 60%;" type="number" placeholder="ID" id="idMascota" name="idMascota" value="" readonly>
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
            $sql = mysqli_query($conn, "SELECT m.*, r.nombreRaza FROM tblmascota m JOIN tblraza r ON m.raza_id = r.idRaza ORDER BY m.idMascota");
            ?>
            <table id="table">
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Tipo</th>
                    <th>Raza</th>
                    <th>Dueño</th>
                </tr>
                <?php
                while ($consulta = mysqli_fetch_array($sql)) {
                    ?>
                    <tr>
                        <td><input class="checkbox" type="checkbox" /></td>
                        <td class="idMascota"><?php echo $consulta['idMascota']; ?></td>
                        <td class="nombreMascota"><?php echo $consulta['nombreMascota']; ?></td>
                        <td class="edadMascota"><?php echo $consulta['edadMascota']; ?></td>
                        <td class="tipoMascota"><?php echo $consulta['tipoMascota']; ?></td>
                        <td class="raza"><?php echo $consulta['nombreRaza']; ?></td>
                        <td class="dueño"><?php echo obtenerNombreCliente($conn, $consulta['idCliente']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <script type="text/javascript" src='mascotas.js'></script>
</body>
</html>

<?php
function obtenerNombreCliente($conn, $idCliente)
{
    $consulta = mysqli_query($conn, "SELECT nombre1, apellido1 FROM tblcliente WHERE idCliente = $idCliente");
    $cliente = mysqli_fetch_array($consulta);
    return "{$cliente['nombre1']} {$cliente['apellido1']}";
}
?>
