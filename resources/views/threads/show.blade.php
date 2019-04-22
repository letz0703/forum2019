@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">
                            {{ $thread->creator->name }}
                        </a> posted
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        {{ $thread-> body }}
                    </div>
                </div>
            </div>
        </div>
        @if ( auth()->check())
            <div class="row justify-content-center">
                <div class="col-md-8 col-md-offset-2">
                    <form method="POST" action="{{ $thread->path().'/replies' }}">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control"
                                      placeholder="Have something to say"
                                      rows=5
                            ></textarea>
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <p style="text-align:center;">Please <a href="{{ route('login') }}">login to participate</a></p>,
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>
    </div>
@endsection