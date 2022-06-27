@extends('layouts.main')

@section('body')
<section class="login-clean">
    <form method="post" action="/login">
        @csrf
        <center><h2>SIMRS Login</h2></center>
        <div class="illustration">
            <i class="icon ion-medkit"></i></div>
        <div class="mb-3">
            <input class="form-control" type="text" name="nomor_hp" placeholder="Nomor Telepon"></div>
        <div class="mb-3">
            <input class="form-control" type="password" name="password" placeholder="Password"></div>
        <div class="mb-3">
            <button class="btn btn-primary d-block w-100" type="submit" name="submit">Login</button></div>
            <a class="forgot" href="/register">Register</a>
    </form>
</section>
@endsection