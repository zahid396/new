<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $storeSettings['store_name'] ?? config('app.name') }}</title>
    @if(!empty($storeSettings['store_favicon']))
    <link rel="icon" type="image/png" href="{{ asset('storage/store/' . $storeSettings['store_favicon']) }}">
    @endif
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #6366f1; --primary-dark: #4f46e5; --primary-light: #818cf8;
            --primary-50: #eef2ff; --primary-100: #e0e7ff;
            --accent: #10b981; --accent-dark: #059669;
            --gray-50: #f9fafb; --gray-100: #f3f4f6; --gray-200: #e5e7eb; --gray-300: #d1d5db;
            --gray-400: #9ca3af; --gray-500: #6b7280; --gray-600: #4b5563; --gray-700: #374151;
            --gray-800: #1f2937; --gray-900: #111827;
            --white: #ffffff; --shadow-sm: 0 1px 2px rgba(0,0,0,.05);
            --shadow: 0 1px 3px rgba(0,0,0,.1), 0 1px 2px rgba(0,0,0,.06);
            --shadow-md: 0 4px 6px rgba(0,0,0,.07), 0 2px 4px rgba(0,0,0,.06);
            --shadow-lg: 0 10px 15px rgba(0,0,0,.1), 0 4px 6px rgba(0,0,0,.05);
            --shadow-xl: 0 20px 25px rgba(0,0,0,.1), 0 10px 10px rgba(0,0,0,.04);
            --radius: .75rem; --radius-lg: 1rem; --radius-xl: 1.25rem;
            --transition: all .2s ease; --font: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        html { scroll-behavior: smooth; font-family: var(--font); color: var(--gray-800); background: var(--gray-50); }
        body { line-height: 1.6; min-height: 100vh; display: flex; flex-direction: column; }
        img { max-width: 100%; display: block; }
        a { color: var(--primary); text-decoration: none; transition: var(--transition); }
        a:hover { color: var(--primary-dark); }
        .container { width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 1rem; }

        /* ── Navbar ── */
        .navbar { position: sticky; top: 0; z-index: 100; background: rgba(255,255,255,.92); backdrop-filter: blur(12px); border-bottom: 1px solid var(--gray-200); }
        .navbar .container { display: flex; align-items: center; justify-content: space-between; height: 64px; }
        .nav-brand { display: flex; align-items: center; gap: .6rem; font-weight: 700; font-size: 1.2rem; color: var(--gray-900); }
        .nav-brand img { height: 36px; width: auto; border-radius: .5rem; object-fit: contain; }
        .nav-links { display: flex; align-items: center; gap: .25rem; }
        .nav-links a { padding: .5rem 1rem; border-radius: var(--radius); font-weight: 500; font-size: .935rem; color: var(--gray-600); transition: var(--transition); }
        .nav-links a:hover, .nav-links a.active { color: var(--primary); background: var(--primary-50); }
        .hamburger { display: none; flex-direction: column; gap: 5px; background: none; border: none; cursor: pointer; padding: .5rem; }
        .hamburger span { display: block; width: 22px; height: 2px; background: var(--gray-700); border-radius: 2px; transition: var(--transition); }
        .mobile-menu { display: none; position: fixed; top: 64px; left: 0; right: 0; background: var(--white); border-bottom: 1px solid var(--gray-200); box-shadow: var(--shadow-lg); z-index: 99; padding: 1rem; }
        .mobile-menu.open { display: block; animation: slideDown .2s ease; }
        .mobile-menu a { display: block; padding: .75rem 1rem; border-radius: var(--radius); font-weight: 500; color: var(--gray-600); }
        .mobile-menu a:hover, .mobile-menu a.active { color: var(--primary); background: var(--primary-50); }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

        /* ── Main ── */
        main { flex: 1; }

        /* ── Footer ── */
        .footer { background: var(--gray-900); color: var(--gray-300); padding: 3rem 0 1.5rem; margin-top: auto; }
        .footer-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 2rem; }
        .footer-brand { display: flex; align-items: center; gap: .5rem; font-weight: 700; font-size: 1.15rem; color: var(--white); margin-bottom: .75rem; }
        .footer-brand img { height: 32px; border-radius: .5rem; object-fit: contain; }
        .footer-about { font-size: .9rem; line-height: 1.7; color: var(--gray-400); max-width: 320px; }
        .footer h4 { color: var(--white); font-size: .95rem; font-weight: 600; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: .5px; }
        .footer ul { list-style: none; }
        .footer ul li { margin-bottom: .5rem; }
        .footer ul li a { color: var(--gray-400); font-size: .9rem; transition: var(--transition); }
        .footer ul li a:hover { color: var(--primary-light); padding-left: 4px; }
        .footer-social { display: flex; gap: .75rem; margin-top: 1.25rem; }
        .footer-social a { display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background: var(--gray-800); color: var(--gray-400); font-size: .85rem; transition: var(--transition); }
        .footer-social a:hover { background: var(--primary); color: var(--white); transform: translateY(-2px); }
        .footer-bottom { border-top: 1px solid var(--gray-800); margin-top: 2rem; padding-top: 1.5rem; text-align: center; font-size: .85rem; color: var(--gray-500); }
        .footer-legal { display: flex; justify-content: center; gap: 1.5rem; margin-top: .75rem; }
        .footer-legal a { color: var(--gray-500); font-size: .82rem; }
        .footer-legal a:hover { color: var(--primary-light); }

        /* ── Support Button & Modal ── */
        .support-btn { position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 200; width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), #8b5cf6); color: var(--white); border: none; cursor: pointer; box-shadow: var(--shadow-xl), 0 0 0 0 rgba(99,102,241,.4); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; transition: var(--transition); animation: pulse-ring 2s infinite; }
        .support-btn:hover { transform: scale(1.08); box-shadow: var(--shadow-xl); }
        @keyframes pulse-ring { 0% { box-shadow: var(--shadow-xl), 0 0 0 0 rgba(99,102,241,.4); } 70% { box-shadow: var(--shadow-xl), 0 0 0 12px rgba(99,102,241,0); } 100% { box-shadow: var(--shadow-xl), 0 0 0 0 rgba(99,102,241,0); } }
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 300; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
        .modal-overlay.open { display: flex; animation: fadeIn .2s ease; }
        .modal-box { background: var(--white); border-radius: var(--radius-xl); padding: 2rem; max-width: 420px; width: 90%; box-shadow: var(--shadow-xl); animation: modalUp .25s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes modalUp { from { opacity: 0; transform: translateY(20px) scale(.96); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }
        .modal-header h3 { font-size: 1.15rem; font-weight: 700; color: var(--gray-900); }
        .modal-close { background: none; border: none; font-size: 1.4rem; color: var(--gray-400); cursor: pointer; padding: .25rem; line-height: 1; transition: var(--transition); }
        .modal-close:hover { color: var(--gray-700); }
        .support-channels { display: flex; flex-direction: column; gap: .75rem; }
        .support-channel { display: flex; align-items: center; gap: .75rem; padding: 1rem; border-radius: var(--radius); border: 1px solid var(--gray-200); transition: var(--transition); text-decoration: none; color: var(--gray-700); }
        .support-channel:hover { border-color: var(--primary); background: var(--primary-50); color: var(--primary); transform: translateX(4px); }
        .support-channel .ch-icon { width: 42px; height: 42px; border-radius: .5rem; background: var(--primary-100); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
        .support-channel .ch-info { font-weight: 600; font-size: .95rem; }
        .support-channel .ch-sub { font-size: .8rem; color: var(--gray-400); font-weight: 400; }

        /* ── Utility / Responsive ── */
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .hamburger { display: flex; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .footer-about { max-width: 100%; }
        }
        @media (max-width: 480px) {
            .footer-grid { grid-template-columns: 1fr; gap: 1.5rem; }
        }
    </style>
    @yield('head')
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="nav-brand">
                @if(!empty($storeSettings['store_logo']))
                    <img src="{{ asset('storage/store/' . $storeSettings['store_logo']) }}" alt="{{ $storeSettings['store_name'] }}">
                @endif
                {{ $storeSettings['store_name'] ?? config('app.name') }}
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a>
                <a href="{{ route('home') }}#reviews" class="{{ request()->query('scroll') === 'reviews' ? 'active' : '' }}">Reviews</a>
                <a href="{{ route('home') }}#about" class="{{ request()->query('scroll') === 'about' ? 'active' : '' }}">About</a>
            </div>
            <button class="hamburger" id="hamburgerBtn" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a>
            <a href="{{ route('home') }}#reviews">Reviews</a>
            <a href="{{ route('home') }}#about">About</a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-brand">
                        @if(!empty($storeSettings['store_logo']))
                            <img src="{{ asset('storage/store/' . $storeSettings['store_logo']) }}" alt="{{ $storeSettings['store_name'] }}">
                        @endif
                        {{ $storeSettings['store_name'] ?? '' }}
                    </div>
                    @if(!empty($storeSettings['about_text']))
                        <p class="footer-about">{{ Str::limit($storeSettings['about_text'], 180) }}</p>
                    @endif
                    @if($socialLinks && $socialLinks->count())
                        <div class="footer-social">
                            @foreach($socialLinks as $link)
                                @if($link->is_active)
                                    <a href="{{ $link->url }}" target="_blank" rel="noopener" title="{{ $link->label }}">@include('partials.platform-icon', ['platform' => $link->platform, 'size' => 18])</a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
                <div>
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">All Products</a></li>
                        <li><a href="{{ route('home') }}#reviews">Reviews</a></li>
                        <li><a href="{{ route('home') }}#about">About Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Support</h4>
                    <ul>
                        <li><a href="{{ route('order.track') }}">Track Order</a></li>
                        @if(!empty($storeSettings['contact_email']))
                            <li><a href="mailto:{{ $storeSettings['contact_email'] }}">Email Us</a></li>
                        @endif
                        @if(!empty($storeSettings['contact_phone']))
                            <li><a href="tel:{{ $storeSettings['contact_phone'] }}">Call Us</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                        <li><a href="{{ route('refund-policy') }}">Refund Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>{{ $storeSettings['copyright_text'] ?? '© ' . date('Y') . ' ' . ($storeSettings['store_name'] ?? '') . '. All rights reserved.' }}</p>
                <div class="footer-legal">
                    <a href="{{ route('privacy-policy') }}">Privacy</a>
                    <a href="{{ route('terms') }}">Terms</a>
                    <a href="{{ route('refund-policy') }}">Refund</a>
                </div>
            </div>
        </div>
    </footer>

    <button class="support-btn" id="supportBtn" aria-label="Support">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
    </button>

    <div class="modal-overlay" id="supportModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Get Support</h3>
                <button class="modal-close" id="closeModal">&times;</button>
            </div>
            <div class="support-channels">
                @if($socialLinks && $socialLinks->count())
                    @foreach($socialLinks as $link)
                        @if($link->is_active)
                            <a href="{{ $link->url }}" target="_blank" rel="noopener" class="support-channel">
                                <div class="ch-icon">@include('partials.platform-icon', ['platform' => $link->platform, 'size' => 22])</div>
                                <div>
                                    <div class="ch-info">{{ $link->label }}</div>
                                    <div class="ch-sub">Chat with us on {{ $link->platform }}</div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                @else
                    <p style="text-align:center;color:var(--gray-400);padding:1rem 0;">No support channels available.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
    (function(){
        var h=document.getElementById('hamburgerBtn'),m=document.getElementById('mobileMenu'),open=false;
        h&&h.addEventListener('click',function(){open=!open;m.classList.toggle('open',open);});
        var sb=document.getElementById('supportBtn'),sm=document.getElementById('supportModal'),cm=document.getElementById('closeModal');
        sb&&sb.addEventListener('click',function(){sm.classList.add('open');});
        cm&&cm.addEventListener('click',function(){sm.classList.remove('open');});
        sm&&sm.addEventListener('click',function(e){if(e.target===sm)sm.classList.remove('open');});
        document.querySelectorAll('a[href^="#"]').forEach(function(a){
            a.addEventListener('click',function(e){
                var id=this.getAttribute('href');if(id.length<2)return;
                var t=document.querySelector(id);
                if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth',block:'start'});if(open){open=false;m.classList.remove('open');}}
            });
        });
    })();
    </script>
    @yield('scripts')
</body>
</html>
