@extends('admin.layout.app')
@section('administration-content')
    <p>
        <a href="{{ route('admin.channels.create') }}" class="btn btn-primary btn-sm">New Channel<sup>+</sup></a>
    </p>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Slug</th>
            <th>Description</th>
            <th>Threads</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($channels as $channel)
            <tr>
                <td>{{ $channel->name }}</td>
                <td>{{ $channel->slug }}</td>
                <td>{{ $channel->description }}</td>
                <td>{{ count($channel->threads) }}</td>
                <td>
                    <a href="{{ route('admin.channels.edit',$channel->slug) }}"
                       class="btn btn-sm">Edit
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td>Nothing here.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
