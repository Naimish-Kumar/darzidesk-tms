<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $segment['meta_title'] }}</title>
    <meta name="description" content="{{ $segment['meta_desc'] }}"/>
    <meta name="keywords" content="tailoring software, tailor shop management app, boutique software india, darzi software, tailor billing app, measurement app"/>
    
    <!-- OpenGraph -->
    <meta property="og:title" content="{{ $segment['meta_title'] }}"/>
    <meta property="og:description" content="{{ $segment['meta_desc'] }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}"/>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}"/>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"/>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}"/>
    <link rel="manifest" href="{{ asset('site.webmanifest') }}"/>

    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>

    <!-- Tailwind & Google Fonts -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              primary: "#E5A93C",
              "primary-hover": "#F5BE58",
              "primary-muted": "rgba(229, 169, 60, 0.12)",
              "on-primary": "#050B14",
              background: "#050B14",
              surface: "#0A1424",
              "surface-card": "#0E1C30",
              "surface-hover": "#13253E",
              "on-surface": "#F8FAFC",
              "on-surface-variant": "#94A3B8",
              "on-surface-muted": "#64748B"
            },
            fontFamily: {
              sans: ["Plus Jakarta Sans", "system-ui", "sans-serif"],
              mono: ["JetBrains Mono", "monospace"]
            }
          }
        }
      }
    </script>
    <style>
        .hero-mesh {
            background-image: radial-gradient(at 50% 0%, rgba(229, 169, 60, 0.12) 0px, transparent 60%),
                              radial-gradient(at 100% 100%, rgba(14, 28, 48, 0.5) 0px, transparent 50%);
        }
        .btn-gold {
            background: linear-gradient(135deg, #E5A93C 0%, #C88E28 100%);
            color: #050B14;
            font-weight: 700;
            transition: all 0.25s ease;
            box-shadow: 0 4px 18px rgba(229, 169, 60, 0.25);
        }
        .btn-gold:hover {
            background: linear-gradient(135deg, #F5BE58 0%, #E5A93C 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(229, 169, 60, 0.38);
        }
        .btn-outline-gold {
            border: 1px solid rgba(229, 169, 60, 0.4);
            color: #F5BE58;
            font-weight: 600;
            transition: all 0.25s ease;
        }
        .btn-outline-gold:hover {
            background: rgba(229, 169, 60, 0.08);
            border-color: #E5A93C;
            color: #FFFFFF;
        }
        .glass-header {
            background: rgba(5, 11, 20, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }
        .card-modern {
            background: #0A1424;
            border: 1px solid rgba(255, 255, 255, 0.07);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-modern:hover {
            border-color: rgba(229, 169, 60, 0.4);
            transform: translateY(-3px);
            box-shadow: 0 16px 32px -8px rgba(0, 0, 0, 0.5);
        }
        .whatsapp-float {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 99;
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.35);
        }
    </style>
</head>
<body class="bg-background text-on-surface font-sans antialiased selection:bg-primary selection:text-on-primary">

    <!-- WhatsApp Floating Action Button -->
    <a href="https://wa.me/919536824061?text=Hi%20DarziDesk%20Team%2C%20I%20want%20to%20learn%20more%20about%20{{ urlencode($segment['h1']) }}%20and%20book%20a%20free%20demo." target="_blank" aria-label="Chat with DarziDesk on WhatsApp" class="whatsapp-float bg-[#25D366] text-white p-3.5 md:px-5 md:py-3.5 rounded-full flex items-center gap-2.5 hover:bg-[#20ba59] transition-all font-bold text-sm">
        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
        <span class="hidden md:inline">WhatsApp Us</span>
    </a>

    <!-- Top Navigation Bar -->
    <header class="fixed top-0 w-full glass-header z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" class="h-9 w-auto max-w-[190px] object-contain">
                </a>
                <nav class="hidden lg:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium">Home</a>
                    <a href="{{ route('home') }}#features" class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium">Features</a>
                    <a href="{{ route('pricing.public') }}" class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium">Pricing</a>
                    <a href="{{ route('blog.index') }}" class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium">Blog</a>
                    <a href="{{ route('about.us') }}" class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium">About Us</a>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="hidden sm:inline-flex px-4 py-2 rounded-xl text-sm font-semibold text-on-surface hover:text-primary transition-colors">Login</a>
                <a href="{{ route('register') }}" class="btn-gold px-4 py-2 rounded-xl text-sm font-bold">Start Free Trial</a>
                <button onclick="document.getElementById('seg-mobile-nav').classList.toggle('hidden')" class="lg:hidden p-2 rounded-xl text-on-surface hover:text-primary transition-colors" aria-label="Toggle navigation menu">
                    <span class="material-symbols-outlined text-2xl">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div id="seg-mobile-nav" class="hidden lg:hidden bg-surface border-t border-white/[0.06]">
            <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col gap-1">
                <a href="{{ route('home') }}" class="py-3 px-4 rounded-xl text-sm font-medium text-on-surface-variant hover:text-primary hover:bg-white/[0.04] transition-all">Home</a>
                <a href="{{ route('home') }}#features" class="py-3 px-4 rounded-xl text-sm font-medium text-on-surface-variant hover:text-primary hover:bg-white/[0.04] transition-all">Features</a>
                <a href="{{ route('pricing.public') }}" class="py-3 px-4 rounded-xl text-sm font-medium text-on-surface-variant hover:text-primary hover:bg-white/[0.04] transition-all">Pricing</a>
                <a href="{{ route('blog.index') }}" class="py-3 px-4 rounded-xl text-sm font-medium text-on-surface-variant hover:text-primary hover:bg-white/[0.04] transition-all">Blog</a>
                <a href="{{ route('about.us') }}" class="py-3 px-4 rounded-xl text-sm font-medium text-on-surface-variant hover:text-primary hover:bg-white/[0.04] transition-all">About Us</a>
                <div class="border-t border-white/[0.06] mt-2 pt-3 flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="py-3 px-4 rounded-xl text-sm font-semibold text-on-surface text-center border border-white/[0.1] hover:border-primary/40 transition-all">Login</a>
                    <a href="{{ route('register') }}" class="btn-gold py-3 px-4 rounded-xl text-sm font-bold text-center">Start Free Trial</a>
                </div>
            </div>
        </div>
    </header>

    <main class="pt-24">
        <!-- Hero Section -->
        <section class="relative hero-mesh py-16 lg:py-24 border-b border-white/[0.06]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 flex flex-col gap-6">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/[0.04] border border-white/[0.08] w-fit">
                        <span class="material-symbols-outlined text-primary text-base">verified</span>
                        <span class="text-primary font-bold text-xs uppercase tracking-wider">{{ $segment['badge'] }}</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
                        {{ $segment['h1'] }}
                    </h1>
                    <p class="text-base sm:text-lg text-on-surface-variant leading-relaxed">
                        {{ $segment['subtitle'] }}
                    </p>
                    
                    <!-- Quick Value Props -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-2">
                        <div class="flex items-center gap-2 text-xs sm:text-sm text-on-surface font-medium">
                            <span class="material-symbols-outlined text-emerald-400 text-base">check_circle</span>
                            <span>14-Day Free Trial</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs sm:text-sm text-on-surface font-medium">
                            <span class="material-symbols-outlined text-emerald-400 text-base">check_circle</span>
                            <span>No Credit Card</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs sm:text-sm text-on-surface font-medium">
                            <span class="material-symbols-outlined text-emerald-400 text-base">check_circle</span>
                            <span>Android & iOS Apps</span>
                        </div>
                    </div>

                    <!-- Action CTAs -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-4">
                        <a href="{{ route('register') }}" class="btn-gold px-7 py-3.5 rounded-xl text-center text-sm font-bold flex items-center justify-center gap-2">
                            <span>Start 14-Day Free Trial</span>
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </a>
                        <button onclick="document.getElementById('demo-modal').classList.remove('hidden')" class="btn-outline-gold px-6 py-3.5 rounded-xl text-center text-sm font-semibold flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-base">calendar_month</span>
                            <span>Book a Free Demo</span>
                        </button>
                    </div>
                </div>

                <!-- Inbound Demo Booking Form Card (No Emojis) -->
                <div class="lg:col-span-5">
                    <div class="card-modern rounded-2xl p-6 sm:p-8 relative">
                        <div class="inline-block bg-primary-muted text-primary text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-3">
                            Free 1-on-1 Consultation
                        </div>
                        <h3 class="text-xl font-bold text-white mb-1">Book Your Live Software Demo</h3>
                        <p class="text-xs text-on-surface-variant mb-6">See how DarziDesk works for your shop in a 10-minute walkthrough.</p>
                        
                        <form action="{{ route('demo.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-on-surface-variant mb-1">Your Full Name *</label>
                                <input type="text" name="name" required placeholder="e.g. Rajesh Sharma" class="w-full bg-background border border-white/[0.1] rounded-xl px-3.5 py-2.5 text-sm text-white focus:border-primary">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-on-surface-variant mb-1">Mobile / WhatsApp *</label>
                                    <input type="tel" name="mobile" required placeholder="9876543210" class="w-full bg-background border border-white/[0.1] rounded-xl px-3.5 py-2.5 text-sm text-white focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-on-surface-variant mb-1">City *</label>
                                    <input type="text" name="city" placeholder="e.g. Jaipur" class="w-full bg-background border border-white/[0.1] rounded-xl px-3.5 py-2.5 text-sm text-white focus:border-primary">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-on-surface-variant mb-1">Business Name</label>
                                    <input type="text" name="business_name" placeholder="Shop / Boutique Name" class="w-full bg-background border border-white/[0.1] rounded-xl px-3.5 py-2.5 text-sm text-white focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-on-surface-variant mb-1">Number of Workers</label>
                                    <select name="workers_count" class="w-full bg-background border border-white/[0.1] rounded-xl px-3.5 py-2.5 text-sm text-white focus:border-primary">
                                        <option value="1-2">1 to 2 workers</option>
                                        <option value="3-5" selected>3 to 5 workers</option>
                                        <option value="6-10">6 to 10 workers</option>
                                        <option value="10+">More than 10</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="business_type" value="{{ $segment['target_audience'] }}">
                            <button type="submit" class="w-full btn-gold py-3 rounded-xl font-bold text-sm mt-2 flex items-center justify-center gap-2">
                                <span>Confirm Free Demo Call</span>
                                <span class="material-symbols-outlined text-sm">send</span>
                            </button>
                            <p class="text-[11px] text-center text-on-surface-muted">We respect your privacy. Zero spam guaranteed.</p>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Problem vs Solution Section (No Emojis) -->
        <section class="py-16 bg-surface border-b border-white/[0.06]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">The Operational Challenge</span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-white">Why Traditional Notebooks Create Delivery Delays & Lost Records</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Pain Points -->
                    <div class="card-modern rounded-2xl p-6 sm:p-8 border-red-500/20">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-9 h-9 rounded-xl bg-red-500/10 text-red-400 flex items-center justify-center">
                                <span class="material-symbols-outlined text-lg">close</span>
                            </div>
                            <h3 class="text-base font-bold text-red-300">Daily Struggles With Paper Registers</h3>
                        </div>
                        <ul class="space-y-4">
                            @foreach($segment['pain_points'] as $pain)
                            <li class="flex items-start gap-3 text-xs sm:text-sm text-on-surface-variant">
                                <span class="material-symbols-outlined text-red-400 text-sm shrink-0 mt-0.5">remove_circle_outline</span>
                                <span>{{ $pain }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- DarziDesk Solution -->
                    <div class="card-modern rounded-2xl p-6 sm:p-8 border-primary/30">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-9 h-9 rounded-xl bg-primary-muted text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined text-lg">task_alt</span>
                            </div>
                            <h3 class="text-base font-bold text-primary">How DarziDesk Solves This</h3>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3 text-xs sm:text-sm text-white">
                                <span class="material-symbols-outlined text-emerald-400 text-sm shrink-0 mt-0.5">check_circle</span>
                                <span><strong>Instant 1-Click Search:</strong> Find any customer's measurements and past order details in under 2 seconds.</span>
                            </li>
                            <li class="flex items-start gap-3 text-xs sm:text-sm text-white">
                                <span class="material-symbols-outlined text-emerald-400 text-sm shrink-0 mt-0.5">check_circle</span>
                                <span><strong>On-Time Delivery Protection:</strong> Visual production stages with automated alerts 24 hours prior to deadline.</span>
                            </li>
                            <li class="flex items-start gap-3 text-xs sm:text-sm text-white">
                                <span class="material-symbols-outlined text-emerald-400 text-sm shrink-0 mt-0.5">check_circle</span>
                                <span><strong>Clear Worker Accountability:</strong> Track which master cutter and stitching tailor worked on each piece.</span>
                            </li>
                            <li class="flex items-start gap-3 text-xs sm:text-sm text-white">
                                <span class="material-symbols-outlined text-emerald-400 text-sm shrink-0 mt-0.5">check_circle</span>
                                <span><strong>Automated Payment Ledger:</strong> Track advances, pending balances, and collect payments with zero confusion.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Segment Key Features -->
        <section class="py-20 bg-background border-b border-white/[0.06]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Engineered For Your Needs</span>
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-white">Key Features Designed for {{ $segment['target_audience'] }}</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($segment['features'] as $feat)
                    <div class="card-modern rounded-2xl p-6 flex flex-col group">
                        <div class="w-11 h-11 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-xl">{{ $feat['icon'] }}</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-2 group-hover:text-primary transition-colors">{{ $feat['title'] }}</h3>
                        <p class="text-xs text-on-surface-variant leading-relaxed">{{ $feat['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- App Screenshots Showcase Grid -->
        <section class="py-16 bg-surface border-b border-white/[0.06]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Software Preview</span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-white">Manage Your Business From Mobile & Web</h2>
                    <p class="text-xs sm:text-sm text-on-surface-variant mt-2">DarziDesk runs seamlessly on Android, iPhone, iPad, and all desktop browsers.</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                    <div class="card-modern rounded-xl p-3 shadow-xl">
                        <img src="{{ asset('assets/images/app_screenshots/dashboard_mobile.png') }}" alt="Dashboard Screenshot" class="rounded-lg w-full h-auto object-cover">
                        <p class="text-center text-xs font-bold text-white mt-3">Smart Dashboard</p>
                    </div>
                    <div class="card-modern rounded-xl p-3 shadow-xl">
                        <img src="{{ asset('assets/images/app_screenshots/measurements_mobile.png') }}" alt="Measurement Screen" class="rounded-lg w-full h-auto object-cover">
                        <p class="text-center text-xs font-bold text-white mt-3">Measurement Vault</p>
                    </div>
                    <div class="card-modern rounded-xl p-3 shadow-xl">
                        <img src="{{ asset('assets/images/app_screenshots/orders_mobile.png') }}" alt="Order Pipeline" class="rounded-lg w-full h-auto object-cover">
                        <p class="text-center text-xs font-bold text-white mt-3">Order Tracking</p>
                    </div>
                    <div class="card-modern rounded-xl p-3 shadow-xl">
                        <img src="{{ asset('assets/images/app_screenshots/pos_invoicing_mobile.png') }}" alt="POS Invoicing" class="rounded-lg w-full h-auto object-cover">
                        <p class="text-center text-xs font-bold text-white mt-3">POS & WhatsApp Bills</p>
                    </div>
                </div>

                <!-- Download App Badges -->
                <div class="mt-12 flex flex-wrap justify-center items-center gap-4">
                    <a href="https://play.google.com/store/apps/details?id=com.darzidesk.app&hl=en" target="_blank" class="inline-block hover:opacity-85 transition-opacity">
                        <img src="{{ asset('assets/images/google_play_badge.svg') }}" alt="Get it on Google Play" class="h-11 w-auto">
                    </a>
                    <a href="https://apps.apple.com/us/app/darzidesk/id6796700050" target="_blank" class="inline-block hover:opacity-85 transition-opacity">
                        <img src="{{ asset('assets/images/app_store_badge.svg') }}" alt="Download on the App Store" class="h-11 w-auto">
                    </a>
                </div>
            </div>
        </section>

        <!-- Segment FAQ Section -->
        <section class="py-16 bg-background border-b border-white/[0.06]">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Help & Clarity</span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-white">Frequently Asked Questions</h2>
                </div>

                <div class="space-y-4">
                    @foreach($segment['faqs'] as $faq)
                    <div class="card-modern rounded-xl p-5">
                        <h3 class="text-sm sm:text-base font-bold text-white mb-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-base">help</span>
                            <span>{{ $faq['q'] }}</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed pl-6">{{ $faq['a'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Final CTA Banner -->
        <section class="py-16 bg-surface-card border-b border-white/[0.06]">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-2xl sm:text-4xl font-extrabold text-white mb-4">Start Managing Your Shop Smarter Today</h2>
                <p class="text-on-surface-variant text-sm sm:text-base max-w-xl mx-auto mb-8">Join hundreds of tailor shops and boutiques across India. Sign up in under 60 seconds.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="btn-gold px-8 py-3.5 rounded-xl font-bold text-sm w-full sm:w-auto">Start 14-Day Free Trial</a>
                    <a href="https://wa.me/919536824061?text=Hi%20DarziDesk%2C%20I%20want%20a%20free%20demo%20call" target="_blank" class="btn-outline-gold px-8 py-3.5 rounded-xl font-semibold text-sm w-full sm:w-auto flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-base">chat</span>
                        <span>Chat on WhatsApp</span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Global Footer -->
    @include('layouts.saas_footer')

    <!-- Modal for Book Demo (No Emojis) -->
    <div id="demo-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
        <div class="bg-surface rounded-2xl p-6 sm:p-8 max-w-md w-full border border-white/[0.1] shadow-2xl relative">
            <button onclick="document.getElementById('demo-modal').classList.add('hidden')" class="absolute top-4 right-4 text-on-surface-muted hover:text-white">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
            <h3 class="text-xl font-bold text-white mb-1">Book Your Free Live Demo</h3>
            <p class="text-xs text-on-surface-variant mb-6">Our product specialist will give you a personalized tour.</p>
            <form action="{{ route('demo.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant mb-1">Your Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Ankit Verma" class="w-full bg-background border border-white/[0.1] rounded-xl px-3.5 py-2.5 text-sm text-white focus:border-primary">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant mb-1">Mobile / WhatsApp Number *</label>
                    <input type="tel" name="mobile" required placeholder="9876543210" class="w-full bg-background border border-white/[0.1] rounded-xl px-3.5 py-2.5 text-sm text-white focus:border-primary">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant mb-1">Shop / Boutique Name</label>
                    <input type="text" name="business_name" placeholder="Darzi / Studio Name" class="w-full bg-background border border-white/[0.1] rounded-xl px-3.5 py-2.5 text-sm text-white focus:border-primary">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant mb-1">City</label>
                    <input type="text" name="city" placeholder="e.g. Mumbai, Delhi, Lucknow" class="w-full bg-background border border-white/[0.1] rounded-xl px-3.5 py-2.5 text-sm text-white focus:border-primary">
                </div>
                <button type="submit" class="w-full btn-gold py-3 rounded-xl font-bold text-sm mt-2">Request Demo Now</button>
                <p class="text-[11px] text-center text-on-surface-muted">Free 1-on-1 Consultation. Zero spam guaranteed.</p>
            </form>
        </div>
    </div>

</body>
</html>
