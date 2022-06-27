@extends('layouts.main')

@section('body')
    <div id="wrapper">
        <div id="sidebar-wrapper" style="background: #f4476b;">
            <ul class="sidebar-nav">
                <li class="sidebar-brand"> 
                    <a href="#" style="color: rgb(40,40,40);">Hi, {{ $name }}</a>
                </li>
                <li > 
                    <form action="/logout" method="POST">
                        @csrf  
                        <input type="submit" style="font-weight:bold;border: none;outline:none;background-color: Transparent;color: rgb(40,40,40);"  value="LOG OUT">
                        
                    </form>

                    
                </li>
                @foreach ($sidebar_items as $key => $val)
                <li> <a href="{{ $val }}" style="color: rgb(40,40,40);">{{ $key }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="page-content-wrapper">
            <div class="container-fluid"><a class="btn btn-link" role="button" id="menu-toggle" href="#menu-toggle"><i class="fa fa-bars"></i></a>
                <div class="row">
                    <div class="col-md-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection