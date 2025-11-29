<?php

namespace App\Addons\Faq\Controllers\Admin;

use App\Models\Admin\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FaqSettingsController extends Controller
{
    public function __construct()
    {
        if (request()->isXmlHttpRequest()) {
            $this->middleware('web');
        }
    }

    public function settings()
    {
        return redirect()->route('admin.faq.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'faq_usefulness_enabled' => ['nullable'],
        ]);

        Setting::updateSettings([
            'faq_usefulness_enabled' => $request->has('faq_usefulness_enabled'),
        ]);

        return redirect()->back()->with('success', __('admin.flash.updated'));
    }
}
