@extends('layouts.app')

@section('header')
    @include('partials.header')
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
        <main>
            <div class="d-flex">
                <!-- sidebar -->
                <div class="my-sidebar my-sidebar-lg text-white" id="sidebar">
                    <div class=" h-100 container-fluid">
                        <div class=" h-100 row">
                            <div class="col-sm-12">
                                <div class=" d-flex h-100 flex-column justify-content-between">
                                    <div class="sidebar-top">
                                        <!-- home -->
                                        <div class=" my-btn p-2">
                                            <a href="{{-- route('admin.projects.index') --}}">
                                                <i class="fa-solid fa-house"></i> <span class="px-1 d-none d-lg-inline">
                                                    Home</span></a>
                                        </div>
                                        <!-- projects -->
                                        <div class="my-btn p-2">
                                            <a href="{{-- route('admin.projects.index') --}}">
                                                <i class="fa-solid fa-diagram-project"></i>
                                                <span class="px-1 d-none d-lg-inline">
                                                    Projects</span>
                                            </a>

                                        </div>
                                        <!-- types -->
                                        <div class="my-btn p-2">
                                            <a href="{{-- route('admin.types.index') --}}">
                                                <i class="fa-solid fa-server"></i>
                                                <span class="px-1 d-none d-lg-inline">
                                                    Types</span>
                                            </a>

                                        </div>
                                        <div class="my-btn p-2">
                                            <a href="{{-- route('admin.technologies.index') --}}">
                                                <i class="fa-solid fa-code"></i>
                                                <span class="px-1 d-none d-lg-inline">
                                                    Technologies</span>
                                            </a>

                                        </div>
                                    </div>
                                    <div class="sidebar-bottom">
                                        <!-- admin -->
                                        <div class="my-btn p-2">
                                            <i class="fa-solid fa-gear"></i> <span class="px-1 d-none d-lg-inline">
                                                Admin</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-content" id="main-content">

                    <div class="container-fluid">
                        <!-- top-main -->
                        <div class="row bg-primary text-white" id="top-main">
                            <div class="col-8 col-md-12">
                                <div class="row py-2">
                                    <!-- nuovo studente -->
                                    <div class="col-12 col-md-4 col-lg order-md-last">
                                        <span class="">Nuovo Progetto</span>


                                        <button class="btn btn-outline-light ms-2" type="button" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">+</button>
                                        <!-- offcanvas -->
                                        <div class=" offcanvas my-offcanvas offcanvas-end" tabindex="-1"
                                            id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                            <div class="offcanvas-header">
                                                <h5 class="offcanvas-title" id="offcanvasRightLabel">Inserisci un
                                                    nuovo studente</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="offcanvas-body">
                                                <form>
                                                    <div class="container-fluid">
                                                        <!-- nome e cognome -->
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Nome</label>
                                                                    <input type="text" class="form-control"
                                                                        id="name" placeholder="">
                                                                </div>

                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="lastname" class="form-label">Cognome</label>
                                                                    <input type="text" class="form-control"
                                                                        id="lastname" placeholder="">
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- email e password -->
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="email" class="form-label">Email</label>
                                                                    <div class="input-group mb-3">
                                                                        <span class="input-group-text"
                                                                            id="basic-addon1">@</span>
                                                                        <input type="email" id="email"
                                                                            class="form-control" placeholder=""
                                                                            aria-label="Username"
                                                                            aria-describedby="basic-addon1">
                                                                    </div>
                                                                </div>


                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="password"
                                                                        class="form-label">Password</label>
                                                                    <input type="password" class="form-control"
                                                                        id="password" placeholder="">
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- email e password -->
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="email2" class="form-label">Email</label>
                                                                    <div class="input-group mb-3">
                                                                        <span class="input-group-text"
                                                                            id="basic-addon2">@</span>
                                                                        <input type="email" id="email2"
                                                                            class="form-control" placeholder=""
                                                                            aria-label="Username"
                                                                            aria-describedby="basic-addon1">
                                                                    </div>
                                                                </div>


                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="password2"
                                                                        class="form-label">Password</label>
                                                                    <input type="password" class="form-control"
                                                                        id="password2" placeholder="">
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- indirizzo -->
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="mb-3">
                                                                    <label for="adress"
                                                                        class="form-label">Indirizzo</label>
                                                                    <input type="text" class="form-control"
                                                                        id="adress" placeholder="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- citta, stato cap -->
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="city"
                                                                        class="form-label">CittÃ </label>
                                                                    <input type="text" class="form-control"
                                                                        id="city" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-4">
                                                                <div class="mb-3">
                                                                    <label for="state" class="form-label">Stato</label>
                                                                    <select class="form-select" id="state"
                                                                        aria-label="Default select example">
                                                                        <option selected>Scegli...</option>
                                                                        <option value="1">Italia</option>
                                                                        <option value="2">Svizzera</option>
                                                                        <option value="3">Montenegro</option>
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <div class="col-12 col-md-2">
                                                                <div class="mb-3">
                                                                    <label for="cap" class="form-label">CAP</label>
                                                                    <input type="text" class="form-control"
                                                                        id="cap" placeholder="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- foto -->
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="mb-3">
                                                                    <label for="formFile" class="form-label">Foto</label>
                                                                    <input class="form-control" type="file"
                                                                        id="formFile">
                                                                </div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                    <!-- checkbox -->
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" value="agree"
                                                            id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Seleziona per proseguire
                                                        </label>
                                                    </div>
                                                    <!-- submit and reset -->
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary">Salva</button>
                                                        <button type="reset" class="btn btn-warning">Svuota</button>

                                                    </div>
                                                </form>


                                            </div>
                                        </div>
                                    </div>
                                    <!-- left side -->
                                    <div class="col-12 col-md-4 col-lg-6">
                                        <div class="mb-1"><span class="fs-4 fw-bold">Boolean</span> <span
                                                class="badge rounded-pill my-blue-badge">Piano Blaze</span></div>
                                        <nav class="text-white" style="--bs-breadcrumb-divider: '>>';"
                                            aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item">
                                                    <a href="#"><span class="badge rounded-pill my-blue-badge">3
                                                            app</span></a>
                                                </li>
                                                <li class="breadcrumb-item active" aria-current="page">
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
                                    <div class="col-12 col-md-4 col-lg-3">
                                        <span>Studenti online negli utlimi 30 minuti</span>
                                        <div class="fs-3 fw-bold">125</div>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <!-- center-main -->
                        <div id="center-main" class="row py-4">
                            <!-- left -->
                            <div class="col-12 col-lg-10">
                                <div class="card my-4">
                                    <div class="card-header fs-5">
                                        Projects
                                    </div>
                                    <!-- tabella -->
                                    @yield('content')
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
                                                    Come aggiunere un nuovo studente?
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">Clicca sul + in alto nella sezione blu
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
                                                <div class="accordion-body">Clicca sull' icona della campanella
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
                            <div class="col-12 col-lg-2">
                                <div class="card my-4">
                                    <div class="card-header fs-5"> Todo</div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" value=""
                                                    id="firstCheckbox">
                                                <label class="form-check-label" for="firstCheckbox">Kickoff nuove
                                                    classi</label>
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" value=""
                                                    id="secondCheckbox">
                                                <label class="form-check-label" for="secondCheckbox">Lezione su
                                                    Bootstrap 5 in classe
                                                    #107</label>
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" value=""
                                                    id="thirdCheckbox">
                                                <label class="form-check-label" for="thirdCheckbox">Controllare
                                                    username github studenti</label>
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
