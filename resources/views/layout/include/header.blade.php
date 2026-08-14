<header id="mainHeader" class="header d-flex align-items-center">
    <div class="header-left d-flex align-items-center gap-3">
        <i id="menuOpen" class="fa-solid fa-bars-staggered fs-5 text-primary"></i>
        <i id="menuClose" class="fa-solid fa-arrow-right fs-5 d-none text-primary"></i>
    </div>

    <nav class="ms-auto bg-light text-primary p-3">
        <div class="dropdown">
            <div class="d-flex flex-column align-items-start">
{{--
                <span><i class="fa fa-user"></i> {{ session('user_name') }}</span>
                <span><i class="fa fa-envelope"></i> {{ session('user_email') }}</span> --}}
                <span><i class="fa fa-user"></i> Admin</span>
                <span><i class="fa fa-envelope"></i> admin@gmail.com</span>

            </div>

        </div>
    </nav>
</header>
