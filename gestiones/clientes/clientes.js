document.addEventListener("DOMContentLoaded", function() {
    var checkboxes = document.querySelectorAll(".checkbox");

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener("change", function() {
            checkboxes.forEach(function(cb) {
                if (cb !== checkbox) {
                    cb.checked = false;
                    var filaNoSeleccionada = cb.closest("tr");
                    filaNoSeleccionada.classList.remove("fila-seleccionada");
                }
            });

            var fila = this.closest("tr");
            if (!fila.classList.contains("fila-seleccionada")) {
                fila.classList.add("fila-seleccionada");
            }
        });
    });

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
        }
    });

    var btnModificar = document.getElementById("btnmodificar");
    btnModificar.addEventListener("click", function(event) {
        event.preventDefault();
        var idText = document.getElementById("idtext");
        var filaSeleccionada = obtenerFilaSeleccionada();
        if (filaSeleccionada !== null) {
            idText.value = filaSeleccionada.querySelector(".idcliente").textContent;
            idText.style.display = "inline";
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

    function obtenerIdClienteSeleccionado() {
        var idCliente = null;
        var casillas = document.querySelectorAll("#table .checkbox");
        casillas.forEach(function(casilla) {
            if (casilla.checked) {
                var fila = casilla.closest("tr");
                idCliente = fila.querySelector("td:nth-child(2)").textContent;
                return;
            }
        });
        return idCliente;
    }

    function eliminarCliente(idCliente) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "accionesCliente.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    location.reload(); // Recargar la página después de eliminar
                } else {
                    console.error("Error al eliminar el cliente:", xhr.statusText);
                }
            }
        };
        xhr.send("idtext=" + encodeURIComponent(idCliente) + "&btneliminar=Eliminar");
    }

    function obtenerFilaSeleccionada() {
        var filas = document.querySelectorAll("#table tr");
        for (var i = 0; i < filas.length; i++) {
            var checkbox = filas[i].querySelector(".checkbox");
            if (checkbox && checkbox.checked) {
                return filas[i];
            }
        }
        return null;
    }
});
