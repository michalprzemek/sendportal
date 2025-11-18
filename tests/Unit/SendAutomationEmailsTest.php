<?php

namespace Tests\Unit;

use App\Jobs\SendAutomationEmail;
use App\Models\Automation;
use App\Models\AutomationEmail;
use App\Models\SubscriberList;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Sendportal\Base\Models\Subscriber;
use Tests\TestCase;

class SendAutomationEmailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_dispatches_a_job_for_subscribers_who_should_receive_an_email_and_have_not_received_it_yet()
    {
        Queue::fake();

        $list = SubscriberList::factory()->create();

        $automation = Automation::factory()->create([
            'subscriber_list_id' => $list->id,
        ]);

        $email = AutomationEmail::factory()->create([
            'automation_id' => $automation->id,
            'delay_in_hours' => 24,
        ]);

        $subscriberToReceiveEmail = Subscriber::factory()->create([
            'subscriber_list_id' => $list->id,
            'created_at' => Carbon::now()->subHours(25),
        ]);

        $subscriberAlreadyReceived = Subscriber::factory()->create([
            'subscriber_list_id' => $list->id,
            'created_at' => Carbon::now()->subHours(25),
        ]);

        DB::table('automation_email_subscriber')->insert([
            'automation_email_id' => $email->id,
            'subscriber_id' => $subscriberAlreadyReceived->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->artisan('automations:send');

        Queue::assertPushed(SendAutomationEmail::class, function ($job) use ($subscriberToReceiveEmail, $email) {
            return $job->subscriber->id === $subscriberToReceiveEmail->id && $job->email->id === $email->id;
        });

        Queue::assertNotPushed(SendAutomationEmail::class, function ($job) use ($subscriberAlreadyReceived) {
            return $job->subscriber->id === $subscriberAlreadyReceived->id;
        });
    }
}
