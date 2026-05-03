@props(['application'])
@php
    $module = $application->module;
    $summary = match ($module) {
        'birth' => 'Permohonan pendaftaran kelahiran ini kelihatan lengkap. Maklumat ibu bapa tersedia, hospital direkodkan, dan dokumen wajib telah dimuat naik.',
        'mykad' => 'Maklumat pemohon lengkap. Pemeriksaan ABIS palsu lulus. Tiada rekod senarai hitam dikesan.',
        'marriage' => 'Maklumat pengantin lelaki, perempuan dan saksi lengkap. Status sivil bersih. Tempoh caveat sedia untuk dijadualkan.',
        default => 'Permohonan kelihatan lengkap. Sila teruskan dengan pengesahan rutin.',
    };
    $rec = match ($module) {
        'birth' => 'Teruskan ke pengesahan dokumen.',
        'mykad' => 'Teruskan ke kelulusan.',
        'marriage' => 'Beralih ke penjadualan temujanji.',
        default => 'Teruskan ke semakan biasa.',
    };
@endphp
<div class="ai-panel">
    <div class="ai-panel-head">
        <div class="ai-panel-title">🤖 AI Review Assistant</div>
        <span class="badge badge-green">High Confidence</span>
    </div>
    <div class="muted" style="font-size: 12px; margin-bottom: 4px;">RINGKASAN AI</div>
    <div class="ai-panel-summary">{{ $summary }}</div>
    <div class="ai-panel-rec">
        <span class="badge badge-blue">Saranan</span>
        <strong>{{ $rec }}</strong>
    </div>
    <div class="muted mt-3" style="font-size: 11px;">Nota: Ini adalah pembantu AI palsu untuk demo. Tiada panggilan API AI sebenar dilakukan.</div>
</div>
