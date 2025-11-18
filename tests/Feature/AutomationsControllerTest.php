<?php

namespace Tests\Feature;

use App\Models\Automation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutomationsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_unauthenticated_user_cannot_view_automations()
    {
        $response = $this->get('/automations');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_view_automations()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/automations');

        $response->assertOk();
    }

    /** @test */
    public function an_authenticated_user_can_create_an_automation()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/automations', [
            'name' => 'My First Automation',
            'subscriber_list_id' => 1,
        ]);

        $response->assertRedirect('/automations');
        $this->assertDatabaseHas('automations', ['name' => 'My First Automation']);
    }

    /** @test */
    public function an_authenticated_user_can_update_an_automation()
    {
        $user = User::factory()->create();
        $automation = Automation::factory()->create();

        $response = $this->actingAs($user)->put("/automations/{$automation->id}", [
            'name' => 'Updated Automation Name',
        ]);

        $response->assertRedirect('/automations');
        $this->assertDatabaseHas('automations', ['name' => 'Updated Automation Name']);
    }

    /** @test */
    public function an_authenticated_user_can_delete_an_automation()
    {
        $user = User::factory()->create();
        $automation = Automation::factory()->create();

        $response = $this->actingAs($user)->delete("/automations/{$automation->id}");

        $response->assertRedirect('/automations');
        $this->assertDatabaseMissing('automations', ['id' => $automation->id]);
    }
}
