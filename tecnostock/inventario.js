// Validación inmediata. PHP repite todos los controles antes de guardar.
document.querySelectorAll('form[data-validar]').forEach(form => {
    const error = form.querySelector('.error-cliente');
    function revisar() {
        let mensaje = '';
        if (form.dataset.validar === 'producto') {
            if (!form.elements.codigo.value.trim() || !form.elements.nombre.value.trim()) mensaje = 'El código y el nombre son obligatorios.';
            else if (!/^\d{1,8}(\.\d{1,2})?$/.test(form.elements.precio.value)) mensaje = 'Ingresa un precio válido, con hasta dos decimales.';
        } else {
            const opcion = form.elements.id_producto.selectedOptions[0];
            const stock = Number(opcion?.dataset.stock);
            const cantidad = Number(form.elements.cantidad.value);
            const nuevo = stock + (form.elements.tipo.value === 'salida' ? -cantidad : cantidad);
            const previa = form.querySelector('#stock-previsto');
            previa.textContent = Number.isFinite(stock) && form.elements.cantidad.value ? `Stock estimado después del movimiento: ${nuevo}` : '';
            if (form.elements.tipo.value === 'salida' && cantidad > stock) mensaje = 'Stock insuficiente para realizar esta salida.';
            else if (nuevo > 2147483647) mensaje = 'La entrada supera el máximo permitido.';
        }
        error.textContent = mensaje;
        error.hidden = mensaje === '';
        return mensaje === '';
    }
    form.addEventListener('input', revisar);
    form.addEventListener('change', revisar);
    form.addEventListener('submit', e => { if (!revisar()) e.preventDefault(); });
});
