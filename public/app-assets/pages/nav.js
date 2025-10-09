$(function () {
    'use strict';

    // Mejora para la lista sortable
    dragula([document.getElementById('basic-list-group')], {
        mirrorContainer: document.body, // Mejorar el área de movimiento del elemento clonado
        moves: function (el, container, handle) {
            return true; // Esto asegura que se pueda arrastrar desde cualquier lugar del item
        }
    }).on('drag', function(el) {
        // Agregamos alguna lógica para que sea más visible que el elemento está siendo arrastrado
        el.classList.add('gu-transit');
    }).on('dragend', function(el) {
        // Al final de arrastrar, removemos cualquier clase de estilo extra
        el.classList.remove('gu-transit');
    });
});


$((function() {
        "use strict";
        dragula([document.getElementById("card-drag-area")]),
            dragula([document.getElementById("basic-list-group")]),
            dragula([document.getElementById("multiple-list-group-a"), document.getElementById("multiple-list-group-b")]),
            dragula([document.getElementById("badge-list-1"), document.getElementById("badge-list-2")], {
                copy: !0
            }),
            dragula([document.getElementById("handle-list-1"), document.getElementById("handle-list-2")], {
                moves: function(e, t, d) {
                    return d.classList.contains("handle")
                }
            })
    }
));


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
            { data: 'nombre_menu', name: 'nombre_menu' },
            { data: 'ruta', name: 'ruta' },
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

    $('#saveNav').on('click', function() {
        var nombre_menu = $('#nombre_menu').val();
        var ruta = $('#ruta').val();
        var icono = $('#icono').val();
        var token = document.querySelector('input[name="_token"]').value;
        var idNav = $('#id_nav').val();
        if (idNav == 0){
            guardarNav(token,nombre_menu,ruta,icono,table);
        }else{
            actualizarNav(token,nombre_menu,ruta,icono,idNav,table);

        }
    });
});

function guardarNav(token,nombre_menu,ruta,icono,table) {
    $.ajax({
        url: saveNav, // Asegúrate de que la URL es correcta
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        data: {
            nombre_menu: nombre_menu,
            ruta: ruta,
            icono: icono
        },
        success: function(response) {
            // Mostrar mensaje de éxito
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Menú Guardada Correctamente',
            });

            table.ajax.reload(null, false);

            // Limpiar el formulario del modal
            $('#navForm')[0].reset();

            // Cerrar el modal
            $('#nav_modal').modal('hide');
        },
        error: function(response) {
            var errorMessage = 'Hubo un problema al guardar el Menu ';
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

function actualizarNav(token,nombre_menu,ruta,icono,idNav,table){
    $.ajax({
        url: updateNav, // Asegúrate de que la URL es correcta
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        data: {
            nombre_menu: nombre_menu,
            ruta: ruta,
            icono: icono,
            id: idNav
        },
        success: function(response) {
            // Mostrar mensaje de éxito
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Menú Actualizado Correctamente',
            });

            table.ajax.reload(null, false);

            // Limpiar el formulario del modal
            $('#navForm')[0].reset();

            // Cerrar el modal
            $('#nav_modal').modal('hide');
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
        fetch('/nav/' + id + '/edit')
            .then(response => response.json())
            .then(data => {
                document.getElementById('myModalLabel17').textContent = 'Editar Ítem';
                //document.getElementById('modalButton').id = 'editButton';
                document.getElementById('saveNav').textContent = 'Actualizar';
                // Llena el formulario con los datos existentes
                document.getElementById('nombre_menu').value = data.nombre_menu;
                document.getElementById('ruta').value = data.ruta;
                document.getElementById('id_nav').value = data.id;
                // Si hay otros campos, también debes llenarlos
                var navModal = new bootstrap.Modal(document.getElementById('nav_modal'));
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
                fetch(deleteNav + '/' + id, {
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
    $('#navForm')[0].reset();
}


function enviarNuevoOrden(){
    var orderedItems = [];
    $('#basic-list-group .list-group-item').each(function(index) {
        var userId = $(this).data('id'); // Asegúrate de tener un ID o algún identificador para cada elemento
        orderedItems.push({
            id: userId,
            order: index + 1 // El nuevo orden empieza desde 1
        });
    });

    var token = document.querySelector('input[name="_token"]').value;
    // Enviar el nuevo orden al servidor
    $.ajax({
        url: ordenamientoNav, // URL de tu backend donde vas a procesar la actualización
        method: 'POST',
        data: {
            _token: token, // Si usas Laravel o un framework con tokens CSRF
            orderedItems: orderedItems
        },
        success: function(response) {
            console.log('Orden actualizado correctamente');
             Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Menú Actualizado Correctamente',
            });
        },
        error: function(error) {
            console.error('Error al actualizar el orden:', error);
        }
    });
}
