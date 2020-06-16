const moreMenu = document.querySelector('.nav-link.sub>.sub-menu');

document.addEventListener('click', (e) => {
    if (!e.target.matches('.nav-link.sub>a, .nav-link.sub>.sub-menu')) return;
    moreMenu.css.style.display =
        moreMenu.css.style.display == 'none' ? 'flex' : 'none';
});