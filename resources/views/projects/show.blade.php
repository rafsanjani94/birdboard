@extends('layouts.app')

@section('content')
    <div class="flex item-center mb-3 w-full">
        <p>
            <a href="/projects">My Projects</a> / {{ $project->title }}
        </p>
        <a href="/projects/create" class="btn btn-primary">New Project</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <h5 class="text-muted">Task</h5>

                @foreach ($project->tasks as $task)
                    <div class="bg-white rounded shadow p-3 mb-4" style="height: 50px">
                        <form action="{{ $project->path() . '/tasks/' . $task->id }}" method="post">
                            @method('PATCH')
                            @csrf

                            <input type="text" name="body" value="{{ $task->body }}" style="width: 95%;" class="{{ $task->completed ? 'text-muted' : '' }}">
                            <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                        </form>
                    </div>
                @endforeach

                <form action="{{ $project->path() . '/tasks' }}" method="POST">
                    @csrf

                    <input type="text" class="form-control shadow" name="body" placeholder="Add New Task ...">
                </form>
            </div>

            <div>
                <h5 class="text-muted">General Notes</h5>

                <textarea style="height: 200px" class="form-control shadow">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nam omnis sed veritatis veniam corporis rem dolore mollitia quibusdam placeat temporibus? Nesciunt repellendus voluptatum quod eligendi alias minus quam itaque vitae!</textarea>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bg-white mr-4 rounded shadow p-3 mb-4" style="height: 200px">
                @include('projects.card')
            </div>
        </div>
    </div>
@endsection
