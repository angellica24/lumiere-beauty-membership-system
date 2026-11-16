@extends('layouts.app')

@section('title', 'Pembayaran Treatment - Lumiere Beauty')

@section('content')
    <section class="section">
        <div class="container">
            <div class="form-card" style="width:min(760px, 92%);">
                <h2>Pembayaran Treatment</h2>
                <p>Selesaikan instruksi pembayaran berikut, lalu kirim konfirmasi.</p>

                <div class="card" style="margin-bottom:20px;">
                    <h3>{{ $treatment->treatment_name }}</h3>
                    <p>{{ $treatment->short_description }}</p>

                    <p>
                        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pending['booking_date'])->format('d M Y') }}<br>
                        <strong>Jam:</strong> {{ $pending['booking_time'] }}<br>
                        <strong>Metode:</strong> {{ $paymentLabels[$pending['payment_method']] ?? $pending['payment_method'] }}
                    </p>

                    <div class="price">
                        Total: Rp {{ number_format($treatment->price, 0, ',', '.') }}
                    </div>
                </div>

                @if($pending['payment_method'] === 'qris')
                    <div class="card" style="margin-bottom:20px;">
                        <h3>Instruksi QRIS</h3>
                        <p>Scan QRIS berikut menggunakan aplikasi mobile banking atau e-wallet Anda.</p>

                        <img 
                            src="{{ asset($qrisImage) }}" 
                            alt="QRIS Lumiere Beauty"
                            style="max-width:260px; height:auto; border-radius:12px;"
                        >
                    </div>
                @endif

                @if($pending['payment_method'] === 'bank_transfer')
                    <div class="card" style="margin-bottom:20px;">
                        <h3>Instruksi Bank Transfer</h3>

                        @foreach($bankAccounts as $account)
                            <p>
                                <strong>{{ $account['bank'] }}</strong><br>
                                Nomor Rekening: {{ $account['number'] }}<br>
                                Atas Nama: {{ $account['name'] }}
                            </p>
                        @endforeach
                    </div>
                @endif

                @if($pending['payment_method'] === 'e_wallet')
                    <div class="card" style="margin-bottom:20px;">
                        <h3>Instruksi E-Wallet</h3>

                        @foreach($eWalletAccounts as $account)
                            <p>
                                <strong>{{ $account['provider'] }}</strong><br>
                                Nomor: {{ $account['number'] }}<br>
                                Atas Nama: {{ $account['name'] }}
                            </p>
                        @endforeach
                    </div>
                @endif

                @if($pending['payment_method'] === 'cash')
                    <div class="card" style="margin-bottom:20px;">
                        <h3>Pembayaran Cash</h3>
                        <p>Pembayaran dilakukan langsung di klinik. Anda tetap perlu mengirim konfirmasi agar booking tercatat dan menunggu verifikasi admin.</p>
                    </div>
                @endif

                <form action="{{ route('checkout.confirm') }}" method="POST">
                    @csrf

                    <input type="hidden" name="payment_token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="payer_name">Nama Pembayar</label>
                        <input 
                            type="text" 
                            id="payer_name" 
                            name="payer_name" 
                            value="{{ old('payer_name', auth()->user()->name) }}" 
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="payment_reference">Nomor Referensi atau Catatan Transaksi</label>
                        <input 
                            type="text" 
                            id="payment_reference" 
                            name="payment_reference" 
                            value="{{ old('payment_reference') }}"
                            placeholder="Opsional. Contoh: nomor transaksi, nama bank, atau akun e-wallet"
                        >
                    </div>

                    <div class="form-group">
                        <label for="payment_note">Catatan Pembayaran</label>
                        <textarea id="payment_note" name="payment_note" rows="4">{{ old('payment_note') }}</textarea>
                    </div>

                    <button type="submit" class="btn">Konfirmasi Pembayaran</button>
                    <a href="{{ route('treatments.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </section>
@endsection