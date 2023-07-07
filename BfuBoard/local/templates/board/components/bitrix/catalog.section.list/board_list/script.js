

document.addEventListener('DOMContentLoaded',function () {
    let teamInfoToggles = document.querySelectorAll('.team-menu-toggle');
    let teamMenu = document.querySelector('.main-menu__popover');
    if(teamInfoToggles){
        teamInfoToggles.forEach((toggle) => {
            toggle.addEventListener('click', () => {
                teamMenu.classList.toggle('popover--opened');
            })
        })
    }

    let menuToggle = document.querySelector('.main-menu__toggle');
    let menu = document.querySelector('.main-menu');
    let mainMenuInner = document.querySelector('.main-menu__inner');
    if(menuToggle){
        menuToggle.addEventListener('click', () => {
            menu.classList.toggle('main-menu--opened');
            mainMenuInner.classList.toggle('main-menu__inner--opened');

            if (teamMenu.classList.contains('popover--opened')) {
                teamMenu.classList.toggle('popover--opened');
            }
        });
    }
    // User info popover
    let userInfo = document.querySelector('.user-info');
    let userPopover = document.querySelector('.header-right-menu__popover');

    userInfo.addEventListener('click', (evt) => {
        evt.preventDefault();
        userPopover.classList.toggle('popover--opened');
    });
})