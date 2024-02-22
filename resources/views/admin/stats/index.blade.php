@extends('admin.dashboard')
@section('dashboard_content')


    <h1>Statistiche</h1>
    <div>
        <canvas id="ChartLeads"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    const ctx = document.getElementById('ChartLeads');
    
    let leads = [];
    let count = 0;
    @foreach ($leads as $value)
        leads[count] = {{ $value }};
        count++;
    @endforeach

    new Chart(ctx, {
        type: 'bar',
        data: {
        labels: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
        datasets: [{
            label: 'messaggi per mese',
            data: leads,
            borderWidth: 1,
            hoverBorderWidth: 2,
        }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });
    </script>

    
@endsection