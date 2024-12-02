
document.getElementById('registerForm').onsubmit = function(e) {
    e.preventDefault(); // Evitar envío por defecto

    const nombre = document.getElementById('nombre').value;
    const apellido = document.getElementById('apellido').value;
    const dni = document.getElementById('dni').value;
    const cargo = document.getElementById('cargo').value;
    const fecha = new Date().toLocaleDateString(); // Fecha actual
    const estado = "Alta";

    const tableBody = document.getElementById('userTableBody');
    const newRow = tableBody.insertRow();
    newRow.innerHTML = `<td>${tableBody.rows.length + 1}</td>
                        <td>${nombre}</td>
                        <td>${apellido}</td>
                        <td>${dni}</td>
                        <td>${cargo}</td>
                        <td>${fecha}</td>
                        <td class="estado-cell">
                            <span class="estado-text">Alta</span>
                            <select class="form-control estado-select" onchange="cambiarEstado(this)" style="display:none;">
                                <option value="Alta">Alta</option>
                                <option value="Baja">Baja</option>
                            </select>
                        </td>
                        <td>
                            <button class='btn btn-editar' onclick="habilitarEdicion(this)">Editar</button>
                            <button class='btn btn-permiso' data-toggle="modal" data-target="#permisoModal">Permiso</button>
                        </td>`;

    $('#registerModal').modal('hide');
    this.reset(); // Limpiar formulario
}

function cambiarEstado(select) {
    const cell = select.closest('td');
    cell.querySelector('.estado-text').innerText = select.value;
    select.style.display = 'none';
    cell.querySelector('.estado-text').style.display = 'inline';
}

function habilitarEdicion(button) {
    const row = button.closest('tr');
    const estadoCell = row.querySelector('.estado-cell');
    const estadoSelect = estadoCell.querySelector('.estado-select');
    const estadoText = estadoCell.querySelector('.estado-text');

    estadoText.style.display = 'none';
    estadoSelect.style.display = 'inline';
    estadoSelect.value = estadoText.innerText;

    // Desactivar otros botones si es necesario
    button.innerText = 'Guardar';
    button.setAttribute('onclick', 'guardarEdicion(this)');
}

function guardarEdicion(button) {
    const row = button.closest('tr');
    const estadoCell = row.querySelector('.estado-cell');
    const estadoSelect = estadoCell.querySelector('.estado-select');
    const estadoText = estadoCell.querySelector('.estado-text');

    estadoText.innerText = estadoSelect.value;
    estadoText.style.display = 'inline';
    estadoSelect.style.display = 'none';

    // Restaurar el botón a su estado original
    button.innerText = 'Editar';
    button.setAttribute('onclick', 'habilitarEdicion(this)');
}

// Expande y comprime las opciones de Fichas
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('fichas-toggle')) {
        const options = e.target.nextElementSibling;
        options.style.display = options.style.display === 'none' ? 'block' : 'none';
    }
});
