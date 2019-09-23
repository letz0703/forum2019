@csrf
<div class="form-group">
    <label for="name">Channel Name:</label>
    <input type="text" class="form-control" id="name" name="name"
           value="{{ old('name', $channel->name) }}" required>
</div>
<div class="form-group">
    <label for="description">Description:</label>
    <input type="text" class="form-control" id="description" name="description"
           value="{{ old('description', $channel->description) }}"
           required>
</div>
{{--<div class="form-group form-check">--}}
{{--    <input type="checkbox" class="form-check-input" id="archived" name="archived" placeholder="Archived"--}}
{{--           value="" required>--}}
{{--    <label class="form-check-label" for="archive">Archive it</label>--}}
{{--</div>--}}
<div class="form-group">
    <button type="submit" class="btn btn-link btn-sm">
        {{ $buttonText?:'Add Channel' }}
    </button>
</div>

@if (count($errors))
    <ul class="alert alert-danger">
        @foreach( $errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

