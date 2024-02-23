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

            {{-- al click, mostra il bottone per tornare a visualizzare gli ultimi 12 mesi, e genera i grafici in base all'anno richiesto --}}
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

        /**
         * Riordina i valori in base agli ultimi 12 mesi
         */
        function ChangeDataInDefault() {
            //fa scomparire il bottone che lo aziona
            defaultBtn.style.display = 'none';
            //inserisco i dati di default
            let defaultData = {
                "votes" : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                "leads" : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                "reviews" : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            };
            //indice per iterare i mesi dall'ultimo al primo
            let j = 11;
            // "i" va dal mese attuale fino al mese successivo dell'anno precedente (all'inizio i è 4 quindi maggio 2024, arriva fino a -7 ossia giugno del 2023 [in quanto facendo i(-7) + 12 esce 5 quindi il SESTO mese dell'anno])
            for(let i = currentMonth; i > (currentMonth - 12); i--){
                //se i è maggiore uguale di 0 allora si tratta dell'anno corrente
                if(i >= 0){
                    defaultData["votes"][j] = votes[currentYear][i];
                    defaultData["leads"][j] = leads[currentYear][i];
                    defaultData["reviews"][j] = reviews[currentYear][i];
                }
                //se i è minore di 0 allora si tratta dell'anno precedente, quindi devo aggiungere 12
                else{
                    defaultData["votes"][j] = votes[currentYear-1][i+12];
                    defaultData["leads"][j] = leads[currentYear-1][i+12];
                    defaultData["reviews"][j] = reviews[currentYear-1][i+12];
                }
                j--;
            }
            console.log(defaultData);
            //passo questi valori per la creazione dei grafici
            makeCharts(defaultData["votes"], defaultData["reviews"], defaultData["leads"]);
        }

        /**@argument yearSelected è l'anno selezionato 
         *  crea i grafici in base ai dati passati
        */
        function makeCharts( votes, reviews, leads) {
            //se esistono vanno distrutti per essere ricreati
            if (myChartVotes !== null) {
                myChartVotes.destroy();
            }
            if (myChartReviewsMessages !== null) {
                myChartReviewsMessages.destroy();
            }
            // se si tratta degli ultimi 12 mesi, devo cacolare ordine in cui vengono visualizzati i mesi nell'ascisse
            let monthsLabels = [];
            if(changeBtnFlag){
                for(let i = currentMonth; i > (currentMonth - 12); i--){
                    if(i >= 0){
                        monthsLabels.unshift(MonthIndexToName(i));
                    }else{
                        monthsLabels.unshift(MonthIndexToName(i+12));
                    }
                }
            }
            //altrimenti l'ordine è quello reale
            else{
                monthsLabels = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
            }
            //crei il grafico dei voti
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
                        //valore massimo è ovviamente 5 essendo 5 i voti che si possono dare
                        max: 5
                    }
                }
            }
            });

            //creo il grafico delle recensioni e dei messaggi
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

        /**
         * @argument index è l'indice del mese
         * trasforma l'indice ricevuto nel mese corrispondente
         **/
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