{{--Editing the question--}}
<div class="card" v-if="editing">
    <div class="card-header">
        <div class="level">
            <input type="text" class="form-control" v-model="form.title">
        </div>
    </div>
    <div class="card-body" class="form-group">
        <textarea class="form-control" rows="10" v-model="form.body">{{ $thread->body }}</textarea>
    </div>
    <div class="card-footer">
        <div class="level">
            <button class="btn-sm btn-outline-dark mr-2"
                    @click="editing = false" v-show="!editing">Edit
            </button>
            <button class="btn-sm btn-outline-dark mr-2"
                    @click="update">Update
            </button>
            <button class="btn-sm btn-outline-dark"
                    @click="reset">Cancel
            </button>
            @can('update',$thread)
                <form method="POST" action="{{ $thread->path() }}" class="ml-auto">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-link btn-sm">Delete Thread</button>
                </form>
            @endcan
        </div>
        {{--<button class="btn-sm btn-outline-dark" @click="this.editing = false">Cancel</buttoccn>--}}

    </div>
</div>

{{--Viewing--}}
<div class="card" v-else>
    <div class="card-header">
        <div class="level">
            <img src="{{ asset($thread->creator->avatar_path) }}"
                 alt="{{ $thread->creator->name }}"
                 width="40"
                 height="40"
                 class="mr-2"
            >
            <span class="flex">
                <a href="{{ route('profile', $thread->creator) }}">
                    {{ $thread->creator->name }}
                </a> ( {{ $thread->creator->reputation }} XP )posted
                <div v-text="form.title"></div>
                {{--{{ $thread->title }}--}}
            </span>
        </div>
    </div>
    <div class="card-body" v-text="form.body">
        {{--{{ $thread-> body }}--}}
    </div>
    <div class="card-footer">
        <div class="level">
            <button class="btn-sm btn-outline-dark" @click="editing = true">Edit</button>
            @can('update',$thread)
                <form method="POST" action="{{ $thread->path() }}" class="ml-auto">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-link btn-sm">Delete Thread</button>
                </form>
            @endcan
        </div>
    </div>
    {{--<button class="btn btn-outline-dark btn-sm" @click="edit = true"--}}
    {{--> Edit </button>--}}
</div>
