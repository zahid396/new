<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StoreSettingController extends Controller
{
    public function index(): View
    {
        $settings = [
            'store_name' => StoreSetting::get('store_name', ''),
            'store_logo' => StoreSetting::get('store_logo', ''),
            'store_favicon' => StoreSetting::get('store_favicon', ''),
            'about_text' => StoreSetting::get('about_text', ''),
            'contact_email' => StoreSetting::get('contact_email', ''),
            'contact_phone' => StoreSetting::get('contact_phone', ''),
            'copyright_text' => StoreSetting::get('copyright_text', ''),
            'footer_text' => StoreSetting::get('footer_text', ''),
        ];

        return view('admin.store-settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'store_name' => 'required|max:255',
            'store_logo' => 'nullable|image|max:2048',
            'store_favicon' => 'nullable|image|max:1024',
            'about_text' => 'nullable',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|max:20',
            'copyright_text' => 'nullable|max:500',
            'footer_text' => 'nullable',
        ]);

        if ($request->hasFile('store_logo')) {
            $oldLogo = StoreSetting::get('store_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete('store/' . $oldLogo);
            }

            $file = $request->file('store_logo');
            $filename = time() . '_logo.' . $file->getClientOriginalExtension();
            $file->storeAs('store', $filename, 'public');
            $validated['store_logo'] = $filename;
        } else {
            unset($validated['store_logo']);
        }

        if ($request->hasFile('store_favicon')) {
            $oldFavicon = StoreSetting::get('store_favicon');
            if ($oldFavicon) {
                Storage::disk('public')->delete('store/' . $oldFavicon);
            }

            $file = $request->file('store_favicon');
            $filename = time() . '_favicon.' . $file->getClientOriginalExtension();
            $file->storeAs('store', $filename, 'public');
            $validated['store_favicon'] = $filename;
        } else {
            unset($validated['store_favicon']);
        }

        foreach ($validated as $key => $value) {
            StoreSetting::set($key, $value);
        }

        return redirect()->route('admin.store-settings.index')->with('success', 'Store settings updated successfully.');
    }
}
