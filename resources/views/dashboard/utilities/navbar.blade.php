<nav class="navbar navbar-expand-lg bg-gradient">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Warsztat Samochodowy</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item d-flex align-items-center mx-0 mx-lg-3 mx-xl-3 mx-xxl-3">
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" role="switch" id="toggle-dark-mode">
                            <label class="form-check-label" for="flexSwitchCheckChecked">Zmień motyw</label>
                        </div>
                    </li>  
                    <li class="nav-item">
                        <a class="nav-link" href="/">Strona Główna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/uslugi">Usługi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/kontakt">Kontakt</a>
                    </li>
                    @if(Auth::check() && App\Enums\RolesEnum::isEmployee())
                        <li class="nav-item">
                            <a class="nav-link" href="/employeePanel">Panel Pracownika</a>
                        </li>
                    @endif
                    @if(Auth::check() && App\Enums\RolesEnum::isManager())
                        <li class="nav-item">
                            <a class="nav-link" href="/managerPanel">Panel Menadżera</a>
                        </li>
                    @endif
                    @if(Auth::check() && App\Enums\RolesEnum::isCustomer())
                        <li class="nav-item">
                            <a class="nav-link" href="/employeePanel">Moje konto</a>
                        </li>
                    @endif
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Zaloguj się</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Zarejestruj się</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Wyloguj się
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest                 
                </ul>
            </div>
        </div>
    </div>
</nav>