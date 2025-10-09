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

    $('#saveCategoria').on('click', function() {
        var titulo = $('#titulo').val();
        var token = document.querySelector('input[name="_token"]').value;
        var idAbout = $('#id_categoria').val();
        if (idAbout == 0){
            guardarAboutItem(token,titulo,table);
        }else{
            actualizarAboutItem(token,titulo,idAbout,table);

        }
    });
});

function guardarAboutItem(token,nombre_menu,table) {
    $.ajax({
        url: saveCategoria, // Asegúrate de que la URL es correcta
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
            $('#categoriaForm')[0].reset();

            // Cerrar el modal
            $('#categoria_modal').modal('hide');
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
        url: updateCategoria, // Asegúrate de que la URL es correcta
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
            $('#categoriaForm')[0].reset();

            // Cerrar el modal
            $('#categoria_modal').modal('hide');
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
        fetch('/categoria/' + id + '/edit')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('myModalLabel17').textContent = 'Editar Ítem';
                //document.getElementById('modalButton').id = 'editButton';
                document.getElementById('saveCategoria').textContent = 'Actualizar';
                document.getElementById('titulo').value = data.data.titulo;

                document.getElementById('id_categoria').value = data.data.id;

                // Si hay otros campos, también debes llenarlos
                var navModal = new bootstrap.Modal(document.getElementById('categoria_modal'));
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
                fetch(deleteCategoria + '/' + id, {
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
    document.getElementById('saveCategoria').textContent = 'Guardar';
    document.getElementById('id_categoria').value = 0;
    $('#categoriaForm')[0].reset();
}
