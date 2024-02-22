@extends('admin.dashboard')
@section('dashboard_content')

    <h1>Statistiche</h1>
    <h3 class="pb-3 me-3">Messaggi per mese</h3>
    <select name="yearLeads" id="yearLeads" class="form-select w-25">
        @foreach ($years as $year)
            <option value="{{ $year }}" @if ($year == date('Y')) selected @endif>{{ $year }}</option>
        @endforeach
    </select>
    <button class="btn btn-primary w-25" onclick="makeChartLeads(yearLeads.value)">cambia</button>
    <div>
        <canvas id="ChartLeads"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let chartLeads = document.getElementById('ChartLeads');
        let yearLeads = document.getElementById('yearLeads');
        let myChart = null;

        let year
        let leads = {};

        @for ($i = 0; $i < count($years); $i++)
            year = {{ 2022 + $i }};
            leads[year] = [];
            @foreach ($leads[2022 + $i] as $lead)
                leads[year].push({{ $lead }});
            @endforeach
        @endfor

        console.log(leads);

        makeChartLeads(yearLeads.value);
        
        function makeChartLeads(year){
            console.log(yearLeads.value);
            if (myChart !== null) {
                myChart.destroy();
            }
            myChart = new Chart(chartLeads, {
            type: 'bar',
            data: {
                labels: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
                datasets: [{
                    label: 'messaggi per mese',
                    data: leads[yearLeads.value],
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