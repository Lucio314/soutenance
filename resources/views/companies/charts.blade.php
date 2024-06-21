@extends('companies.dashboard')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
</head>

<body>
    <h1>Bar chart in Laravel</h1>
    <div style="width: 900px; margin:auto;">
        <canvas id="chart"></canvas>
    </div>
    {{-- {{dd(json_encode($labels))}} --}}
    <script>
        var ctx = document.getElementById('chart').getContext('2d');
        const label =  {!! json_encode($labels) !!};
        console.log(label);
        var userChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!} ,
                datasets:[ {!! json_encode($datasets) !!}],
                borderWidth:1
            },
            options:{
                scales:{
                    y:{
                        beginAtZero:true,

                    },

                }
            }
        });
    </script>
</body>

</html>

@endsection
