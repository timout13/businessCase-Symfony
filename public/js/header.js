/***************
 Variables
 ***************/

let sectionNavBar = document.querySelector(".section-navbar");
let searchForm = document.querySelector("#form-searchBar");
let searchIcon = document.querySelector(".searchBar-search");
let searchClose = document.querySelector(".searchBar-remove");
let searchInput = document.querySelector("#searchBar-input");
let listLogin = document.querySelector(".li-connexion");

/***************
 Fonctions
 ***************/

/***************
 Code principal
 ***************/

/* starts when the html is loaded */
document.addEventListener("DOMContentLoaded", function () {
    searchIcon.addEventListener("click", () => {
        //Apply the class 'open' to the form, the input and the close btn on the click of search btn
        searchForm.classList.add("open");
        searchInput.classList.add("open");
        searchClose.classList.add("open");
        searchInput.focus();

        //Window's width under 960 = search bar take full width of the window
        if (innerWidth < 960) {
            sectionNavBar.classList.add("position-relative");
            searchForm.classList.add("position-absolute");
        }
    });

    searchClose.addEventListener("click", () => {
        //SearchBar come back at it initial position = in the navbar
        sectionNavBar.classList.remove("position-relative");
        searchForm.classList.remove("position-absolute");

        //Remove the class 'open' to the form, the input and the close btn on the click of close btn
        searchForm.classList.remove("open");
        searchInput.classList.remove("open");
        searchClose.classList.remove("open");

        //clear search field on close
        searchInput.value = "";
    });

    window.addEventListener("resize", () => {
        if (innerWidth < 960) {
            //Input 'open' & width < 960 = input take full width of the window
            if (searchInput.classList.contains("open")) {
                sectionNavBar.classList.add("position-relative");
                searchForm.classList.add("position-absolute");
            } else {
                sectionNavBar.classList.remove("position-relative");
                searchForm.classList.remove("position-absolute");
            }
        }

        //Initial position of the searchBar
    });
});
