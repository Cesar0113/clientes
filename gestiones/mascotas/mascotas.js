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
        var idMascotaEliminar = obtenerIdMascotaSeleccionada();
        if (idMascotaEliminar !== null) {
            var confirmacion = confirm("¿Estás seguro de que deseas eliminar esta mascota?");
            if (confirmacion) {
                eliminarMascota(idMascotaEliminar);
            }
        } else {
            alert("Por favor selecciona una mascota para eliminar.");
        }
    });

    var btnModificar = document.getElementById("btnmodificar");
    btnModificar.addEventListener("click", function(event) {
        event.preventDefault();
        var idText = document.getElementById("idMascota");
        var filaSeleccionada = obtenerFilaSeleccionada();
        if (filaSeleccionada !== null) {
            idText.value = filaSeleccionada.querySelector(".idMascota").textContent;
            idText.style.display = "inline";
            document.getElementById("nombreMascota").value = filaSeleccionada.querySelector(".nombreMascota").textContent;
            document.getElementById("edadMascota").value = filaSeleccionada.querySelector(".edadMascota").textContent;
            document.getElementById("tipoMascota").value = filaSeleccionada.querySelector(".tipoMascota").textContent;
            document.getElementById("nombreRaza").value = filaSeleccionada.querySelector(".raza").textContent;
            // Aquí puedes agregar la lógica para manejar la raza y el dueño
        } else {
            alert("Por favor selecciona una mascota para modificar.");
        }
    });

    function obtenerIdMascotaSeleccionada() {
        var idMascota = null;
        var casillas = document.querySelectorAll("#table .checkbox");
        casillas.forEach(function(casilla) {
            if (casilla.checked) {
                var fila = casilla.closest("tr");
                idMascota = fila.querySelector("td:nth-child(2)").textContent;
                return;
            }
        });
        return idMascota;
    }

    function eliminarMascota(idMascota) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "accionesMascota.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    location.reload(); // Recargar la página después de eliminar
                } else {
                    console.error("Error al eliminar la mascota:", xhr.statusText);
                }
            }
        };
        xhr.send("idMascota=" + encodeURIComponent(idMascota) + "&btneliminar=Eliminar");
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
