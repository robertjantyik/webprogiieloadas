@extends('layout')
@section('content')
<h1 class="section-title" style="margin-top:8px">{{ $notebook->exists ? 'Notebook szerkesztése' : 'Notebook hozzáadása' }}</h1>
<form class="form" method="post" action="{{ $notebook->exists ? route('admin.notebooks.update', $notebook) : route('admin.notebooks.store') }}">@csrf
@if($notebook->exists) @method('put') @endif
@foreach(['manufacturer'=>'Gyártó','model'=>'Típus','screen_size'=>'Kijelző mérete','memory_mb'=>'Memória (MB)','disk_gb'=>'Tárhely (GB)','graphics'=>'Videovezérlő','price'=>'Ár (Ft)'] as $field=>$label)
<label>{{ $label }}</label><input name="{{ $field }}" value="{{ old($field, $notebook->$field) }}" required>@error($field)<div class="errors">{{ $message }}</div>@enderror
@endforeach
<label>Processzor</label><select name="processor_id">@foreach($processors as $p)<option value="{{ $p->id }}" @selected(old('processor_id', $notebook->processor_id) == $p->id)>{{ $p->manufacturer }} {{ $p->model }}</option>@endforeach</select>
<label>Operációs rendszer</label><select name="operating_system_id">@foreach($systems as $s)<option value="{{ $s->id }}" @selected(old('operating_system_id', $notebook->operating_system_id) == $s->id)>{{ $s->name }}</option>@endforeach</select>
<button class="pill">Mentés</button></form>
@endsection
