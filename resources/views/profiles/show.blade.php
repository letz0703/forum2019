@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="page-header">
                    <h1> {{ $profileUser->name }}
                        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>

                @can('update', $profileUser)
                    <!--Add Form Here-->
                        {{--<form action="/profiles/{{ $profileUser->name }}/avatar" method="POST">--}}
                        <form action="{{ route('avatar', $profileUser) }}" method="POST"
                              enctype="multipart/form-data"
                        >
                            @csrf
                            <input type="file" name="avatar">
                            <button type="submit">Add Avatar</button>
                        </form>
                    @endcan

                    <img src="{{ asset($profileUser->avatar_path) }}" width="50" height="50">

                    <hr>
                </div>
                @forelse($activities as $date => $activity)
                    <h3 class="page-header">{{ $date }}</h3>
                    @foreach ($activity as $record)
                        @if (view()->exists("profiles.activities.{$record->type}"))
                            @include ("profiles.activities.{$record->type}",['activity' => $record])
                        @endif
                    @endforeach
                    <hr>
                @empty
                    <h3>No Activity Yet</h3>
                @endforelse

            </div>
            {{--{{ $threads->links() }}--}}
        </div>
    </div>
@endsection