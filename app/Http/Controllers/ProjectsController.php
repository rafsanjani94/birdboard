<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return view('projects.index', compact('projects'));
    }

    public function show()
    {
        $project = Project::findOrFail(\request('project'));

        return view('projects.show', compact('project'));
    }

    public function store()
    {
        //validate
        $attributes = \request()->validate([
            'title' => 'required',
            'description' => 'required',
            // 'owner_id' => \auth()->id,
        ]);

        // \dd($attributes);

        //insert hasMany
        \auth()->user()->projects()->create(
            $attributes
        );

        //presist
        // Project::create($attributes);

        //redirect
        return redirect('/projects');
    }
}
