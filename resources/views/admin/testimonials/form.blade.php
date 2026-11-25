@extends('layouts.admin')

@section('title', ($testimonial->exists ? 'Edit' : 'Tambah').' Testimonial — Dikky Admin')

@section('content')
  <div class="admin-top">
    <div>
      <p class="eyebrow">Content</p>
      <h1>{{ $testimonial->exists ? 'Edit Testimonial' : 'Tambah Testimonial' }}</h1>
    </div>
    <a class="btn btn-outline" href="{{ route('admin.testimonials.index') }}">← Kembali</a>
  </div>

  <div class="form-card">
    <form method="POST" action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" class="form-grid" enctype="multipart/form-data">
      @csrf
      @if($testimonial->exists) @method('PUT') @endif

      <label class="full"><span>Quote</span><textarea name="quote" required>{{ old('quote', $testimonial->quote) }}</textarea></label>
      <label><span>Author name</span><input name="author_name" value="{{ old('author_name', $testimonial->author_name) }}" required /></label>
      <label><span>Author role</span><input name="author_role" value="{{ old('author_role', $testimonial->author_role) }}" /></label>

      <label><span>Upload avatar</span><input type="file" name="avatar_file" accept="image/*" /></label>
      <label><span>Upload visual (featured)</span><input type="file" name="visual_file" accept="image/*" /></label>

      @if($testimonial->avatar || $testimonial->visual_image)
        <div class="full upload-preview-row">
          @if($testimonial->avatar)
            <div class="upload-preview">
              <p>Avatar:</p>
              <img src="{{ media_url($testimonial->avatar) }}" alt="" />
            </div>
          @endif
          @if($testimonial->visual_image)
            <div class="upload-preview">
              <p>Visual:</p>
              <img src="{{ media_url($testimonial->visual_image) }}" alt="" />
            </div>
          @endif
        </div>
      @endif

      <label><span>Sort</span><input type="number" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" /></label>
      <label class="form-check"><input type="checkbox" name="featured" value="1" @checked(old('featured', $testimonial->featured)) /><span>Featured (biru)</span></label>
      <label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $testimonial->is_active ?? true)) /><span>Active</span></label>

      <div class="form-actions full">
        <button class="btn btn-accent" type="submit">Simpan</button>
      </div>
    </form>
  </div>
@endsection
