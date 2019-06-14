@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex"> <a
                                        href="{{ route('profile', $thread->creator) }}"> {{ $thread->creator->name }} </a> posted
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
                    <div class="card-footer">
                        {{--@php--}}
                        {{--$replies = $thread->replies()->paginate(2);--}}
                        {{--@endphp--}}
                        @foreach($replies as $reply)
                            @include('threads.reply')
                        @endforeach
                    </div>
                    <div style="align-self:center;">
                        {{ $replies->links() }}
                    </div>
                </div>

                @if ( auth()->check())
                    <form method="POST" action="{{ $thread->path().'/replies' }}">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control"
                                      placeholder="Have something to say"
                                      rows=5
                            ></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </form>
                @else
                    <p style="text-align:center;">Please <a href="{{ route('login') }}">login to participate</a></p>,
                @endif
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
                        <p>it has {{ $thread->replies_count }}
                            {{ str_plural('comment',$thread->replies_count) }}
                            {{--$thread->replies_count == 1? comment: comments--}}
                            {{--@if ($thread->replies_count == 1)--}}
                            {{--comment--}}
                            {{--@else--}}
                            {{--comments--}}
                            {{--@endif--}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection