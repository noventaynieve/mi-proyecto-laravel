const isFormControl = (element) => (
    element instanceof HTMLInputElement
    || element instanceof HTMLSelectElement
    || element instanceof HTMLTextAreaElement
);

const validateFile = (control) => {
    if (!(control instanceof HTMLInputElement) || control.type !== 'file') {
        return;
    }

    control.setCustomValidity('');

    const file = control.files?.[0];

    if (!file) {
        return;
    }

    const maximumSize = Number(control.dataset.maxSize);

    if (maximumSize > 0 && file.size > maximumSize) {
        control.setCustomValidity('El archivo excede el tamaño máximo permitido.');
        return;
    }

    const acceptedTypes = control.accept
        .split(',')
        .map((type) => type.trim().toLowerCase())
        .filter(Boolean);
    const fileName = file.name.toLowerCase();
    const isAccepted = acceptedTypes.length === 0 || acceptedTypes.some((type) => {
        if (type.startsWith('.')) {
            return fileName.endsWith(type);
        }

        if (type.endsWith('/*')) {
            return file.type.toLowerCase().startsWith(type.slice(0, -1));
        }

        return file.type.toLowerCase() === type;
    });

    if (!isAccepted) {
        control.setCustomValidity('Selecciona un archivo del tipo indicado.');
    }
};

document.querySelectorAll('form').forEach((form) => {
    const controls = Array.from(form.querySelectorAll('input, select, textarea'))
        .filter((control) => !control.disabled);

    const updateValidationState = (control) => {
        validateFile(control);

        if (control.validity.valid) {
            control.removeAttribute('aria-invalid');
            return;
        }

        control.setAttribute('aria-invalid', 'true');
    };

    form.addEventListener('invalid', (event) => {
        if (isFormControl(event.target)) {
            updateValidationState(event.target);
        }
    }, true);

    controls.forEach((control) => {
        control.addEventListener('input', () => updateValidationState(control));
        control.addEventListener('change', () => updateValidationState(control));
    });

    if (form.hasAttribute('data-client-validation-only')) {
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            const status = form.querySelector('[data-validation-status]');

            if (status instanceof HTMLElement) {
                status.hidden = false;
                status.textContent = 'La validación terminó, pero la solicitud no se envió ni guardó porque la recepción en línea todavía no está habilitada.';
            }
        });

        const submitButton = form.querySelector('[data-validation-submit]');

        if (submitButton instanceof HTMLButtonElement) {
            submitButton.disabled = false;
        }
    }

    form.addEventListener('reset', () => {
        controls.forEach((control) => {
            control.removeAttribute('aria-invalid');

            if (control instanceof HTMLInputElement && control.type === 'file') {
                control.setCustomValidity('');
            }
        });

        const status = form.querySelector('[data-validation-status]');

        if (status instanceof HTMLElement) {
            status.hidden = true;
            status.textContent = '';
        }
    });
});
