@extends('admin.dashboard')
@section('dashboard_content')
    @php
        $allYearsSelected = false;
    @endphp
    <h1>Statistiche</h1>

    <div>
        <h4>Intervallo di Tempo</h4>

        <select name="year" id="year" class="form-select w-25">
            {{-- <option value="all">Tutti</option> --}}
            @foreach ($years as $year)
                <option value="{{ $year }}" @if ($year == date('Y')) selected @endif>{{ $year }}</option>
            @endforeach
        </select>

        <button class="btn btn-primary w-25" id="changeDataBtn" onclick="makeCharts(year.value, votes, leads, reviews)">cambia</button>
        <button class="btn btn-primary w-25" id="defaultBtn" >Ultimi 12 mesi</button>

    </div>

    <div>
        <canvas id="ChartReviewsMessages"></canvas>
    </div>

    <h5 class="mt-3 me-3">Grafico media voti per anno</h5>

     <h7 class="text-danger">attenzione il grafico è visualizzato in base all'anno</h7>
    <div>
        <canvas id="ChartVotes"></canvas>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        //TO-DO LIST
        // 1) CORREGGERE QUERY DEI VOTI (INDIPENDENTEMENTE DALLA DATA, RIEMPIE SOLO FEBBRAIO 2024) XXXXXXXXXXXXXXX
        // 2) AGGIUNGERE COMMENTI E DOCUMENTAZIONEXXXXXXXXXXXXX
        // 3) ? CREARE FUNZIONE PER NON RIPETERE OGNI VOLTA L'INIZIALIZZAZIONE DI LEADS, VOTES, REVIES ESSENDO QUASI IDENTICI    
        // 4) correggere mesi disordinati in leads e reviews XXXXXXXXXXXXXXXXX
        // 5) trasformare n messaggi + recensioni per anno/mese in un grafico
        // 6) creare funzione per il default ultimi 12 mesi
        // 7) migliorare la grafica

        //inizializzo le variabili per i grafici
        let chartVotes = document.getElementById('ChartVotes');
        let myChartVotes = null;
        let ChartReviewsMessages = document.getElementById('ChartReviewsMessages');
        let myChartReviewsMessages = null;

        //inizializzo la variabile dell'anno da visualizzare (quando l'utente vuole cambiare anno)
        const year = document.getElementById('year');

        //inizializzo le variabili dei bottoni
        const changeDataBtn = document.getElementById('changeDataBtn');
        const defaultBtn = document.getElementById('defaultBtn');
        let changeBtnFlag = true;
        defaultBtn.style.display = 'none';

        //inizializzo le variabili contententi i dati suddivisi per mese e anno
        let leads = {};
            yearIndex = 0;
                @for ($i = 0; $i < count($years); $i++)
                    yearIndex = {{ 2022 + $i }};
                    leads[yearIndex] = [];
                        @foreach ($leads[2022 + $i] as $lead)
                            leads[yearIndex].push({{ $lead }});
                        @endforeach
                @endfor
        console.log(leads);

        let reviews = {};
            yearIndex = 0;
                @for ($i = 0; $i < count($years); $i++)
                    yearIndex = {{ 2022 + $i }};
                    reviews[yearIndex] = [];
                        @foreach ($reviews[2022 + $i] as $review)
                            reviews[yearIndex].push({{ $review }});
                        @endforeach
                @endfor
        console.log(reviews);

        let votes = {};
            yearIndex = 0;
                @for ($i = 0; $i < count($years); $i++)
                    yearIndex = {{ 2022 + $i }};
                    votes[yearIndex] = [];
                        @foreach ($votes[2022 + $i] as $vote)
                        @if($vote === null)
                            votes[yearIndex].push(0);
                        @endif
                            votes[yearIndex].push({{ $vote }});
                        @endforeach
                @endfor
        console.log(votes);

        // ChangeDataLast12Mounths();
        makeCharts(year.value, votes, leads, reviews);

        function ChangeDataForYear(year) {
            console.log(year);
            
            let currentReviews = reviews[year];
            if(currentReviews === undefined) currentReviews = 0;
            totalReviews.innerHTML = currentReviews;
            
            let currentVotes = votes[year];
            if(currentVotes === undefined) currentVotes = 0;
            makeCharts(year, votes);
            
        }

        /**@argument yearSelected è l'anno selezionato 
         *  crea il grafico dei votes in base all'anno selezionato 
        */
        function makeCharts(yearSelected, votes, leads, reviews) {
            console.log(yearSelected);
            if (myChartVotes !== null) {
                myChartVotes.destroy();
            }
            if (myChartReviewsMessages !== null) {
                myChartReviewsMessages.destroy();
            }
            
            myChartVotes = new Chart(chartVotes, {
            type: 'bar',
            data: {
                labels: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
                datasets: [{
                    label: 'Media voti',
                    data: votes[yearSelected],
                    borderWidth: 1,
                    hoverBorderWidth: 2,
                }]
                // datasets: Object.keys(leads).map(year => ({
                //     label: `messaggi per mese ${year}`,
                //     data: leads[year],
                //     borderWidth: 1,
                //     hoverBorderWidth: 2,
                // }))
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5
                    }
                }
            }
            });

            myChartReviewsMessages = new Chart(ChartReviewsMessages, {
                type: 'bar',
                data: {
                    labels: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
                    datasets: [{
                        label: 'Numero recensioni',
                        data: reviews[yearSelected],
                        borderWidth: 1,
                        hoverBorderWidth: 2,
                    },
                    {
                        label: 'Numero messaggi',
                        data: leads[yearSelected],
                        borderWidth: 1,
                        hoverBorderWidth: 2,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    }
                }
            });

        };

    </script>
        
        

@endsection