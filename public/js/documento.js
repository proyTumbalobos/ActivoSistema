// Obtener referencias de las casillas
const fechaInput = document.getElementById('fecha');
const estadoInput = document.getElementById('estado');
const usuarioInput = document.getElementById('usuario');
const codigoInput = document.getElementById('codigo');
const detalleInput = document.getElementById('detalle');

// Referencias de los spans del documento
const docFecha = document.getElementById('doc-fecha');
const docEstado = document.getElementById('doc-estado');
const docUsuario = document.getElementById('doc-usuario');
const docCodigo = document.getElementById('doc-codigo');
const docDetalle = document.getElementById('doc-detalle');

// Actualizar la fecha actual automáticamente
const today = new Date().toISOString().split('T')[0];
fechaInput.value = today;
docFecha.textContent = today;

// Actualizar el documento en tiempo real
fechaInput.addEventListener('input', function() {
    docFecha.textContent = fechaInput.value || '[Fecha]';
});

estadoInput.addEventListener('input', function() {
    docEstado.textContent = estadoInput.value || '[Estado]';
});

usuarioInput.addEventListener('input', function() {
    docUsuario.textContent = usuarioInput.value || '[Usuario]';
});

codigoInput.addEventListener('input', function() {
    docCodigo.textContent = codigoInput.value || '[Código Inventario]';
});

detalleInput.addEventListener('input', function() {
    docDetalle.textContent = detalleInput.value || '[Detalle]';
});

// Función para descargar el documento en formato Word
function downloadWordDocument() {
    const documentText = document.getElementById('document-text').innerHTML;

    const preHtml = `
    <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
    <head><meta charset='utf-8'></head><body>`;
    const postHtml = "</body></html>";
    const html = preHtml + documentText + postHtml;

    const blob = new Blob(['\ufeff', html], { type: 'application/msword' });

    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'documento_autocompletado.doc';

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Función para resetear el formulario y el documento
function resetForm() {
    fechaInput.value = today;
    estadoInput.value = 'Operativo';
    usuarioInput.value = '';
    codigoInput.value = '';
    detalleInput.value = '';

    docFecha.textContent = today;
    docEstado.textContent = '[Estado]';
    docUsuario.textContent = '[Usuario]';
    docCodigo.textContent = '[Código Inventario]';
    docDetalle.textContent = '[Detalle]';
}
