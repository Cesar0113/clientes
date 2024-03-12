document.addEventListener("DOMContentLoaded", function () {
    // ... Otras funciones y lógica existente ...

    // Nueva función para mostrar el formulario de agregar producto
    function mostrarFormularioAgregar() {
        // Muestra el modal
        document.getElementById("agregarProductoModal").style.display = "block";
   
    }

    // Nueva función para cerrar el formulario de agregar producto
    function cerrarFormularioAgregar() {
        // Cierra el modal
        document.getElementById("agregarProductoModal").style.display = "none";
      
    }
    /// Asocia la función al evento click del botón de editar producto
    document.getElementById("btnAgregarProducto").addEventListener("click", mostrarFormularioAgregar, cerrarFormularioAgregar);
   
    
});

function activarBotones() {
    var checkboxes = document.querySelectorAll('.chk-producto');
    var btnEditar = document.getElementById('btn-editar');
    var btnEliminar = document.getElementById('btn-eliminar');

    var seleccionados = Array.from(checkboxes).filter(checkbox => checkbox.checked);

    if (seleccionados.length === 1) {
        btnEditar.disabled = false;
        btnEliminar.disabled = false;
    } else {
        btnEditar.disabled = true;
        btnEliminar.disabled = true;
    }
}

// Asociar la función al evento change de los checkboxes
var checkboxes = document.querySelectorAll('.chk-producto');
checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', activarBotones);
})

function obtenerIdProductoSeleccionado() {
    var checkboxes = document.querySelectorAll('.chk-producto');
    var idProducto = null;

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            idProducto = checkbox.getAttribute('data-id');
        }
    });

    return idProducto;
}

function eliminarProducto() {
    var idProducto = obtenerIdProductoSeleccionado();

    if (idProducto !== null) {
        // Crear un formulario para enviar la información al servidor
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = 'accionesProducto.php';

        // Crear un input oculto con el id del producto y la acción
        var inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = 'idProducto';
        inputId.value = idProducto;
        form.appendChild(inputId);

        var inputAccion = document.createElement('input');
        inputAccion.type = 'hidden';
        inputAccion.name = 'btnEliminarProducto';
        form.appendChild(inputAccion);

        // Adjuntar el formulario al documento y enviarlo
        document.body.appendChild(form);
        form.submit();
    }
}


    // Nueva función para mostrar el formulario de agregar producto
    function mostrarFormularioEditar() {
        // Muestra el modal
        document.getElementById("editarProductoModal").style.display = "block";
   
    }
    function cerrarFormularioEditar() {
        // Muestra el modal
        document.getElementById("editarProductoModal").style.display = "none";
   
    }
    function editarProducto() {
        var idProducto = obtenerIdProductoSeleccionado();
    
        if (idProducto !== null) {
            // Asignar el ID del producto al campo oculto
            document.getElementById("idProductoEditar").value = idProducto;
    
            // Realizar una petición AJAX para obtener los datos del producto
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Parsear la respuesta JSON
                    var producto = JSON.parse(xhr.responseText);
    
                    // Llenar el formulario con los datos del producto
                    llenarFormulario(producto);
    
                    // Mostrar el botón "Editar" y ocultar el botón "Guardar"
                    document.getElementById("btnEditarProducto").style.display = "none";
                    document.getElementById("btnEditarProducto").style.display = "inline-block";
    
                    // Mostrar el formulario de agregar producto con los datos del producto a editar
                    mostrarFormularioEditar ();
                }
            };
    
            // Hacer la petición al servidor para obtener los datos del producto con el id proporcionado
            xhr.open("GET", "obtenerProducto.php?id=" + idProducto, true);
            xhr.send();
        }
    }
    
    
    //Añadir esta función al final del archivo productos.js
function llenarFormulario(producto) {
    document.querySelector('input[name="nombreProducto"]').value = producto.nombre;
    document.querySelector('input[name="precioProducto"]').value = producto.precio;
    document.querySelector('textarea[name="descripcionProducto"]').value = producto.descripcion;

    // Puedes cargar la imagen si es necesario
    // document.querySelector('input[name="imgProducto"]').value = producto.imagen;
}
