@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="page-header">
            <h1> {{ $profileUser->name }}
                <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
            </h1>
        </div>
    </div>

@endsection