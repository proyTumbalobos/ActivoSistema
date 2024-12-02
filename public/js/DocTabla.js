let currentRowData = [];

        // Abrir el modal con los datos de la fila seleccionada
        function openModal(rowData) {
            currentRowData = rowData; // Guardar los datos de la fila
            document.getElementById('modal-content').innerText = `Código: ${rowData[0]}, Tipo Ficha: ${rowData[1]}, Fecha: ${rowData[2]}, Personal: ${rowData[3]}, Equipo: ${rowData[4]}, Área: ${rowData[5]}, Sede: ${rowData[6]}`;
            document.getElementById('modal').style.display = 'block';
        }

        // Cerrar el modal
        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        // Cerrar el modal al hacer clic fuera del contenido
        window.onclick = function(event) {
            const modal = document.getElementById('modal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Descargar la fila seleccionada como PDF
        function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.text(`Código: ${currentRowData[0]}`, 10, 10);
            doc.text(`Tipo Ficha: ${currentRowData[1]}`, 10, 20);
            doc.text(`Fecha: ${currentRowData[2]}`, 10, 30);
            doc.text(`Personal: ${currentRowData[3]}`, 10, 40);
            doc.text(`Equipo: ${currentRowData[4]}`, 10, 50);
            doc.text(`Área: ${currentRowData[5]}`, 10, 60);
            doc.text(`Sede: ${currentRowData[6]}`, 10, 70);
            doc.save('detalle_solicitud.pdf');
        }