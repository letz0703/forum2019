@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <app></app>
            </div>

            <div class="col-md-4">

                @if (count($trending))
                    <div class="card">
                        <div class="card-header">
                            Trending Thread
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($trending as $thread)
                                    <a href="{{ url($thread->path) }}">
                                        <li class="list-group-item">{{ $thread->title}}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
