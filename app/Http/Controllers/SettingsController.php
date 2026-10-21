<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function user_settings()
    {
        return view('settings.account_settings');
    }

    public function setting_list()
    {
        return view('settings.system_name');
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:12048',
            'system_name' => 'required|string|max:255',
        ]);

        $photo = $request->file('photo');
        $filename = time() . '_' . Str::random(8) . '.' . $photo->extension();
        $photo->move(public_path('uploads'), $filename);

        $setting = Setting::firstOrNew(['id' => 1]);
        $oldFilename = $setting->photo_filename;

        $setting->fill([
            'photo_filename' => $filename,
            'system_name' => $validated['system_name'],
        ])->save();
        Setting::forgetCurrent();

        if ($oldFilename && is_file(public_path('uploads/' . basename($oldFilename)))) {
            unlink(public_path('uploads/' . basename($oldFilename)));
        }

        return redirect()->back()->with('success', 'Photo uploaded successfully!');
    }
}
