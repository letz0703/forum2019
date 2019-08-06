@forelse($threads as $thread)
    <div class="card mb-2">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <h5>
                        <a href="{{ $thread->path() }}">
                            @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                {{ $thread->title }}
                            @else
                                <span style="color:grey;">
                                                {{ $thread->title }}
                                                </span>
                            @endif
                        </a>
                    </h5>
                    <h5>Posted By:
                        <a href="{{ route('profile', $thread->creator->name) }}"> {{ $thread->creator->name }} </a>
                    </h5>
                </div>
                <a href="{{ $thread->path() }}">
                    {{ $thread->replies_count }}
                    {{ str_plural('reply',$thread->replies_count) }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="body">{{ $thread->body }}</div>
        </div>
        <div class="card-footer">
            {{ $thread->visits()}} Visits
        </div>
    </div>
@empty
    <p> There is no relevant article right now</p>
@endforelse