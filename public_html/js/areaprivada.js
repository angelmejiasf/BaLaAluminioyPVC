document.addEventListener('DOMContentLoaded', function() {
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');
  if (togglePassword && passwordInput) {
    const icon = togglePassword.querySelector('i');
    togglePassword.addEventListener('click', function () {
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });
  }
});


function actualizarTotales() {
  document.querySelectorAll('.concepto-item').forEach(function(conceptoDiv) {
    var cantidad = parseFloat(conceptoDiv.querySelector('input[name="cantidad[]"]').value) || 0;
    var precio = parseFloat(conceptoDiv.querySelector('input[name="precio[]"]').value) || 0;
    var totalInput = conceptoDiv.querySelector('input[name="total[]"]');
    totalInput.value = (cantidad * precio).toFixed(2);
  });
}

// Evento para recalcular totales cuando cambie cantidad o precio
document.getElementById('conceptos-container').addEventListener('input', function(e) {
  if (e.target.name === 'cantidad[]' || e.target.name === 'precio[]') {
    actualizarTotales();
  }
});

// Calcula totales también cuando se añade un nuevo concepto
function agregarConcepto() {
  const container = document.getElementById('conceptos-container');
  const div = document.createElement('div');
  div.className = 'concepto-item';
  div.innerHTML = `
    <label>Concepto:</label>
    <textarea name="concepto[]" required class="concepto-textarea"></textarea>
    <label>Cantidad:</label>
    <input type="number" name="cantidad[]" min="1" value="1" required>
    <label>Precio:</label>
    <input type="number" name="precio[]" step="0.01" min="0" required>
    <label>Total:</label>
    <input type="file" accept="image/*" name="imagen[]" class="input-imagen">
    <img src="" class="preview-imagen">
    <button type="button" class="back-button eliminar-concepto" onclick="this.parentNode.remove()">Eliminar</button>
  `;
  container.appendChild(div);
}



// Inicializa totales al cargar la página
window.onload = actualizarTotales;
