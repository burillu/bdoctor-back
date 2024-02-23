<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You Page</title>
</head>
<body>
    <div class="container">
        <div class="background"></div> <!-- Aggiunta dello sfondo sfocato -->
        <div class="circle d-flex flex-column justify-content-center align-items-center">
            <h1 class="text">Grazie per l'acquisto!</h1>
            <p class="text">Il suo profilo verrà sponsorizzato fino al {{ date('d/m/y \o\r\e H:i', strtotime(session('expire_date'))) }}</p>
            <a class="btn" href="{{ route('admin.profile.edit') }}">Torna al tuo profilo</a>
        </div>
    </div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        overflow: hidden;
        position: relative; /* Aggiunto position relative per sfondo */
    }

    .container {
        text-align: center;
    }

    h1 {
        color: #333;
        font-size: 4em;
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
        background-color: #007bff; /* Colore blu */
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer; /* Cambio cursore in un puntatore */
        transition: background-color 0.3s ease, color 0.3s ease; /* Transizione fluida */
    }

    .btn:hover {
        background-color: #87ceeb; /* Colore azzurro al passaggio del mouse */
    }

    .background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom right, #007bff, #ffffff, #87ceeb); /* Sfondo gradiente */
        opacity: 0;
        filter: blur(50px); /* Applicazione dello sfocato */
        animation: fadeInBackground 1s ease 0.1s forwards;
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
        width: 800px;
        height: 800px;
        border-radius: 50%;
        background-color: #5dabff;
        opacity: 0;
        animation: scaleUp 0.5s ease 0.5s forwards;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative; /* Aggiunto position relative per sfondo */
        z-index: 1000; /* Assicura che il contenuto sia sopra lo sfondo */
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
</style>


