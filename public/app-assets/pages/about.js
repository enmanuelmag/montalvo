$(document).ready(function() {
    var table = $('.datatables-basic').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: datatable,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'titulo', name: 'titulo' },
            { data: 'estado', name: 'estado' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        order: [[0, 'asc']],
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
    document.getElementById('imagen_seccion').addEventListener('change', function() {
        readURL(this, 'preview_imagen_seccion');
    });

});

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
    document.getElementById('imagen_seccion').addEventListener('change', function() {
        readURL(this, 'preview_imagen_seccion');
    });

    document.getElementById('updateAboutForm').addEventListener('submit', function(e) {
        e.preventDefault();

        var form = document.getElementById('updateAboutForm');
        var formData = new FormData(form);

        axios.post(saveFormulario, formData, {
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

$(document).ready(function() {
    var table = $('.datatables-basic').DataTable();

    $('#saveAbout').on('click', function() {
        var titulo = $('#titulo').val();
        var token = document.querySelector('input[name="_token"]').value;
        var idAbout = $('#id_about').val();
        if (idAbout == 0){
            guardarAboutItem(token,titulo,table);
        }else{
            actualizarAboutItem(token,titulo,idAbout,table);

        }
    });
});

function guardarAboutItem(token,nombre_menu,table) {
    $.ajax({
        url: saveFormularioItem, // Asegúrate de que la URL es correcta
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        data: {
            titulo: nombre_menu
        },
        success: function(response) {
            // Mostrar mensaje de éxito
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Item Guardada Correctamente',
            });

            table.ajax.reload(null, false);

            // Limpiar el formulario del modal
            $('#aboutForm')[0].reset();

            // Cerrar el modal
            $('#about_modal').modal('hide');
        },
        error: function(response) {
            var errorMessage = 'Hubo un problema al guardar el Item ';
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

function actualizarAboutItem(token,nombre_menu,idSeccion,table){
    $.ajax({
        url: updateFormularioItem, // Asegúrate de que la URL es correcta
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        data: {
            titulo: nombre_menu,
            id: idSeccion
        },
        success: function(response) {
            // Mostrar mensaje de éxito
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Item Actualizado Correctamente',
            });

            table.ajax.reload(null, false);

            // Limpiar el formulario del modal
            $('#aboutForm')[0].reset();

            // Cerrar el modal
            $('#about_modal').modal('hide');
        },
        error: function(response) {
            var errorMessage = 'Hubo un problema al actualizar el Item ';
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


document.addEventListener('DOMContentLoaded', function() {
    // Función para abrir el modal para editar un ítem existente
    window.openEditModal = function(id) {
        fetch('/nosotros/' + id + '/edit')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('myModalLabel17').textContent = 'Editar Ítem';
                //document.getElementById('modalButton').id = 'editButton';
                document.getElementById('saveAbout').textContent = 'Actualizar';
                document.getElementById('titulo').value = data.titulo;

                document.getElementById('id_about').value = data.id;

                // Si hay otros campos, también debes llenarlos
                var navModal = new bootstrap.Modal(document.getElementById('about_modal'));
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
                fetch(deleteFormularioItem + '/' + id, {
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
    document.getElementById('myModalLabel17').textContent = 'Agregar Ítem';
    document.getElementById('saveAbout').textContent = 'Guardar';
    document.getElementById('id_about').value = 0;
    $('#aboutForm')[0].reset();
}
