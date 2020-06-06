<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    // test owner
    /** @test */
    public function guests_cannot_manage_project()
    {
        $project = \factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.'
        ];

        //route, bisa juga assert redirect
        $response = $this->post('/projects', $attributes);

        $project = \App\Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {

        $this->signIn();
        $this->withoutExceptionHandling();

        $project = \factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->patch($project->path(), [
            'notes' => 'Changed'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', ['notes' => 'Changed']);
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = \factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())->assertSee($project->title)->assertSee($project->description); //route
    }


    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = \factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = \factory('App\Project')->create();

        $this->patch($project->path(), [])->assertStatus(403);
    }

    // test req. validation
    /** @test */
    public function a_project_requires_a_title()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();

        //ambil dari factory tinker. kenapa '' dianggep validate?
        $attributes = \factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    // test req. validation
    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = \factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
