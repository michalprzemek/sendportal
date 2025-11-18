<?php

namespace Tests\Feature;

use App\Models\SubscriptionForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Sendportal\Base\Models\Subscriber;
use Sendportal\Base\Models\Template;
use Tests\TestCase;

class SubscriptionFormsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_create_a_subscription_form()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/forms', [
            'name' => 'My First Form',
            'subscriber_list_id' => 1,
        ]);

        $response->assertRedirect('/forms');
        $this->assertDatabaseHas('subscription_forms', ['name' => 'My First Form']);
    }

    /** @test */
    public function a_public_user_can_subscribe_through_a_form()
    {
        $form = SubscriptionForm::factory()->create();

        $response = $this->post("/f/{$form->uuid}/subscribe", [
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('subscribers', ['email' => 'test@example.com']);
    }

}
