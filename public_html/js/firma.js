// firma.js
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('canvas-firma');
    const signaturePad = new SignaturePad(canvas);

    document.getElementById('btn-guardar-firma').addEventListener('click', function() {
        if (signaturePad.isEmpty()) {
            alert('Por favor, firme antes de guardar.');
            return;
        }
        const firmaBase64 = signaturePad.toDataURL('image/png');
        const urlParams = new URLSearchParams(window.location.search);
        const id_presupuesto = urlParams.get('id');

        fetch('/index.php?url=cliente/guardarFirmaPresupuesto', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({presupuesto_id: id_presupuesto, firma: firmaBase64})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Firma guardada correctamente.');
                window.location.href = '/index.php?url=cliente/dashboard';
            } else {
                alert('Error al guardar la firma.');
            }
        });
    });

    document.getElementById('btn-limpiar-firma').addEventListener('click', function() {
        signaturePad.clear();
    });
});
