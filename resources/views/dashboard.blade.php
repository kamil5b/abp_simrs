@extends('layouts.side')

@section('content')
<div>
    <h1>Dashboard {{ $title }}</h1>
</div>
<p>{{ $description }}</p>
@if(!isset($no_add))
    @if($route == "records")
        <a href="/{{ $route }}/add/{{ $id }}">
    @else
        <a href="/{{ $route }}/add">
    @endif
    <button class="btn btn-success">
        Add
    </button>
    </a>
@endif
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                @if($edit && $route != "records")
                    <th>Edit</th>
                @endif
                @foreach ($head as $col)
                <th>
                    {{ $col }}
                </th>
                @endforeach
                @if($edit && $route == "records")
                    <th>Details</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    
                    @foreach ($row as $val)
                        @if($edit && $loop->first && $route != "records")
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
                    @if($route == 'records' && $edit)
                        <td>
                            <a href="/{{ $route }}/gate/{{{ $row[0] }}}"><button class='btn btn-primary'>Details</button></a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection