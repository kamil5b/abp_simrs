@extends('layouts.main')

@section('body')

<section class="login-clean">
    <form action="/{{ $route }}/{{ $method }}" method="post">
        @csrf
        <h2>{{ $title }}</h2>
        <div class="illustration"><i class="icon ion-medkit"></i></div>
        @if(isset($id))
            <input type="hidden" name="id" value={{ $id }}>
        @endif
        <div class="mb-3">
            <input class="form-control" type="password" name="key" placeholder="Key">
                    
        </div>
        <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit" name="submit">Submit Key</button></div>
        <a class="forgot" href="/{{ $route }}">Back to Dashboard</a>
    </form>
</section>

@endsection