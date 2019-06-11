<div class="page-body">
    <div class="card">
        <div class="card-header">
            <div class="level">
                        <span class="flex">
                            {{ $profileUser->name }} published a
                            <a href="{{ $activity->subject->path() }}">
                                {{ $activity->subject->title }}
                            </a>
                            thread
                            {{--<a href="{{ route('profile', $thread->creator->name) }}">--}}
                            {{--{{ $thread->creator->name }}</a> posted--}}
                            {{--<a href="{{ $thread->path() }}"> {{ $thread->title }}</a>--}}
                        </span>
                <span>
                                        {{--{{ $thread->created_at->diffForHumans() }}--}}
                                    </span>
            </div>

        </div>
        <div class="card-body">
            {{ $activity->subject->body }}
        </div>
    </div>

</div>