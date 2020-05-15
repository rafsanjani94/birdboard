@extends('layouts.app')

@section('content')

    <form action="/projects" method="post">
        @csrf

        <h1 class="heading is-1">Create a Project</h1>

        <div class="field">
            <label class="label">Title</label>
            <p class="control">
                <input class="input" type="text" name="title" placeholder="Title">
            </p>
        </div>

        <div class="field">
            <label class="label">Description</label>
            <p class="control">
                <textarea class="textarea" name="description" placeholder="Description"></textarea>
            </p>
        </div>

        <div class="field">
            <p class="control">
                <button class="button is-primary" type="submit">Submit</button>
                <a href="/projects">Back</a>
            </p>
        </div>
    </form>

@endsection
