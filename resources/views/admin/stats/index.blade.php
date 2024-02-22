@extends('admin.dashboard')
@section('dashboard_content')

    <h1>Statistiche</h1>

    <div>
        <h3>Range di Tempo</h3>
        <select name="year" id="year" class="form-select w-25">
            @foreach ($years as $year)
                <option value="{{ $year }}" @if ($year == date('Y')) selected @endif>{{ $year }}</option>
            @endforeach
        </select>
    </div>

    <h3 class="pb-3 me-3">Grafico messaggi per mese</h3>
    <button class="btn btn-primary w-25" onclick="makeChartLeads(yearLeads.value)">cambia</button>
    <div>
        <canvas id="ChartLeads"></canvas>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        //dichiaro le variabili per il grafico dei leads
        let chartLeads = document.getElementById('ChartLeads');
        let myChart = null;

        //salvo l'anno inserito per i leads
        let yearLeads = document.getElementById('year');
        let yearIndex;
        let leads = {};

        //riempio l'array js con i dati dell'array php
        @for ($i = 0; $i < count($years); $i++)
            yearIndex = {{ 2022 + $i }};
            leads[yearIndex] = [];
            @foreach ($leads[2022 + $i] as $lead)
                leads[yearIndex].push({{ $lead }});
            @endforeach
        @endfor

        console.log(leads);
        //creo il grafico di default
        makeChartLeads(year.value);
        
        /**@argument yearSelected è l'anno selezionato 
         *  crea il grafico dei leads in base all'anno selezionato 
        */
        function makeChartLeads(yearSelected){
            // console.log(year.value);
            if (myChart !== null) {
                myChart.destroy();
            }
            myChart = new Chart(chartLeads, {
            type: 'bar',
            data: {
                labels: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
                datasets: [{
                    label: 'messaggi per mese',
                    data: leads[year.value],
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
    </script>
        
        

@endsection