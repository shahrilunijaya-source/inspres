<div class="govbar">
    <div class="container govbar-inner">
        <div class="govbar-left">
            <a href="#" class="govbar-link active">Bahasa Melayu</a>
            <span class="govbar-sep">|</span>
            <a href="#" class="govbar-fz" onclick="event.preventDefault(); govFz(-1)">A-</a>
            <span class="govbar-sep">|</span>
            <a href="#" class="govbar-fz" onclick="event.preventDefault(); govFz(0)">A</a>
            <span class="govbar-sep">|</span>
            <a href="#" class="govbar-fz" onclick="event.preventDefault(); govFz(1)">A+</a>
        </div>
        <div class="govbar-right">
            <a href="#" aria-label="Facebook" class="govbar-icon">f</a>
            <a href="#" aria-label="Twitter" class="govbar-icon">𝕏</a>
            <a href="#" aria-label="YouTube" class="govbar-icon">▶</a>
            <a href="#" aria-label="Instagram" class="govbar-icon">◎</a>
            <a href="#" aria-label="Share" class="govbar-icon">⤴</a>
        </div>
    </div>
</div>
<script>
    function govFz(delta) {
        const html = document.documentElement;
        let cur = parseFloat(getComputedStyle(html).fontSize);
        if (delta === 0) html.style.fontSize = '';
        else html.style.fontSize = Math.max(12, Math.min(20, cur + delta)) + 'px';
    }
</script>
