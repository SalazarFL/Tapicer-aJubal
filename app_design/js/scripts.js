console.log("scripts.js está funcionando");

// Función para asignar eventos a botones de eliminar
function asignarEventosBotones() {
    document.querySelectorAll('.btn-eliminar').forEach(function (boton) {
        boton.addEventListener('click', function () {
            const id = this.dataset.id;
            if (confirm('¿Desea eliminar este cliente?')) {
                fetch(`${BASE_AJAX_CLIENTES_ACCIONES}?accion=eliminar&id=${id}`, {
                    method: 'GET'
                })
                .then(async response => {
                    const contentType = response.headers.get("content-type");
                    
                    if (!response.ok) {
                        console.error('Respuesta del servidor no OK.');
                        throw new Error('Error en el servidor.');
                    }

                    if (contentType && contentType.includes("application/json")) {
                        return response.json();
                    } else {
                        const text = await response.text();
                        console.error('Respuesta inesperada (no JSON):', text);
                        throw new Error('La respuesta no es JSON.');
                    }
                })
                .then(data => {
                    if (data.success) {
                        alert('Cliente eliminado correctamente.');
                        location.reload(); // Recargar para actualizar lista
                    } else {
                        alert(data.error || 'Error al eliminar el cliente.');
                    }
                })
                
                .catch(error => {
                    console.error('Error en fetch:', error);
                    alert('Error al eliminar el cliente.');
                });
            }
        });
    });
}


// Función para cargar vistas dinámicamente (si la usas)
function cargarVista(vista) {
    fetch(`app_core/views/${vista}.php`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Vista no encontrada');
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('contenido-principal').innerHTML = data;
        })
        .catch(error => {
            document.getElementById('contenido-principal').innerHTML = `<p>Error: ${error.message}</p>`;
            console.error('Error al cargar vista:', error);
        });
}

// Esperar que el documento esté listo
document.addEventListener("DOMContentLoaded", function () {
    const formFiltro = document.getElementById('form-filtro-clientes');
    const btnLimpiar = document.getElementById('btn-limpiar');

    if (formFiltro) {
        formFiltro.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(formFiltro);
            const queryString = new URLSearchParams(formData).toString();

            fetch(BASE_AJAX_CLIENTES + '?' + queryString)
                .then(res => res.text())
                .then(data => {
                    document.querySelector('tbody').innerHTML = data;
                    asignarEventosBotones(); // Reasignar eventos
                })
                .catch(err => console.error("Error AJAX:", err));
        });
    }

    if (btnLimpiar) {
        btnLimpiar.addEventListener('click', function () {
            formFiltro.reset();

            fetch(BASE_AJAX_CLIENTES)
                .then(res => res.text())
                .then(data => {
                    document.querySelector('tbody').innerHTML = data;
                    asignarEventosBotones(); // Reasignar eventos
                })
                .catch(err => console.error("Error AJAX:", err));
        });
    }

    // Al cargar la página también se asignan los eventos iniciales
    asignarEventosBotones();
});
