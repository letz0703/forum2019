@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <ul class="nav flex-column nav-stacked" aria-orientation="vertical" id="v-menu">
                    <li role="presentation"><a class="nav-link"  href="{{route('admin.dashboard.index')}}">Dashboard</a></li>
                    <li role="presentation"><a class="nav-link" href="{{route('admin.channels.index')}}">Channels</a></li>
                </ul>
            </div>
            <div class="col-md-10">
                <div class="card card-default">
                    <div class="card-body">
                        @yield('administration-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
