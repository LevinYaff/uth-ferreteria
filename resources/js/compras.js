function toggleRechazarModal(compraId) {
    const modal = document.getElementById(`rechazar-modal-${compraId}`);
    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
    } else {
        modal.classList.add('hidden');
    }
}
