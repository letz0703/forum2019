@extends('layouts.app')
@section ('header')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a Thread</div>

                    <div class="card-body">
                        <form action="/threads" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="channel_id">Channel :</label>
                                <select name="channel_id" id="channel_id" class="form-control">
                                    <option value="">Choose One ...</option>
                                    {{--                                    @foreach(App\Channel::all() as $channel)--}}
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected': '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{ old('title') }}">
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <wysiwyg name="body"></wysiwyg>
{{--                                <textarea name="body" id="body" class="form-control" rows=8>{{ old('body') }}</textarea>--}}
                            </div>

                            {{--                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.sitekey') }}"></div>--}}
                            <div>
                                <div class="g-recaptcha" data-sitekey="{{ config('forum2019.recaptcha.key') }}"></div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>
                            @if (count($errors))
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
