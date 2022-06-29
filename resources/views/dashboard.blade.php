@extends('layouts.side')

@section('content')
<div>
    <h1>Dashboard {{ $title }}</h1>
</div>
<p>{{ $description }}</p>
@if(!isset($no_add))
    <a href="/{{ $route }}/add">
    <button class="btn btn-success">
        Add
    </button>
    </a>
@endif
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                @if(isset($edit))
                    <th>Edit</th>
                @endif
                @foreach ($head as $col)
                <td>
                    {{ $col }}
                </td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    
                    @foreach ($row as $val)
                        @if(isset($edit) && $loop->first)
                            <td>
                                <a href="/{{ $route }}/edit/{{ $val }}"><button class='btn btn-primary'>Edit</button></a>
                                <a href="/{{ $route }}/delete/{{ $val }}"><button class='btn btn-danger'>Delete</button></a>
                            </td>
                        @endif
                        
                        <td>
                        @if($route == 'peralatan' && $loop->last)
                            @if($val['capt'] == "MENGEMBALIKAN")
                                Sedang dipakai
                            @else
                                Dapat dipakai
                            @endif
                            <br/>
                            <a href="/{{ $route }}/pakai/{{{ $val['id'] }}}"><button class='btn btn-{{{  $val['cls']  }}}'>{{{  $val['capt']  }}}</button></a>
                        @else
                            {{ $val }}   
                        @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection