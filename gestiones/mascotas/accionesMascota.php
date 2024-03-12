<?php
session_start();
include '../../conexion.php';

error_reporting(E_ERROR | E_PARSE | E_NOTICE);

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../inicio.php");
}

// Acción para crear una nueva mascota
if (isset($_POST['btncrear'])) {
    $nombreMascota = $_POST['nombreMascota'] ?? null;
    $edadMascota = $_POST['edadMascota'] ?? null;
    $tipoMascota = $_POST['tipoMascota'] ?? null;
    $raza = $_POST['raza'] ?? null;
    $cliente = $_POST['cliente'] ?? null;

    if ($nombreMascota != "" && $edadMascota != "" && $tipoMascota != "" && $raza != "" && $cliente != "") {
        // Verifica si la raza ya existe en la tabla, si no, la inserta
        $consultaRaza = mysqli_query($conn, "SELECT * FROM tblraza WHERE nombreRaza = '$raza'");
        $filaRaza = mysqli_fetch_array($consultaRaza);

        // Inicializa $idRaza
        $idRaza = 0;

        if (!$filaRaza) {
            // La raza no existe, la insertamos
            $insertarRaza = mysqli_query($conn, "INSERT INTO tblraza (nombreRaza) VALUES ('$raza')");
            if ($insertarRaza) {
                $idRaza = mysqli_insert_id($conn);
            } else {
                echo "Error al crear la nueva raza.";
            }
        } else {
            // La raza ya existe, obtenemos su id
            $idRaza = $filaRaza['idRaza'];
        }

        // Inserta la mascota con la raza correspondiente
        $insertar = mysqli_query($conn, "INSERT INTO tblmascota (nombreMascota, edadMascota, tipoMascota, raza_id, idCliente) VALUES ('$nombreMascota', '$edadMascota', '$tipoMascota', '$idRaza', '$cliente')");

        if ($insertar) {
            echo "Mascota creada correctamente.";
        } else {
            echo "Error al crear la mascota.";
        }
    } else {
        echo "Faltan campos por llenar, por favor revisar.";
    }
} elseif (isset($_POST['btneliminar'])) {
    // Acción para eliminar una mascota
    $idMascotaEliminar = $_POST['idMascota'] ?? null;

    if ($idMascotaEliminar != "") {
        // Obtener la información de la mascota antes de eliminarla
        $consulta_info = mysqli_query($conn, "SELECT * FROM tblmascota WHERE idMascota = '$idMascotaEliminar'");
        $info_mascota = mysqli_fetch_array($consulta_info);

        $consulta_eliminar = mysqli_query($conn, "DELETE FROM tblmascota WHERE idMascota = '$idMascotaEliminar'");

        if ($consulta_eliminar) {
            echo "Mascota eliminada correctamente.";

            // Ahora, verifica si la raza ya no está siendo utilizada por otras mascotas
            $raza_id_eliminar = $info_mascota['raza_id'];
            $consulta_otras_mascotas = mysqli_query($conn, "SELECT * FROM tblmascota WHERE raza_id = '$raza_id_eliminar'");
            
            if (mysqli_num_rows($consulta_otras_mascotas) == 0) {
                // No hay otras mascotas usando esta raza, se puede eliminar
                $consulta_eliminar_raza = mysqli_query($conn, "DELETE FROM tblraza WHERE idRaza = '$raza_id_eliminar'");
                if ($consulta_eliminar_raza) {
                    echo "Raza eliminada correctamente.";
                } else {
                    echo "Error al eliminar la raza.";
                }
            }
        } else {
            echo "Error al eliminar la mascota.";
        }
    } else {
        echo "Selecciona una mascota para eliminar.";
    }
} elseif (isset($_POST['btnguardar'])) {
    $id = $_POST['idMascota'] ?? null;
    $nombreMascota = $_POST['nombreMascota'] ?? null;
    $edadMascota = $_POST['edadMascota'] ?? null;
    $tipoMascota = $_POST['tipoMascota'] ?? null;
    $raza = $_POST['raza'] ?? null;
    $cliente = $_POST['cliente'] ?? null;

    if ($nombreMascota != "" && $edadMascota != "" && $tipoMascota != "" && $raza != "" && $cliente != "") {
        // Verifica si la raza ya existe en la tabla, si no, la inserta
        $consultaRaza = mysqli_query($conn, "SELECT * FROM tblraza WHERE nombreRaza = '$raza'");
        $filaRaza = mysqli_fetch_array($consultaRaza);

        // Inicializa $idRaza
        $idRaza = 0;

        if (!$filaRaza) {
            // La raza no existe, la insertamos
            $insertarRaza = mysqli_query($conn, "INSERT INTO tblraza (nombreRaza) VALUES ('$raza')");
            if ($insertarRaza) {
                $idRaza = mysqli_insert_id($conn);
            } else {
                echo "Error al crear la nueva raza.";
            }
        } else {
            // La raza ya existe, obtenemos su id
            $idRaza = $filaRaza['idRaza'];
        }

        // Actualiza la mascota con la raza correspondiente
        $actualizar = mysqli_query($conn, "UPDATE tblmascota SET nombreMascota = '$nombreMascota', edadMascota = '$edadMascota', tipoMascota = '$tipoMascota', raza_id = '$idRaza', idCliente = '$cliente' WHERE idMascota = '$id'");

        if ($actualizar) {
            echo "Mascota modificada correctamente.";
        } else {
            echo "Error al modificar la mascota.";
        }
    } else {
        echo "Faltan campos por llenar, por favor revisar.";
    }
} else {
    echo "Acción no reconocida.";
}
?>
