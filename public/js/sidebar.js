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


    // ================= SIDEBAR COLLAPSE =================

    menuOpen.addEventListener("click", function () {

        sidebar.classList.add("collapsed");

        header?.classList.add("collapsed");
        footer?.classList.add("collapsed");
        main?.classList.add("collapsed");

        menuOpen.style.display = "none";
        menuClose.style.display = "block";
    });


    // ================= SIDEBAR EXPAND =================

    menuClose.addEventListener("click", function () {

        sidebar.classList.remove("collapsed");

        header?.classList.remove("collapsed");
        footer?.classList.remove("collapsed");
        main?.classList.remove("collapsed");

        menuClose.style.display = "none";
        menuOpen.style.display = "block";
    });


    // ================= PAYROLL SUBMENU =================

    const payrollToggle = document.querySelector(".payroll-toggle");

    if (payrollToggle) {

        payrollToggle.addEventListener("click", function () {

            const parent = this.closest(".has-submenu");

            parent.classList.toggle("open");

        });

    }

}
