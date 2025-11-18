<?php

namespace App\Console\Commands;

use App\Models\SubscriptionForm;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Sendportal\Base\Models\Subscriber;
use Sendportal\Base\Services\Campaigns\CampaignDispatchService;

class SendWelcomeEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forms:send-welcome-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send welcome emails to newly confirmed subscribers.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(CampaignDispatchService $campaignDispatchService)
    {
        $subscribers = Subscriber::whereNotNull('confirmed_at')
            ->whereNull('welcome_email_sent_at')
            ->whereNotNull('subscription_form_id')
            ->get();

        foreach ($subscribers as $subscriber) {
            $form = SubscriptionForm::find($subscriber->subscription_form_id);

            if ($form && $form->welcome_email_template_id) {
                $campaignDispatchService->dispatch($subscriber, $form->welcome_email_template, $subscriber->workspace_id);
                $subscriber->update(['welcome_email_sent_at' => now()]);
            }
        }

        return 0;
    }
}
