@extends('admin.dashboard')
@section('dashboard_content')
    @php
        $allYearsSelected = false;
    @endphp
    <h1>Statistiche</h1>

    <div>
        <h3>Range di Tempo</h3>

        <select name="year" id="year" class="form-select w-25">
            {{-- <option value="all">Tutti</option> --}}
            @foreach ($years as $year)
                <option value="{{ $year }}" @if ($year == date('Y')) selected @endif>{{ $year }}</option>
            @endforeach
        </select>

        <select name="mounth" id="mounth" class="form-select w-25">
            {{-- <option value="all">Tutti</option> --}}
            <option value="January" @if ('January' == date('F')) selected @endif>Gennaio</option>
            <option value="February" @if ('February' == date('F')) selected @endif>Febbraio</option>
            <option value="March" @if ('March' == date('F')) selected @endif>Marzo</option>
            <option value="April" @if ('April' == date('F')) selected @endif>Aprile</option>
            <option value="May" @if ('May' == date('F')) selected @endif>Maggio</option>
            <option value="June" @if ('June' == date('F')) selected @endif>Giugno</option>
            <option value="July" @if ('July' == date('F')) selected @endif>Luglio</option>
            <option value="August" @if ('August' == date('F')) selected @endif>Agosto</option>
            <option value="September" @if ('September' == date('F')) selected @endif>Settembre</option>
            <option value="October" @if ('October' == date('F')) selected @endif>Ottobre</option>
            <option value="November" @if ('November' == date('F')) selected @endif>Novembre</option>
            <option value="December" @if ('December' == date('F')) selected @endif>Dicembre</option>
        </select>
        <button class="btn btn-primary w-25" onclick="ChangeData(year.value, mounth.value)">cambia</button>

    </div>

    <div>
        <p>Messaggi ricevuti: <strong id="totalMessages"></strong></p>
    </div>

    <div>
        <p>Recensioni ricevute: <strong id="totalReviews"></strong></p>
    </div>

    <h5 class="mt-3 me-3">Grafico messaggi per mese</h5>

     <h7 {{--id="allYearsSelectedErrorMessage" --}} class="text-danger">attenzione il grafico è visualizzato in base all'anno</h7>
    <div>
        <canvas id="ChartVotes"></canvas>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        //dichiaro le variabili per il grafico dei votes
        let chartVotes = document.getElementById('ChartVotes');
        let myChart = null;
        // const allYearsSelectedErrorMessage = document.getElementById('allYearsSelectedErrorMessage');
        // allYearsSelectedErrorMessage.style.display = 'none';

        const year = document.getElementById('year');
        const mounth = document.getElementById('mounth');
        const totalMessages = document.getElementById('totalMessages');
        const totalReviews = document.getElementById('totalReviews');

        ChangeData(year.value,mounth.value);

        //TO-DO LIST
        // 1) CORREGGERE QUERY DEI VOTI (INDIPENDENTEMENTE DALLA DATA, RIEMPIE SOLO FEBBRAIO 2024)
        // 2) AGGIUNGERE COMMENTI E DOCUMENTAZIONE
        // 3) ? CREARE FUNZIONE PER NON RIPETERE OGNI VOLTA L'INIZIALIZZAZIONE DI LEADS, VOTES, REVIES ESSENDO QUASI IDENTICI   
        function ChangeData(year, mounth) {
            console.log(year);
            console.log(mounth);
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
            
            mounthIndex = mounthToIndex(mounth);
            // console.log(mounthIndex);
            let currentLeads = leads[year][mounthIndex];
            if(currentLeads === undefined) currentLeads = 0;
            totalMessages.innerHTML = currentLeads;
            
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

            mounthIndex = mounthToIndex(mounth);
            let currentReviews = reviews[year][mounthIndex];
            if(currentReviews === undefined) currentReviews = 0;
            totalReviews.innerHTML = currentReviews;

            let votes = {};
            yearIndex = 0;
                @for ($i = 0; $i < count($years); $i++)
                    yearIndex = {{ 2022 + $i }};
                    votes[yearIndex] = [];
                        @foreach ($votes[2022 + $i] as $vote)
                            votes[yearIndex].push({{ $vote }});
                        @endforeach
                @endfor
            console.log(votes);

            mounthIndex = mounthToIndex(mounth);
            let currentVotes = votes[year][mounthIndex];
            if(currentVotes === undefined) currentVotes = 0;
            makeChartVote(year, votes);


            // if(year === 'all'){
            //     allYearsSelectedErrorMessage.style.display = 'block';
                
            // }else{
            //     allYearsSelectedErrorMessage.style.display = 'none';
            // }
            
        }

        /**@argument yearSelected è l'anno selezionato 
         *  crea il grafico dei votes in base all'anno selezionato 
        */
        function makeChartVote(yearSelected, votes){
            console.log(yearSelected);
            if (myChart !== null) {
                myChart.destroy();
            }
            if (yearSelected === 'all') {
                yearSelected = {{ date('Y') }};
                // allYearsSelectedErrorMessage.style.display = 'block';
            }else{
                // allYearsSelectedErrorMessage.style.display = 'none';
            }
            myChart = new Chart(chartVotes, {
            type: 'bar',
            data: {
                labels: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
                datasets: [{
                    label: 'messaggi per mese',
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
                        beginAtZero: true
                    }
                }
            }
        });
    }

        function mounthToIndex(mounth){
            switch(mounth){
                case 'January': return 0;
                case 'February': return 1;
                case 'March': return 2;
                case 'April': return 3;
                case 'May': return 4;
                case 'June': return 5;
                case 'July': return 6;
                case 'August': return 7;
                case 'September': return 8;
                case 'October': return 9;
                case 'November': return 10;
                case 'December': return 11;
            }
            ;
        }
    </script>
        
        

@endsection