@extends('layouts.admin')

@section('title', 'Edit Treatment - Lumiere Beauty Clinic')

@section('admin_content')
    <section class="section-block">
        <div class="container admin-page-shell">
            <div class="admin-toolbar reveal">
                <div>
                    <span class="eyebrow eyebrow-dark">Edit Treatment</span>
                    <h1>{{ $treatment->treatment_name }}</h1>
                    <p>Perbarui informasi treatment, harga, durasi, status, dan gambar.</p>
                </div>

                <div class="admin-toolbar-actions">
                    <a href="{{ route('admin.treatments.index') }}" class="btn btn-outline">Kembali</a>
                </div>
            </div>

            <div class="table-card reveal">
                <form action="{{ route('admin.treatments.update', $treatment) }}" method="POST" enctype="multipart/form-data" class="admin-form-grid">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="treatment_name">Nama Treatment</label>
                        <input
                            type="text"
                            id="treatment_name"
                            name="treatment_name"
                            value="{{ old('treatment_name', $treatment->treatment_name) }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="category">Kategori</label>
                        <input
                            type="text"
                            id="category"
                            name="category"
                            value="{{ old('category', $treatment->category) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="price">Harga</label>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            value="{{ old('price', $treatment->price) }}"
                            min="0"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="duration_minutes">Durasi Menit</label>
                        <input
                            type="number"
                            id="duration_minutes"
                            name="duration_minutes"
                            value="{{ old('duration_minutes', $treatment->duration_minutes) }}"
                            min="1"
                        >
                    </div>

                    <div class="form-group admin-form-full">
                        <label for="short_description">Deskripsi Singkat</label>
                        <input
                            type="text"
                            id="short_description"
                            name="short_description"
                            value="{{ old('short_description', $treatment->short_description) }}"
                        >
                    </div>

                    <div class="form-group admin-form-full">
                        <label for="description">Deskripsi Lengkap</label>
                        <textarea id="description" name="description" rows="6">{{ old('description', $treatment->description) }}</textarea>
                    </div>

                    <div class="form-group admin-form-full">
                        <label>Gambar Saat Ini</label>

                        @if($treatment->image)
                            <div class="admin-current-image">
                                <img
                                    src="{{ str_starts_with($treatment->image, 'assets/') ? asset($treatment->image) : asset('storage/' . $treatment->image) }}"
                                    alt="{{ $treatment->treatment_name }}"
                                >
                            </div>
                        @else
                            <p>Belum ada gambar.</p>
                        @endif

                        <input type="file" id="image" name="image" accept="image/*">
                        <small>Kosongkan jika tidak ingin mengganti gambar.</small>
                    </div>

                    <div class="admin-checkbox-group admin-form-full">
                        <label>
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $treatment->is_featured) ? 'checked' : '' }}>
                            Jadikan treatment unggulan
                        </label>

                        <label>
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $treatment->is_active) ? 'checked' : '' }}>
                            Aktif
                        </label>
                    </div>

                    <div class="admin-form-actions admin-form-full">
                        <button type="submit" class="btn btn-primary">Update Treatment</button>
                        <a href="{{ route('admin.treatments.index') }}" class="btn btn-outline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection