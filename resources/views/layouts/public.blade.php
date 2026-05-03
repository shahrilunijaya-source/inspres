<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'INPReS — Sistem Pendaftaran Bersepadu' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @stack('head')
</head>
<body>
    @include('partials.navbar')
    @if (session('success'))
        <div class="container mt-4"><div class="card" style="border-left: 4px solid var(--accent); padding: 12px 18px;">{{ session('success') }}</div></div>
    @endif
    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>
    @include('partials.footer')
    <script>
    (function(){
      var KEY = 'inpres_lang';
      function apply(lang){
        document.documentElement.setAttribute('lang', lang === 'en' ? 'en' : 'ms');
        document.querySelectorAll('[data-bm][data-en]').forEach(function(el){
          var t = el.getAttribute(lang === 'en' ? 'data-en' : 'data-bm');
          if (t != null) el.textContent = t;
        });
        document.querySelectorAll('[data-bm-placeholder][data-en-placeholder]').forEach(function(el){
          el.placeholder = el.getAttribute(lang === 'en' ? 'data-en-placeholder' : 'data-bm-placeholder');
        });
        document.querySelectorAll('.lang-toggle .lang-btn').forEach(function(b){
          b.classList.toggle('active', b.getAttribute('data-lang') === lang);
        });
      }
      var saved = localStorage.getItem(KEY) || 'bm';
      apply(saved);
      document.addEventListener('click', function(e){
        var b = e.target.closest('.lang-toggle .lang-btn');
        if (!b) return;
        var lang = b.getAttribute('data-lang');
        localStorage.setItem(KEY, lang);
        apply(lang);
      });
    })();
    </script>
    @stack('scripts')
</body>
</html>
