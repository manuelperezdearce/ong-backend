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

window.addEventListener('scroll', function () {
    const header = document.querySelector('header');
    if (window.scrollY > 20) {
        header.classList.add('scroll-active');
    } else {
        header.classList.remove('scroll-active');
    }
});