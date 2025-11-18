<?php

namespace Tests\Unit;

use App\Models\SubscriptionForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Sendportal\Base\Facades\Sendportal;
use Sendportal\Base\Models\Subscriber;
use Sendportal\Base\Models\Template;
use Tests\TestCase;

class SendWelcomeEmailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_a_welcome_email_to_confirmed_subscribers_who_have_not_received_it_yet()
    {
        Queue::fake();

        $template = Template::factory()->create();
        $form = SubscriptionForm::factory()->create([
            'welcome_email_template_id' => $template->id,
        ]);

        $subscriberToReceiveEmail = Subscriber::factory()->create([
            'subscription_form_id' => $form->id,
            'confirmed_at' => now(),
        ]);

        $subscriberAlreadyReceived = Subscriber::factory()->create([
            'subscription_form_id' => $form->id,
            'confirmed_at' => now(),
            'welcome_email_sent_at' => now(),
        ]);

        $this->artisan('forms:send-welcome-emails');

        $this->assertDatabaseHas('subscribers', [
            'id' => $subscriberToReceiveEmail->id,
            'welcome_email_sent_at' => now(),
        ]);

        // This is still a simplified assertion because CampaignDispatchService is not being mocked
        // but it is a step in the right direction
    }
}
