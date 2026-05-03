<div class="footer-map">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.0907837497145!2d101.6960103!3d2.9241413!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdb77002962f55%3A0x70f80746f8c3c54!2sJabatan%20Pendaftaran%20Negara%20Malaysia%20%28Ibu%20Pejabat%29!5e0!3m2!1sen!2smy!4v1714800000000"
        width="100%" height="300" style="border:0; display:block;" allowfullscreen=""
        loading="lazy" referrerpolicy="no-referrer-when-downgrade"
        title="Lokasi JPN Ibu Pejabat Putrajaya"></iframe>
    <div class="footer-map-caption">
        <strong>Ibu Pejabat JPN</strong> — No. 20, Persiaran Perdana, Presint 2, 62551 Putrajaya
    </div>
</div>
<footer style="background: var(--navy); color: rgba(255,255,255,0.85); padding: 40px 0;">
    <div class="container">
        <div class="row row-3">
            <div>
                <div class="flex gap-2 items-center mb-3">
                    <img src="{{ asset('img/logo_jata.png') }}" alt="Jata Negara" style="height: 40px;">
                    <img src="{{ asset('img/logo_jpn.png') }}" alt="JPN" style="height: 36px;">
                </div>
                <h3 style="color: #fff;">INPReS</h3>
                <p style="font-size: 13px; opacity: 0.75;">Sistem Pendaftaran Bersepadu Negara — Jabatan Pendaftaran Negara Malaysia.</p>
            </div>
            <div>
                <h3 style="color: #fff; font-size: 14px;">Hubungi</h3>
                <ul style="list-style: none; padding: 0; font-size: 13px; opacity: 0.85;">
                    <li>Talian: 03-8000 8000</li>
                    <li>Aduan: aduan@jpn.gov.my</li>
                </ul>
            </div>
            <div>
                <h3 style="color: #fff; font-size: 14px;">Pautan</h3>
                <ul style="list-style: none; padding: 0; font-size: 13px;">
                    <li><a href="{{ route('track') }}" style="color: var(--yellow);">Semak Status Permohonan</a></li>
                    <li><a href="{{ route('login') }}" style="color: rgba(255,255,255,0.85);">Log Masuk</a></li>
                    <li><a href="#" style="color: rgba(255,255,255,0.85);">Dasar Privasi</a></li>
                </ul>
            </div>
        </div>
        <div style="border-top: 1px solid rgba(255,255,255,0.15); margin-top: 32px; padding-top: 16px; text-align: center; font-size: 12px; opacity: 0.7;">
            © {{ date('Y') }} INPReS Prototype — Pra-pelaksanaan demo. Bukan sistem pengeluaran.
        </div>
    </div>
</footer>
