//выпадающее меню
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

//подсветка текущей ссылки
var currentLink = null;
switch (window.location.pathname) {
    case '/feed':
        currentLink = document.querySelector('#nav-feed');
        console.log(currentLink);
        break
    case '/registration/org':
        currentLink = document.querySelector('.nav-link#reg>a');
        break
    case '/login/org':
        currentLink = document.querySelector('.nav-link#login>a');
        break
    default:
        currentLink = document.querySelector('#nav-avatar');
}
if (currentLink) currentLink.classList.add('active');