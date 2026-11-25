@extends('layouts.admin')

@section('title', ($service->exists ? 'Edit' : 'Tambah').' Service — Dikky Admin')

@section('content')
  @php $stats = old('stat_values')
    ? collect(old('stat_values'))->map(fn ($v, $i) => ['value' => $v, 'label' => old('stat_labels.'.$i)])
    : collect($service->stats ?? [['value'=>'','label'=>''],['value'=>'','label'=>''],['value'=>'','label'=>'']]);
  @endphp

  <div class="admin-top">
    <div>
      <p class="eyebrow">Content</p>
      <h1>{{ $service->exists ? 'Edit Service' : 'Tambah Service' }}</h1>
    </div>
    <a class="btn btn-outline" href="{{ route('admin.services.index') }}">← Kembali</a>
  </div>

  <div class="form-card">
    <form method="POST" action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}" class="form-grid" enctype="multipart/form-data">
      @csrf
      @if($service->exists) @method('PUT') @endif

      <label class="full"><span>Title</span><input name="title" value="{{ old('title', $service->title) }}" required /></label>
      <label class="full"><span>Description</span><textarea name="description">{{ old('description', $service->description) }}</textarea></label>

      <label><span>Upload thumbnail</span><input type="file" name="thumbnail_file" accept="image/*" /></label>
      <label><span>Upload preview</span><input type="file" name="preview_file" accept="image/*" /></label>

      @if($service->thumbnail || $service->preview_image)
        <div class="full upload-preview-row">
          @if($service->thumbnail)
            <div class="upload-preview">
              <p>Thumbnail:</p>
              <img src="{{ media_url($service->thumbnail) }}" alt="" />
            </div>
          @endif
          @if($service->preview_image)
            <div class="upload-preview">
              <p>Preview:</p>
              <img src="{{ media_url($service->preview_image) }}" alt="" />
            </div>
          @endif
        </div>
      @endif

      <label><span>Sort</span><input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}" /></label>
      <label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service->is_active ?? true)) /><span>Active</span></label>

      @foreach($stats->take(3) as $i => $stat)
        <label><span>Stat {{ $i+1 }} value</span><input name="stat_values[]" value="{{ $stat['value'] ?? '' }}" /></label>
        <label><span>Stat {{ $i+1 }} label</span><input name="stat_labels[]" value="{{ $stat['label'] ?? '' }}" /></label>
      @endforeach

      <div class="form-actions full">
        <button class="btn btn-accent" type="submit">Simpan</button>
      </div>
    </form>
  </div>
@endsection
