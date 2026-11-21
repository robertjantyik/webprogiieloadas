@extends('layout')
@section('content')
<div class="eyebrow">Csatlakozz hozzánk</div><h1 class="section-title" style="margin-top:8px">Regisztráció</h1>
<form class="form" method="post">@csrf
<label>Név</label><input name="name" value="{{ old('name') }}" required>@error('name')<div class="errors">{{ $message }}</div>@enderror
<label>E-mail cím</label><input type="email" name="email" value="{{ old('email') }}" required>@error('email')<div class="errors">{{ $message }}</div>@enderror
<label>Jelszó</label><input type="password" name="password" required>@error('password')<div class="errors">{{ $message }}</div>@enderror
<label>Jelszó újra</label><input type="password" name="password_confirmation" required>
<button class="pill">Fiók létrehozása</button></form>
@endsection
