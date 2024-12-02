// Obtener referencias a los elementos del formulario
const fechaInput = document.getElementById('fecha');
const estadoInput = document.getElementById('estado');
const tipoEquipoInput = document.getElementById('tipo-equipo');
const fabricanteInput = document.getElementById('fabricante');
const modeloInput = document.getElementById('modelo');
const serieInput = document.getElementById('serie');
const ipInput = document.getElementById('ip');
const colorInput = document.getElementById('color');

// Obtener referencia a la tabla
const tablaActivos = document.getElementById('tabla-activos').getElementsByTagName('tbody')[0];

// Variable para saber si estamos editando un activo existente
let currentRow = null;

// Función para agregar o actualizar un activo en la tabla
function addActivo() {
    // Obtener los valores del formulario
    const fecha = fechaInput.value;
    const estado = estadoInput.value;
    const tipoEquipo = tipoEquipoInput.value;
    const fabricante = fabricanteInput.value;
    const modelo = modeloInput.value;
    const serie = serieInput.value;
    const ip = ipInput.value;
    const color = colorInput.value;

    // Validar que todos los campos estén completos
    if (!fecha || !estado || !tipoEquipo || !fabricante || !modelo || !serie || !ip || !color) {
        alert('Por favor, completa todos los campos antes de agregar el activo.');
        return;
    }

    // Si estamos editando una fila existente
    if (currentRow) {
        currentRow.cells[0].innerText = fecha;
        currentRow.cells[1].innerText = estado;
        currentRow.cells[2].innerText = tipoEquipo;
        currentRow.cells[3].innerText = fabricante;
        currentRow.cells[4].innerText = modelo;
        currentRow.cells[5].innerText = serie;
        currentRow.cells[6].innerText = ip;
        currentRow.cells[7].innerText = color;
        currentRow = null; // Reiniciar la fila actual
    } else {
        // Crear una nueva fila en la tabla
        const newRow = tablaActivos.insertRow();

        // Insertar las celdas en la nueva fila
        newRow.insertCell(0).innerText = fecha;
        newRow.insertCell(1).innerText = estado;
        newRow.insertCell(2).innerText = tipoEquipo;
        newRow.insertCell(3).innerText = fabricante;
        newRow.insertCell(4).innerText = modelo;
        newRow.insertCell(5).innerText = serie;
        newRow.insertCell(6).innerText = ip;
        newRow.insertCell(7).innerText = color;

        // Agregar evento al hacer clic en una fila para editarla
        newRow.onclick = function() {
            editActivo(newRow);
        };
    }

    // Limpiar el formulario
    resetForm();
}

// Función para editar un activo al hacer clic en una fila de la tabla
function editActivo(row) {
    currentRow = row; // Guardar la fila actual

    // Rellenar el formulario con los datos de la fila seleccionada
    fechaInput.value = row.cells[0].innerText;
    estadoInput.value = row.cells[1].innerText;
    tipoEquipoInput.value = row.cells[2].innerText;
    fabricanteInput.value = row.cells[3].innerText;
    modeloInput.value = row.cells[4].innerText;
    serieInput.value = row.cells[5].innerText;
    ipInput.value = row.cells[6].innerText;
    colorInput.value = row.cells[7].innerText;
}

// Función para resetear el formulario
function resetForm() {
    fechaInput.value = '';
    estadoInput.value = 'Operativo';
    tipoEquipoInput.value = 'Laptop';
    fabricanteInput.value = '';
    modeloInput.value = '';
    serieInput.value = '';
    ipInput.value = '';
    colorInput.value = '';
}
