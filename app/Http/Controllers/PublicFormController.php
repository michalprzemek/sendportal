<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionForm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Sendportal\Base\Services\Subscribers\ApiSubscriberService;

class PublicFormController extends Controller
{
    /** @var ApiSubscriberService */
    protected $apiSubscriberService;

    public function __construct(ApiSubscriberService $apiSubscriberService)
    {
        $this->apiSubscriberService = $apiSubscriberService;
    }

    public function subscribe(Request $request, string $uuid): RedirectResponse
    {
        $form = SubscriptionForm::where('uuid', $uuid)->firstOrFail();

        $subscriber = $this->apiSubscriberService->store($form->workspace_id, [
            'email' => $request->input('email'),
            'subscriber_list_id' => $form->subscriber_list_id,
            'subscription_form_id' => $form->id,
        ]);

        if ($form->redirect_after_subscribe_url) {
            return redirect()->to($form->redirect_after_subscribe_url);
        }

        return redirect()->route('sendportal.subscriptions.thankyou');
    }
}
