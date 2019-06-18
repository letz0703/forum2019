<reply :attributes="{{ $reply }}" inline-template>
    <div id="reply-{{$reply->id}}" class="card">
        {{--<div><h4 style="padding-left:0.4em;">Replies</h4></div>--}}
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    {{--                <a href="/profiles/{{ $reply->owner->name }}"> {{ $reply->owner->name }} </a> said {{ $reply->created_at->diffForHumans() }}--}}
                    <a href="{{ route('profile', $reply->owner) }}"> {{ $reply->owner->name }} </a>
                    said {{ $reply->created_at->diffForHumans() }}
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
            <div v-if="editing">
                <textarea class="form-control" v-model="body"></textarea>
            </div>
            <div v-else>
                {{ $reply->body }}
            </div>
        </div>
        @can('update')
            <div class="card-footer level">
                <button class="btn btn-outline-dark btn-sm mr-1" @click="editing = true">
                    Edit
                </button>
                <form method="POST" action="/replies/{{ $reply->id }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger btn-sm">delete</button>
                </form>
            </div>
        @endcan
    </div>
</reply>