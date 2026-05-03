@extends('layouts.public')

@section('content')
<section class="container-narrow" style="padding: 32px 24px;">
    <h2>Pendaftaran Perkahwinan</h2>
    <p class="muted">SLA: 7 hari bekerja. Caveat & semakan status sivil dilakukan oleh sistem.</p>
    @if ($errors->any())<div class="error-box">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
    <form method="POST" action="{{ route('apply.marriage') }}" class="card">
        @csrf
        <h3 class="mt-0">Pengantin Lelaki</h3>
        <div class="row row-2">
            <div class="form-group"><label class="form-label">Nama</label><input class="form-control" name="groom_name" required value="{{ old('groom_name') }}"></div>
            <div class="form-group"><label class="form-label">No. KP</label><input class="form-control" name="groom_nric" required value="{{ old('groom_nric') }}"></div>
            <div class="form-group"><label class="form-label">Agama</label><input class="form-control" name="groom_religion" value="{{ old('groom_religion') }}"></div>
        </div>
        <h3>Pengantin Perempuan</h3>
        <div class="row row-2">
            <div class="form-group"><label class="form-label">Nama</label><input class="form-control" name="bride_name" required value="{{ old('bride_name') }}"></div>
            <div class="form-group"><label class="form-label">No. KP</label><input class="form-control" name="bride_nric" required value="{{ old('bride_nric') }}"></div>
            <div class="form-group"><label class="form-label">Agama</label><input class="form-control" name="bride_religion" value="{{ old('bride_religion') }}"></div>
        </div>
        <h3>Saksi</h3>
        <div class="row row-2">
            <div class="form-group"><label class="form-label">Nama Saksi 1</label><input class="form-control" name="witness1_name" required value="{{ old('witness1_name') }}"></div>
            <div class="form-group"><label class="form-label">No. KP Saksi 1</label><input class="form-control" name="witness1_nric" required value="{{ old('witness1_nric') }}"></div>
            <div class="form-group"><label class="form-label">Nama Saksi 2</label><input class="form-control" name="witness2_name" required value="{{ old('witness2_name') }}"></div>
            <div class="form-group"><label class="form-label">No. KP Saksi 2</label><input class="form-control" name="witness2_nric" required value="{{ old('witness2_nric') }}"></div>
        </div>
        <div class="form-group"><label class="form-label">Tarikh Akad Nikah Dicadangkan</label><input type="datetime-local" class="form-control" name="appointment_at" value="{{ old('appointment_at') }}"></div>
        <div class="muted mb-3" style="font-size: 12px;">Demo: dokumen disimulasi sebagai dimuat naik. Bayaran RM30 dianggap selesai.</div>
        <button class="btn btn-primary">Hantar Permohonan</button>
        <a href="{{ route('dashboard') }}" class="btn btn-ghost">Batal</a>
    </form>
</section>
@endsection
