@extends('layouts.app')

@section('content')
    <a href="/projects/create">Create a Project</a>

    <ul>
        @forelse ($projects as $project)
        <li>
            <a href="{{ $project->path() }}">{{ $project->title }}</a>
        </li>
        @empty
        <li>No Projects yet</li>
        @endforelse
    </ul>
@endsection
