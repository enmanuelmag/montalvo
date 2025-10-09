$(document).ready(function() {
    var table = $('.datatables-basic').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: datatableSocialMedia,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'url', name: 'url' },
            { data: 'icon', name: 'icon' },
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



$(document).ready(function() {
    var table = $('.datatables-basic').DataTable();

    $('#saveSocialMedia').on('click', function() {
        var nombre = $('#nombre').val();
        var link = $('#link').val();
        var icono_red_social = $('#icono_red_social').val();
        var token = document.querySelector('input[name="_token"]').value;
        var idRed = $('#id_nav').val();
        if (idRed == 0){
            guardarRed(token,nombre,link,icono_red_social,table);
        }else{
            actualizarRed(token,nombre,link,icono_red_social,table,idRed);

        }
    });
});

function guardarRed(token,nombre,link,icono_red_social,table) {
    $.ajax({
        url: saveSocialMedia, // Asegúrate de que la URL es correcta
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        data: {
            name: nombre,
            link: link,
            icon: icono_red_social
        },
        success: function(response) {
            // Mostrar mensaje de éxito
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Red social guardada correctamente',
            });

            table.ajax.reload(null, false);

            // Limpiar el formulario del modal
            $('#redes_form')[0].reset();

            // Cerrar el modal
            $('#redes_sociales_modal').modal('hide');
        },
        error: function(response) {
            var errorMessage = 'Hubo un problema al guardar la red social';
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

function actualizarRed(token,nombre,link,icono_red_social,table,idRed){
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




document.addEventListener('DOMContentLoaded', function() {
    // Función para abrir el modal para editar un ítem existente
    window.openEditModal = function(id) {
        fetch('/redes-sociales/' + id + '/edit')
            .then(response => response.json())
            .then(data => {
               document.getElementById('myModalLabel17').textContent = 'Editar Ítem';
                //document.getElementById('modalButton').id = 'editButton';
                document.getElementById('saveSocialMedia').textContent = 'Actualizar';
                // Llena el formulario con los datos existentes
                document.getElementById('nombre').value = data.data.name;
                document.getElementById('link').value = data.data.url;
                document.getElementById('icono_red_social').value = data.data.icono;
                document.getElementById('id_nav').value = data.data.id;
                // Si hay otros campos, también debes llenarlos
                var navModal = new bootstrap.Modal(document.getElementById('redes_sociales_modal'));
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
                fetch(deleteSocialMedia + '/' + id, {
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


function resetModal(){
    $('#redes_form')[0].reset();
}
