@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 align-items-center">
                <div class="page-header">
                    <h1> {{ $profileUser->name }}
                        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>
                    <hr>
                </div>
                @foreach($threads as $thread)
                    <div class="page-body">
                        <div class="card">
                            <div class="card-header">
                                <div class="level">
                        <span class="flex">
                            <a href="{{ route('profile', $thread->creator->name) }}">
                            {{ $thread->creator->name }}</a> posted
                            <a href="{{ $thread->path() }}"> {{ $thread->title }}</a>
                        </span>
                                    <span>{{ $thread->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="card-body">
                                    {{ $thread-> body }}
                                </div>
                            </div>

                        </div>
                        {{ $threads->links() }}

                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection