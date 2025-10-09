Dropzone.autoDiscover = false;
let snowEditor;
let basicRatings;


$(function () {
    'use strict';

    var bsStepper = document.querySelectorAll('.bs-stepper'),
        select = $('.select2'),
        modernVerticalWizard = document.querySelector('.modern-vertical-wizard-example');

    var isRtl = $('html').attr('data-textdirection') === 'rtl';
        basicRatings = $('.basic-ratings');
    if (basicRatings.length) {
        basicRatings.rateYo({
            rating: 3.6,
            rtl: isRtl
        });
    }



    var Font = Quill.import('formats/font');
    Font.whitelist = ['sofia', 'slabo', 'roboto', 'inconsolata', 'ubuntu'];
    Quill.register(Font, true);

    // Bubble Editor
    // Snow Editor

     snowEditor = new Quill('#snow-container .editor', {
        bounds: '#snow-container .editor',
        modules: {
            formula: true,
            syntax: true,
            toolbar: '#snow-container .quill-toolbar'
        },
        theme: 'snow'
    });

    var removeAllThumbs = $('#dpz-remove-all-thumb');

// Remove All Thumbnails
    removeAllThumbs.dropzone({
        url: '#', // La URL a la que se enviarán los archivos
        paramName: 'file', // El nombre que se usará para transferir el archivo
        maxFilesize: 50, // Tamaño máximo de archivo (MB) - límite general de 50MB para video
        acceptedFiles: 'image/*', // Solo aceptar imágenes y videos
        autoProcessQueue: false, // Deshabilitar la carga automática
        maxFiles: 1, // Limitar a 2 archivos en total (1 imagen, 1 video)
        init: function () {
            var _this = this;
            var imageUploaded = false;
            var videoUploaded = false;

            // Limitar diferentes tipos de archivos a diferentes tamaños
            this.on("addedfile", function (file) {
                $('.dz-message').hide();

                var maxImageSize = 10; // 10 MB para imágenes
                var maxVideoSize = 50; // 50 MB para videos

                if (file.type.startsWith("image/")) {
                    if (imageUploaded) {
                        _this.removeFile(file); // Eliminar el archivo si ya hay una imagen
                        alert('Solo puedes subir una imagen.');
                        return;
                    }
                    if (file.size > maxImageSize * 1024 * 1024) {
                        _this.removeFile(file); // Eliminar el archivo si excede el tamaño
                        alert('El archivo de imagen es demasiado grande. El tamaño máximo es de ' + maxImageSize + ' MB.');
                        return;
                    }
                    imageUploaded = true; // Marcar que se ha subido una imagen
                } else if (file.type.startsWith("video/")) {
                    if (videoUploaded) {
                        _this.removeFile(file); // Eliminar el archivo si ya hay un video
                        alert('Solo puedes subir un video.');
                        return;
                    }
                    if (file.size > maxVideoSize * 1024 * 1024) {
                        _this.removeFile(file); // Eliminar el archivo si excede el tamaño
                        alert('El archivo de video es demasiado grande. El tamaño máximo es de ' + maxVideoSize + ' MB.');
                        return;
                    }
                    videoUploaded = true; // Marcar que se ha subido un video
                }

                // Deshabilitar la posibilidad de agregar más archivos si ya hay 1 imagen y 1 video
                if (imageUploaded && videoUploaded) {
                    _this.options.maxFiles = 2;
                }
            });

            // Cuando se elimina un archivo, reactivar la capacidad de agregar nuevos si es necesario
            this.on("removedfile", function (file) {
                if (file.type.startsWith("image/")) {
                    imageUploaded = false; // Permitir subir otra imagen
                } else if (file.type.startsWith("video/")) {
                    videoUploaded = false; // Permitir subir otro video
                }

                // Volver a habilitar la opción de subir archivos si se ha eliminado uno
                _this.options.maxFiles = 2;

                if (_this.files.length === 0) {
                    $('.dz-message').show();
                }
            });

            // Evento para evitar el tooltip que muestra "object Object"
            this.on("mouseover", function (file) {
                // Evitar que el tooltip de estado predeterminado se muestre si hay errores
                if (!file.name) {
                    file.title = ''; // Quitar cualquier título que intente mostrar "[object Object]"
                }
            });

            // Configuración del botón para eliminar todos los archivos
            $('#clear-dropzone').on('click', function () {
                _this.removeAllFiles();
            });

        },
        dictFileTooBig: "El archivo es demasiado grande ({{filesize}} MB). Tamaño máximo permitido: {{maxFilesize}} MB.", // Mensaje de error personalizado
    });

    // Full Editor
    // Adds crossed class
    if (typeof bsStepper !== undefined && bsStepper !== null) {
        for (var el = 0; el < bsStepper.length; ++el) {
            bsStepper[el].addEventListener('show.bs-stepper', function (event) {
                var index = event.detail.indexStep;
                var numberOfSteps = $(event.target).find('.step').length - 1;
                var line = $(event.target).find('.step');

                for (var i = 0; i < index; i++) {
                    line[i].classList.add('crossed');

                    for (var j = index; j < numberOfSteps; j++) {
                        line[j].classList.remove('crossed');
                    }
                }
                if (event.detail.to == 0) {
                    for (var k = index; k < numberOfSteps; k++) {
                        line[k].classList.remove('crossed');
                    }
                    line[0].classList.remove('crossed');
                }
            });
        }
    }
    select.each(function () {
        var $this = $(this);

        // Envolver solo si no está ya envuelto
        if (!$this.parent().hasClass('position-relative')) {
            $this.wrap('<div class="position-relative"></div>');
        }

        // Inicialización de Select2
        $this.select2({
            placeholder: $this.attr('placeholder') || 'Select value', // Placeholder dinámico
            dropdownParent: $this.parent() // Asegura que el dropdown se anida correctamente
        });
    });


    if (typeof modernVerticalWizard !== undefined && modernVerticalWizard !== null) {
        var modernVerticalStepper = new Stepper(modernVerticalWizard, {
            linear: false
        });
        $(modernVerticalWizard)
            .find('.btn-next')
            .on('click', function () {
                modernVerticalStepper.next();
            });
        $(modernVerticalWizard)
            .find('.btn-prev')
            .on('click', function () {
                modernVerticalStepper.previous();
            });

        $(modernVerticalWizard)
            .find('.btn-submit')
            .on('click', function () {
                guardarPublicidad();
            });
    }




});


