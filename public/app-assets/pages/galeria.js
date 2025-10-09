$(document).ready(function() {
    var table = $('.datatables-basic').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: datatableGaleria,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'titulo', name: 'titulo' },
            { data: 'detalle', name: 'detalle' },
            { data: 'imagen', name: 'imagen' },
            { data: 'categoria', name: 'categoria' },
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

//envio de formulario con imagenes
document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('updateGaleriaForm').addEventListener('submit', function(e) {
        e.preventDefault();

        var form = document.getElementById('updateGaleriaForm');
        var formData = new FormData(form);

        axios.post(updateGaleria, formData, {
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

    var saveButton = document.getElementById('saveItemGaleria');
    var updateButton = document.getElementById('updateItemGaleria');

    function handleSubmit(event, url) {
        event.preventDefault();

        var form = document.getElementById('storeGaleriaItemForm');
        var formData = new FormData(form);

        axios.post( url, formData, {
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
                    $('#storeGaleriaItemForm')[0].reset();

                    // Cerrar el general_modal
                    $('#galeria_modal').modal('hide');
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
        handleSubmit(e, saveItemGaleria);
    });

    updateButton.addEventListener('click', function(e) {
        handleSubmit(e, updateItemGaleria);
    });
});



document.addEventListener('DOMContentLoaded', function() {
    // Función para abrir el modal para editar un ítem existente
    window.openEditModal = function(id) {
        fetch('/galeria/' + id + '/edit')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('myModalLabel17').textContent = 'Editar Ítem';
                //document.getElementById('modalButton').id = 'editButton';


                document.getElementById('updateItemGaleria').removeAttribute('hidden');
                document.getElementById('saveItemGaleria').setAttribute('hidden', 'true');

                document.getElementById('titulo').value = data.data.titulo;
                document.getElementById('detalle').value = data.data.detalle;
                document.getElementById('preview_imagen').src = data.data.imagen;
                document.getElementById('id_categoria').value = data.data.landing_categoria_trabajo_id;

                document.getElementById('id_item_galeria').value = data.data.id;

                // Si hay otros campos, también debes llenarlos
                var navModal = new bootstrap.Modal(document.getElementById('galeria_modal'));
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
                fetch(deleteItemGaleria + '/' + id, {
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
    document.getElementById('saveItemGaleria').removeAttribute('hidden');
    document.getElementById('updateItemGaleria').setAttribute('hidden', 'true');
    document.getElementById('myModalLabel17').textContent = 'Agregar Ítem';
    document.getElementById('saveItemGaleria').textContent = 'Guardar';
    document.getElementById('id_item_galeria').value = 0;
    //$('#storeGaleriaItemForm')[0].reset();
}
