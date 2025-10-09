let snowEditor;

$(function () {
    'use strict';
    var Font = Quill.import('formats/font');
    Font.whitelist = ['sofia', 'slabo', 'roboto', 'inconsolata', 'ubuntu'];
    Quill.register(Font, true);

// secccion del editor de texto
    snowEditor = new Quill('#snow-container .editor', {
        bounds: '#snow-container .editor',
        modules: {
            formula: true, // Para soporte de fórmulas matemáticas
            syntax: true,  // Para resaltado de sintaxis
            toolbar: '#snow-container .quill-toolbar' // La barra de herramientas personalizada
        },
        theme: 'snow'  // Tema Snow
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

// Copiar el contenido del editor Quill al campo oculto del formulario al enviar
// Copiar el contenido de Quill al campo oculto antes de enviar el formulario
function prepararContenidoQuill() {
    var contenido = snowEditor.root.innerHTML;  // Obtener el contenido del editor Quill
    console.log("Contenido de Quill:", contenido);  // Depuración: Mostrar el contenido en la consola
    document.getElementById('detalle_completo').value = contenido;  // Asignarlo al campo oculto

    // Verificar si el campo oculto tiene el valor correcto
    console.log("Valor en campo oculto:", document.getElementById('detalle_completo').value);

    return true;  // Permitir que el formulario se envíe
}
