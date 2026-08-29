<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TERESA — Agricultural Pricing Portal, San Jose, Camarines Sur</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zilla+Slab:wght@400;500;600;700&family=Work+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root{
            --emerald:#1B5E20;
            --emerald-dark:#123f15;
            --emerald-mid:#3d7a44;
            --soil:#4A3728;
            --gold:#FFC107;
            --gold-dark:#c98f00;
            --paper:#FBF8F1;
            --paper-dim:#F2EDE0;
            --ink:#1F2A1F;
            --ink-soft:#5b6b5c;
            --line:#dcd4c0;
        }
        *{box-sizing:border-box; margin:0; padding:0;}
        html{scroll-behavior:smooth;}
        body{
            font-family:'Work Sans', sans-serif;
            background:var(--paper);
            color:var(--ink);
            line-height:1.5;
            overflow-x:hidden;
        }
        h1,h2,h3{font-family:'Zilla Slab', serif; font-weight:600; letter-spacing:-0.01em;}
        .mono{font-family:'IBM Plex Mono', monospace;}
        a{color:inherit; text-decoration:none;}
        .wrap{max-width:1180px; margin:0 auto; padding:0 28px;}

        @media (prefers-reduced-motion: reduce){
            *{animation-duration:0.01ms !important; animation-iteration-count:1 !important; scroll-behavior:auto !important;}
        }

        /* ---------- Header ---------- */
        header{
            position:sticky; top:0; z-index:30;
            background:rgba(251,248,241,0.92);
            backdrop-filter:blur(6px);
            border-bottom:1px solid var(--line);
        }
        .header-inner{
            display:flex; align-items:center; justify-content:space-between;
            padding:16px 28px; max-width:1180px; margin:0 auto;
        }
        .brand{display:flex; align-items:center; gap:10px; font-family:'Zilla Slab',serif; font-weight:700; font-size:20px; color:var(--emerald-dark);}
        .brand .mark{
            width:34px; height:34px; border-radius:8px;
            background:linear-gradient(155deg, var(--emerald), var(--emerald-mid));
            display:flex; align-items:center; justify-content:center;
            color:var(--gold); font-size:16px; font-weight:700;
            box-shadow:0 2px 0 var(--emerald-dark);
        }
        .brand small{display:block; font-family:'Work Sans',sans-serif; font-weight:500; font-size:10.5px; color:var(--ink-soft); letter-spacing:0.04em; text-transform:uppercase; margin-top:-2px;}
        nav.auth-links{display:flex; align-items:center; gap:22px;}
        nav.auth-links a{font-weight:600; font-size:14px; color:var(--soil);}
        nav.auth-links a:hover{color:var(--emerald-dark);}
        .btn-register{
            background:var(--emerald); color:var(--paper) !important; padding:9px 20px;
            border-radius:7px; border:2px solid transparent; font-weight:600; font-size:14px;
            transition:border-color .15s;
        }
        .btn-register:hover{border-color:var(--gold);}

        /* ---------- Hero ---------- */
        .hero{
            padding:76px 0 90px;
            position:relative;
        }
        .hero-grid{
            display:grid; grid-template-columns:1.15fr 0.85fr; gap:56px; align-items:center;
        }
        .eyebrow{
            display:inline-flex; align-items:center; gap:8px;
            font-family:'IBM Plex Mono',monospace; font-size:12px; letter-spacing:0.06em;
            color:var(--soil); background:var(--paper-dim); border:1px solid var(--line);
            padding:6px 12px; border-radius:20px; margin-bottom:22px; text-transform:uppercase;
        }
        .eyebrow .dot{width:6px; height:6px; border-radius:50%; background:var(--gold);}
        .hero h1{
            font-size:52px; line-height:1.06; color:var(--emerald-dark); margin-bottom:22px;
        }
        .hero h1 em{font-style:normal; color:var(--soil); position:relative; white-space:nowrap;}
        .hero h1 em::after{
            content:''; position:absolute; left:0; right:0; bottom:6px; height:11px;
            background:var(--gold); z-index:-1; opacity:0.55;
        }
        .hero p.lede{font-size:17.5px; color:var(--ink-soft); max-width:480px; margin-bottom:34px;}
        .hero-ctas{display:flex; gap:14px; margin-bottom:40px;}
        .btn-primary{
            background:var(--emerald); color:var(--paper); padding:14px 28px; border-radius:9px;
            font-weight:700; font-size:15px; border:2px solid transparent; transition:border-color .15s, transform .15s;
            display:inline-flex; align-items:center; gap:8px;
        }
        .btn-primary:hover{border-color:var(--gold); transform:translateY(-1px);}
        .btn-secondary{
            background:transparent; color:var(--soil); padding:14px 26px; border-radius:9px;
            font-weight:600; font-size:15px; border:1.5px solid var(--line); transition:.15s;
        }
        .btn-secondary:hover{border-color:var(--soil); background:var(--paper-dim);}
        .trust-line{display:flex; gap:26px; flex-wrap:wrap;}
        .trust-line div{font-size:13px; color:var(--ink-soft);}
        .trust-line strong{display:block; font-family:'Zilla Slab',serif; font-size:22px; color:var(--emerald-dark); font-weight:700;}

        /* ---------- Ticker card (signature element) ---------- */
        .ticker-card{
            background:var(--emerald-dark); border-radius:16px; padding:0; overflow:hidden;
            box-shadow:0 20px 50px -18px rgba(18,63,21,0.55);
            border:1px solid #0d2c10;
        }
        .ticker-head{
            display:flex; justify-content:space-between; align-items:center;
            padding:18px 22px; border-bottom:1px solid rgba(255,255,255,0.08);
        }
        .ticker-head .label{color:var(--gold); font-family:'IBM Plex Mono',monospace; font-size:12px; letter-spacing:0.08em; text-transform:uppercase;}
        .ticker-head .live{display:flex; align-items:center; gap:6px; color:#cfe6d1; font-size:11.5px; font-family:'IBM Plex Mono',monospace;}
        .live .pulse{width:7px; height:7px; border-radius:50%; background:#6fe08a; animation:pulse 1.8s infinite;}
        @keyframes pulse{0%,100%{opacity:1;} 50%{opacity:0.3;}}
        .ticker-body{height:340px; overflow:hidden; position:relative;}
        .ticker-body::before, .ticker-body::after{
            content:''; position:absolute; left:0; right:0; height:36px; z-index:2; pointer-events:none;
        }
        .ticker-body::before{top:0; background:linear-gradient(var(--emerald-dark), transparent);}
        .ticker-body::after{bottom:0; background:linear-gradient(transparent, var(--emerald-dark));}
        .ticker-scroll{
            display:flex; flex-direction:column;
            animation:scrollUp 22s linear infinite;
        }
        .ticker-body:hover .ticker-scroll{ animation-play-state:paused; }
        @keyframes scrollUp{
            0%{ transform:translateY(0); }
            100%{ transform:translateY(-50%); }
        }
        .tick-row{
            display:flex; justify-content:space-between; align-items:center;
            padding:14px 22px; border-bottom:1px solid rgba(255,255,255,0.06);
        }
        .tick-row .name{color:#eef4ee; font-size:14px; font-weight:500;}
        .tick-row .name span{display:block; font-size:11px; color:#8fae91; font-family:'IBM Plex Mono',monospace; margin-top:1px;}
        .tick-right{display:flex; align-items:center; gap:10px;}
        .tick-price{font-family:'IBM Plex Mono',monospace; color:#fff; font-size:14.5px; font-weight:500;}
        .tick-change{font-family:'IBM Plex Mono',monospace; font-size:12px; padding:3px 7px; border-radius:5px; display:flex; align-items:center; gap:3px;}
        .up{color:#123f15; background:var(--gold);}
        .down{color:#f1e4d8; background:#6b5140;}
        .ticker-foot{
            padding:13px 22px; font-size:11.5px; color:#9fc0a1; font-family:'IBM Plex Mono',monospace;
            border-top:1px solid rgba(255,255,255,0.08);
        }

        /* ---------- Section shared ---------- */
        section{padding:80px 0;}
        .section-head{max-width:600px; margin-bottom:52px;}
        .section-head .eyebrow{margin-bottom:16px;}
        .section-head h2{font-size:34px; color:var(--emerald-dark); margin-bottom:14px;}
        .section-head p{color:var(--ink-soft); font-size:15.5px;}

        /* ---------- Roles (three ways) ---------- */
        .roles{background:var(--paper-dim); border-top:1px solid var(--line); border-bottom:1px solid var(--line);}
        .role-grid{display:grid; grid-template-columns:repeat(3,1fr); gap:0; border:1px solid var(--line); border-radius:14px; overflow:hidden; background:var(--paper);}
        .role-col{padding:36px 30px; position:relative; transition:background-color .2s ease;}
        .role-col + .role-col{border-left:1px solid var(--line);}
        .role-col:hover{background-color:#fff8e1;}
        .role-col:hover h3{color:var(--gold-dark);}
        .role-col:hover .role-tag{color:var(--gold-dark);}
        .role-tag{font-family:'IBM Plex Mono',monospace; font-size:11.5px; color:var(--soil); letter-spacing:0.06em; text-transform:uppercase; margin-bottom:14px; display:block;}
        .role-col h3{font-size:22px; color:var(--emerald-dark); margin-bottom:10px;}
        .role-col p{color:var(--ink-soft); font-size:14px; margin-bottom:18px;}
        .role-col ul{list-style:none;}
        .role-col li{font-size:13.5px; color:var(--ink); padding:6px 0 6px 20px; position:relative; border-top:1px dashed var(--line);}
        .role-col li:first-child{border-top:none;}
        .role-col li::before{content:'—'; position:absolute; left:0; color:var(--gold-dark);}

        /* ---------- Feature ledger ---------- */
        .ledger-grid{display:grid; grid-template-columns:repeat(2,1fr); gap:1px; background:var(--line); border:1px solid var(--line); border-radius:14px; overflow:hidden;}
        .ledger-item{background:var(--paper); padding:30px 32px; display:flex; gap:18px; transition:background-color .2s ease;}
        .ledger-item:hover{background-color:#fff8e1;}
        .ledger-item:hover h4{color:var(--gold-dark);}
        .ledger-item:hover .ledger-num{color:var(--soil);}
        .ledger-num{font-family:'IBM Plex Mono',monospace; color:var(--gold-dark); font-size:13px; font-weight:600; flex-shrink:0; padding-top:3px;}
        .ledger-item h4{font-size:17px; color:var(--emerald-dark); margin-bottom:6px; font-family:'Zilla Slab',serif; font-weight:600;}
        .ledger-item p{font-size:13.5px; color:var(--ink-soft);}

        /* ---------- Trust strip ---------- */
        .trust-strip{
            background:var(--emerald-dark); color:#eef4ee; padding:40px 0;
        }
        .trust-strip .wrap{display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:20px;}
        .trust-strip .badge{
            display:flex; align-items:center; gap:14px;
        }
        .trust-strip .badge .icon{
            width:44px; height:44px; border-radius:50%; border:1.5px solid var(--gold);
            display:flex; align-items:center; justify-content:center; color:var(--gold); font-size:18px;
        }
        .trust-strip .badge span{display:block; font-size:12px; color:#9fc0a1; font-family:'IBM Plex Mono',monospace;}
        .trust-strip .badge strong{display:block; font-size:15px; font-family:'Zilla Slab',serif;}

        /* ---------- CTA band ---------- */
        .cta-band{
            background:var(--paper); text-align:center; padding:100px 0;
            border-bottom:1px solid var(--line);
        }
        .cta-band h2{font-size:38px; color:var(--emerald-dark); margin-bottom:16px; max-width:640px; margin-left:auto; margin-right:auto;}
        .cta-band p{color:var(--ink-soft); font-size:16px; margin-bottom:32px;}
        .cta-buttons{display:flex; gap:14px; justify-content:center;}

        /* ---------- Footer ---------- */
        footer{padding:36px 0; background:var(--paper-dim);}
        footer .wrap{display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;}
        footer p{font-size:13px; color:var(--ink-soft);}
        footer .brand{font-size:15px;}

        /* ---------- Reveal on scroll ---------- */
        .reveal{opacity:0; transform:translateY(16px); transition:opacity .6s ease, transform .6s ease;}
        .reveal.in{opacity:1; transform:translateY(0);}

        /* ---------- Responsive ---------- */
        @media (max-width:900px){
            .hero-grid{grid-template-columns:1fr;}
            .hero h1{font-size:38px;}
            .role-grid{grid-template-columns:1fr;}
            .role-col + .role-col{border-left:none; border-top:1px solid var(--line);}
            .ledger-grid{grid-template-columns:1fr;}
            nav.auth-links{gap:12px;}
            .trust-line{gap:16px;}
        }
        :focus-visible{outline:2.5px solid var(--gold-dark); outline-offset:2px;}
    </style>
</head>
<body>

    <header>
        <div class="header-inner">
            <div class="brand">
    <img src="{{ asset('GROUP3-LOGO.png') }}" alt="TERESA logo" style="width: 80px;px;height:80px;border-radius:8px;object-fit:contain;">
    <div>TERESA<small>San Jose, Camarines Sur</small></div>
</div>
            <nav class="auth-links">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-register">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-register">Register</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="wrap hero-grid">
            <div>
                <span class="eyebrow"><span class="dot"></span> Municipal Agriculture Office · San Jose</span>
                <h1>Fair prices,<br><em>straight from the farm.</em></h1>
                <p class="lede">TERESA connects San Jose's farmers directly with buyers — real listings, transparent pricing, and room to negotiate. No middlemen guessing what your harvest is worth.</p>
                <div class="hero-ctas">
                    <a href="{{ route('register') }}" class="btn-primary">Create your account →</a>
                    <a href="{{ route('login') }}" class="btn-secondary">I already have one</a>
                </div>
            </div>

            <div class="ticker-card">
                <div class="ticker-head">
                    <span class="label">Today's Market</span>
                    <span class="live"><span class="pulse"></span> Live pricing</span>
                </div>
                <div class="ticker-body">
    <div class="ticker-scroll">
        @php
            $tickerProducts = \App\Models\Product::with('farmer')
                ->where('status', 'active')
                ->latest()
                ->limit(8)
                ->get();
        @endphp
        @forelse ($tickerProducts as $product)
            @for ($r = 0; $r < 2; $r++)
                <div class="tick-row">
                    <div class="name">{{ $product->product_name }}<span>{{ $product->farmer->barangay }} · per {{ $product->unit_of_measurement }}</span></div>
                    <div class="tick-right">
                        <span class="tick-price">₱{{ number_format($product->selling_price, 2) }}</span>
                        <span class="tick-change {{ in_array($product->freshness_status, ['Very Fresh', 'Fresh']) ? 'up' : 'down' }}">{{ $product->freshness_status }}</span>
                    </div>
                </div>
            @endfor
        @empty
            <div class="tick-row">
                <div class="name">No listings yet<span>Check back soon</span></div>
            </div>
        @endforelse
    </div>
</div>
<div class="ticker-foot">Live listings from registered farmers</div>
            </div>
        </div>
    </section>

    <section class="roles">
        <div class="wrap">
            <div class="section-head reveal">
                <span class="eyebrow">USERS</span>
                <h2>Built around who's using it</h2>
                <p>Farmers, buyers, and the Municipal Agriculture Office each get exactly what their role needs — nothing more.</p>
            </div>
            <div class="role-grid reveal">
                <div class="role-col">
                    <span class="role-tag">Farmer</span>
                    <h3>List. Negotiate. Sell.</h3>
                    <p>Manage your own storefront and see every order come in.</p>
                    <ul>
                        <li>Post produce with harvest date &amp; quality grade</li>
                        <li>Review and accept buyer offers</li>
                        <li>Track orders through pickup or delivery</li>
                        <li>See your own sales trends and ratings</li>
                    </ul>
                </div>
                <div class="role-col">
                    <span class="role-tag">Buyer</span>
                    <h3>Browse. Bargain. Buy.</h3>
                    <p>Shop directly from growers in your own barangay.</p>
                    <ul>
                        <li>Search listings by commodity or category</li>
                        <li>Message farmers before you order</li>
                        <li>Make an offer below the listed price</li>
                        <li>Rate your experience after delivery</li>
                    </ul>
                </div>
                <div class="role-col">
                    <span class="role-tag">Municipal Admin</span>
                    <h3>Oversee. Advise. Protect.</h3>
                    <p>Keep the marketplace fair without touching a single sale.</p>
                    <ul>
                        <li>Manage farmer &amp; buyer accounts</li>
                        <li>Review reported accounts</li>
                        <li>Publish agricultural advisories</li>
                        <li>Watch municipality-wide market trends</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="wrap">
            <div class="section-head reveal">
                <span class="eyebrow">Features and Fuction</span>
                <h2>Everything a local market needs</h2>
                <p>No feature here for its own sake — each one answers something San Jose's farmers and buyers actually asked for.</p>
            </div>
            <div class="ledger-grid reveal">
                <div class="ledger-item">
                    <span class="ledger-num">01</span>
                    <div><h4>Direct negotiation</h4><p>Buyers can offer a lower price for bulk orders — farmers decide, every time.</p></div>
                </div>
                <div class="ledger-item">
                    <span class="ledger-num">02</span>
                    <div><h4>Freshness and Quality at a glance</h4><p>Harvest date and shelf life are calculated automatically on every listing.</p></div>
                </div>
                <div class="ledger-item">
                    <span class="ledger-num">03</span>
                    <div><h4>Built-in messaging</h4><p>Ask a farmer a question before you commit — no phone number required.</p></div>
                </div>
                <div class="ledger-item">
                    <span class="ledger-num">04</span>
                    <div><h4>Market analytics</h4><p>See which commodities are in demand this month, municipality-wide.</p></div>
                </div>
                <div class="ledger-item">
                    <span class="ledger-num">05</span>
                    <div><h4>Agricultural advisories</h4><p>Pest alerts and planting schedules, published by the Municipal Agriculture Office.</p></div>
                </div>
                <div class="ledger-item">
                    <span class="ledger-num">06</span>
                    <div><h4>Verified accounts</h4><p>Every farmer and buyer registers with a real barangay and contact number.</p></div>
                </div>
            </div>
        </div>
    </section>


    <section class="cta-band">
        <div class="wrap">
            <h2 class="reveal">Whether you're growing it or buying it, TERESA gets you a fair deal.</h2>
            <p class="reveal">Free to join. Takes less than two minutes.</p>
            <div class="cta-buttons reveal">
                <a href="{{ route('register') }}" class="btn-primary">Register now →</a>
                <a href="{{ route('login') }}" class="btn-secondary">Log in</a>
            </div>
        </div>
    </section>

    <footer>
        <div class="wrap">
            <div class="brand">
              <img src="{{ asset('GROUP3-LOGO.png') }}" alt="TERESA logo" style="width:70px;height: 70px;px;border-radius:6px;object-fit:contain;">
            </div>
            <p>Technology-Enabled Resource for Economic and Sales Advancement — San Jose, Camarines Sur</p>
        </div>
    </footer>

    <script>
        const revealEls = document.querySelectorAll('.reveal');
        const io = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('in'); });
        }, { threshold: 0.15 });
        revealEls.forEach(el => io.observe(el));
    </script>
</body>
</html>