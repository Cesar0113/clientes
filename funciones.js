//Función para cerrar sesión
function salir(){
    var respuesta = window.confirm("¿Desea cerrar la sesión?");
    if(respuesta == true)
        window.location="logout.php";
    else
        return 0;
}

// Función para manejar el cambio de estado de las casillas de verificación
document.addEventListener("DOMContentLoaded", function() {
    var checkboxes = document.querySelectorAll(".checkbox");

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener("change", function() {
            // Desmarcar todos los otros checkboxes
            checkboxes.forEach(function(cb) {
                if (cb !== checkbox) {
                    cb.checked = false;
                    var filaNoSeleccionada = cb.closest("tr");
                    filaNoSeleccionada.classList.remove("fila-seleccionada"); // Remover la clase de fila seleccionada
                }
            });

            // Verificar si la fila de este checkbox tiene la clase fila-seleccionada
            var fila = this.closest("tr");
            if (!fila.classList.contains("fila-seleccionada")) {
                // Si no tiene la clase, agregársela
                fila.classList.add("fila-seleccionada");
            }
        });
    });
});


//Eliminar un campo de la tabla si el checkbox está seleccionado

document.addEventListener("DOMContentLoaded", function() {
    var btnEliminar = document.getElementById("btneliminar");
    btnEliminar.addEventListener("click", function() {
        var idClienteEliminar = obtenerIdClienteSeleccionado();
        if (idClienteEliminar !== null) {
            var confirmacion = confirm("¿Estás seguro de que deseas eliminar este cliente?");
            if (confirmacion) {
                eliminarCliente(idClienteEliminar);
            }
        } else {
            alert("Por favor selecciona un cliente para eliminar.");
            window.location='admin.php';
        }
    });

    function obtenerIdClienteSeleccionado() {
        var idCliente = null;
        var casillas = document.querySelectorAll("#table .checkbox");
        casillas.forEach(function(casilla) {
            if (casilla.checked) {
                var fila = casilla.closest("tr");
                idCliente = fila.querySelector("td:nth-child(2)").textContent; // Obtener el ID de la segunda columna (índice 1)
                console.log(idCliente);
                return; // Salir del bucle forEach
            }
        });
        return idCliente;
    }

    function eliminarCliente(idCliente) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "acciones.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    // Aquí podrías recargar la tabla u otras acciones después de la eliminación
                } else {
                    console.error("Error al eliminar el cliente:", xhr.statusText);
                }
            }
        };
        xhr.send("idCliente=" + encodeURIComponent(idCliente));
    }
});


//Modificar un campo si el checkbox está seleccionado

document.addEventListener("DOMContentLoaded", function() {
    var btnModificar = document.getElementById("btnmodificar");
    btnModificar.addEventListener("click", function(event) {
        event.preventDefault(); // Prevenir el comportamiento predeterminado del botón (enviar el formulario)
        var idText = document.getElementById("idtext");
        var filaSeleccionada = obtenerFilaSeleccionada();
        if (filaSeleccionada !== null) {
            // Copiar los datos de la fila seleccionada al formulario
            idText.value = filaSeleccionada.querySelector(".idcliente").textContent;
            idText.style.display = "inline";
            console.log(idText.value);
            document.getElementById("nombre1").value = filaSeleccionada.querySelector(".nombre1").textContent;
            document.getElementById("nombre2").value = filaSeleccionada.querySelector(".nombre2").textContent;
            document.getElementById("apellido1").value = filaSeleccionada.querySelector(".apellido1").textContent;
            document.getElementById("apellido2").value = filaSeleccionada.querySelector(".apellido2").textContent;
            document.getElementById("direccion").value = filaSeleccionada.querySelector(".direccion").textContent;
            document.getElementById("movil").value = filaSeleccionada.querySelector(".movil").textContent;
            document.getElementById("email").value = filaSeleccionada.querySelector(".email").textContent;
        } else {
            alert("Por favor selecciona un cliente para modificar.");
        }
    });

    function obtenerFilaSeleccionada() {
        var filas = document.querySelectorAll("#table tr");
        for (var i = 0; i < filas.length; i++) {
            var checkbox = filas[i].querySelector(".checkbox");
            if (checkbox && checkbox.checked) {
                return filas[i];
            }
        }
        return null; // Si no se encuentra ninguna fila seleccionada
    }
    
});