function guardarPublicidad(){
    var editors = snowEditor.root.innerHTML;
    var calificacion = basicRatings.rateYo("rating");
    var titulo = $("#titulo").val();
    var subtitulo = $("#subtitulo_categoria").val();
    var resumen = $("#resumen_minimo").val();
    var precio = $("#precio_curso").val();
    var fecha = $("#fecha").val();
    var cantidad_duracion = $("#duracion").val();
    var categoria_id = $("#categoria_id").val();
    var unidad_duracion = $("#unidad_duracion").val();
    var modalidad = $("#modalidad").val();
    var link_moodle = $("#link_moodle").val();
    var moodle_id = $("#moodle_id").val();
    var dropzoneInstance = Dropzone.forElement('#dpz-remove-all-thumb');

    var formData = new FormData();
    var acceptedFiles = dropzoneInstance.getAcceptedFiles();
    if (acceptedFiles.length > 0) {
        acceptedFiles.forEach(function(file, index) {
            formData.append('files[]', file, file.name);
        });
    }
    formData.append('detalle_completo', editors);
    formData.append('calificacion', calificacion);
    formData.append('titulo', titulo);
    formData.append('subtitulo', subtitulo);
    formData.append('resumen', resumen);
    formData.append('precio', precio);
    formData.append('categoria_id', categoria_id);
    formData.append('fecha', fecha);
    formData.append('cantidad_duracion', cantidad_duracion);
    formData.append('unidad_duracion', unidad_duracion);
    formData.append('link_moodle', link_moodle);
    formData.append('moodle_id', moodle_id);
    formData.append('modalidad', modalidad);
    $.ajax({
        url: url,  // La URL a la que enviarás los datos
        type: 'POST',  // El tipo de solicitud
        data: formData,  // Los datos que vas a enviar (archivos y otros datos)
        contentType: false,  // Necesario para enviar archivos correctamente
        processData: false,  // No procesar los datos (porque estamos enviando FormData)
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),  // CSRF Token]
        },
        success: function(response) {
            // Manejo de éxito
            console.log('Éxito:', response);
            Swal.fire({
                title: "Publicidad guardada",
                text: "La publicidad se guardo correctamente",
                icon: "success",
                button: "Aceptar",
            }).then(function() {
                window.location.href = "/seccionCapacitaciones";

            });
        },
        error: function(xhr, status, error) {
            // Manejo de error
            console.error('Error al guardar la publicidad:', error);
            alert('Error al guardar la publicidad.');
        }
    });

}

/*
ENVIO DE LOS ARCHIVOS AL BACK
// Obtener la instancia de Dropzone desde el elemento
var dropzoneInstance = Dropzone.forElement('#dpz-remove-all-thumb');

// Evento para manejar el botón externo
$('#upload-files').on('click', function (e) {
    e.preventDefault(); // Prevenir comportamiento por defecto del botón si está en un formulario

    // Crear un objeto FormData para enviar datos por AJAX
    var formData = new FormData();

    // Obtener todos los archivos que están listos para ser procesados
    var acceptedFiles = dropzoneInstance.getAcceptedFiles();

    if (acceptedFiles.length > 0) {
        // Agregar los archivos al FormData
        acceptedFiles.forEach(function(file, index) {
            formData.append('files[]', file, file.name); // 'files[]' es el nombre del campo para los archivos
        });

        // Agregar otros datos al FormData (ejemplo)
        formData.append('nombre', $('#nombre').val());  // Asumiendo que tienes un input con ID 'nombre'
        formData.append('descripcion', $('#descripcion').val()); // Otro campo de ejemplo

        // Enviar la solicitud AJAX con los archivos y otros datos
        $.ajax({
            url: 'URL_DEL_SERVIDOR', // Reemplaza con la URL a la que enviarás los archivos
            type: 'POST',
            data: formData,
            contentType: false, // Necesario para enviar archivos
            processData: false, // No procesar los datos
            success: function(response) {
                // Manejo de la respuesta
                console.log('Éxito:', response);
                alert('Archivos subidos correctamente.');
            },
            error: function(xhr, status, error) {
                // Manejo de errores
                console.error('Error al subir archivos:', error);
                alert('Error al subir los archivos.');
            }
        });
    } else {
        alert('No hay archivos seleccionados para subir.');
    }
});

 */
