@extends('layouts.public')

@section('content')
<section class="container-narrow" style="padding: 32px 24px;">
    <h2>Pendaftaran Kelahiran</h2>
    <p class="muted">Lengkapkan maklumat kelahiran anak. SLA: 3 hari bekerja.</p>
    @if ($errors->any())<div class="error-box">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
    <form method="POST" action="{{ route('apply.birth') }}" class="card">
        @csrf
        <h3 class="mt-0">Maklumat Anak</h3>
        <div class="row row-2">
            <div class="form-group"><label class="form-label">Nama Penuh Anak</label><input class="form-control" name="child_name" required value="{{ old('child_name') }}"></div>
            <div class="form-group"><label class="form-label">Jantina</label>
                <select class="form-control" name="child_gender" required>
                    <option value="lelaki">Lelaki</option><option value="perempuan">Perempuan</option>
                </select>
            </div>
            <div class="form-group"><label class="form-label">Tarikh Lahir</label><input type="date" class="form-control" name="child_dob" required value="{{ old('child_dob') }}"></div>
            <div class="form-group"><label class="form-label">Hospital / Tempat Lahir</label><input class="form-control" name="hospital" required value="{{ old('hospital') }}"></div>
        </div>
        <h3>Maklumat Ibu Bapa</h3>
        <div class="row row-2">
            <div class="form-group"><label class="form-label">Nama Bapa</label><input class="form-control" name="father_name" required value="{{ old('father_name') }}"></div>
            <div class="form-group"><label class="form-label">No. KP Bapa</label><input class="form-control" name="father_nric" required value="{{ old('father_nric') }}"></div>
            <div class="form-group"><label class="form-label">Nama Ibu</label><input class="form-control" name="mother_name" required value="{{ old('mother_name') }}"></div>
            <div class="form-group"><label class="form-label">No. KP Ibu</label><input class="form-control" name="mother_nric" required value="{{ old('mother_nric') }}"></div>
        </div>
        <div class="muted mb-3" style="font-size: 12px;">Demo: dokumen disimulasi sebagai dimuat naik. Bayaran RM20 dianggap selesai.</div>
        <button class="btn btn-primary">Hantar Permohonan</button>
        <a href="{{ route('dashboard') }}" class="btn btn-ghost">Batal</a>
    </form>
</section>
@endsection
