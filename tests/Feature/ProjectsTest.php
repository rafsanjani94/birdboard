<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    // test owner
    /** @test */
    public function guests_cannot_create_project()
    {
        $attributes = \factory('App\Project')->raw();

        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_view_project()
    {
        $this->get('/projects')->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_view_a_single_project()
    {
        $project = \factory('App\Project')->create();

        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        // $this->withoutExceptionHandling();
        $this->actingAs(\factory('App\User')->create()); //for login auth

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
        $this->be(\factory('App\User')->create()); //for login auth
        
        $this->withoutExceptionHandling();

        $project = \factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())->assertSee($project->title)->assertSee($project->description); //route
    }

    
    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->be(\factory('App\User')->create()); //for login auth
        
        // $this->withoutExceptionHandling();

        $project = \factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

    // test req. validation
    /** @test */
    public function a_project_requires_a_title()
    {
        // $this->withoutExceptionHandling();
        $this->actingAs(\factory('App\User')->create()); //for login auth

        //ambil dari factory tinker. kenapa '' dianggep validate?
        $attributes = \factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    // test req. validation
    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(\factory('App\User')->create());

        $attributes = \factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
