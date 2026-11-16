@extends('layouts.app')

@section('title', 'Treatments - Lumiere Beauty Clinic')

@section('content')
    <main>
        <section class="page-hero">
            <div class="container page-hero-content">
                <span class="eyebrow eyebrow-dark">Our Treatments</span>
                <h1>Choose Your Beauty Treatment</h1>
                <p>
                    Pilih treatment yang sesuai dengan kebutuhan kulitmu, tentukan jadwal kunjungan,
                    lalu lanjutkan ke proses pembayaran.
                </p>
            </div>
        </section>

        <section class="section-block">
            <div class="container">
                <form action="{{ route('treatments.index') }}" method="GET" class="filter-panel reveal">
                    <div class="filter-group">
                        <label for="search">Cari Treatment</label>
                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Masukkan nama treatment"
                        >
                    </div>

                    <div class="filter-group">
                        <label for="category">Kategori</label>
                        <select id="category" name="category">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('treatments.index') }}" class="btn btn-outline">Reset</a>
                    </div>
                </form>

                <div class="treatment-grid treatment-list-grid">
                    @forelse($treatments as $treatment)
                        <article class="treatment-card reveal">
                            <div class="treatment-badge">
                                {{ $treatment->category ?? 'Treatment' }}
                            </div>

                            @if($treatment->image)
                                <div class="treatment-image-wrap">
                                    <img
                                        src="{{ str_starts_with($treatment->image, 'assets/') ? asset($treatment->image) : asset('storage/' . $treatment->image) }}"
                                        alt="{{ $treatment->treatment_name }}"
                                        class="treatment-image"
                                    >
                                </div>
                            @endif

                            <h3>{{ $treatment->treatment_name }}</h3>

                            <p>{{ $treatment->short_description }}</p>

                            <ul>
                                <li>Durasi {{ $treatment->duration_minutes ?? '-' }} menit</li>
                                <li>Harga Rp {{ number_format($treatment->price, 0, ',', '.') }}</li>
                                <li>Status tersedia untuk booking online</li>
                            </ul>

                            <a
                                href="{{ route('treatments.index', array_merge(request()->query(), ['selected' => $treatment->id])) }}#booking-form"
                                class="btn btn-primary"
                            >
                                Pilih Treatment
                            </a>
                        </article>
                    @empty
                        <article class="treatment-card reveal">
                            <div class="treatment-badge">Treatment</div>
                            <h3>Data treatment belum tersedia</h3>
                            <p>Tidak ada treatment yang sesuai dengan filter.</p>
                        </article>
                    @endforelse
                </div>

                <div class="pagination-wrap">
                    {{ $treatments->links() }}
                </div>
            </div>
        </section>

        <section class="section-block booking-section" id="booking-form">
            <div class="container">
                <div class="booking-layout">
                    <div class="section-heading reveal">
                        <span class="eyebrow eyebrow-dark">Online Reservation</span>
                        <h2>Booking Treatment</h2>
                        <p>
                            Setelah memilih treatment, isi tanggal, jam, metode pembayaran, dan catatan tambahan.
                        </p>
                    </div>

                    <div class="booking-card reveal">
                        @auth
                            @if($selectedTreatment)
                                <div class="selected-treatment-box">
                                    <span class="promo-tag">Selected Treatment</span>
                                    <h3>{{ $selectedTreatment->treatment_name }}</h3>
                                    <p>{{ $selectedTreatment->short_description }}</p>
                                    <strong>Rp {{ number_format($selectedTreatment->price, 0, ',', '.') }}</strong>
                                </div>

                                <form action="{{ route('checkout.store') }}" method="POST" class="booking-form">
                                    @csrf

                                    <input type="hidden" name="treatment_id" value="{{ $selectedTreatment->id }}">

                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label for="booking_date">Tanggal Booking</label>
                                            <input
                                                type="date"
                                                id="booking_date"
                                                name="booking_date"
                                                value="{{ old('booking_date') }}"
                                                min="{{ now()->toDateString() }}"
                                                required
                                            >
                                        </div>

                                        <div class="form-group">
                                            <label for="booking_time">Jam Booking</label>
                                            <input
                                                type="time"
                                                id="booking_time"
                                                name="booking_time"
                                                value="{{ old('booking_time') }}"
                                                required
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="payment_method">Metode Pembayaran</label>
                                        <select id="payment_method" name="payment_method" required>
                                            <option value="">Pilih metode pembayaran</option>
                                            @foreach($paymentMethods as $method => $label)
                                                <option value="{{ $method }}" {{ old('payment_method') === $method ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="notes">Catatan</label>
                                        <textarea id="notes" name="notes" rows="4" placeholder="Catatan tambahan jika ada">{{ old('notes') }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">
                                        Lanjut Pembayaran
                                    </button>
                                </form>
                            @else
                                <div class="empty-state">
                                    <h3>Belum ada treatment dipilih</h3>
                                    <p>Silakan pilih salah satu treatment terlebih dahulu.</p>
                                </div>
                            @endif
                        @else
                            <div class="empty-state">
                                <h3>Login diperlukan</h3>
                                <p>Silakan login terlebih dahulu untuk melakukan booking treatment.</p>
                                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection