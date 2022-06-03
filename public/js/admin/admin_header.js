const contentLayout = document.querySelector('#content-layout');
const navBar = document.querySelector('#nav-bar');

const showNavbar = (toggleOpenId, toggleCloseId, navId, bodyId, headerId, layoutId) => {
    const toggleOpen = document.getElementById(toggleOpenId),
        toggleClose = document.getElementById(toggleCloseId),
        nav = document.getElementById(navId),
        bodypd = document.getElementById(bodyId),
        headerpd = document.getElementById(headerId),
        contentLayout = document.getElementById(layoutId)

// Validate that all variables exist
    if (toggleOpen && nav && bodypd && headerpd && toggleClose && contentLayout) {
        toggleOpen.addEventListener('click', () => {
// show navbar
            nav.classList.toggle('show')
// change icon
            toggleOpen.classList.toggle('bx-x')
// add padding to header
            headerpd.classList.toggle('header-pd')
// add display to div ContentLayout
            contentLayout.classList.toggle('d-none')
// add opacity to div ContentLayout
            contentLayout.classList.toggle('op')
        });
        toggleClose.addEventListener('click', () => {
// show navbar
            nav.classList.toggle('show')
// change icon
            toggleClose.classList.toggle('bx-x')
// add padding to header
            headerpd.classList.toggle('header-pd')
// add display to div ContentLayout
            contentLayout.classList.toggle('d-none')
// add opacity to div ContentLayout
            contentLayout.classList.toggle('op')
        });
    }
}

document.addEventListener("DOMContentLoaded", function (event) {

    if (innerWidth > 768 && !contentLayout.classList.contains('d-none')) {
        contentLayout.classList.add('d-none');
    }

    window.addEventListener("resize", () => {
        if (innerWidth > 768 && !contentLayout.classList.contains('d-none')) {
            contentLayout.classList.add('d-none');
        } else if (innerWidth < 768 && navBar.classList.contains('show')) {
            contentLayout.classList.remove('d-none');
        }
    });

    contentLayout.addEventListener('click', ()=>{
        console.log('gdg');

    })



    showNavbar('header-open', 'header-close', 'nav-bar', 'body-pd', 'header', 'content-layout');

    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link');

    function colorLink() {
        if (linkColor) {
            linkColor.forEach(l => l.classList.remove('active'))
            this.classList.add('active')
        }
    }

    linkColor.forEach(l => l.addEventListener('click', colorLink));

// Your code to run since DOM is loaded and ready
});