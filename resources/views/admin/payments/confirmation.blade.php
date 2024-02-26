<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Thank You Page</title>
</head>

<body>

    <div class="container p-5">

        <div class="background">

        </div> <!-- Aggiunta dello sfondo sfocato -->

        <div class="circle d-flex flex-column justify-content-center align-items-center position-relative mt-5">
            <div class="container-fluid mt-5 py-5">
                <div class="logo-bdoctors logo-position rounded-5 overflow-hidden">

                    <img class="transform-logo " src="{{ asset('storage' . '\/images/OIG2.kc86IYLpVtKY.jpg') }}"
                        alt="logo-bdoctors">
                </div>
                <h1 class="text">Grazie per l'acquisto, {{ Auth::user()->name }}!</h1>
                <h4><span class="text-success">&#10004;</span> - Il pagamento di {{ session('amount') }} &euro;, è
                    andato a
                    buon
                    fine.</h4>
                <p class="text">Adesso con la tua sottoscrizione <b>{{ session('sponsorship_name') }}</b> , <br>
                    il tuo profilo verrà sponsorizzato fino al
                    {{ date('d/m/y \o\r\e H:i', strtotime(session('expire_date'))) }}</p>
                <a class="btn" href="{{ route('admin.profile.edit') }}">Torna al tuo profilo</a>
            </div>

        </div>
    </div>
</body>

</html>

<style>
    /* @import '~bootstrap/dist/css/bootstrap.css'; */

    .position-relative {
        position: relative;
    }

    .logo-position {
        position: absolute;
        border: 5px solid #5dabff;
        left: 50%;
        top: -90px;
        z-index: 1100;
        /* border-radius: 45px; */

    }

    .transform-logo {
        animation: transform-logo 3s ease 1.5s forwards;
    }

    .text-success {
        color: greenyellow;
        font-size: 1.5em
    }

    img {
        display: block;
        width: 100%
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        /* height: 100vh; */
        overflow-y: auto;
        position: relative;
        /* Aggiunto position relative per sfondo */
    }

    .container {
        text-align: center;
    }

    h1 {
        color: #333;
        font-size: 3.5em;
        margin-bottom: 20px;
        opacity: 1;
        animation: fadeIn 0.5s ease forwards;

    }

    p {
        color: #555;
        font-size: 18px;
        margin-bottom: 30px;
        opacity: 1;
        animation: fadeIn 0.5s ease 0.25s forwards;
    }

    .btn {
        display: inline-block;
        text-decoration: none;
        padding: 10px 20px;
        background-color: #007bff;
        /* Colore blu */
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        /* Cambio cursore in un puntatore */
        transition: background-color 0.3s ease, color 0.3s ease;
        /* Transizione fluida */
    }

    .btn:hover {
        background-color: #87ceeb;
        /* Colore azzurro al passaggio del mouse */
    }

    .background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom right, #007bff, #ffffff, #87ceeb);
        /* Sfondo gradiente */
        opacity: 0;
        filter: blur(50px);
        /* Applicazione dello sfocato */
        animation: fadeInBackground 1s ease 0.1s forwards;
    }

    @keyframes transform-logo {
        from {
            filter: invert(0%);
        }

        to {
            filter: invert(100%);
        }
    }

    @keyframes fadeInBackground {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .circle {
        width: 700px;
        height: 700px;
        border-radius: 50%;
        background-color: #5dabff;
        opacity: 0;
        animation: scaleUp 0.5s ease 0.5s forwards;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        /* Aggiunto position relative per sfondo */
        z-index: 1000;
        /* Assicura che il contenuto sia sopra lo sfondo */
    }

    @keyframes scaleUp {
        from {
            transform: scale(0);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    @media screen and (max-width:767.98px) {
        .circle {
            margin-top: 100px;
            width: 500px;
            height: 500px;
        }

        .logo-position {



            width: 200px;
        }

        body {
            overflow-y: auto;
            /* height: 100%; */
        }

        h1 {
            margin-top: 5px;
            font-size: 3em;
            margin-bottom: 10px;
        }


    }

    @media screen and (max-width:576px) {
        .circle {
            margin-top: 100px;
            width: 100%;
            height: 80vw;
        }

        .logo-position {
            margin-top: 100px;
            position: static;
            top: 10px;
            left: 0;
            display: flex;
            width: 180px;
        }

        body {
            overflow-y: auto;
            /* height: 100%; */
        }

        h1 {
            margin-top: 5px;
            font-size: 3em;
            margin-bottom: 10px;
        }


    }
</style>
