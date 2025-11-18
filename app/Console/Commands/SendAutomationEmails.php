<?php

namespace App\Console\Commands;

use App\Jobs\SendAutomationEmail;
use App\Models\Automation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Sendportal\Base\Models\Subscriber;

class SendAutomationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'automations:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails for all automations';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $automations = Automation::with('emails')->get();

        foreach ($automations as $automation) {
            foreach ($automation->emails as $email) {
                $sentSubscriberIds = DB::table('automation_email_subscriber')
                    ->where('automation_email_id', $email->id)
                    ->pluck('subscriber_id');

                $threshold = Carbon::now()->subHours($email->delay_in_hours);

                $subscribers = Subscriber::where('subscriber_list_id', $automation->subscriber_list_id)
                    ->whereNotIn('id', $sentSubscriberIds)
                    ->where('created_at', '<=', $threshold)
                    ->get();

                foreach ($subscribers as $subscriber) {
                    dispatch(new SendAutomationEmail($subscriber, $email));
                }
            }
        }

        $this->info('Automation emails have been dispatched.');

        return 0;
    }
}
