const moreMenu = document.querySelector('.nav-link.sub>.sub-menu');

document.addEventListener('click', (e) => {
    if (!e.target.matches('.nav-link.sub>a, .nav-link.sub>.sub-menu, .nav-link.sub>.sub-menu>a')) return;
    if (e.target.matches('.nav-link.sub>a')) {
        e.preventDefault();
    }
    var style = window.getComputedStyle ? getComputedStyle(moreMenu, null) : moreMenu.currentStyle;
    moreMenu.style.display =
        style.display == 'none' ? 'grid' : 'none';
});