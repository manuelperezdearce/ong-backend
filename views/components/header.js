function toggleMenu() {
    const menu = document.getElementById("userMenu");
    menu.classList.toggle("hidden");
}

// Cierra el menú si haces clic fuera
document.addEventListener('click', function (event) {
    const menu = document.getElementById("userMenu");
    const button = event.target.closest('button');
    if (!event.target.closest('#userMenu') && !button) {
        menu?.classList.add("hidden");
    }
});