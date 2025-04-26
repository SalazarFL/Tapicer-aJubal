console.log("scripts.js está funcionando");

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
                })
                .catch(err => console.error("Error AJAX:", err));
        });
    }
});
