@extends('admin.dashboard')
@section('dashboard_content')
    @php
        $allYearsSelected = false;
    @endphp

    <div class="mx-2">
        <h1>Statistiche</h1>

        <hr>

        <div>
            <h5 class="mt-4">Intervallo di Tempo</h5>

            <select name="year" id="year" class="form-select w-25">
                {{-- <option value="all">Tutti</option> --}}
                @foreach ($years as $year)
                    <option value="{{ $year }}" @if ($year == date('Y')) selected @endif>{{ $year }}</option>
                @endforeach
            </select>

            <button class="btn btn-primary w-25 mt-2" id="changeDataBtn" onclick="defaultBtn.style.display = 'inline';  makeCharts(votes[year.value], reviews[year.value], leads[year.value])">cambia</button>
            <button class="btn btn-primary w-25 mt-2" id="defaultBtn" onclick="ChangeDataInDefault()">Ultimi 12 mesi</button>

        </div>

        <h5 class="mt-4 me-3">Grafico del numero di recensioni e messaggi per anno</h5>

        <div>
            <canvas id="ChartReviewsMessages"></canvas>
        </div>

        <h5 class="mt-5 me-3">Grafico media voti per anno</h5>

        <div>
            <canvas id="ChartVotes"></canvas>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        //TO-DO LIST
        // 1) CORREGGERE QUERY DEI VOTI (INDIPENDENTEMENTE DALLA DATA, RIEMPIE SOLO FEBBRAIO 2024) XXXXXXXXXXXXXXX
        // 2) AGGIUNGERE COMMENTI E DOCUMENTAZIONEXXXXXXXXXXXXX
        // 3) ? CREARE FUNZIONE PER NON RIPETERE OGNI VOLTA L'INIZIALIZZAZIONE DI LEADS, VOTES, REVIES ESSENDO QUASI IDENTICI    
        // 4) correggere mesi disordinati in leads e reviews XXXXXXXXXXXXXXXXX
        // 5) trasformare n messaggi + recensioni per anno/mese in un grafico XXXXXXXXXXXXX
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

        // inizializzazione variabili data attuale, utile nel defaultData
        const data = new Date();
        let currentMonth = data.getMonth();
        let currentYear = data.getFullYear();

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

        ChangeDataInDefault();

        function ChangeDataInDefault() {
            defaultBtn.style.display = 'none';
            let defaultData = {
                "votes" : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                "leads" : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                "reviews" : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            };
            // console.log(currentMonth);
            // console.log(currentYear);
            let j = 11;
            for(let i = currentMonth; i > (currentMonth - 12); i--){
                if(i >= 0){
                    // console.log(votes[currentYear][i]);
                    defaultData["votes"][j] = votes[currentYear][i];
                    defaultData["leads"][j] = leads[currentYear][i];
                    defaultData["reviews"][j] = reviews[currentYear][i];
                }
                else{
                    // console.log(votes[currentYear-1][i+12]);
                    defaultData["votes"][j] = votes[currentYear-1][i+12];
                    defaultData["leads"][j] = leads[currentYear-1][i+12];
                    defaultData["reviews"][j] = reviews[currentYear-1][i+12];
                }
                j--;
            }
            console.log(defaultData);
            makeCharts(defaultData["votes"], defaultData["reviews"], defaultData["leads"]);
        }

        /**@argument yearSelected è l'anno selezionato 
         *  crea il grafico dei votes in base all'anno selezionato 
        */
        function makeCharts( votes, reviews, leads) {
            if (myChartVotes !== null) {
                myChartVotes.destroy();
            }
            if (myChartReviewsMessages !== null) {
                myChartReviewsMessages.destroy();
            }
            let monthsLabels = [];
            if(changeBtnFlag){
                for(let i = currentMonth; i > (currentMonth - 12); i--){
                    if(i >= 0){
                        monthsLabels.unshift(MonthIndexToName(i));
                    }else{
                        monthsLabels.unshift(MonthIndexToName(i+12));
                    }
                }
            }else{
                monthsLabels = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
                
                // mounthsLabels = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
            }
            myChartVotes = new Chart(chartVotes, {
            type: 'bar',
            data: {
                labels: monthsLabels,
                datasets: [{
                    label: 'Media voti',
                    data: votes,
                    borderWidth: 1,
                    hoverBorderWidth: 2,
                    backgroundColor: 'rgba(0, 119, 182, 0.6)',
                    borderColor: 'rgba(0, 119, 182, 1)',
                }]
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
                    labels: monthsLabels,
                    datasets: [{
                        label: 'Numero recensioni',
                        data: reviews,
                        borderWidth: 1,
                        hoverBorderWidth: 2,
                        backgroundColor: 'rgba(0, 119, 182, 0.6)',
                        borderColor: 'rgba(0, 119, 182, 1)',
                    },
                    {
                        label: 'Numero messaggi',
                        data: leads,
                        borderWidth: 1,
                        hoverBorderWidth: 2,
                        backgroundColor: 'rgba(227, 28, 65, 0.6)',
                        borderColor: 'rgba(227, 28, 65, 1)',
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

        function MonthIndexToName(index){
            switch(index){
                case 0:
                    return 'Gennaio';
                case 1:
                    return 'Febbraio';
                case 2:
                    return 'Marzo';
                case 3:
                    return 'Aprile';
                case 4:
                    return 'Maggio';
                case 5:
                    return 'Giugno';
                case 6:
                    return 'Luglio';
                case 7:
                    return 'Agosto';
                case 8:
                    return 'Settembre';
                case 9:
                    return 'Ottobre';
                case 10:
                    return 'Novembre';
                case 11:
                    return 'Dicembre';
            }
        }

    </script>
        
        

@endsection