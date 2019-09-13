@extends('layouts.app')
@section('header')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection
@section('content')
    <thread-view inline-template :data-locked="{{ $thread->locked }}" :data-replies-count="{{ $thread->replies_count }}">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                                <img src="{{ asset($thread->creator->avatar_path) }}"
                                     alt="{{ $thread->creator->name }}"
                                     width="40" height="40"
                                     class="mr-2"
                                >
                                <span class="flex">
                                    <a href="{{ route('profile', $thread->creator) }}">
                                        {{ $thread->creator->name }}
                                    </a> ( {{ $thread->creator->reputation }} XP )posted
                                    {{ $thread->title }}
                            </span>
                                @can('update',$thread)
                                    <form method="POST" action="{{ $thread->path() }}">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-link btn-sm">Delete Thread</button>
                                    </form>
                                @endcan
                            </div>
                            {{--<a href="/profiles/{{ $thread->creator->name }}">--}}

                        </div>

                        <div class="card-body">
                            {{ $thread-> body }}
                        </div>
                        <replies @removed="repliesCount--" @added="repliesCount++"></replies>
                        {{--@php--}}
                        {{--$replies = $thread->replies()->paginate(2);--}}
                        {{--@endphp--}}
                        {{--@foreach($replies as $reply)--}}
                        {{--@include('threads.reply')--}}
                        {{--@endforeach--}}
                        {{--<div style="align-self:center;">--}}
                        {{--                            {{ $thread->replies()->links() }}--}}
                        {{--</div>--}}
                    </div>

                    {{--@if ( auth()->check())--}}
                    {{--<form method="POST" action="{{ $thread->path().'/replies' }}">--}}
                    {{--@csrf--}}
                    {{--<div class="form-group">--}}
                    {{--<textarea name="body" id="body" class="form-control"--}}
                    {{--placeholder="Have something to say"--}}
                    {{--rows=5--}}
                    {{--></textarea>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                    {{--<button type="submit" class="btn btn-sm btn-primary">Submit</button>--}}
                    {{--</div>--}}
                    {{--</form>--}}
                    {{--@else--}}
                    {{--<p style="text-align:center;">Please <a href="{{ route('login') }}">login to participate</a></p>,--}}
                    {{--@endif--}}
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            This post was published by
                            <a href="#">
                                {{ $thread->creator->name }}
                            </a> and posted on {{ $thread->created_at->diffForHumans() }}
                        </div>

                        <div class="card-body">
                            <p>it has <span v-text="repliesCount"></span>
                                {{--{{ $thread->replies_count }}--}}
                                {{ str_plural('comment',$thread->replies_count) }}
                                {{--$thread->replies_count == 1? comment: comments--}}
                                {{--@if ($thread->replies_count == 1)--}}
                                {{--comment--}}
                                {{--@else--}}
                                {{--comments--}}
                                {{--@endif--}}
                            </p>
                            <p>
                            <div class="level">
                                <subscriptions :active="{{ json_encode($thread->isSubscribedTo) }}"
                                               v-if="signedIn"></subscriptions>
                                <div v-if="! locked">
                                    <button class="btn btn-primary btn-sm ml-1" v-if="authorize('isAdmin')"
                                            @click="locked = true">Lock
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection