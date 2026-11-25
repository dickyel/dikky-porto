@extends('layouts.admin')

@section('title', 'Hero Stats — Dikky Admin')

@section('content')
  <div class="admin-top">
    <div>
      <p class="eyebrow">Content</p>
      <h1>Hero Stats</h1>
    </div>
  </div>

  <div class="form-card" style="margin-bottom:1.25rem">
    <form method="POST" action="{{ route('admin.stats.store') }}" class="form-grid">
      @csrf
      <label><span>Value</span><input name="value" required placeholder="08+" /></label>
      <label><span>Label</span><input name="label" required placeholder="Years of experience" /></label>
      <label><span>Sort</span><input type="number" name="sort_order" value="0" /></label>
      <div class="form-actions full"><button class="btn btn-accent" type="submit">Tambah stat</button></div>
    </form>
  </div>

  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Value</th><th>Label</th><th>Sort</th><th></th></tr></thead>
      <tbody>
        @foreach($stats as $stat)
          <tr>
            <td colspan="3">
              <form method="POST" action="{{ route('admin.stats.update', $stat) }}" class="form-grid" style="grid-template-columns:1fr 2fr 100px auto;align-items:center">
                @csrf
                @method('PUT')
                <input name="value" value="{{ $stat->value }}" required />
                <input name="label" value="{{ $stat->label }}" required />
                <input type="number" name="sort_order" value="{{ $stat->sort_order }}" />
                <label class="form-check"><input type="checkbox" name="is_active" value="1" @checked($stat->is_active) /><span>Active</span></label>
                <button class="btn btn-accent" type="submit">Update</button>
              </form>
            </td>
            <td class="admin-actions">
              <form method="POST" action="{{ route('admin.stats.destroy', $stat) }}" onsubmit="return confirm('Hapus?')">
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
