@extends('layouts.app')
@section('head')
<style>
/* ── Hero ── */
.hero { position: relative; overflow: hidden; background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%); color: var(--white); }
.hero-track { display: flex; transition: transform .5s cubic-bezier(.4,0,.2,1); }
.hero-slide { min-width: 100%; position: relative; }
.hero-bg { position: absolute; inset: 0; overflow: hidden; z-index: 0; }
.hero-bg img { width: 100%; height: 100%; object-fit: cover; filter: blur(24px) saturate(1.3); transform: scale(1.25); opacity: .55; }
.hero-bg::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(30,27,75,.85), rgba(49,46,129,.68) 50%, rgba(67,56,202,.62)); }
.hero-slide-inner { display: flex; align-items: center; min-height: 420px; padding: 3rem 0; position: relative; z-index: 1; }
.hero-slide .container { display: grid; grid-template-columns: minmax(0, 1fr) minmax(260px, 420px); align-items: center; column-gap: 3rem; row-gap: 1.5rem; }
.hero-text { z-index: 2; grid-column: 1; grid-row: 1; align-self: center; }
.hero-text h1 { font-size: 2.5rem; font-weight: 800; line-height: 1.15; margin-bottom: 1rem; }
.hero-text p { font-size: 1.1rem; color: rgba(255,255,255,.8); margin-bottom: 1.5rem; max-width: 520px; line-height: 1.7; }
.hero-cta { display: inline-flex; align-items: center; gap: .5rem; padding: .85rem 2rem; background: var(--white); color: var(--primary-dark); font-weight: 700; border-radius: 50px; font-size: 1rem; transition: var(--transition); border: none; cursor: pointer; text-decoration: none; grid-column: 1; grid-row: 2; justify-self: start; align-self: start; }
.hero-cta:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); color: var(--primary-dark); }
.hero-img { position: relative; z-index: 2; grid-column: 2; grid-row: 1 / span 2; justify-self: center; width: 100%; max-width: 420px; }
.hero-img img { width: 100%; border-radius: var(--radius-xl); box-shadow: var(--shadow-xl); aspect-ratio: 4/3; object-fit: cover; }
.hero-nav { position: absolute; bottom: 1.5rem; left: 50%; transform: translateX(-50%); display: flex; gap: .5rem; z-index: 10; }
.hero-dot { width: 10px; height: 10px; border-radius: 50%; border: 2px solid rgba(255,255,255,.5); background: transparent; cursor: pointer; transition: var(--transition); }
.hero-dot.active { background: var(--white); border-color: var(--white); }
.hero-arrow { position: absolute; top: 50%; transform: translateY(-50%); z-index: 10; width: 42px; height: 42px; border-radius: 50%; background: rgba(255,255,255,.15); backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,.2); color: var(--white); font-size: 1.1rem; cursor: pointer; transition: var(--transition); display: flex; align-items: center; justify-content: center; }
.hero-arrow:hover { background: rgba(255,255,255,.25); }
.hero-arrow.prev { left: 1.5rem; }
.hero-arrow.next { right: 1.5rem; }

/* ── Sections ── */
.section { padding: 4rem 0; }
.section-header { text-align: center; margin-bottom: 2.5rem; }
.section-header h2 { font-size: 1.75rem; font-weight: 800; color: var(--gray-900); }
.section-header p { color: var(--gray-500); margin-top: .5rem; font-size: 1rem; }

