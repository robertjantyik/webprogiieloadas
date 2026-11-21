@extends('layout')
@section('content')
<div class="eyebrow">Adatok vizuálisan</div><h1 class="section-title" style="margin-top:8px">Márkák a kínálatban</h1>
<div class="card"><canvas id="brands" height="110"></canvas></div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>new Chart(document.getElementById('brands'),{type:'bar',data:{labels:@json($stats->pluck('manufacturer')),datasets:[{label:'Modellek száma',data:@json($stats->pluck('total')),backgroundColor:'#315f4e',borderRadius:8}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{precision:0}}}}});</script>
@endsection
