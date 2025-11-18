<?php

namespace App\Services\Forms;

use App\Models\SubscriptionForm;

class FormGeneratorService
{
    public function generate(SubscriptionForm $form): string
    {
        $actionUrl = route('forms.subscribe', $form->uuid);

        $html = <<<HTML
<form action="{$actionUrl}" method="POST">
    <div style="display:none;">
        <label for="honeypot">Keep this field blank</label>
        <input type="text" name="honeypot" id="honeypot" tabindex="-1" autocomplete="off">
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
    </div>
    <button type="submit">Subscribe</button>
</form>
HTML;

        return $html;
    }
}
