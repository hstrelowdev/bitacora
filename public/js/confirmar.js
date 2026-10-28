document.addEventListener("submit", (evento) => {
  const mensaje = evento.target.dataset.confirmar;

  if (mensaje && !confirm(mensaje)) {
    evento.preventDefault();
  }
});
