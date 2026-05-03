@extends('layouts.public')

@section('content')
<section class="container-narrow" style="padding: 32px 24px;">
    <h2>Permohonan MyKad</h2>
    <p class="muted">SLA: 5 hari bekerja. Pemeriksaan ABIS & senarai hitam dilakukan oleh sistem.</p>
    @if ($errors->any())<div class="error-box">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
    <form method="POST" action="{{ route('apply.mykad') }}" class="card">
        @csrf
        <div class="row row-2">
            <div class="form-group"><label class="form-label">Jenis Permohonan</label>
                <select class="form-control" name="type" required>
                    <option value="first_time">Pertama Kali</option>
                    <option value="replacement">Gantian (Hilang/Rosak)</option>
                    <option value="renewal">Pembaharuan</option>
                    <option value="mykid_to_mykad">MyKid ke MyKad</option>
                </select>
            </div>
            <div class="form-group"><label class="form-label">Nama Penuh</label><input class="form-control" name="full_name" required value="{{ old('full_name', auth()->user()->name) }}"></div>
            <div class="form-group"><label class="form-label">No. KP</label><input class="form-control" name="nric" required value="{{ old('nric', auth()->user()->nric) }}"></div>
            <div class="form-group"><label class="form-label">Tarikh Lahir</label><input type="date" class="form-control" name="dob" required value="{{ old('dob') }}"></div>
        </div>
        <div class="form-group"><label class="form-label">Sebab Permohonan</label><textarea class="form-control" rows="3" name="reason">{{ old('reason') }}</textarea></div>
        <div class="muted mb-3" style="font-size: 12px;">Demo: gambar pasport & dokumen disimulasi sebagai dimuat naik. Bayaran RM10 dianggap selesai.</div>
        <button class="btn btn-primary">Hantar Permohonan</button>
        <a href="{{ route('dashboard') }}" class="btn btn-ghost">Batal</a>
    </form>
</section>
@endsection
