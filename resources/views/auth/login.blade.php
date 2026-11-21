@extends('layout')
@section('content')
<div class="eyebrow">Üdv újra</div><h1 class="section-title" style="margin-top:8px">Bejelentkezés</h1>
<form class="form" method="post">@csrf @error('email')<div class="errors">{{ $message }}</div>@enderror
<label>E-mail cím</label><input type="email" name="email" value="{{ old('email') }}" required>
<label>Jelszó</label><input type="password" name="password" required>
<label><input style="width:auto" type="checkbox" name="remember"> Emlékezz rám</label>
<button class="pill">Belépés</button></form>
@endsection
