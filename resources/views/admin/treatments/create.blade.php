@extends('layouts.admin')

@section('title', 'Add Treatment - Lumiere Beauty Clinic')

@section('admin_content')
    <section class="section-block">
        <div class="container admin-page-shell">
            <div class="admin-toolbar reveal">
                <div>
                    <span class="eyebrow eyebrow-dark">Create Treatment</span>
                    <h1>Add Treatment</h1>
                    <p>Add a new treatment service that will appear on the customer page.</p>                </div>

                <div class="admin-toolbar-actions">
                    <a href="{{ route('admin.treatments.index') }}" class="btn btn-outline">Kembali</a>
                </div>
            </div>

            <div class="table-card reveal">
                <form action="{{ route('admin.treatments.store') }}" method="POST" enctype="multipart/form-data" class="admin-form-grid">
                    @csrf

                    <div class="form-group">
                        <label for="treatment_name">Nama Treatment</label>
                        <input
                            type="text"
                            id="treatment_name"
                            name="treatment_name"
                            value="{{ old('treatment_name') }}"
                            placeholder="Contoh: Brightening Skin Therapy"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="category">Kategori</label>
                        <input
                            type="text"
                            id="category"
                            name="category"
                            value="{{ old('category') }}"
                            placeholder="Contoh: Facial, Skin Care, Body Treatment"
                        >
                    </div>

                    <div class="form-group">
                        <label for="price">Harga</label>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            value="{{ old('price') }}"
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
                            value="{{ old('duration_minutes') }}"
                            min="1"
                        >
                    </div>

                    <div class="form-group admin-form-full">
                        <label for="short_description">Deskripsi Singkat</label>
                        <input
                            type="text"
                            id="short_description"
                            name="short_description"
                            value="{{ old('short_description') }}"
                            placeholder="Deskripsi singkat untuk card treatment"
                        >
                    </div>

                    <div class="form-group admin-form-full">
                        <label for="description">Deskripsi Lengkap</label>
                        <textarea id="description" name="description" rows="6" placeholder="Jelaskan detail treatment">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group admin-form-full">
                        <label for="image">Gambar Treatment</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        <small>Maksimal 2 MB. Format JPG, JPEG, PNG, WEBP.</small>
                    </div>

                    <div class="admin-checkbox-group admin-form-full">
                        <label>
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            Jadikan treatment unggulan
                        </label>

                        <label>
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                            Aktif
                        </label>
                    </div>

                    <div class="admin-form-actions admin-form-full">
                        <button type="submit" class="btn btn-primary">Save Treatment</button>
                        <a href="{{ route('admin.treatments.index') }}" class="btn btn-outline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection