<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
            'description' => $this->faker->paragraph,
        ];

        //route, bisa juga assert redirect
        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']); //route
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