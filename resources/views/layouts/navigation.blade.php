<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/">PCs & Parts</a>
        <div class="collapse navbar-collapse d-lg-flex justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/parts">Parts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/pcs">PCs</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/account">Account</a>
                    </li>
                @endauth
            </ul>
            <ul class="navbar-nav mt-5 mb-2 mb-lg-0 mt-lg-0">
                @auth
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/logout">Sign Out</a>
                    </li>
                @endauth
                @guest
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/login">Log In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/register">Sign up</a>
                        </li>
                @endguest
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="mailto:pcsandpartskenya@gmail.com">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
