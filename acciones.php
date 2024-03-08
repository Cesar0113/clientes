<?php

//Inicio de la session y librerías necesarias
session_start();
include 'conexion.php';


$id = $_POST['idtext'] ?? null;
$nombre1 = $_POST['nombre1'] ?? null;
$nombre2 = $_POST['nombre2'] ?? null;
$apellido1 = $_POST['apellido1'] ?? null;
$apellido2 = $_POST['apellido2'] ?? null;
$direccion = $_POST['direccion'] ?? null;
$movil = $_POST['movil'] ?? null;
$email = $_POST['email'] ?? null;
$insertar = "" ?? null;
$actualizar = "" ?? null;

//INSERTAR UN CLIENTE NUEVO
if (isset($_POST['btncrear']))
{
    if($nombre1 != "" && $apellido1 != "" && $apellido2 != "" && $direccion != "" && $movil != "" &&  $email != "")
    {
        $insertar = mysqli_query($conn, "INSERT INTO tblcliente (nombre1, nombre2, apellido1, apellido2, direccion, movil, email) values ('$nombre1', '$nombre2', '$apellido1', '$apellido2', '$direccion', '$movil', '$email') ");
    }else{
        echo "<script> alert('Faltan campos por llenar, por favor revisar.');window.location='admin.php' </script> ";
    }


    if($insertar){ header("Location: admin.php"); }
}

//ELIMINAR UN CLIENTE
if(isset($_POST['idCliente']) || isset($_POST['btneliminar']))
{
	// Recibir el ID del cliente desde la solicitud POST
    $idCliente = $_POST['idCliente'] ?? null;

    if($idCliente != "")
    {
        $consulta_eliminar = mysqli_query($conn, "DELETE FROM tblcliente WHERE idCliente ='$idCliente' ");
    }else{
        echo "<script> window.location='admin.php'; </script> ";
    }

    if($consulta_eliminar)
    { 
        header("Location: admin.php");
    }
}

//GUARDAR CAMBIOS MODIFICADOS
if (isset($_POST['btnguardar'])) 
{
    $id = $_POST['idtext'] ?? null;

    if($nombre1 != "" && $apellido1 != "" && $apellido2 != "" && $direccion != "" && $movil != "" &&  $email != "")
    {
        $actualizar = mysqli_query($conn, "UPDATE tblcliente set nombre1 = '$nombre1', nombre2 = '$nombre2', apellido1 = '$apellido1', apellido2 = '$apellido2', direccion = '$direccion', movil = '$movil', email = '$email' WHERE idCliente = '$id' ");
    }else{
        echo "<script> alert('Faltan campos por llenar, por favor revisar.');window.location='admin.php' </script> ";
    }

    if($actualizar){ echo "<script> alert('Modificado correctamente.');window.location='admin.php' </script> ";}
}


//CONSULTAR INFORMACIÓN ESPECÍFICA
if (isset($_POST['btnconsultar'])) 
{
    header("Location: admin.php");
}

?>