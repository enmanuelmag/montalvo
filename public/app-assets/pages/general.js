$(document).ready(function() {

    var table = $('.datatables-basic').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: datatableGeneral,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'titulo', name: 'titulo' },
            { data: 'subtitulo', name: 'subtitulo' },
            { data: 'descripcion', name: 'descripcion' },
            { data: 'imagen', name: 'imagen' },
            { data: 'btn_text', name: 'btn_text' },
            { data: 'btn_link', name: 'btn_link' },
            { data: 'estado', name: 'estado' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                className: 'btn-excel btn-border-table'
            },
            {
                extend: 'pdf',
                className: 'btn-pdf btn-border-table'
            },
            {
                extend: 'print',
                className: 'btn-print btn-border-table'
            }
        ],
        initComplete: function(settings, json) {
            table.buttons().container().appendTo('.dt-buttons-container');
            feather.replace(); // Renderiza los íconos de Feather después de que la tabla se haya inicializado
        },
        drawCallback: function(settings) {
            feather.replace(); // Renderiza los íconos de Feather después de cada actualización de la tabla
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {
    function readURL(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('imagen').addEventListener('change', function() {
        readURL(this, 'preview_imagen');
    });

});

/*
//envio de formulario con imagenes
document.addEventListener('DOMContentLoaded', function() {
    function readURL(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('imagen').addEventListener('change', function() {
        readURL(this, 'preview_imagen');
    });

    document.getElementById('storeGeneralForm').addEventListener('submit', function(e) {
        e.preventDefault();

        var form = document.getElementById('storeGeneralForm');
        var formData = new FormData(form);

        axios.post(saveGeneral, formData, {
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
                    });
                    // Limpiar el formulario del modal
                    $('#storeGeneralForm')[0].reset();

                    // Cerrar el general_modal
                    $('#general_modal').modal('hide');
                    window.location.reload();
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

*/
document.addEventListener('DOMContentLoaded', function() {
    function readURL(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('imagen').addEventListener('change', function() {
        readURL(this, 'preview_imagen');
    });

    var saveButton = document.getElementById('saveGeneral');
    var updateButton = document.getElementById('updateGeneral');

    function handleSubmit(event, url) {
        event.preventDefault();

        var form = document.getElementById('storeGeneralForm');
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
                    });
                    // Limpiar el formulario del modal
                    $('#storeGeneralForm')[0].reset();

                    // Cerrar el general_modal
                    $('#general_modal').modal('hide');
                    window.location.reload();
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
    }

    saveButton.addEventListener('click', function(e) {
        handleSubmit(e, saveGeneral);
    });

    updateButton.addEventListener('click', function(e) {
        handleSubmit(e, updateGeneral);
    });
});


document.addEventListener('DOMContentLoaded', function() {
    // Función para abrir el modal para editar un ítem existente
    window.openEditModal = function(id) {
        fetch('/general/' + id + '/edit')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('myModalLabel17').textContent = 'Editar Ítem';
                //document.getElementById('modalButton').id = 'editButton';
                document.getElementById('saveGeneral').textContent = 'Actualizar';
                document.getElementById('updateGeneral').removeAttribute('hidden');
                document.getElementById('saveGeneral').setAttribute('hidden', 'true');
                // Llena el formulario con los datos existentes
                // Llena el formulario con los datos existentes
                document.getElementById('titulo').value = data.data.titulo;
                document.getElementById('subtitulo').value = data.data.subtitulo;
                document.getElementById('descripcion').value = data.data.descripcion;
                document.getElementById('preview_imagen').src = data.data.imagen; // Usa la URL completa
                document.getElementById('btn_text').value = data.data.btn_text;
                document.getElementById('btn_link').value = data.data.btn_link;
                document.getElementById('idSeccion').value = data.data.id;

                // Si hay otros campos, también debes llenarlos
                var navModal = new bootstrap.Modal(document.getElementById('general_modal'));
                navModal.show();
            })
            .catch(error => console.error('Error:', error));
    };

    window.deleteNavItem = function(id) {
        var table = $('.datatables-basic').DataTable();

        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                    fetch(deleteGeneral + '/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => {
                        if (response.ok) {
                            Swal.fire(
                                'Eliminado!',
                                'El ítem ha sido eliminado.',
                                'success'
                            );

                            // Aquí puedes agregar código para actualizar la tabla o la vista
                        } else {
                            Swal.fire(
                                'Error!',
                                'Hubo un problema al eliminar el ítem.',
                                'error'
                            );
                        }
                        table.ajax.reload(null, false);
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error!',
                            'Hubo un problema al eliminar el ítem.',
                            'error'
                        );
                    });
            }
        })
    };
});


function resetModal() {
    console.log('Reset');
    // Asegúrate de que los elementos existen antes de manipularlos
    var saveButton = document.getElementById('saveGeneral');
    var updateButton = document.getElementById('updateGeneral');

    if (saveButton && updateButton) {
        saveButton.removeAttribute('hidden');
        saveButton.textContent = 'Guardar';
        document.getElementById('preview_imagen').src = previewImageDefault;
        updateButton.setAttribute('hidden', 'true');
    } else {
        console.error('Elementos saveGeneral o updateGeneral no encontrados.');
    }

    $('#storeGeneralForm')[0].reset();
}
/*

$(document).ready(function() {
    var table = $('.datatables-basic').DataTable();

    $('#updateGeneral').on('click', function() {
        var titulo = $('#titulo').val();
        var subtitulo = $('#subtitulo').val();
        var descripcion = $('#descripcion').val();
        var subtitulo = $('#subtitulo').val();
        var subtitulo = $('#subtitulo').val();
        var icono_red_social = $('#icono_red_social').val();
        var token = document.querySelector('input[name="_token"]').value;
        var idRed = $('#id_nav').val();

            actualizarGeneral(token,nombre,link,icono_red_social,table,idRed);

    });
});


function actualizarGeneral(token,nombre,link,icono_red_social,table,idRed){
    $.ajax({
        url: updateSocialMedia, // Asegúrate de que la URL es correcta
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        data: {
            nombre: nombre,
            link: link,
            icono_red_social: icono_red_social,
            id: idRed
        },
        success: function(response) {
            // Mostrar mensaje de éxito
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Red Social Actualizada Correctamente',
            });

            table.ajax.reload(null, false);

            // Limpiar el formulario del modal
            $('#redes_form')[0].reset();

            // Cerrar el modal
            $('#redes_sociales_modal').modal('hide');
        },
        error: function(response) {
            var errorMessage = 'Hubo un problema al actualizar el Menu ';
            if (response.status === 422) {
                errorMessage = 'Validación fallida: ' + JSON.stringify(response.responseJSON.messages);
            }
            // Mostrar mensaje de error
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage,
            });
        }
    });
}
*/
