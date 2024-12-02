document.addEventListener('DOMContentLoaded', function () {
    // Si ya se cargan las fechas, muestra un mensaje de filtro aplicado
    const fechaInicio = document.querySelector('[name="fecha_inicio"]').value;
    const fechaFin = document.querySelector('[name="fecha_fin"]').value;

});

// Resto de la lógica de JavaScript para mostrar/ocultar columnas y descargar el reporte
document.querySelectorAll('.column-management input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const column = this.value;
        const isChecked = this.checked;
        const columnIndex = Array.from(document.querySelectorAll(`#reporteTable th`)).findIndex(th => th.getAttribute('data-column') === column) + 1;
        const header = document.querySelector(`th[data-column="${column}"]`);
        const cells = document.querySelectorAll(`td:nth-child(${columnIndex})`);

        header.style.display = isChecked ? '' : 'none';
        cells.forEach(cell => {
            cell.style.display = isChecked ? '' : 'none';
        });
    });
});


// Descargar el reporte con las columnas visibles en formato Excel
function descargarReporte() {
    const selectedColumns = [];
    const headers = [];
    const data = [];

    // Obtener las columnas seleccionadas para mostrar
    document.querySelectorAll('.column-management input[type="checkbox"]:checked').forEach(checkbox => {
        const column = checkbox.value;
        const header = document.querySelector(`th[data-column="${column}"]`);
        const columnIndex = Array.from(document.querySelectorAll(`#reporteTable th`)).findIndex(th => th.getAttribute('data-column') === column);
        selectedColumns.push(columnIndex);
        headers.push(header.innerText);
    });

    // Verificar si hay columnas seleccionadas
    if (headers.length === 0) {
        alert("Por favor, selecciona al menos una columna.");
        return;
    }

    // Obtener los datos de la tabla, respetando las columnas seleccionadas
    const rows = document.querySelectorAll('#reporteTable tbody tr');
    rows.forEach(row => {
        const rowData = [];
        selectedColumns.forEach(index => {
            rowData.push(row.cells[index].innerText);  // Recoge los datos de la fila según las columnas seleccionadas
        });

        // Obtener los activos (información adicional)
        const activos = row.querySelectorAll('td[data-activos]');  // Asumimos que los activos están en una columna con 'data-activos'
        let activosData = [];
        activos.forEach(activo => {
            activosData.push(activo.innerText);  // Aquí recogemos los datos de activos asociados a la ficha
        });

        rowData.push(activosData.join(', '));  // Añadir los activos a la fila

        data.push(rowData);  // Agregar la fila a los datos

    });

    // Verificar si se obtuvieron datos
    if (data.length === 0) {
        alert("No hay datos para exportar.");
        return;
    }

    // Crear la hoja de trabajo con los datos
    const worksheet = XLSX.utils.aoa_to_sheet([headers, ...data]);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Reporte");

    // Definir el tamaño de las columnas en el Excel
    const wscols = headers.map(_ => ({ wpx: 120 }));
    worksheet['!cols'] = wscols;

    // Descargar archivo Excel
    XLSX.writeFile(workbook, 'reporte.xlsx');
}
