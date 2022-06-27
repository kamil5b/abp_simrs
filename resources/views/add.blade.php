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
        @foreach ($data as $row)
            <div class="mb-3">
                @if($method == "edit")
                    @if($row["type"] == "select")
                        <select class="form-select" name={{ $row["name"] }} required>
                            <option value="" selected disabled>{{ $row["placeholder"] }}</option>
                            @foreach($row["options"] as $key => $val)
                                <option value={{ $key }} {{ $key == $row["value"] ? 'selected' : '' }} >{{ $val }}</option>
                            @endforeach
                        </select>
                    @elseif($row["type"] == "textarea")
                        <textarea class="form-control" name={{ $row["name"] }} value={{ $row["value"] }} rows="3"></textarea>
                    @else
                        <input class="form-control" type={{ $row["type"] }} name={{ $row["name"] }} value={{ $row["value"] }}>
                    @endif
                @else
                    @if($row["type"] == "select")
                        <select class="form-select" name={{ $row["name"] }} required>
                            <option value="" selected disabled>{{ $row["placeholder"] }}</option>
                            @foreach($row["options"] as $key => $val)
                                <option value={{ $key }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    @elseif($row["type"] == "textarea")
                        <textarea class="form-control" name={{ $row["name"] }} placeholder={{ $row["placeholder"] }} rows="3"></textarea>
                    @else
                        <input class="form-control" type={{ $row["type"] }} name={{ $row["name"] }} placeholder={{ $row["placeholder"] }}>
                    @endif
                @endif
            </div>
        @endforeach
        <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit" name="submit">Add</button></div>
        <a class="forgot" href="/{{ $route }}">Back to Dashboard</a>
    </form>
</section>

@endsection