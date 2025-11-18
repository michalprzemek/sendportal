<?php

namespace App\Jobs;

use App\Models\AutomationEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Sendportal\Base\Models\Subscriber;
use Sendportal\Base\Services\Campaigns\CampaignDispatchService;

class SendAutomationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Subscriber */
    protected $subscriber;

    /** @var AutomationEmail */
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber, AutomationEmail $email)
    {
        $this->subscriber = $subscriber;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CampaignDispatchService $campaignDispatchService)
    {
        $campaignDispatchService->dispatch($this->subscriber, $this->email->template, $this->subscriber->workspace_id);

        DB::table('automation_email_subscriber')->insert([
            'automation_email_id' => $this->email->id,
            'subscriber_id' => $this->subscriber->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
