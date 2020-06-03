<h3 class="font-normal text-xl py-2 -ml-5 border-left border-blue-100 pl-4">
    <a href="{{ $project->path() }}">{{ $project->title }}</a>
</h3>

<div class="text-muted">{{ Illuminate\Support\Str::limit($project->description, 150) }}</div>
