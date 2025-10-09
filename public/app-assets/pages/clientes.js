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
});



document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('updateClientesForm').addEventListener('submit', function(e) {
        e.preventDefault();

        var form = document.getElementById('updateClientesForm');
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

    var saveButton = document.getElementById('saveItemCliente');
    var updateButton = document.getElementById('updateItemCliente');

    function handleSubmit(event, url) {
        event.preventDefault();

        var form = document.getElementById('clienteForm');
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
                    $('#clienteForm')[0].reset();

                    // Cerrar el general_modal
                    $('#cliente_modal').modal('hide');
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
        fetch('/clientes/' + id + '/edit')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('myModalLabel17').textContent = 'Editar Ítem';
                //document.getElementById('modalButton').id = 'editButton';


                document.getElementById('updateItemCliente').removeAttribute('hidden');
                document.getElementById('saveItemCliente').setAttribute('hidden', 'true');

                document.getElementById('titulo').value = data.titulo;
                document.getElementById('preview_imagen').src = data.imagen;
                document.getElementById('id_item_cliente').value = data.id;

                // Si hay otros campos, también debes llenarlos
                var navModal = new bootstrap.Modal(document.getElementById('cliente_modal'));
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

    document.getElementById('saveItemCliente').removeAttribute('hidden');
    document.getElementById('updateItemCliente').setAttribute('hidden', 'true');
    document.getElementById('myModalLabel17').textContent = 'Agregar Ítem';
    document.getElementById('preview_imagen').src = '';
    document.getElementById('id_item_cliente').value = 0;
    $('#testimonioForm')[0].reset();
}
