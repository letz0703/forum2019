@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('threads._list')
                {{ $threads->render() }}
            </div>
            @if (count($trending))
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Trending Thread
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($trending as $thread)
                                    <a href="{{ url($thread->path) }}">
                                        <li class="list-group-item mb-1">{{ $thread->title}}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection