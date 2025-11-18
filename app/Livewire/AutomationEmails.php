<?php

namespace App\Livewire;

use App\Models\Automation;
use App\Models\AutomationEmail;
use Livewire\Component;
use Sendportal\Base\Facades\Sendportal;
use Sendportal\Base\Repositories\TemplateRepository;

class AutomationEmails extends Component
{
    public Automation $automation;
    public $emails;
    public $templates;

    public function mount(Automation $automation, TemplateRepository $templateRepository)
    {
        $this->automation = $automation;
        $this->emails = $automation->emails->toArray();
        $this->templates = $templateRepository->all(Sendportal::currentWorkspaceId());
    }

    public function render()
    {
        return view('livewire.automation-emails');
    }

    public function addEmail()
    {
        $this->emails[] = [
            'template_id' => $this->templates->first()->id,
            'delay_in_hours' => 0,
        ];
    }

    public function removeEmail($index)
    {
        $email = $this->emails[$index];

        if (isset($email['id'])) {
            AutomationEmail::find($email['id'])->delete();
        }

        unset($this->emails[$index]);
    }

    public function save()
    {
        foreach ($this->emails as $emailData) {
            if (isset($emailData['id'])) {
                $email = AutomationEmail::find($emailData['id']);
                $email->update($emailData);
            } else {
                $this->automation->emails()->create($emailData);
            }
        }

        $this->emails = $this->automation->emails()->get()->toArray();

        $this->dispatch('saved');
    }
}
