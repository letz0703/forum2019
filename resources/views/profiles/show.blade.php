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
                            <div class="card-header level">
                        <span class="flex">
                        {{ $thread->title }}
                        </span>
                                {{ $thread->created_at->diffForHumans() }}
                            </div>
                            <div class="card-body">
                                {{ $thread-> body }}
                            </div>

                            {{ $threads->links() }}

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection