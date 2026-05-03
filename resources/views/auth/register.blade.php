<x-layouts.auth-split>
    <div class="auth-card">
        <h2 class="mt-0 mb-2">Daftar Akaun</h2>
        <p class="muted mb-4">Buka akaun pengguna awam untuk menguruskan permohonan anda.</p>

        @if ($errors->any())
            <div class="error-box">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register.attempt') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Penuh</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label class="form-label">No. Kad Pengenalan</label>
                <input type="text" name="nric" class="form-control" placeholder="000000-00-0000" required value="{{ old('nric') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Telefon</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Kata Laluan</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Sahkan Kata Laluan</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Daftar Akaun</button>
        </form>

        <div style="border-top: 1px solid var(--border); margin: 20px 0; padding-top: 16px; text-align: center; font-size: 13px;">
            Sudah ada akaun? <a href="{{ route('login') }}">Log Masuk</a>
        </div>
    </div>
</x-layouts.auth-split>
