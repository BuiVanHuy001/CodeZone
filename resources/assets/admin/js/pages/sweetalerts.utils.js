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

export function showConfirmAction(livewireComponent, id, method, options = {}) {
    const {
        title = 'Are you sure?',
        text = 'This action cannot be undone.',
        confirmButtonText = 'Yes, confirm it!'
    } = options;

    swalConfirm(
        title,
        text,
        () => {
            // Gọi dynamic method name
            livewireComponent.call(method, id);
        },
        confirmButtonText
    );
}
