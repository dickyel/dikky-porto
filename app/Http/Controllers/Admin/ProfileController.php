<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', [
            'profile' => SiteProfile::current(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'greeting' => ['required', 'string', 'max:255'],
            'headline' => ['required', 'string', 'max:255'],
            'hire_label' => ['required', 'string', 'max:100'],
            'hire_url' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string'],
            'photo_file' => ['nullable', 'image', 'max:5120'],
            'availability' => ['required', 'string', 'max:255'],
            'about_dark_1' => ['nullable', 'string'],
            'about_mute_1' => ['nullable', 'string'],
            'about_dark_2' => ['nullable', 'string'],
            'about_mute_2' => ['nullable', 'string'],
            'about_cta_label' => ['required', 'string', 'max:255'],
            'services_heading' => ['required', 'string', 'max:255'],
            'services_subtext' => ['nullable', 'string'],
            'services_button_label' => ['required', 'string', 'max:100'],
            'showcase_heading' => ['required', 'string', 'max:255'],
            'contact_eyebrow' => ['required', 'string', 'max:255'],
            'contact_heading' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
        ]);

        $profile = SiteProfile::current();

        if ($request->hasFile('photo_file')) {
            if (
                $profile->photo
                && ! str_starts_with($profile->photo, 'http')
                && str_starts_with($profile->photo, 'profiles/')
                && Storage::disk('public')->exists($profile->photo)
            ) {
                Storage::disk('public')->delete($profile->photo);
            }

            $data['photo'] = $request->file('photo_file')->store('profiles', 'public');
        }

        unset($data['photo_file']);

        $profile->update($data);

        return back()->with('success', 'Profil homepage berhasil diperbarui.');
    }
}
