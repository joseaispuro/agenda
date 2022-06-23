
// Click en el calendario

var inputFecha = document.querySelector('.fecha input');

document.querySelector('.fecha .click-area').addEventListener('click', () => {
    inputFecha.showPicker();
});

document.querySelectorAll('.fecha .arrow').forEach(arrow => arrow.addEventListener('click', (e) => {
    var diff = e.target.classList.contains('next') ? +1 : -1,
        fecha = inputFecha.valueAsDate || new Date();

    fecha.setDate(fecha.getDate() + diff);
    inputFecha.valueAsDate = fecha;
    onDateSelect(fecha);
}));

inputFecha.addEventListener('input', () => {
    onDateSelect(inputFecha.valueAsDate);
});

function onDateSelect(fecha) {
    console.log("Fecha Seleccionada:", fecha);
}
