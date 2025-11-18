<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionForm;
use App\Services\Forms\FormGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Sendportal\Base\Facades\Sendportal;
use Sendportal\Base\Repositories\SubscriberListRepository;
use Sendportal\Base\Repositories\TemplateRepository;

class SubscriptionFormsController extends Controller
{
    /** @var FormGeneratorService */
    protected $formGenerator;

    public function __construct(FormGeneratorService $formGenerator)
    {
        $this->formGenerator = $formGenerator;
    }

    public function index(): View
    {
        $forms = SubscriptionForm::where('workspace_id', Sendportal::currentWorkspaceId())->get();

        return view('forms.index', compact('forms'));
    }

    public function create(SubscriberListRepository $subscriberListRepository, TemplateRepository $templateRepository): View
    {
        $subscriberLists = $subscriberListRepository->all(Sendportal::currentWorkspaceId());
        $templates = $templateRepository->all(Sendportal::currentWorkspaceId());

        return view('forms.create', compact('subscriberLists', 'templates'));
    }

    public function store(Request $request): RedirectResponse
    {
        $form = SubscriptionForm::create(array_merge($request->all(), [
            'workspace_id' => Sendportal::currentWorkspaceId(),
        ]));

        $form->html_content = $this->formGenerator->generate($form);
        $form->save();

        return redirect()->route('forms.index');
    }

    public function edit(int $id, SubscriberListRepository $subscriberListRepository, TemplateRepository $templateRepository): View
    {
        $form = SubscriptionForm::findOrFail($id);
        $subscriberLists = $subscriberListRepository->all(Sendportal::currentWorkspaceId());
        $templates = $templateRepository->all(Sendportal::currentWorkspaceId());

        return view('forms.edit', compact('form', 'subscriberLists', 'templates'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $form = SubscriptionForm::findOrFail($id);
        $form->update($request->all());

        $form->html_content = $this->formGenerator->generate($form);
        $form->save();

        return redirect()->route('forms.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        SubscriptionForm::destroy($id);

        return redirect()->route('forms.index');
    }
}
