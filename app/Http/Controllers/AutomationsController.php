<?php

namespace App\Http\Controllers;

use App\Repositories\AutomationsRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Sendportal\Base\Facades\Sendportal;
use Sendportal\Base\Repositories\SubscriberListRepository;

class AutomationsController extends Controller
{
    /** @var AutomationsRepository */
    protected $automations;

    public function __construct(AutomationsRepository $automations)
    {
        $this->automations = $automations;
    }

    public function index(): View
    {
        $automations = $this->automations->all();

        return view('automations.index', compact('automations'));
    }

    public function create(SubscriberListRepository $subscriberListRepository): View
    {
        $subscriberLists = $subscriberListRepository->all(Sendportal::currentWorkspaceId());

        return view('automations.create', compact('subscriberLists'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->automations->create($request->all());

        return redirect()->route('automations.index');
    }

    public function edit(int $id): View
    {
        $automation = $this->automations->find($id);

        return view('automations.edit', compact('automation'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $this->automations->update($id, $request->all());

        return redirect()->route('automations.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->automations->delete($id);

        return redirect()->route('automations.index');
    }
}
