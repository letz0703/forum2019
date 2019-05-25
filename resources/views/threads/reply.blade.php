<div class="card">
    {{--<div><h4 style="padding-left:0.4em;">Replies</h4></div>--}}
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="#"> {{ $reply->owner->name }} </a> said {{ $reply->created_at->diffForHumans() }}
            </h5>
            <form action="/replies/{{ $reply->id }}/favorites" method="POST">
                @csrf

                <button type="submit" class="btn btn-default btn-sm" {{ $reply->isFavorited()? 'disabled': '' }}>
                    {{$reply->favorites_count}} {{ str_plural('favorite', $reply->favorites_count) }}
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        {{ $reply-> body }}
    </div>
</div>