/* ── Product Cards ── */
.pcard-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.25rem; }
.pcard-scroll { display: flex; gap: 1.25rem; overflow-x: auto; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; padding-bottom: .5rem; }
.pcard-scroll::-webkit-scrollbar { height: 4px; }
.pcard-scroll::-webkit-scrollbar-track { background: var(--gray-100); border-radius: 4px; }
.pcard-scroll::-webkit-scrollbar-thumb { background: var(--primary-light); border-radius: 4px; }
.pcard-scroll .pcard { min-width: 260px; max-width: 260px; scroll-snap-align: start; flex-shrink: 0; }
.pcard { background: var(--white); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow); transition: var(--transition); cursor: pointer; border: 1px solid var(--gray-100); }
.pcard:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); }
.pcard-img { position: relative; aspect-ratio: 4/3; overflow: hidden; background: var(--gray-100); }
.pcard-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s ease; }
.pcard:hover .pcard-img img { transform: scale(1.04); }
.pcard-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: var(--gray-100); }
.pcard-badge { position: absolute; top: .75rem; left: .75rem; background: #ef4444; color: var(--white); font-size: .75rem; font-weight: 700; padding: .25rem .65rem; border-radius: 50px; }
.pcard-unavailable { position: absolute; top: .75rem; right: .75rem; background: var(--gray-800); color: var(--white); font-size: .72rem; font-weight: 600; padding: .25rem .65rem; border-radius: 50px; }
.pcard-body { padding: 1rem 1.15rem 1.25rem; }
.pcard-title { font-size: 1rem; font-weight: 700; color: var(--gray-900); margin-bottom: .25rem; line-height: 1.35; }
.pcard-subtitle { font-size: .82rem; color: var(--gray-500); margin-bottom: .65rem; line-height: 1.5; }
.pcard-price { display: flex; align-items: baseline; gap: .5rem; margin-bottom: .85rem; }
.pcard-current { font-size: 1.1rem; font-weight: 800; color: var(--primary); }
.pcard-old { font-size: .85rem; color: var(--gray-400); text-decoration: line-through; }
.pcard-btn { width: 100%; padding: .6rem; background: var(--primary-50); color: var(--primary); font-weight: 600; font-size: .88rem; border: none; border-radius: var(--radius); cursor: pointer; transition: var(--transition); }
.pcard-btn:hover { background: var(--primary); color: var(--white); }
.pcard-btn:disabled { background: var(--gray-100); color: var(--gray-400); cursor: not-allowed; }

/* ── Reviews ── */
.review-carousel { max-width: 700px; margin: 0 auto; position: relative; min-height: 200px; }
.review-card { background: var(--white); border-radius: var(--radius-lg); padding: 2rem; box-shadow: var(--shadow-md); text-align: center; border: 1px solid var(--gray-100); position: relative; }
.review-card-inner { animation: fadeUp .4s ease; }
@keyframes fadeUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
.review-stars { color: #f59e0b; font-size: 1.15rem; margin-bottom: .75rem; letter-spacing: 2px; }
.review-text { font-size: 1rem; color: var(--gray-700); line-height: 1.75; margin-bottom: 1rem; font-style: italic; }
.review-author { font-weight: 700; color: var(--gray-900); font-size: .95rem; }
.review-nav { display: flex; justify-content: center; gap: .5rem; margin-top: 1.5rem; }
.review-dot { width: 8px; height: 8px; border-radius: 50%; border: none; background: var(--gray-300); cursor: pointer; transition: var(--transition); }
.review-dot.active { background: var(--primary); width: 24px; border-radius: 4px; }

/* ── About ── */
.about-section { background: var(--white); border-radius: var(--radius-xl); padding: 3rem 2.5rem; max-width: 800px; margin: 0 auto; text-align: center; box-shadow: var(--shadow); border: 1px solid var(--gray-100); }
.about-section h2 { font-size: 1.6rem; font-weight: 800; color: var(--gray-900); margin-bottom: 1rem; }
.about-section p { color: var(--gray-600); line-height: 1.8; font-size: 1rem; max-width: 600px; margin: 0 auto; }
.about-contact { display: flex; justify-content: center; gap: 2rem; margin-top: 1.5rem; flex-wrap: wrap; }
.about-contact-item { display: flex; align-items: center; gap: .5rem; color: var(--gray-600); font-size: .9rem; }
.about-contact-item strong { color: var(--gray-800); }
.view-all-link { display: inline-flex; align-items: center; gap: .4rem; color: var(--primary); font-weight: 600; font-size: .95rem; margin-top: 1rem; }
.view-all-link:hover { gap: .6rem; }

/* ── Product Modal ── */
#productModal.modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 300; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
#productModal.modal-overlay.open { display: flex; animation: fadeIn .2s ease; }
#productModal .modal-box { background: var(--white); border-radius: var(--radius-xl); max-width: 720px; width: 92%; max-height: 88vh; overflow-y: auto; box-shadow: var(--shadow-xl); animation: modalUp .25s ease; }
#productModal .modal-close { position: absolute; top: 1rem; right: 1rem; background: rgba(0,0,0,.1); border: none; width: 36px; height: 36px; border-radius: 50%; font-size: 1.2rem; cursor: pointer; color: var(--gray-600); display: flex; align-items: center; justify-content: center; transition: var(--transition); z-index: 5; }
#productModal .modal-close:hover { background: rgba(0,0,0,.2); }
#productModal .modal-img { width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: var(--radius-xl) var(--radius-xl) 0 0; }
#productModal .modal-body { padding: 1.75rem; }
#productModal .modal-title { font-size: 1.35rem; font-weight: 800; color: var(--gray-900); margin-bottom: .25rem; }
#productModal .modal-subtitle { color: var(--gray-500); font-size: .9rem; margin-bottom: 1rem; }
#productModal .modal-price-row { display: flex; align-items: baseline; gap: .75rem; margin-bottom: 1rem; }
#productModal .modal-price { font-size: 1.4rem; font-weight: 800; color: var(--primary); }
#productModal .modal-old-price { font-size: 1rem; color: var(--gray-400); text-decoration: line-through; }
#productModal .modal-discount { background: #fef2f2; color: #ef4444; font-size: .78rem; font-weight: 700; padding: .2rem .6rem; border-radius: 50px; }
#productModal .modal-desc { color: var(--gray-600); line-height: 1.75; font-size: .95rem; margin-bottom: 1.25rem; }
#productModal .modal-features { margin-bottom: 1.25rem; }
#productModal .modal-features h4 { font-size: .95rem; font-weight: 700; color: var(--gray-800); margin-bottom: .5rem; }
#productModal .modal-features ul { list-style: none; }
#productModal .modal-features li { padding: .3rem 0; font-size: .9rem; color: var(--gray-600); display: flex; align-items: flex-start; gap: .5rem; }
#productModal .modal-features li::before { content: '✓'; color: var(--accent); font-weight: 700; flex-shrink: 0; }
#productModal .modal-buy { display: block; width: 100%; padding: .85rem; background: linear-gradient(135deg, var(--primary), #8b5cf6); color: var(--white); font-weight: 700; font-size: 1rem; border: none; border-radius: var(--radius); cursor: pointer; text-align: center; transition: var(--transition); text-decoration: none; }
#productModal .modal-buy:hover { opacity: .92; transform: translateY(-1px); color: var(--white); }
#productModal .modal-loading { display: flex; align-items: center; justify-content: center; padding: 3rem; color: var(--gray-400); }
#productModal .modal-loading::after { content: ''; width: 28px; height: 28px; border: 3px solid var(--gray-200); border-top-color: var(--primary); border-radius: 50%; animation: spin .6s linear infinite; margin-left: .75rem; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes modalUp { from { opacity: 0; transform: translateY(20px) scale(.96); } to { opacity: 1; transform: translateY(0) scale(1); } }
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Hero Responsive ── */
@media (max-width: 768px) {
    .hero-slide-inner { min-height: 340px; }
    .hero-slide .container { grid-template-columns: 1fr; text-align: center; gap: 1.25rem; }
    .hero-text h1 { font-size: 1.7rem; }
    .hero-text { grid-row: auto; order: 1; }
    .hero-text p { margin-left: auto; margin-right: auto; }
    .hero-cta { grid-row: auto; order: 3; justify-self: center; }
    .hero-img { grid-row: auto; order: 2; flex: none; max-width: 280px; width: 100%; }
    .hero-arrow { display: none; }
    .pcard-grid { grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); }
    .section { padding: 2.5rem 0; }
    .about-section { padding: 2rem 1.25rem; }
}
</style>
@endsection

@section('content')

@if(isset($banners) && $banners->count())
<section class="hero" id="heroCarousel">
    <div class="hero-track" id="heroTrack">
        @foreach($banners as $banner)
        <div class="hero-slide">
            <div class="hero-bg">
                @if(!empty($banner->image))
                    <img src="{{ asset('storage/banners/' . $banner->image) }}" alt="">
                @endif
            </div>
            <div class="hero-slide-inner">
                <div class="container">
                    <div class="hero-text">
                        <h1>{{ $banner->title ?? 'Welcome' }}</h1>
                        @if(!empty($banner->subtitle))
                            <p>{{ $banner->subtitle }}</p>
                        @endif
                    </div>
                    @if(!empty($banner->image))
                    <div class="hero-img">
                        <img src="{{ asset('storage/banners/' . $banner->image) }}" alt="{{ $banner->title }}">
                    </div>
                    @endif
                    @if(!empty($banner->button_text) && ($banner->action_type ?? 'none') !== 'none')
                        @php
                            $btnHref = null;
                            $actionType = $banner->action_type ?? '';
                            if (in_array($actionType, ['product', 'product_page'], true)) {
                                if ($banner->actionProduct && $banner->actionProduct->is_active) {
                                    $btnHref = route('products.show', $banner->actionProduct->slug);
                                }
                            } elseif ($actionType === 'external_url' && !empty($banner->action_url)) {
                                $btnHref = $banner->action_url;
                            }
                        @endphp
                        @if($btnHref)
                            <a href="{{ $btnHref }}" class="hero-cta">{{ $banner->button_text }} →</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <button class="hero-arrow prev" id="heroPrev">‹</button>
    <button class="hero-arrow next" id="heroNext">›</button>
    <div class="hero-nav" id="heroNav">
        @foreach($banners as $i => $banner)
            <button class="hero-dot {{ $i===0?'active':'' }}" data-slide="{{ $i }}"></button>
        @endforeach
    </div>
</section>
@endif

@if(isset($products) && $products->count())
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Featured Products</h2>
            <p>Discover our curated collection of premium digital products</p>
        </div>
        <div class="pcard-scroll">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div style="text-align:center;margin-top:1.5rem;">
            <a href="{{ route('products.index') }}" class="view-all-link">View All Products →</a>
        </div>
    </div>
</section>
@endif

@if(isset($reviews) && $reviews->count())
<section class="section" id="reviews" style="background:var(--gray-100);">
    <div class="container">
        <div class="section-header">
            <h2>What Our Customers Say</h2>
            <p>Real reviews from real customers</p>
        </div>
        <div class="review-carousel" id="reviewCarousel">
            @foreach($reviews as $ri => $review)
            <div class="review-card" style="display:{{ $ri===0?'block':'none' }}" data-review="{{ $ri }}">
                <div class="review-card-inner">
                    <div class="review-stars">{{ str_repeat('★', $review->rating ?? 5) }}{{ str_repeat('☆', max(0, 5 - ($review->rating ?? 5))) }}</div>
                    <p class="review-text">"{{ $review->review_text ?? '' }}"</p>
                    <div class="review-author">{{ $review->customer_name ?? 'Customer' }}</div>
                </div>
            </div>
            @endforeach
            <div class="review-nav" id="reviewNav">
                @foreach($reviews as $i => $r)
                    <button class="review-dot {{ $i===0?'active':'' }}" data-idx="{{ $i }}"></button>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@if(!empty($storeSettings['about_text']))
<section class="section" id="about">
    <div class="container">
        <div class="about-section">
            <h2>About {{ $storeSettings['store_name'] ?? 'Us' }}</h2>
            <p>{!! nl2br(e($storeSettings['about_text'])) !!}</p>
            <div class="about-contact">
                @if(!empty($storeSettings['contact_email']))
                    <div class="about-contact-item"><strong>Email:</strong> {{ $storeSettings['contact_email'] }}</div>
                @endif
                @if(!empty($storeSettings['contact_phone']))
                    <div class="about-contact-item"><strong>Phone:</strong> {{ $storeSettings['contact_phone'] }}</div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

@include('partials.product-modal')

@endsection

@section('scripts')
<script>
(function(){
    /* Hero Carousel */
    var track=document.getElementById('heroTrack'), dots=document.querySelectorAll('.hero-dot'),
        prev=document.getElementById('heroPrev'), next=document.getElementById('heroNext');
    if(!track) return;
    var slides=track.children.length, cur=0, auto;
    function go(i){ cur=((i%slides)+slides)%slides; track.style.transform='translateX(-'+cur*100+'%)'; dots.forEach(function(d,j){d.classList.toggle('active',j===cur);}); }
    dots.forEach(function(d){d.addEventListener('click',function(){go(+d.dataset.slide);resetAuto();});});
    if(prev) prev.addEventListener('click',function(){go(cur-1);resetAuto();});
    if(next) next.addEventListener('click',function(){go(cur+1);resetAuto();});
    function startAuto(){auto=setInterval(function(){go(cur+1);},5000);}
    function resetAuto(){clearInterval(auto);startAuto();}
    startAuto();
    var hx=0;
    track.addEventListener('touchstart',function(e){hx=e.touches[0].clientX;},{passive:true});
    track.addEventListener('touchend',function(e){var dx=e.changedTouches[0].clientX-hx;if(Math.abs(dx)>50){dx>0?go(cur-1):go(cur+1);resetAuto();}});

    /* Review Carousel */
    var cards=document.querySelectorAll('.review-card'),rdots=document.querySelectorAll('.review-dot'),ri=0,rt;
    function goReview(j){ri=((j%cards.length)+cards.length)%cards.length;cards.forEach(function(c,k){c.style.display=k===ri?'block':'none';});rdots.forEach(function(d,k){d.classList.toggle('active',k===ri);});}
    rdots.forEach(function(d){d.addEventListener('click',function(){goReview(+d.dataset.idx);clearInterval(rt);rt=setInterval(function(){goReview(ri+1);},6000);});});
    if(cards.length>1) rt=setInterval(function(){goReview(ri+1);},6000);
})();
</script>
@endsection
