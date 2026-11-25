@extends('layouts.admin')

@section('title', 'Projects — Dikky Admin')

@section('content')
  <div class="admin-top">
    <div>
      <p class="eyebrow">Portfolio</p>
      <h1>Semua Project</h1>
      <p class="admin-lead">Project yang tampil di showcase homepage dan halaman detail.</p>
    </div>
    <a class="btn btn-accent" href="{{ route('admin.projects.create') }}">+ Project baru</a>
  </div>

  @if ($projects->isEmpty())
    <div class="empty-state">
      <h2>Belum ada project</h2>
      <p>Tambahkan project pertama supaya portfolio jadi dinamis.</p>
      <a class="btn btn-accent" href="{{ route('admin.projects.create') }}">Tambah project</a>
    </div>
  @else
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Project</th>
            <th>Kategori</th>
            <th>Tahun</th>
            <th>Featured</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($projects as $project)
            <tr>
              <td>
                <div class="admin-project-cell">
                  <img src="{{ media_url($project->cover) }}" alt="" />
                  <div>
                    <strong>{{ $project->title }}</strong>
                    <span>{{ $project->slug }}</span>
                  </div>
                </div>
              </td>
              <td>{{ $project->category }}</td>
              <td>{{ $project->year }}</td>
              <td>
                <span class="badge {{ $project->featured ? 'badge-yes' : 'badge-no' }}">
                  {{ $project->featured ? 'Ya' : 'Tidak' }}
                </span>
              </td>
              <td class="admin-actions">
                <a class="action-btn" href="{{ route('projects.show', $project) }}" target="_blank" rel="noopener">Lihat</a>
                <a class="action-btn action-btn-edit" href="{{ route('admin.projects.edit', $project) }}">Edit</a>
                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Yakin hapus project ini?');" style="display:inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="action-btn action-btn-danger">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
@endsection
