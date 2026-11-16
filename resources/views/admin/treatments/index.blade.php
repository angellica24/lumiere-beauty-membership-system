@extends('layouts.admin')

@section('title', 'Manage Treatments - Lumiere Beauty Clinic')

@section('admin_content')
    <section class="section-block">
        <div class="container admin-page-shell">
            <div class="admin-toolbar reveal">
                <div>
                    <span class="eyebrow eyebrow-dark">Treatment Management</span>
                    <h1>Kelola Treatment</h1>
                    <p>Add, edit, activate, deactivate, and delete Lumiere Beauty treatment services.</p>
                </div>

                <div class="admin-toolbar-actions"><a href="{{ route('admin.treatments.create') }}" class="btn btn-primary">Add Treatment</a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Dashboard</a>
                </div>
            </div>

            <div class="table-card reveal">
                <form action="{{ route('admin.treatments.index') }}" method="GET" class="admin-filter-grid">
                    <div class="form-group">
                        <label for="search">Cari Treatment</label>
                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Nama, kategori, atau deskripsi"
                        >
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="admin-filter-actions">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.treatments.index') }}" class="btn btn-outline">Reset</a>
                    </div>
                </form>
            </div>

            <div class="admin-treatment-grid">
                @forelse($treatments as $treatment)
                    <article class="admin-treatment-card reveal">
                        <div class="admin-treatment-image">
                            @if($treatment->image)
                                <img
                                    src="{{ str_starts_with($treatment->image, 'assets/') ? asset($treatment->image) : asset('storage/' . $treatment->image) }}"
                                    alt="{{ $treatment->treatment_name }}"
                                >
                            @else
                                <div class="admin-no-image">No Image</div>
                            @endif
                        </div>

                        <div class="admin-treatment-body">
                            <div class="booking-admin-header">
                                <div>
                                    <span class="promo-tag">{{ $treatment->category ?? 'Treatment' }}</span>
                                    <h2>{{ $treatment->treatment_name }}</h2>
                                    <p>{{ $treatment->short_description ?? 'Tidak ada deskripsi singkat.' }}</p>
                                </div>

                                <div class="booking-admin-badges">
                                    @if($treatment->is_active)
                                        <span class="status-pill status-paid">Aktif</span>
                                    @else
                                        <span class="status-pill status-cancelled">Nonaktif</span>
                                    @endif

                                    @if($treatment->is_featured)
                                        <span class="status-pill status-waiting_verification">Featured</span>
                                    @endif
                                </div>
                            </div>

                            <div class="booking-admin-meta">
                                <div>
                                    <h4>Harga</h4>
                                    <p><strong>Rp {{ number_format($treatment->price, 0, ',', '.') }}</strong></p>
                                </div>

                                <div>
                                    <h4>Durasi</h4>
                                    <p>{{ $treatment->duration_minutes ? $treatment->duration_minutes . ' menit' : '-' }}</p>
                                </div>

                                <div>
                                    <h4>Slug</h4>
                                    <p>{{ $treatment->slug }}</p>
                                </div>
                            </div>

                            <div class="admin-card-actions">
                                <a href="{{ route('admin.treatments.edit', $treatment) }}" class="btn btn-primary">
                                    Edit
                                </a>

                                <form action="{{ route('admin.treatments.toggle-status', $treatment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="btn btn-outline">
                                        {{ $treatment->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>

                                <form
                                    action="{{ route('admin.treatments.destroy', $treatment) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus treatment ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger-soft">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="table-card reveal">
                        <p>Belum ada data treatment.</p>
                    </div>
                @endforelse
            </div>

            <div class="pagination-wrap">
                {{ $treatments->links() }}
            </div>
        </div>
    </section>
@endsection