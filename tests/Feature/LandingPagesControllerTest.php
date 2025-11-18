<?php

namespace Tests\Feature;

use App\Models\LandingPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPagesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_create_a_landing_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/landing-pages', [
            'name' => 'My First Landing Page',
            'slug' => 'my-first-landing-page',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('landing_pages', ['name' => 'My First Landing Page']);
    }

    /** @test */
    public function the_public_landing_page_can_be_viewed()
    {
        LandingPage::factory()->create([
            'name' => 'Test Page',
            'slug' => 'test-slug',
            'html_content' => '<h1>Hello World</h1>',
        ]);

        $response = $this->get('/lp/test-slug');

        $response->assertOk();
        $response->assertSee('<h1>Hello World</h1>', false);
    }

    /** @test */
    public function the_api_endpoint_for_saving_content_works()
    {
        $user = User::factory()->create();
        $landingPage = LandingPage::factory()->create();

        $response = $this->actingAs($user, 'api')->putJson("/api/landing-pages/{$landingPage->id}", [
            'gjs-html' => '<div>Updated Content</div>',
            'gjs-css' => 'body { color: red; }',
            'gjs-js' => 'console.log("hello");',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('landing_pages', [
            'id' => $landingPage->id,
            'html_content' => '<div>Updated Content</div>',
        ]);
    }
}
