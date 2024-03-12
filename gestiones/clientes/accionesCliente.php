<?php
session_start();
include '../../conexion.php';

error_reporting(E_ERROR | E_PARSE | E_NOTICE);

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../inicio.php");
}

// Acción para crear un nuevo cliente
if (isset($_POST['btncrear'])) {
    $nombre1 = $_POST['nombre1'] ?? null;
    $nombre2 = $_POST['nombre2'] ?? null;
    $apellido1 = $_POST['apellido1'] ?? null;
    $apellido2 = $_POST['apellido2'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    $movil = $_POST['movil'] ?? null;
    $email = $_POST['email'] ?? null;

    if ($nombre1 != "" && $apellido1 != "" && $direccion != "" && $movil != "" && $email != "") {
        $insertar = mysqli_query($conn, "INSERT INTO tblcliente (nombre1, nombre2, apellido1, apellido2, direccion, movil, email) VALUES ('$nombre1', '$nombre2', '$apellido1', '$apellido2', '$direccion', '$movil', '$email')");
        
        if ($insertar) {
            echo '<script>
            alert("¡Cliente agregado correctamente.");
            window.location.href = "clientes.php"; // Redirige a la página deseada después de la alerta
          </script>';
        } else {
            echo "Error al crear el cliente.";
        }
    } else {
        echo "Faltan campos por llenar, por favor revisar.";
    }
} elseif (isset($_POST['btneliminar'])) {
    // Acción para eliminar un cliente
    $idClienteEliminar = $_POST['idtext'] ?? null;

    if ($idClienteEliminar != "") {
        $consulta_eliminar = mysqli_query($conn, "DELETE FROM tblcliente WHERE idCliente = '$idClienteEliminar'");
        
        if ($consulta_eliminar) {
            echo "Cliente eliminado correctamente.";
        } else {
            echo "Error al eliminar el cliente.";
        }
    } else {
        echo "Selecciona un cliente para eliminar.";
    }
} elseif (isset($_POST['btnguardar'])) {
    $id = $_POST['idtext'] ?? null;
    $nombre1 = $_POST['nombre1'] ?? null;
    $nombre2 = $_POST['nombre2'] ?? null;
    $apellido1 = $_POST['apellido1'] ?? null;
    $apellido2 = $_POST['apellido2'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    $movil = $_POST['movil'] ?? null;
    $email = $_POST['email'] ?? null;

    if ($nombre1 != "" && $apellido1 != "" && $direccion != "" && $movil != "" && $email != "") {
        $actualizar = mysqli_query($conn, "UPDATE tblcliente SET nombre1 = '$nombre1', nombre2 = '$nombre2', apellido1 = '$apellido1', apellido2 = '$apellido2', direccion = '$direccion', movil = '$movil', email = '$email' WHERE idCliente = '$id'");
        
        if ($actualizar) {
            // Redirigir a la página principal con un mensaje de éxito en la URL
            header("Location: clientes.php?mensaje=Cliente modificado correctamente");
            exit();
        } else {
            echo "Error al modificar el cliente.";
        }
    } else {
        echo "Faltan campos por llenar, por favor revisar.";
    }
} else {
    echo "Acción no reconocida.";
}
?>
