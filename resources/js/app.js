require('./bootstrap');
Livewire.on('open-modal', (componentName, params) => {
    // This will open the modal with the passed arguments
    window.livewireUiModal.open(componentName, params);
});