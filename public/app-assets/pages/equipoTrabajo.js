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
            { data: 'nombre', name: 'nombre' },
            { data: 'cargo', name: 'cargo' },
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

    document.getElementById('equipoForm').addEventListener('submit', function(e) {
        e.preventDefault();

        var form = document.getElementById('equipoForm');
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
                        text: 'Agregado Correctamente',
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

*/

// actualizar
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

    var saveButton = document.getElementById('saveItemEquipo');
    var updateButton = document.getElementById('updateItemEquipo');

    function handleSubmit(event, url) {
        event.preventDefault();

        var form = document.getElementById('equipoForm');
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
                    $('#equipoForm')[0].reset();

                    // Cerrar el general_modal
                    $('#equipo_trabajo_modal').modal('hide');
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
        handleSubmit(e, saveFormulario);
    });

    updateButton.addEventListener('click', function(e) {
        handleSubmit(e, updateFormularioItem);
    });
});


document.addEventListener('DOMContentLoaded', function() {
    // Función para abrir el modal para editar un ítem existente
    window.openEditModal = function(id) {
        fetch('/equipoTrabajo/' + id + '/edit')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('myModalLabel17').textContent = 'Editar Ítem';
                //document.getElementById('modalButton').id = 'editButton';


                document.getElementById('updateItemEquipo').removeAttribute('hidden');
                document.getElementById('saveItemEquipo').setAttribute('hidden', 'true');

                document.getElementById('nombre').value = data.nombre;
                document.getElementById('cargo').value = data.cargo;
                document.getElementById('descripcion').value = data.descripcion;
                document.getElementById('preview_imagen').src = data.imagen;
                document.getElementById('facebook').value = data.facebook;
                document.getElementById('twitter').value = data.twitter;
                document.getElementById('instagram').value = data.instagram;
                document.getElementById('linkedin').value = data.linkedin;
                document.getElementById('youtube').value = data.youtube;

                document.getElementById('id_item_equipo').value = data.id;

                // Si hay otros campos, también debes llenarlos
                var navModal = new bootstrap.Modal(document.getElementById('equipo_trabajo_modal'));
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

document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('updateEquipoTrabajoForm').addEventListener('submit', function(e) {
        e.preventDefault();

        var form = document.getElementById('updateEquipoTrabajoForm');
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


function resetModal() {
    console.log('Reset');
    document.getElementById('saveItemEquipo').removeAttribute('hidden');
    document.getElementById('updateItemEquipo').setAttribute('hidden', 'true');
    document.getElementById('myModalLabel17').textContent = 'Agregar Ítem';
    document.getElementById('preview_imagen').src = '';
    document.getElementById('saveItemEquipo').textContent = 'Guardar';
    document.getElementById('id_item_equipo').value = 0;
    $('#equipoForm')[0].reset();
}
