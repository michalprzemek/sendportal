<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Sendportal\Base\Facades\Sendportal;

class LandingPagesController extends Controller
{
    public function index(): View
    {
        $landingPages = LandingPage::where('workspace_id', Sendportal::currentWorkspaceId())->get();

        return view('landing-pages.index', compact('landingPages'));
    }

    public function create(): View
    {
        return view('landing-pages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $landingPage = LandingPage::create(array_merge($request->all(), [
            'workspace_id' => Sendportal::currentWorkspaceId(),
        ]));

        return redirect()->route('landing-pages.editor', $landingPage->id);
    }

    public function edit(int $id): View
    {
        $landingPage = LandingPage::findOrFail($id);

        return view('landing-pages.edit', compact('landingPage'));
    }

    public function editor(int $id): View
    {
        $landingPage = LandingPage::findOrFail($id);

        return view('landing-pages.editor', compact('landingPage'));
    }

    public function showPublic(string $slug): View
    {
        $landingPage = LandingPage::where('slug', $slug)->firstOrFail();

        return view('landing-pages.public', compact('landingPage'));
    }

    public function updateContent(Request $request, int $id)
    {
        $landingPage = LandingPage::findOrFail($id);

        $landingPage->update([
            'html_content' => $request->input('gjs-html'),
            'css_content' => $request->input('gjs-css'),
            'js_content' => $request->input('gjs-js'),
        ]);

        return response()->json(['success' => true]);
    }
}
