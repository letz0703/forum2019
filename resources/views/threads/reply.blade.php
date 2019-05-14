<div class="card">
    {{--<div><h4 style="padding-left:0.4em;">Replies</h4></div>--}}
    <div class="card-header">
        <a href="#">
            {{ $reply->owner->name }}
        </a>
        said {{ $reply->created_at->diffForHumans() }}
    </div>
    <div class="card-body">
        {{ $reply-> body }}
    </div>
</div>