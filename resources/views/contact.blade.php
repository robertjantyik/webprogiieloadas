@extends('layout')
@section('title', 'Kapcsolat | ReNew')
@section('content')
<div class="eyebrow">Kapcsolat</div><h1 class="section-title" style="margin-top:8px">Írj nekünk</h1>
<form class="form" method="post" action="{{ route('contact.store') }}">@csrf
<label>Név</label><input name="name" value="{{ old('name', auth()->user()?->name) }}" required>@error('name')<div class="errors">{{ $message }}</div>@enderror
<label>E-mail</label><input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" required>@error('email')<div class="errors">{{ $message }}</div>@enderror
<label>Tárgy</label><input name="subject" value="{{ old('subject') }}" required>@error('subject')<div class="errors">{{ $message }}</div>@enderror
<label>Üzenet</label><textarea name="body" rows="6" required>{{ old('body') }}</textarea>@error('body')<div class="errors">{{ $message }}</div>@enderror
<button class="pill">Üzenet küldése</button></form>
@endsection
