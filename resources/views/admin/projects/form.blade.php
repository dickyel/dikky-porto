@extends('layouts.admin')

@section('title', ($project->exists ? 'Edit' : 'Tambah').' Project — Dikky Admin')

@section('content')
  <div class="admin-top">
    <div>
      <p class="eyebrow">Portfolio</p>
      <h1>{{ $project->exists ? 'Edit Project' : 'Tambah Project' }}</h1>
      <p class="admin-lead">Cover dan gallery bisa diupload langsung dari komputer.</p>
    </div>
    <a class="btn btn-outline" href="{{ route('admin.projects.index') }}">← Kembali</a>
  </div>

  <div class="form-card">
    <form
      method="POST"
      action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
      class="form-grid"
      enctype="multipart/form-data"
    >
      @csrf
      @if ($project->exists)
        @method('PUT')
      @endif

      <label class="full">
        <span>Judul</span>
        <input type="text" name="title" required value="{{ old('title', $project->title) }}" placeholder="Nama project" />
      </label>

      <label>
        <span>Slug</span>
        <input type="text" name="slug" value="{{ old('slug', $project->slug) }}" placeholder="nama-project" />
      </label>

      <label>
        <span>Category</span>
        <input type="text" name="category" required value="{{ old('category', $project->category) }}" placeholder="Mobile App · Product Design" />
      </label>

      <label>
        <span>Client</span>
        <input type="text" name="client" required value="{{ old('client', $project->client) }}" placeholder="Nama client" />
      </label>

      <label>
        <span>Year</span>
        <input type="text" name="year" required value="{{ old('year', $project->year) }}" placeholder="2025" />
      </label>

      <label class="full">
        <span>Cover {{ $project->exists ? '(upload baru untuk ganti)' : '(wajib upload)' }}</span>
        <input type="file" name="cover_file" accept="image/*" {{ $project->exists ? '' : 'required' }} />
      </label>

      @if($project->cover)
        <div class="full upload-preview">
          <p>Cover saat ini:</p>
          <img src="{{ media_url($project->cover) }}" alt="Cover" />
        </div>
      @endif

      <label class="full">
        <span>Summary</span>
        <textarea name="summary" required placeholder="Ringkasan singkat project">{{ old('summary', $project->summary) }}</textarea>
      </label>

      <label class="full">
        <span>Description</span>
        <textarea name="description" required placeholder="Cerita case study lengkap">{{ old('description', $project->description) }}</textarea>
      </label>

      <label class="full">
        <span>Tags (pisahkan dengan koma)</span>
        <input type="text" name="tags" value="{{ old('tags', collect($project->tags ?? [])->implode(', ')) }}" placeholder="UI/UX, Mobile, Product Design" />
      </label>

      <label class="full">
        <span>Upload gallery (bisa banyak sekaligus)</span>
        <input type="file" name="gallery_files[]" accept="image/*" multiple />
      </label>

      @if(!empty($project->gallery))
        <div class="full">
          <p style="font-weight:700;margin-bottom:.6rem">Gallery saat ini (centang untuk tetap simpan):</p>
          <div class="gallery-keep-grid">
            @foreach($project->gallery as $image)
              <label class="gallery-keep-item">
                <img src="{{ media_url($image) }}" alt="" />
                <span>
                  <input type="checkbox" name="keep_gallery[]" value="{{ $image }}" checked />
                  Simpan
                </span>
              </label>
            @endforeach
          </div>
        </div>
      @endif

      <label class="form-check full">
        <input type="checkbox" name="featured" value="1" @checked(old('featured', $project->featured)) />
        <span>Tandai sebagai featured project</span>
      </label>

      <div class="form-actions full">
        <button type="submit" class="btn btn-accent">Simpan project</button>
        <a class="btn btn-outline" href="{{ route('admin.projects.index') }}">Batal</a>
      </div>
    </form>
  </div>
@endsection
