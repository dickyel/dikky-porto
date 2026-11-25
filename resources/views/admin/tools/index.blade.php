@extends('layouts.admin')

@section('title', 'Tools — Dikky Admin')

@section('content')
  <div class="admin-top">
    <div>
      <p class="eyebrow">Content</p>
      <h1>EXP Tools</h1>
    </div>
  </div>

  <div class="form-card" style="margin-bottom:1.25rem">
    <form method="POST" action="{{ route('admin.tools.store') }}" class="form-grid">
      @csrf
      <label><span>Name</span><input name="name" required placeholder="Figma" /></label>
      <label>
        <span>Icon key</span>
        <select name="icon_key">
          <option value="">Custom / URL</option>
          <option value="figma">figma</option>
          <option value="framer">framer</option>
          <option value="webflow">webflow</option>
          <option value="after-effects">after-effects</option>
          <option value="notion">notion</option>
        </select>
      </label>
      <label class="full"><span>Icon URL (opsional)</span><input type="url" name="icon_url" placeholder="https://..." /></label>
      <label><span>Sort</span><input type="number" name="sort_order" value="0" /></label>
      <div class="form-actions full"><button class="btn btn-accent" type="submit">Tambah tool</button></div>
    </form>
  </div>

  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Tool</th><th>Key</th><th>Sort</th><th>Active</th><th></th></tr></thead>
      <tbody>
        @foreach($tools as $tool)
          <tr>
            <td>
              <form method="POST" action="{{ route('admin.tools.update', $tool) }}" class="form-grid" style="grid-template-columns:1fr 1fr;gap:.5rem">
                @csrf
                @method('PUT')
                <input name="name" value="{{ $tool->name }}" required />
                <input name="icon_key" value="{{ $tool->icon_key }}" placeholder="icon_key" />
                <input name="icon_url" value="{{ $tool->icon_url }}" placeholder="icon url" />
                <input type="number" name="sort_order" value="{{ $tool->sort_order }}" />
                <label class="form-check"><input type="checkbox" name="is_active" value="1" @checked($tool->is_active) /><span>Active</span></label>
                <button class="btn btn-accent" type="submit">Update</button>
              </form>
            </td>
            <td>{{ $tool->icon_key ?: '—' }}</td>
            <td>{{ $tool->sort_order }}</td>
            <td>{{ $tool->is_active ? 'Yes' : 'No' }}</td>
            <td class="admin-actions">
              <form method="POST" action="{{ route('admin.tools.destroy', $tool) }}" onsubmit="return confirm('Hapus tool?')">
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
