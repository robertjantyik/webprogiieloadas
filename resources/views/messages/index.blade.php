@extends('layout')
@section('content')
<div class="eyebrow">Beérkezett</div><h1 class="section-title" style="margin-top:8px">Üzenetek</h1>
<div class="table-wrap"><table><thead><tr><th>Küldés ideje</th><th>Küldő</th><th>Tárgy</th><th>Üzenet</th></tr></thead><tbody>
@forelse($messages as $m)<tr><td>{{ $m->created_at->format('Y-m-d H:i') }}</td><td>{{ $m->name }}<br>{{ $m->email }}</td><td>{{ $m->subject }}</td><td>{{ $m->body }}</td></tr>@empty<tr><td colspan="4">Még nem érkezett üzenet.</td></tr>@endforelse
</tbody></table></div><div class="pagination">{{ $messages->links() }}</div>
@endsection
