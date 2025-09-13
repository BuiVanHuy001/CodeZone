document.addEventListener("livewire:init", () => {
    Livewire.on("close-modal", ({id}) => {
        let modalEl = document.getElementById(id);
        if (modalEl) {
            let modal =
                bootstrap.Modal.getInstance(modalEl) ||
                new bootstrap.Modal(modalEl);
            modal.hide();
        }
    });
    Livewire.on("open-modal", ({id}) => {
        const modal = new bootstrap.Modal(document.getElementById(id));
        modal.show();
    });
});
