export function swalSuccess(title = "Success!", text = "Operation completed successfully!") {
    const Swal = window.Swal;
    return Swal.fire({
        title,
        text,
        icon: "success",
        buttonsStyling: false,
        showCloseButton: true,
        customClass: {
            confirmButton: "btn btn-primary w-xs mt-2"
        }
    });
}

export function swalError(title = "Oops...", text = "Something went wrong!") {
    const Swal = window.Swal;
    return Swal.fire({
        title,
        text,
        icon: "error",
        buttonsStyling: false,
        showCloseButton: true,
        customClass: {
            confirmButton: "btn btn-danger w-xs mt-2"
        }
    });
}

export function swalConfirm(
    title = "Are you sure?",
    text = "This action cannot be undone.",
    onConfirm = () => {
    },
    confirmButtonText = "Yes, confirm!"
) {
    const Swal = window.Swal;
    return Swal.fire({
        title,
        text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText,
        cancelButtonText: "Cancel",
        buttonsStyling: false,
        showCloseButton: true,
        customClass: {
            confirmButton: "btn btn-primary w-xs me-2 mt-2",
            cancelButton: "btn btn-danger w-xs mt-2"
        }
    }).then((result) => {
        if (result.isConfirmed) {
            onConfirm();
        }
    });
}

export function swalAutoClose(title = "Processing...", timeout = 2000) {
    const Swal = window.Swal;
    let timerInterval;
    return Swal.fire({
        title,
        html: "This will close automatically in <b></b> ms.",
        timer: timeout,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            const b = Swal.getHtmlContainer().querySelector("b");
            timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft();
            }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        },
    });
}

export function showSuspendedConfirm(
    livewireComponent,
    id,
    title = 'Are you sure?',
    text = 'You are about to suspend this item.'
) {
    swalConfirm(
        title,
        text,
        () => {
            livewireComponent.call('suspend', id);
        },
        'Yes, suspend it!'
    );
}

export function showApprovedConfirm(
    livewireComponent,
    id,
    title = 'Are you sure?',
    text = 'This action will approve and publish this item.'
) {
    swalConfirm(
        title,
        text,
        () => {
            livewireComponent.call('approve', id);
        },
        'Yes, approve it!'
    );
}

export function showRejectedConfirm(
    livewireComponent,
    id,
    title = 'Are you sure?',
    text = 'This action will reject this submission.'
) {
    swalConfirm(
        title,
        text,
        () => {
            livewireComponent.call('reject', id);
        },
        'Yes, reject it!'
    );
}

export function showRestoredConfirm(
    livewireComponent,
    id,
    title = 'Are you sure?',
    text = 'You are about to re-activate this item.'
) {
    swalConfirm(
        title,
        text,
        () => {
            livewireComponent.call('restore', id);
        },
        'Yes, re-activate it!'
    );
}
