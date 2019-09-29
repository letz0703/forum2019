@extends('layouts.app')
@section('header')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection
@section('content')
    <thread-view inline-template :thread="{{ $thread }}" v-cloak>
        <div class="container">
            <div class="row">
                <div class="col-md-8" v-cloak>

                    @include('threads._question')

                    <replies @removed="repliesCount--" @added="repliesCount++"></replies>
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
                                <div>
                                    <button class="btn btn-primary btn-sm ml-1" v-if="authorize('isAdmin')"
                                            @click="toggleLock" v-text="locked?'Unlock': 'Lock'">
                                    </button>
                                    <button class="btn btn-primary btn-sm ml-1" v-if="authorize('isAdmin')"
                                            @click="togglePin" v-text="pinned?'UnPin':'Pin'">
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