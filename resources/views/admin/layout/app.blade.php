@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <ul class="nav nav-pills nav-stacked">
                    <li role="presentation"><a href="{{route('admin.dashboard.index')}}">Dashboard</a></li>
                    <li role="presentation"><a href="{{route('admin.channels.index')}}">Channels</a></li>
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
