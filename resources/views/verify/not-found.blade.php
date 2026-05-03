@extends('layouts.public')

@section('content')
<section class="container-narrow" style="padding: 48px 24px;">
    <div class="card" style="border: 2px solid var(--red); background: var(--red-bg); text-align: center; padding: 48px;">
        <div style="font-size: 48px;">✗</div>
        <h2 style="color: var(--red);">Sijil Tidak Sah</h2>
        <p>No. sijil <code>{{ $certNo }}</code> tidak ditemui dalam sistem.</p>
    </div>
</section>
@endsection
