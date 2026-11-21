@extends('layout')
@section('title', 'Notebook adatbázis')
@section('content')
<div class="eyebrow">A kínálat</div><h1 class="section-title" style="margin-top:8px">Notebook adatbázis</h1>
<form method="get"><input name="search" value="{{ request('search') }}" placeholder="Keresés gyártóra vagy típusra"><button class="pill">Keresés</button></form>
<div class="table-wrap"><table><thead><tr><th>Gyártó / típus</th><th>Kijelző</th><th>Memória</th><th>Tárhely</th><th>Processzor</th><th>Operációs rendszer</th><th>Ár</th></tr></thead><tbody>
@foreach($notebooks as $n)<tr><td><b>{{ $n->manufacturer }}</b><br>{{ $n->model }}</td><td>{{ number_format($n->screen_size,1,',','') }}″</td><td>{{ number_format($n->memory_mb/1024,0) }} GB</td><td>{{ $n->disk_gb }} GB</td><td>{{ $n->processor?->manufacturer }} {{ $n->processor?->model }}</td><td>{{ $n->operatingSystem?->name }}</td><td><b>{{ number_format($n->price,0,',',' ') }} Ft</b></td></tr>@endforeach
</tbody></table></div><div class="pagination">{{ $notebooks->links() }}</div>
@endsection
