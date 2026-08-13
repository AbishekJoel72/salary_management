function initializeSidebar(){

    const menuOpen=document.getElementById("menuOpen");
    const menuClose=document.getElementById("menuClose");

    const sidebar=document.getElementById("sidebar");
    const header=document.getElementById("mainHeader");
    const footer=document.getElementById("mainFooter");
    const main=document.querySelector(".main-container");

    if(!menuOpen) return;

    menuOpen.addEventListener("click",()=>{

        sidebar.classList.add("collapsed");
        header.classList.add("collapsed");
        footer.classList.add("collapsed");
        main.classList.add("collapsed");

        menuOpen.classList.add("d-none");
        menuClose.classList.remove("d-none");

    });

    menuClose.addEventListener("click",()=>{

        sidebar.classList.remove("collapsed");
        header.classList.remove("collapsed");
        footer.classList.remove("collapsed");
        main.classList.remove("collapsed");

        menuClose.classList.add("d-none");
        menuOpen.classList.remove("d-none");

    });

}
