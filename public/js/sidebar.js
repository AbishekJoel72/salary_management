function initializeSidebar() {

    const menuOpen = document.getElementById("menuOpen");
    const menuClose = document.getElementById("menuClose");

    const sidebar = document.getElementById("sidebar");
    const header = document.getElementById("mainHeader");
    const footer = document.getElementById("mainFooter");
    const main = document.querySelector(".main-container");

    if (!menuOpen || !menuClose || !sidebar) {
        return;
    }

    menuOpen.addEventListener("click", function () {

        sidebar.classList.add("collapsed");

        if (header) {
            header.classList.add("collapsed");
        }

        if (footer) {
            footer.classList.add("collapsed");
        }

        if (main) {
            main.classList.add("collapsed");
        }
        menuOpen.classList.add("d-none");
        menuClose.classList.remove("d-none");

    });



    menuClose.addEventListener("click", function () {
        sidebar.classList.remove("collapsed");

        if (header) {
            header.classList.remove("collapsed");
        }

        if (footer) {
            footer.classList.remove("collapsed");
        }

        if (main) {
            main.classList.remove("collapsed");
        }

        menuClose.classList.add("d-none");
        menuOpen.classList.remove("d-none");

    });

}
