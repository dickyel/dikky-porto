@extends('layouts.admin')

@section('title', 'Services — Dikky Admin')

@section('content')
  <div class="admin-top">
    <div>
      <p class="eyebrow">Content</p>
      <h1>Services</h1>
    </div>
    <a class="btn btn-accent" href="{{ route('admin.services.create') }}">+ Service</a>
  </div>

  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Service</th><th>Sort</th><th>Active</th><th></th></tr></thead>
      <tbody>
        @foreach($services as $service)
          <tr>
            <td>
              <div class="admin-project-cell">
                @if($service->thumbnail)<img src="{{ media_url($service->thumbnail) }}" alt="" />@endif
                <div>
                  <strong>{{ $service->title }}</strong>
                  <span>{{ \Illuminate\Support\Str::limit($service->description, 60) }}</span>
                </div>
              </div>
            </td>
            <td>{{ $service->sort_order }}</td>
            <td>{{ $service->is_active ? 'Yes' : 'No' }}</td>
            <td class="admin-actions">
              <a href="{{ route('admin.services.edit', $service) }}">Edit</a>
              <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Hapus service?')">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
