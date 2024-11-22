/* Login */
function autocompletePort() {
    const dbType = document.getElementById('db_type').value;
    const portInput = document.getElementById('port');
    switch (dbType) {
        case 'MySQL':
        case 'MariaDB':
            portInput.value = '3306';
            break;
        case 'PostgreSQL':
            portInput.value = '5432';
            break;
        case 'MS-Access':
            portInput.value = '';
            break;
        default:
            portInput.value = '';
    }
}



document.addEventListener('DOMContentLoaded', function() {
    const message = "<?php echo htmlspecialchars($message); ?>";
    if (message) {
    const messageDiv = document.getElementById('message');
    if (message === 'eliminado') {
    messageDiv.textContent = 'Registro eliminado exitosamente.';
} else if (message === 'referenciado') {
    messageDiv.textContent = 'No se puede eliminar el registro porque está referenciado por otros registros.';
} else {
    messageDiv.textContent = 'Error al eliminar el registro.';
}
    messageDiv.style.display = 'block';
    setTimeout(() => {
    messageDiv.style.display = 'none';
}, 5000);
}
});
