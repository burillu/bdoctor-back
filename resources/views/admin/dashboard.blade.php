@extends('layouts.app_no_header')

@section('header')
@endsection

@section('content')
    <div class="my-wrapper-100vh">
        <!-- header -->
        {{-- <header class="border">
                <div class="container-fluid">
                    <div class="row align-content-center">
                        <!-- logo -->
                        <div class="col-auto d-flex align-content-center">
                            <div class="my-logo-container">
                                <img src="img/mobile-logo.png" alt="logo-mobile" class="d-lg-none" id="logo-mobile">
                                <img src="https://hiringplatform.boolean.careers/images/logo.png" alt="logo large"
                                    class="d-none d-lg-block">
                            </div>
                        </div>
                        <!-- search -->
                        <div class="col">
                            <div class="form-floating">
                                <input type="search" class="form-control" id="floatingInput"
                                    placeholder="name@example.com" disabled>
                                <label for="floatingInput"><i class="fa-solid fa-magnifying-glass"> </i> Cerca
                                    Qualcosa</label>
                            </div>
                        </div>
                        <!-- bell e co. -->
                        <div class="col-auto d-flex">
                            <div class="d-flex align-items-center">
                                <ul class="list-group list-group-horizontal border-0 ">
                                    <li class="list-group-item border-0 d-none d-lg-block text-secondary"><i
                                            class="fa-solid fa-list-ul"></i></li>
                                    <li class="list-group-item border-0 d-none d-lg-block text-secondary"><i
                                            class="fa-solid fa-circle-question"></i></li>
                                    <li class="list-group-item border-0 d-none d-lg-block text-secondary"><i
                                            class="fa-solid fa-ellipsis-vertical"></i></li>
                                    <li class="list-group-item border-0 btn">

                                        <div class="dropdown">
                                            <button class="text-warning border-0 bg-transparent" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-bell"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Profilo</a></li>
                                                <li><a class="dropdown-item" href="#">Fatturazione</a></li>
                                                <li><a class="dropdown-item" href="#">Logout</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>


                        </div>
                    </div>
                </div>
            </header> --}}
        <main class="container-fluid p-0">
            <div class="row g-0">
                <!-- sidebar -->
                <div class="col-12 col-md-3 my-sidebar  @if (strtotime($expire_date) > strtotime($now)) bg-sponsored @endif my-sidebar-lg  text-white"
                    id="sidebar">
                    <div class=" h-100 container-fluid">
                        <div class=" h-100 row">
                            <div class="col-sm-12">
                                <div
                                    class=" d-flex h-100 flex-row flex-sm-column justify-content-between justify-content-sm-start align-items-center align-items-sm-baseline">
                                    <!-- image -->
                                    <div
                                        class="my-2 my-logo-query @if (strtotime($expire_date) > strtotime($now)) border border-5 border-primary @endif  rounded-md-5 overflow-hidden">

                                        <img src="{{ asset('storage' . '\/images/OIG2.kc86IYLpVtKY.jpg') }}"
                                            class="@if (strtotime($expire_date) > strtotime($now)) img-sponsored @endif "
                                            alt="logo-bdoctors">
                                    </div>
                                    <!--top-->
                                    <div class="sidebar-top w-sm-100">

                                        <div class="d-flex  d-sm-block">
                                            <!-- home -->
                                            <div class="@if (str_contains(url()->current(), '/home')) active @endif my-btn p-2">
                                                <a href="{{ route('admin.dashboard') }}">
                                                    <i class="fa-solid fa-house"></i>
                                                    <span class="px-1 d-none d-md-inline">
                                                        Home</span></a>
                                            </div>
                                            <!-- Profilo -->
                                            <div class="@if (str_contains(url()->current(), '/profile')) active @endif my-btn p-2">
                                                <a href="{{ route('admin.profile.edit') }}">
                                                    <i class="fa-solid fa-user-doctor"></i>
                                                    <span class="px-1 d-none d-md-inline">
                                                        Profilo</span>
                                                </a>

                                            </div>
                                            <!-- Messaggi -->
                                            <div class="@if (str_contains(url()->current(), '/leads')) active @endif my-btn p-2">
                                                <a href="{{ route('admin.leads.index') }}">
                                                    <i class="fa-solid fa-envelope"></i>
                                                    <span class="px-1 d-none d-md-inline">
                                                        Messaggi</span>
                                                </a>
                                                <!-- Recensioni -->
                                            </div>
                                            <div class="@if (str_contains(url()->current(), '/reviews')) active @endif my-btn p-2">
                                                <a href="{{ route('admin.reviews.index') }}">
                                                    <i class="fa-solid fa-clipboard-question"></i>
                                                    <span class="px-1 d-none d-md-inline">
                                                        Recensioni</span>
                                                </a>
                                                <!-- Sponsorizzazioni -->
                                            </div>
                                            <div class="@if (str_contains(url()->current(), '/sponsorships')) active @endif my-btn p-2">
                                                <a href="{{ route('admin.sponsorships.index') }}">
                                                    <i class="fa-solid fa-plug-circle-bolt"></i>
                                                    <span class="px-1 d-none d-md-inline">
                                                        Sponsorizzazioni</span>
                                                </a>
                                                <!-- Statistiche -->
                                            </div>
                                            <div class="@if (str_contains(url()->current(), '/stat')) active @endif my-btn p-2">
                                                <a href="{{ route('admin.stats.index') }}">
                                                    <i class="fa-solid fa-chart-line"></i>
                                                    <span class="px-1 d-none d-md-inline">
                                                        Statistiche</span>
                                                </a>

                                            </div>

                                        </div>

                                    </div>
                                    <!--bottom-->
                                    <div class="sidebar-bottom w-sm-100 mt-sm-auto">

                                        <ul class="navbar-nav ml-auto">
                                            <!-- Authentication Links -->
                                            @guest
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                                </li>
                                                @if (Route::has('register'))
                                                    <li class="nav-item">
                                                        <a class="nav-link"
                                                            href="{{ route('register') }}">{{ __('Register') }}</a>
                                                    </li>
                                                @endif
                                            @else
                                                <li class="nav-item d-flex dropdown my-btn p-2">
                                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false" v-pre>
                                                        <i class="fa-solid fa-gear"></i> <span
                                                            class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        aria-labelledby="navbarDropdown">
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin') }}">{{ __('Dashboard') }}</a>
                                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                                            onclick="event.preventDefault();
                                                                                 document.getElementById('logout-form').submit();">
                                                            {{ __('Logout') }}
                                                        </a>

                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                            class="d-none">
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </li>
                                            @endguest
                                        </ul>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main -->
                <div class="col-12 col-md-9 main-content" id="main-content">

                    <div class="container-fluid">
                        <!-- top-main -->
                        <div class="row my-bg-blue text-white" id="top-main">
                            <div class="col-8 col-md-12">
                                <div class="row justify-content-between py-2">
                                    <!-- nuova sponsorizzazione -->

                                    <div class="col-auto order-md-last">
                                        <span class="">Nuova Sponsorizzazione</span>


                                        <button class="btn btn-outline-light ms-2" type="button" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"
                                            @if (str_contains(url()->current(), '/sponsorships')) disabled @endif>+</button>
                                        <!-- offcanvas -->
                                        <div class=" offcanvas my-offcanvas offcanvas-end" tabindex="-1"
                                            id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                            <div class="offcanvas-header">
                                                <h5 class="offcanvas-title" id="offcanvasRightLabel">Acquista una nuova
                                                    sponsorizzazione</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="offcanvas-body">
                                                @if (!str_contains(url()->current(), '/sponsorships'))
                                                    @include('admin.payments.form')
                                                @endif



                                            </div>
                                        </div>
                                    </div>
                                    <!-- left side -->
                                    <div class="col-12 col-md-4 col-lg-6">
                                        <div class="mb-1"><span class="fs-4 fw-bold">BDoctors</span>
                                            @if (strtotime($expire_date) > strtotime($now))
                                                <span class="badge rounded-pill bg-sponsored">Sponsor fino al
                                                    {{ date('d/m/y \o\r\e H:i', strtotime($expire_date)) }}</span>
                                            @endif
                                        </div>
                                        <nav class="text-white" style="--bs-breadcrumb-divider: '>>';"
                                            aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item">
                                                    <a href="#"><span class="badge rounded-pill my-blue-badge">3
                                                            app</span></a>
                                                </li>
                                                <li class="breadcrumb-item" aria-current="page">
                                                    <span class="badge rounded-pill my-blue-badge me-1 d-lg-none">+</span>
                                                    <span
                                                        class="badge rounded-pill my-blue-badge me-1 d-none d-lg-inline">Boolean
                                                        mobile
                                                        app</span>
                                                    <span
                                                        class="badge rounded-pill my-blue-badge me-1 d-none d-lg-inline">Boolean
                                                        web
                                                        app</span>
                                                    <span
                                                        class="badge rounded-pill my-blue-badge me-1 d-none d-lg-inline">Boolean
                                                        blog
                                                        app</span>
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>
                                    {{-- <div class="col-12 col-md-4 col-lg-3">
                                        <span>Messaggi ricevuti:</span>
                                        <div class="fs-3 fw-bold"></div>
                                    </div> --}}

                                </div>

                            </div>

                        </div>
                        <!-- center-main -->
                        <div id="center-main" class="row py-4">
                            <!-- left -->
                            <div class="col-12 col-xl-9">
                                <div class="card my-4">
                                    <!-- contenuto variabile -->
                                    @yield('dashboard_content')
                                </div>

                                <div class="card my-4">
                                    <div class="card-header fs-5">
                                        F.A.Q.
                                    </div>
                                    <!-- accordion -->
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                    aria-expanded="false" aria-controls="flush-collapseOne">
                                                    Perchè acquistare una sponsorizzazione?
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    Ti consente di essere tra i primi risultati nelle ricerche. Clicca sul +
                                                    in alto nella sezione blu
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                                    aria-expanded="false" aria-controls="flush-collapseTwo">
                                                    Come posso accedere alle informazioni del mio account?
                                                </button>
                                            </h2>
                                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">Accedi alla sezione profilo, e aggiorna i dati
                                                    per essere contattato dai tuoi clienti. Non daremo i tuoi contatti a
                                                    terzi.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                                    aria-expanded="false" aria-controls="flush-collapseThree">
                                                    Posso usare questa dashboard da mobile?
                                                </button>
                                            </h2>
                                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">Vedi tu... stiamo lavorando sodo
                                                    proprio per questo</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- right -->
                            <div class="col-12 col-xl-3">
                                <div class="card my-4">
                                    <div class="card-header fs-5"> To-do</div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" value=""
                                                    id="firstCheckbox">
                                                <label class="form-check-label" for="firstCheckbox">Pulizia dello
                                                    studio</label>
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" value=""
                                                    id="secondCheckbox">
                                                <label class="form-check-label" for="secondCheckbox">Company Talk online
                                                    con Boolean</label>
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" value=""
                                                    id="thirdCheckbox">
                                                <label class="form-check-label" for="thirdCheckbox">Gestione fatture
                                                    fiscali</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card">
                                            <img src="https://cdn.statcdn.com/Statistic/1400000/1400547-blank-754.png"
                                                class="card-img-top" alt="stats">
                                            <div class="card-body">
                                                <h5 class="card-title">Utenti attivi</h5>
                                                <p class="card-text">Lista degli utenti attivi in piattaforma
                                                    nell'ultimo mese</p>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">Gennaio: 1200</li>
                                                <li class="list-group-item">Febbraio: 800</li>
                                                <li class="list-group-item">Marzo: 1500</li>
                                            </ul>
                                            <div class="card-body">
                                                <a href="#" class="card-link">Visualizza report
                                                    approfondito</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>




    {{-- <div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
