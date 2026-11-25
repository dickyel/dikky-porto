@extends('layouts.admin')

@section('title', 'Profile / Hero — Dikky Admin')

@section('content')
  <div class="admin-top">
    <div>
      <p class="eyebrow">Content</p>
      <h1>Profil & Hero</h1>
      <p class="admin-lead">Foto profil bisa diupload dari komputer.</p>
    </div>
  </div>

  <div class="form-card">
    <form method="POST" action="{{ route('admin.profile.update') }}" class="form-grid" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <label><span>Greeting</span><input type="text" name="greeting" value="{{ old('greeting', $profile->greeting) }}" required /></label>
      <label><span>Hire label</span><input type="text" name="hire_label" value="{{ old('hire_label', $profile->hire_label) }}" required /></label>
      <label class="full"><span>Headline (pakai Enter untuk baris baru)</span><textarea name="headline" required>{{ old('headline', $profile->headline) }}</textarea></label>
      <label><span>Hire URL</span><input type="text" name="hire_url" value="{{ old('hire_url', $profile->hire_url) }}" required /></label>
      <label class="full"><span>Upload foto profil</span><input type="file" name="photo_file" accept="image/*" /></label>

      @if($profile->photo)
        <div class="full upload-preview">
          <p>Foto saat ini:</p>
          <img src="{{ media_url($profile->photo) }}" alt="Foto profil" />
        </div>
      @endif

      <label class="full"><span>Bio</span><textarea name="bio" required>{{ old('bio', $profile->bio) }}</textarea></label>
      <label class="full"><span>Availability</span><input type="text" name="availability" value="{{ old('availability', $profile->availability) }}" required /></label>

      <label class="full"><span>About dark 1</span><input type="text" name="about_dark_1" value="{{ old('about_dark_1', $profile->about_dark_1) }}" /></label>
      <label class="full"><span>About mute 1</span><input type="text" name="about_mute_1" value="{{ old('about_mute_1', $profile->about_mute_1) }}" /></label>
      <label class="full"><span>About dark 2</span><input type="text" name="about_dark_2" value="{{ old('about_dark_2', $profile->about_dark_2) }}" /></label>
      <label class="full"><span>About mute 2</span><input type="text" name="about_mute_2" value="{{ old('about_mute_2', $profile->about_mute_2) }}" /></label>
      <label class="full"><span>About CTA label</span><input type="text" name="about_cta_label" value="{{ old('about_cta_label', $profile->about_cta_label) }}" required /></label>

      <label class="full"><span>Services heading</span><textarea name="services_heading" required>{{ old('services_heading', $profile->services_heading) }}</textarea></label>
      <label class="full"><span>Services subtext</span><textarea name="services_subtext">{{ old('services_subtext', $profile->services_subtext) }}</textarea></label>
      <label><span>Services button</span><input type="text" name="services_button_label" value="{{ old('services_button_label', $profile->services_button_label) }}" required /></label>
      <label><span>Showcase heading</span><textarea name="showcase_heading" required>{{ old('showcase_heading', $profile->showcase_heading) }}</textarea></label>

      <label><span>Contact eyebrow</span><input type="text" name="contact_eyebrow" value="{{ old('contact_eyebrow', $profile->contact_eyebrow) }}" required /></label>
      <label><span>Contact email</span><input type="email" name="contact_email" value="{{ old('contact_email', $profile->contact_email) }}" required /></label>
      <label class="full"><span>Contact heading</span><textarea name="contact_heading" required>{{ old('contact_heading', $profile->contact_heading) }}</textarea></label>

      <div class="form-actions full">
        <button class="btn btn-accent" type="submit">Simpan profil</button>
      </div>
    </form>
  </div>
@endsection
