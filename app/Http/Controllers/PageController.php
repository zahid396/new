<?php

namespace App\Http\Controllers;

use App\Models\LegalPage;
use App\Models\StoreSetting;

class PageController extends Controller
{
    public function privacyPolicy()
    {
        $page = LegalPage::getBySlug('privacy-policy');

        if (!$page) {
            abort(404);
        }

        return view('pages.legal', compact('page'));
    }

    public function terms()
    {
        $page = LegalPage::getBySlug('terms');

        if (!$page) {
            abort(404);
        }

        return view('pages.legal', compact('page'));
    }

    public function refundPolicy()
    {
        $page = LegalPage::getBySlug('refund-policy');

        if (!$page) {
            abort(404);
        }

        return view('pages.legal', compact('page'));
    }

    public function about()
    {
        $settings = StoreSetting::pluck('value', 'key');

        return view('pages.about', compact('settings'));
    }
}
