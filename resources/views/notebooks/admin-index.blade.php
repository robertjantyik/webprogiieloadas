@extends('layout')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center"><h1 class="section-title" style="margin-top:8px">Notebook CRUD</h1><a class="btn" href="{{ route('admin.notebooks.create') }}">+ Új notebook</a></div>
<div class="table-wrap"><table><thead><tr><th>Gyártó / típus</th><th>Processzor</th><th>Ár</th><th>Művelet</th></tr></thead><tbody>
@foreach($notebooks as $n)<tr><td>{{ $n->manufacturer }} {{ $n->model }}</td><td>{{ $n->processor?->model }}</td><td>{{ number_format($n->price,0,',',' ') }} Ft</td><td><a href="{{ route('admin.notebooks.edit',$n) }}">Szerkesztés</a><form method="post" action="{{ route('admin.notebooks.destroy',$n) }}" style="display:inline">@csrf @method('delete')<button class="pill" onclick="return confirm('Törlöd ezt a notebookot?')">Törlés</button></form></td></tr>@endforeach
</tbody></table></div><div class="pagination">{{ $notebooks->links() }}</div>
@endsection
