<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        // $projects = Project::all();

        // get many project from user auth
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    /**
     * show function
     *
     * @param Project $project: findOrfail Model By id : {project}
     * @return void
     */
    public function show(Project $project)
    {
        //cek user id dengan owner_id
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
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
