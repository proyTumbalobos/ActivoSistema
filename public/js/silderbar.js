document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleBtn');
    const sidebar = document.querySelector('.sidebar');
    const content = document.querySelector('.main-content');
    const controlActivoBtn = document.getElementById('controlActivoBtn');
    const submenu = document.getElementById('submenu');

    // Toggle para el sidebar
    toggleBtn.addEventListener('click', () => {
        // Alterna la clase 'active' en el sidebar
        sidebar.classList.toggle('active');
        
        // Alterna el margen izquierdo del contenido principal
        content.classList.toggle('expanded');

        // Si el sidebar se está comprimiendo, cierra el submenú de "Control de Activo"
        if (!sidebar.classList.contains('active')) {
            submenu.classList.remove('active');
        }
    });

    // Toggle para mostrar/ocultar el submenú de "Control de Activo"
    controlActivoBtn.addEventListener('click', () => {
        // Si el sidebar está comprimido, expándelo
        if (!sidebar.classList.contains('active')) {
            sidebar.classList.add('active');
            content.classList.add('expanded');
        }
        
        // Alterna la visibilidad del submenú
        submenu.classList.toggle('active');
    });
});
