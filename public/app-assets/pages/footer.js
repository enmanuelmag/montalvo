
document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('updateFooterForm').addEventListener('submit', function(e) {
        e.preventDefault();

        var form = document.getElementById('updateFooterForm');
        var formData = new FormData(form);

        axios.post(url, formData, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'multipart/form-data'
            }
        })
            .then(function (response) {
                if (response.data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Actualizado Correctamente',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al Enviar el Formulario',
                    });
                }
            })
            .catch(function (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error,
                });
            });
    });
});
