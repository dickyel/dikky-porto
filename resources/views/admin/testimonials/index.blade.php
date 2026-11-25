@extends('layouts.admin')

@section('title', 'Testimonials — Dikky Admin')

@section('content')
  <div class="admin-top">
    <div>
      <p class="eyebrow">Content</p>
      <h1>Testimonials</h1>
    </div>
    <a class="btn btn-accent" href="{{ route('admin.testimonials.create') }}">+ Testimonial</a>
  </div>

  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Author</th><th>Featured</th><th>Sort</th><th></th></tr></thead>
      <tbody>
        @foreach($testimonials as $item)
          <tr>
            <td>
              <div class="admin-project-cell">
                @if($item->avatar)<img src="{{ media_url($item->avatar) }}" alt="" />@endif
                <div>
                  <strong>{{ $item->author_name }}</strong>
                  <span>{{ \Illuminate\Support\Str::limit($item->quote, 70) }}</span>
                </div>
              </div>
            </td>
            <td>{{ $item->featured ? 'Yes' : 'No' }}</td>
            <td>{{ $item->sort_order }}</td>
            <td class="admin-actions">
              <a href="{{ route('admin.testimonials.edit', $item) }}">Edit</a>
              <form method="POST" action="{{ route('admin.testimonials.destroy', $item) }}" onsubmit="return confirm('Hapus?')">
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
