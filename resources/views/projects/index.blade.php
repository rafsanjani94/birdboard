@extends('layouts.app')

@section('content')
    <div class="flex item-center mb-3 w-full">
        <h2>My Projects</h2>
        <a href="/projects/create" class="btn btn-primary">New Project</a>
    </div>

    <div class="row ml-1">
        @forelse ($projects as $project)
            <div class="bg-white mr-4 rounded shadow p-3 mb-4 col-md-3" style="height: 200px">
                @include('projects.card')
            </div>
        @empty
            <div>No Projects yet</div>
        @endforelse
    </div>
@endsection
