document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar");
  const boton = document.getElementById("toggle-sidebar");

  if (sidebar && boton) {
    boton.addEventListener("click", () => {
      sidebar.classList.toggle("abierto");
    });
  }
});
