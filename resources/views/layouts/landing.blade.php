<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    
    <!-- Primary SEO Meta Tags -->
    <title>DarziDesk | Tailoring Shop Management Software in India</title>
    <meta name="title" content="DarziDesk | Tailoring Shop Management Software in India"/>
    <meta name="description" content="Manage your tailoring business with DarziDesk. Track customers, measurements, orders, payments, workers and inventory from one simple tailoring management platform."/>
    <meta name="keywords" content="tailoring management software India, tailor shop management app, boutique management software, tailoring billing software, tailor order management, tailor measurement software, tailoring business app, ladies tailor software, garment workshop management"/>
    
    <!-- OpenGraph / Social Meta Tags -->
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:title" content="DarziDesk | Tailoring Shop Management Software in India"/>
    <meta property="og:description" content="Manage your tailoring business with DarziDesk. Track customers, measurements, orders, payments, workers and inventory from one simple tailoring management platform."/>
    <meta property="og:image" content="{{ asset('assets/images/logo_wide.png') }}"/>

    <!-- Schema.org JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "DarziDesk TMS",
      "operatingSystem": "Android, iOS, Web",
      "applicationCategory": "BusinessApplication",
      "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "INR"
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.9",
        "reviewCount": "1450"
      },
      "description": "All-in-one tailoring shop and boutique management software for tracking measurements, orders, karigars, and POS billing."
    }
    </script>

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

    <!-- Tailwind CSS & Fonts -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script id="tailwind-config">
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
              "surface-border": "rgba(255, 255, 255, 0.08)",
              "surface-border-subtle": "rgba(229, 169, 60, 0.25)",
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
        .gold-gradient-text {
            background: linear-gradient(135deg, #FFFDF8 0%, #F5D38A 45%, #E5A93C 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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
        .tab-btn.active {
            background-color: #E5A93C;
            color: #050B14;
            font-weight: 700;
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
    <a href="https://wa.me/919536824061?text=Hi%20DarziDesk%20Team%2C%20I%20want%20to%20book%20a%20free%20demo%20for%20my%20tailoring%20shop." target="_blank" aria-label="Chat with DarziDesk on WhatsApp" class="whatsapp-float bg-[#25D366] text-white p-3.5 md:px-5 md:py-3.5 rounded-full flex items-center gap-2.5 hover:bg-[#20ba59] transition-all font-bold text-sm">
        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
        <span class="hidden md:inline">WhatsApp Us</span>
    </a>

    <!-- Navigation Bar -->
    <header class="fixed top-0 w-full glass-header z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" class="h-9 w-auto max-w-[190px] object-contain">
                </a>
                <div class="hidden lg:flex items-center gap-6">
                    <a class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium" href="#features">Features</a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium" href="#who-its-for">Solutions</a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium" href="#how-it-works">How It Works</a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium" href="#comparison">Comparison</a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium" href="{{ route('pricing.public') }}">Pricing</a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium" href="{{ route('blog.index') }}">Blog</a>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="hidden sm:inline-flex px-4 py-2 rounded-xl text-sm font-semibold text-on-surface hover:text-primary transition-colors">Login</a>
                <a href="{{ route('register') }}" class="btn-gold px-4 py-2 rounded-xl text-sm font-bold">Start Free Trial</a>
                <!-- Mobile Hamburger -->
                <button onclick="document.getElementById('mobile-nav').classList.toggle('hidden')" class="lg:hidden p-2 rounded-xl text-on-surface hover:text-primary transition-colors" aria-label="Toggle navigation menu">
                    <span class="material-symbols-outlined text-2xl">menu</span>
                </button>
            </div>
        </nav>

        <!-- Mobile Drawer Menu -->
        <div id="mobile-nav" class="hidden lg:hidden bg-surface border-t border-white/[0.06]">
            <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col gap-1">
                <a href="#features" onclick="document.getElementById('mobile-nav').classList.add('hidden')" class="py-3 px-4 rounded-xl text-sm font-medium text-on-surface-variant hover:text-primary hover:bg-white/[0.04] transition-all">Features</a>
                <a href="#who-its-for" onclick="document.getElementById('mobile-nav').classList.add('hidden')" class="py-3 px-4 rounded-xl text-sm font-medium text-on-surface-variant hover:text-primary hover:bg-white/[0.04] transition-all">Solutions</a>
                <a href="#how-it-works" onclick="document.getElementById('mobile-nav').classList.add('hidden')" class="py-3 px-4 rounded-xl text-sm font-medium text-on-surface-variant hover:text-primary hover:bg-white/[0.04] transition-all">How It Works</a>
                <a href="#comparison" onclick="document.getElementById('mobile-nav').classList.add('hidden')" class="py-3 px-4 rounded-xl text-sm font-medium text-on-surface-variant hover:text-primary hover:bg-white/[0.04] transition-all">Comparison</a>
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

    <main class="pt-20">

        <!-- 1. HERO SECTION -->
        <section class="relative hero-mesh pt-16 pb-20 lg:pt-24 lg:pb-28 border-b border-white/[0.06] overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center">
                
                <!-- Trust Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/[0.04] border border-white/[0.08] mb-6">
                    <span class="material-symbols-outlined text-primary text-base">verified</span>
                    <span class="text-xs uppercase tracking-widest text-on-surface-variant font-semibold">Tailor Management System (TMS)</span>
                </div>

                <!-- H1 & Headlines -->
                <h1 class="text-xs uppercase tracking-widest text-on-surface-muted font-bold mb-3">
                    Tailoring Shop Management Software for Modern Businesses
                </h1>
                <p class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight max-w-4xl tracking-tight mb-6">
                    Run Your Tailoring Business <span class="gold-gradient-text">Smarter</span>
                </p>
                <p class="text-base sm:text-lg text-on-surface-variant max-w-2xl mx-auto leading-relaxed mb-8">
                    Manage customers, measurements, orders, payments, workers and inventory from one simple platform built for modern tailoring businesses.
                </p>

                <!-- Action CTAs -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto mb-12">
                    <a href="{{ route('register') }}" class="btn-gold px-8 py-3.5 rounded-xl text-center text-sm font-bold w-full sm:w-auto flex items-center justify-center gap-2">
                        <span>Start 14-Day Free Trial</span>
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </a>
                    <button onclick="document.getElementById('demo-modal').classList.remove('hidden')" class="btn-outline-gold px-8 py-3.5 rounded-xl text-center text-sm font-semibold w-full sm:w-auto flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-base">calendar_month</span>
                        <span>Book a Free Demo</span>
                    </button>
                    <a href="https://wa.me/919536824061?text=Hi%20DarziDesk%2C%20please%20send%20me%20a%20quick%20demo%20on%20WhatsApp" target="_blank" class="px-6 py-3.5 rounded-xl bg-white/[0.04] border border-white/[0.1] text-white text-sm font-semibold hover:bg-white/[0.08] transition-all flex items-center justify-center gap-2 w-full sm:w-auto">
                        <span class="material-symbols-outlined text-emerald-400 text-base">chat</span>
                        <span>Chat on WhatsApp</span>
                    </a>
                </div>

                <!-- Verified SaaS Metrics Bar -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl w-full pt-8 border-t border-white/[0.06] text-center">
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-white">100%</p>
                        <p class="text-xs text-on-surface-variant mt-1">Cloud Data Security</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-white">Android & iOS</p>
                        <p class="text-xs text-on-surface-variant mt-1">Native Mobile Apps</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-white">Zero</p>
                        <p class="text-xs text-on-surface-variant mt-1">Lost Measurements</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-white">10x</p>
                        <p class="text-xs text-on-surface-variant mt-1">Faster Order Search</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- 2. REAL APP SCREENSHOTS & INTERACTIVE DEMO SHOWCASE -->
        <section class="py-20 bg-surface border-b border-white/[0.06]" id="product-demo">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-10">
                    <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Live Software Interface</span>
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-white">See DarziDesk in Action</h2>
                    <p class="text-sm text-on-surface-variant mt-2">Clean, high-performance interface built for speed on mobile and desktop.</p>
                </div>

                <!-- Interactive Tab Selectors -->
                <div class="flex flex-wrap justify-center gap-2 mb-8" id="app-tabs">
                    <button onclick="switchTab('dashboard')" class="tab-btn active px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-white/[0.08] bg-surface-card text-on-surface hover:border-primary/40 transition-all flex items-center gap-2" data-tab="dashboard">
                        <span class="material-symbols-outlined text-base">dashboard</span>
                        <span>Dashboard</span>
                    </button>
                    <button onclick="switchTab('customers')" class="tab-btn px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-white/[0.08] bg-surface-card text-on-surface hover:border-primary/40 transition-all flex items-center gap-2" data-tab="customers">
                        <span class="material-symbols-outlined text-base">person</span>
                        <span>Measurements</span>
                    </button>
                    <button onclick="switchTab('orders')" class="tab-btn px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-white/[0.08] bg-surface-card text-on-surface hover:border-primary/40 transition-all flex items-center gap-2" data-tab="orders">
                        <span class="material-symbols-outlined text-base">receipt_long</span>
                        <span>Order Booking</span>
                    </button>
                    <button onclick="switchTab('kanban')" class="tab-btn px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-white/[0.08] bg-surface-card text-on-surface hover:border-primary/40 transition-all flex items-center gap-2" data-tab="kanban">
                        <span class="material-symbols-outlined text-base">view_kanban</span>
                        <span>Production Kanban</span>
                    </button>
                    <button onclick="switchTab('invoicing')" class="tab-btn px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-white/[0.08] bg-surface-card text-on-surface hover:border-primary/40 transition-all flex items-center gap-2" data-tab="invoicing">
                        <span class="material-symbols-outlined text-base">point_of_sale</span>
                        <span>POS Invoicing</span>
                    </button>
                </div>

                <!-- Showcase Frame -->
                <div class="bg-surface-card rounded-2xl p-6 sm:p-10 border border-white/[0.08] shadow-2xl max-w-5xl mx-auto">
                    
                    <!-- Tab: Dashboard -->
                    <div id="tab-content-dashboard" class="tab-content block">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-center">
                            <div class="md:col-span-6 lg:col-span-7 flex flex-col gap-4 text-left">
                                <span class="text-xs font-bold text-primary uppercase tracking-wider">Store Executive Overview</span>
                                <h3 class="text-xl sm:text-2xl font-bold text-white">Daily Orders, Revenue & Pending Deliveries at a Glance</h3>
                                <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                                    Know exactly how many garments need to be delivered today, total monthly earnings, active workshop orders, and overdue alerts.
                                </p>
                                <ul class="space-y-2.5 text-xs text-white">
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-base">check</span>
                                        <span>Today's delivery countdown alerts</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-base">check</span>
                                        <span>Daily cash and UPI sales tally</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-base">check</span>
                                        <span>Instant 1-tap quick action shortcuts</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="md:col-span-6 lg:col-span-5 flex justify-center">
                                <!-- iOS Device Frame -->
                                <div class="relative mx-auto w-full max-w-[270px] sm:max-w-[290px]">
                                    <div class="absolute -inset-4 bg-gradient-to-tr from-primary/20 via-emerald-500/10 to-transparent rounded-[52px] blur-2xl opacity-60 pointer-events-none"></div>
                                    <div class="relative bg-[#121318] rounded-[44px] p-2.5 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9),0_0_0_1px_rgba(255,255,255,0.14)] border-2 border-[#2c2f3a]">
                                        <div class="absolute -left-[4px] top-20 w-[3px] h-5 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -left-[4px] top-28 w-[3px] h-10 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -left-[4px] top-42 w-[3px] h-10 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -right-[4px] top-32 w-[3px] h-14 bg-[#454856] rounded-r-sm"></div>
                                        <div class="relative bg-black rounded-[34px] overflow-hidden border border-black shadow-inner">
                                            <div class="absolute top-2 inset-x-0 flex justify-center z-20 pointer-events-none">
                                                <div class="h-3.5 w-20 bg-black rounded-full flex items-center justify-between px-2 shadow border border-neutral-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#0a0d14] flex items-center justify-center">
                                                        <span class="w-0.5 h-0.5 rounded-full bg-[#1b2559]"></span>
                                                    </span>
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#0d121c]"></span>
                                                </div>
                                            </div>
                                            <img src="{{ asset('assets/images/app_screenshots/dashboard_mobile.png') }}" alt="DarziDesk Dashboard" class="w-full h-auto object-cover block">
                                            <div class="absolute bottom-1.5 inset-x-0 flex justify-center z-20 pointer-events-none">
                                                <div class="w-24 h-1 bg-white/40 rounded-full"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Customers -->
                    <div id="tab-content-customers" class="tab-content hidden">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-center">
                            <div class="md:col-span-6 lg:col-span-7 flex flex-col gap-4 text-left">
                                <span class="text-xs font-bold text-primary uppercase tracking-wider">Digital Measurement Vault</span>
                                <h3 class="text-xl sm:text-2xl font-bold text-white">Save & Reuse Customer Measurements Forever</h3>
                                <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                                    No more flipping through dusty paper registers. Search any customer by name or mobile number in 1 second and reuse their fitting history.
                                </p>
                                <ul class="space-y-2.5 text-xs text-white">
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-base">check</span>
                                        <span>Supports Suits, Blouses, Kurtis, Sherwanis</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-base">check</span>
                                        <span>Inches and Centimeters with fractions</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-base">check</span>
                                        <span>1-click share with client on WhatsApp</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="md:col-span-6 lg:col-span-5 flex justify-center">
                                <!-- iOS Device Frame -->
                                <div class="relative mx-auto w-full max-w-[270px] sm:max-w-[290px]">
                                    <div class="absolute -inset-4 bg-gradient-to-tr from-primary/20 via-emerald-500/10 to-transparent rounded-[52px] blur-2xl opacity-60 pointer-events-none"></div>
                                    <div class="relative bg-[#121318] rounded-[44px] p-2.5 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9),0_0_0_1px_rgba(255,255,255,0.14)] border-2 border-[#2c2f3a]">
                                        <div class="absolute -left-[4px] top-20 w-[3px] h-5 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -left-[4px] top-28 w-[3px] h-10 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -left-[4px] top-42 w-[3px] h-10 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -right-[4px] top-32 w-[3px] h-14 bg-[#454856] rounded-r-sm"></div>
                                        <div class="relative bg-black rounded-[34px] overflow-hidden border border-black shadow-inner">
                                            <div class="absolute top-2 inset-x-0 flex justify-center z-20 pointer-events-none">
                                                <div class="h-3.5 w-20 bg-black rounded-full flex items-center justify-between px-2 shadow border border-neutral-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#0a0d14] flex items-center justify-center">
                                                        <span class="w-0.5 h-0.5 rounded-full bg-[#1b2559]"></span>
                                                    </span>
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#0d121c]"></span>
                                                </div>
                                            </div>
                                            <img src="{{ asset('assets/images/app_screenshots/measurements_mobile.png') }}" alt="Customer Measurements" class="w-full h-auto object-cover block">
                                            <div class="absolute bottom-1.5 inset-x-0 flex justify-center z-20 pointer-events-none">
                                                <div class="w-24 h-1 bg-white/40 rounded-full"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Orders -->
                    <div id="tab-content-orders" class="tab-content hidden">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-center">
                            <div class="md:col-span-6 lg:col-span-7 flex flex-col gap-4 text-left">
                                <span class="text-xs font-bold text-primary uppercase tracking-wider">Order Creation</span>
                                <h3 class="text-xl sm:text-2xl font-bold text-white">Fast 60-Second Order Booking With Advance Tracking</h3>
                                <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                                    Select garment type, assign promised delivery date, record advance deposit, and print receipt or send PDF over WhatsApp immediately.
                                </p>
                                <ul class="space-y-2.5 text-xs text-white">
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-base">check</span>
                                        <span>Urgent order tags and delivery timer</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-base">check</span>
                                        <span>Advance cash/UPI payment lock</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="md:col-span-6 lg:col-span-5 flex justify-center">
                                <!-- iOS Device Frame -->
                                <div class="relative mx-auto w-full max-w-[270px] sm:max-w-[290px]">
                                    <div class="absolute -inset-4 bg-gradient-to-tr from-primary/20 via-emerald-500/10 to-transparent rounded-[52px] blur-2xl opacity-60 pointer-events-none"></div>
                                    <div class="relative bg-[#121318] rounded-[44px] p-2.5 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9),0_0_0_1px_rgba(255,255,255,0.14)] border-2 border-[#2c2f3a]">
                                        <div class="absolute -left-[4px] top-20 w-[3px] h-5 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -left-[4px] top-28 w-[3px] h-10 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -left-[4px] top-42 w-[3px] h-10 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -right-[4px] top-32 w-[3px] h-14 bg-[#454856] rounded-r-sm"></div>
                                        <div class="relative bg-black rounded-[34px] overflow-hidden border border-black shadow-inner">
                                            <div class="absolute top-2 inset-x-0 flex justify-center z-20 pointer-events-none">
                                                <div class="h-3.5 w-20 bg-black rounded-full flex items-center justify-between px-2 shadow border border-neutral-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#0a0d14] flex items-center justify-center">
                                                        <span class="w-0.5 h-0.5 rounded-full bg-[#1b2559]"></span>
                                                    </span>
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#0d121c]"></span>
                                                </div>
                                            </div>
                                            <img src="{{ asset('assets/images/app_screenshots/order_creation_mobile.png') }}" alt="Order Creation" class="w-full h-auto object-cover block">
                                            <div class="absolute bottom-1.5 inset-x-0 flex justify-center z-20 pointer-events-none">
                                                <div class="w-24 h-1 bg-white/40 rounded-full"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Kanban -->
                    <div id="tab-content-kanban" class="tab-content hidden">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-center">
                            <div class="md:col-span-6 lg:col-span-7 flex flex-col gap-4 text-left">
                                <span class="text-xs font-bold text-primary uppercase tracking-wider">Production Kanban</span>
                                <h3 class="text-xl sm:text-2xl font-bold text-white">Track Every Karigar & Garment Stage</h3>
                                <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                                    Move garments through Cutting, Stitching, Trial, and Ready stages. Assign master cutters and calculate piece-rate worker payroll automatically.
                                </p>
                                <ul class="space-y-2.5 text-xs text-white">
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-base">check</span>
                                        <span>Visual drag-and-drop workflow</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-base">check</span>
                                        <span>Eliminate workshop blame and delays</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="md:col-span-6 lg:col-span-5 flex justify-center">
                                <!-- iOS Device Frame -->
                                <div class="relative mx-auto w-full max-w-[270px] sm:max-w-[290px]">
                                    <div class="absolute -inset-4 bg-gradient-to-tr from-primary/20 via-emerald-500/10 to-transparent rounded-[52px] blur-2xl opacity-60 pointer-events-none"></div>
                                    <div class="relative bg-[#121318] rounded-[44px] p-2.5 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9),0_0_0_1px_rgba(255,255,255,0.14)] border-2 border-[#2c2f3a]">
                                        <div class="absolute -left-[4px] top-20 w-[3px] h-5 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -left-[4px] top-28 w-[3px] h-10 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -left-[4px] top-42 w-[3px] h-10 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -right-[4px] top-32 w-[3px] h-14 bg-[#454856] rounded-r-sm"></div>
                                        <div class="relative bg-black rounded-[34px] overflow-hidden border border-black shadow-inner">
                                            <div class="absolute top-2 inset-x-0 flex justify-center z-20 pointer-events-none">
                                                <div class="h-3.5 w-20 bg-black rounded-full flex items-center justify-between px-2 shadow border border-neutral-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#0a0d14] flex items-center justify-center">
                                                        <span class="w-0.5 h-0.5 rounded-full bg-[#1b2559]"></span>
                                                    </span>
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#0d121c]"></span>
                                                </div>
                                            </div>
                                            <img src="{{ asset('assets/images/app_screenshots/kanban_mobile.png') }}" alt="Kanban Pipeline" class="w-full h-auto object-cover block">
                                            <div class="absolute bottom-1.5 inset-x-0 flex justify-center z-20 pointer-events-none">
                                                <div class="w-24 h-1 bg-white/40 rounded-full"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Invoicing -->
                    <div id="tab-content-invoicing" class="tab-content hidden">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-center">
                            <div class="md:col-span-6 lg:col-span-7 flex flex-col gap-4 text-left">
                                <span class="text-xs font-bold text-primary uppercase tracking-wider">POS & Invoicing</span>
                                <h3 class="text-xl sm:text-2xl font-bold text-white">Professional Invoices & Instant WhatsApp Receipts</h3>
                                <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                                    Generate thermal receipts or A4/A5 GST bills. Send digital invoices directly to customers on WhatsApp with your shop logo.
                                </p>
                                <ul class="space-y-2.5 text-xs text-white">
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-base">check</span>
                                        <span>Supports 2-inch and 3-inch thermal printers</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-base">check</span>
                                        <span>Clear advance vs pending balance breakdown</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="md:col-span-6 lg:col-span-5 flex justify-center">
                                <!-- iOS Device Frame -->
                                <div class="relative mx-auto w-full max-w-[270px] sm:max-w-[290px]">
                                    <div class="absolute -inset-4 bg-gradient-to-tr from-primary/20 via-emerald-500/10 to-transparent rounded-[52px] blur-2xl opacity-60 pointer-events-none"></div>
                                    <div class="relative bg-[#121318] rounded-[44px] p-2.5 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9),0_0_0_1px_rgba(255,255,255,0.14)] border-2 border-[#2c2f3a]">
                                        <div class="absolute -left-[4px] top-20 w-[3px] h-5 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -left-[4px] top-28 w-[3px] h-10 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -left-[4px] top-42 w-[3px] h-10 bg-[#454856] rounded-l-sm"></div>
                                        <div class="absolute -right-[4px] top-32 w-[3px] h-14 bg-[#454856] rounded-r-sm"></div>
                                        <div class="relative bg-black rounded-[34px] overflow-hidden border border-black shadow-inner">
                                            <div class="absolute top-2 inset-x-0 flex justify-center z-20 pointer-events-none">
                                                <div class="h-3.5 w-20 bg-black rounded-full flex items-center justify-between px-2 shadow border border-neutral-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#0a0d14] flex items-center justify-center">
                                                        <span class="w-0.5 h-0.5 rounded-full bg-[#1b2559]"></span>
                                                    </span>
                                                    <span class="w-1.5 h-1.5 rounded-full bg-[#0d121c]"></span>
                                                </div>
                                            </div>
                                            <img src="{{ asset('assets/images/app_screenshots/pos_invoicing_mobile.png') }}" alt="POS Invoicing" class="w-full h-auto object-cover block">
                                            <div class="absolute bottom-1.5 inset-x-0 flex justify-center z-20 pointer-events-none">
                                                <div class="w-24 h-1 bg-white/40 rounded-full"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 3. BUILT FOR EVERY TAILORING BUSINESS (SEGMENTS) -->
        <section class="py-20 bg-background border-b border-white/[0.06]" id="who-its-for">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Tailored For Your Craft</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Built for Every Tailoring Business</h2>
                    <p class="text-on-surface-variant text-sm sm:text-base mt-2">Whether you run a solo shop or a 20-karigar boutique, DarziDesk adapts to your workflow.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <!-- Card 1 -->
                    <a href="{{ url('mens-tailor-management-software') }}" class="card-modern rounded-2xl p-6 sm:p-8 flex flex-col group">
                        <div class="w-11 h-11 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-xl">man</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 group-hover:text-primary transition-colors">Men's Tailors</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed mb-4">
                            Suits, Blazers, Shirts, Trousers, Kurta-Pajama, Safari Suits & Sherwanis. Full posture and style specs.
                        </p>
                        <span class="text-xs font-semibold text-primary flex items-center gap-1 mt-auto">View Details <span class="material-symbols-outlined text-sm">arrow_forward</span></span>
                    </a>

                    <!-- Card 2 -->
                    <a href="{{ url('ladies-tailor-management-software') }}" class="card-modern rounded-2xl p-6 sm:p-8 flex flex-col group">
                        <div class="w-11 h-11 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-xl">woman</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 group-hover:text-primary transition-colors">Ladies' Tailors</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed mb-4">
                            Blouse patterns (Katori, Princess cut), Salwar Suits, Kurtis, Lehengas & Gowns. Zero fitting confusion.
                        </p>
                        <span class="text-xs font-semibold text-primary flex items-center gap-1 mt-auto">View Details <span class="material-symbols-outlined text-sm">arrow_forward</span></span>
                    </a>

                    <!-- Card 3 -->
                    <a href="{{ url('boutique-management-software') }}" class="card-modern rounded-2xl p-6 sm:p-8 flex flex-col group">
                        <div class="w-11 h-11 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-xl">storefront</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 group-hover:text-primary transition-colors">Designer Boutiques</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed mb-4">
                            Custom design sketches, fabric roll stock ledger, bridal embroidery schedules & VIP client fitting calendars.
                        </p>
                        <span class="text-xs font-semibold text-primary flex items-center gap-1 mt-auto">View Details <span class="material-symbols-outlined text-sm">arrow_forward</span></span>
                    </a>

                    <!-- Card 4 -->
                    <a href="{{ url('tailoring-shop-management-software') }}" class="card-modern rounded-2xl p-6 sm:p-8 flex flex-col group">
                        <div class="w-11 h-11 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-xl">palette</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 group-hover:text-primary transition-colors">Fashion Designers</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed mb-4">
                            Manage signature collections, luxury fabric inventory, sample trials, and client styling consultations.
                        </p>
                        <span class="text-xs font-semibold text-primary flex items-center gap-1 mt-auto">View Details <span class="material-symbols-outlined text-sm">arrow_forward</span></span>
                    </a>

                    <!-- Card 5 -->
                    <a href="{{ url('tailoring-order-management') }}" class="card-modern rounded-2xl p-6 sm:p-8 flex flex-col group">
                        <div class="w-11 h-11 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-xl">content_cut</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 group-hover:text-primary transition-colors">Alteration & Repair Shops</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed mb-4">
                            Quick-tag garments, log alteration notes, print hanger QR codes, and notify customers on WhatsApp when ready.
                        </p>
                        <span class="text-xs font-semibold text-primary flex items-center gap-1 mt-auto">View Details <span class="material-symbols-outlined text-sm">arrow_forward</span></span>
                    </a>

                    <!-- Card 6 -->
                    <a href="{{ url('tailoring-software-india') }}" class="card-modern rounded-2xl p-6 sm:p-8 flex flex-col group">
                        <div class="w-11 h-11 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-xl">factory</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 group-hover:text-primary transition-colors">Multi-Worker Units & Karkhanas</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed mb-4">
                            Assign jobs to multiple master cutters & tailors, track piece-rate wage calculation and daily output.
                        </p>
                        <span class="text-xs font-semibold text-primary flex items-center gap-1 mt-auto">View Details <span class="material-symbols-outlined text-sm">arrow_forward</span></span>
                    </a>

                </div>
            </div>
        </section>

        <!-- 4. WHY DARZIDESK? (CORE MODULES) -->
        <section class="py-20 bg-surface border-b border-white/[0.06]" id="features">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Core Platform Capabilities</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Everything Your Tailoring Shop Needs</h2>
                    <p class="text-on-surface-variant text-sm sm:text-base mt-2">Replace 5 fragmented tools with one synchronized tailoring operating system.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <div class="card-modern rounded-2xl p-6 sm:p-8 flex flex-col">
                        <div class="w-11 h-11 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-5">
                            <span class="material-symbols-outlined text-xl">contacts</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-2">Customer Management</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Keep client phone numbers, order histories, fitting preferences, and balance payments organized in one searchable directory.
                        </p>
                    </div>

                    <div class="card-modern rounded-2xl p-6 sm:p-8 flex flex-col">
                        <div class="w-11 h-11 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-5">
                            <span class="material-symbols-outlined text-xl">straighten</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-2">Digital Measurements</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Save, edit, and instantly pull up past measurements for repeat orders. Never lose a customer's fit card again.
                        </p>
                    </div>

                    <div class="card-modern rounded-2xl p-6 sm:p-8 flex flex-col">
                        <div class="w-11 h-11 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-5">
                            <span class="material-symbols-outlined text-xl">schedule</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-2">Order Tracking</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Track every garment from initial booking to cutting, basting, stitching, trial fittings, and final delivery.
                        </p>
                    </div>

                    <div class="card-modern rounded-2xl p-6 sm:p-8 flex flex-col">
                        <div class="w-11 h-11 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-5">
                            <span class="material-symbols-outlined text-xl">receipt_long</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-2">Payment Management</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Manage advance deposits, remaining balances, thermal print receipts, and branded WhatsApp digital bills with GST support.
                        </p>
                    </div>

                    <div class="card-modern rounded-2xl p-6 sm:p-8 flex flex-col">
                        <div class="w-11 h-11 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-5">
                            <span class="material-symbols-outlined text-xl">groups</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-2">Worker Management</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Assign jobs to master cutters and tailors, track workshop bottlenecks, and compute piece-rate artisan payroll.
                        </p>
                    </div>

                    <div class="card-modern rounded-2xl p-6 sm:p-8 flex flex-col">
                        <div class="w-11 h-11 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-5">
                            <span class="material-symbols-outlined text-xl">analytics</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-2">Business Reports</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Understand daily sales, monthly revenue, workshop expenses, profit & loss, and top-selling garment categories.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- 5. HINDI / REGIONAL SECTION (NO EMOJIS) -->
        <section class="py-16 bg-surface-card border-b border-white/[0.06]">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="px-3.5 py-1 rounded-full bg-primary-muted text-primary text-xs font-bold uppercase tracking-wider mb-4 inline-block">
                    Dedicated Support for Indian Tailoring Businesses
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-white mb-3">
                    अपनी Tailoring Shop को Digital बनाइये
                </h2>
                <p class="text-sm sm:text-base text-on-surface-variant max-w-2xl mx-auto mb-6">
                    Customers, measurements, orders aur payments ko ek hi jagah manage karein. Purane paper register se mukti paayein.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <button onclick="document.getElementById('demo-modal').classList.remove('hidden')" class="btn-gold px-7 py-3 rounded-xl font-bold text-sm w-full sm:w-auto flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-base">call</span>
                        <span>Free Demo Lejiye</span>
                    </button>
                    <a href="{{ route('register') }}" class="btn-outline-gold px-7 py-3 rounded-xl font-semibold text-sm w-full sm:w-auto">
                        Abhi Start Karein (14 Days Free)
                    </a>
                </div>
            </div>
        </section>

        <!-- 6. HOW IT WORKS SECTION -->
        <section class="py-20 bg-background border-b border-white/[0.06]" id="how-it-works">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">4-Step Production Lifecycle</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">How DarziDesk Works</h2>
                    <p class="text-on-surface-variant text-sm sm:text-base mt-2">From initial customer entry to final delivery and payment collection.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <div class="card-modern rounded-2xl p-6 flex flex-col">
                        <span class="text-2xl font-mono font-bold text-primary mb-3">01</span>
                        <h3 class="text-base font-bold text-white mb-2">Add Customer & Fit</h3>
                        <p class="text-xs text-on-surface-variant leading-relaxed">
                            Create customer profiles with phone numbers and save their detailed body measurements.
                        </p>
                    </div>

                    <div class="card-modern rounded-2xl p-6 flex flex-col">
                        <span class="text-2xl font-mono font-bold text-primary mb-3">02</span>
                        <h3 class="text-base font-bold text-white mb-2">Book Order & Advance</h3>
                        <p class="text-xs text-on-surface-variant leading-relaxed">
                            Add garments, promised delivery date, design specs, prices, and record advance deposits.
                        </p>
                    </div>

                    <div class="card-modern rounded-2xl p-6 flex flex-col">
                        <span class="text-2xl font-mono font-bold text-primary mb-3">03</span>
                        <h3 class="text-base font-bold text-white mb-2">Track Production</h3>
                        <p class="text-xs text-on-surface-variant leading-relaxed">
                            Move orders through cutting, stitching, trial fittings, and ready stages with karigar assignments.
                        </p>
                    </div>

                    <div class="card-modern rounded-2xl p-6 flex flex-col">
                        <span class="text-2xl font-mono font-bold text-primary mb-3">04</span>
                        <h3 class="text-base font-bold text-white mb-2">Deliver & Collect</h3>
                        <p class="text-xs text-on-surface-variant leading-relaxed">
                            Notify customer on WhatsApp, collect pending balance, and hand over the finished garment.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- 7. COMPARISON TABLE: NOTEBOOK VS DARZIDESK (CLEAN SVG ICONS, NO EMOJIS) -->
        <section class="py-20 bg-surface border-b border-white/[0.06]" id="comparison">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Clear Modern Upgrade</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">From Notebook to Digital Management</h2>
                    <p class="text-on-surface-variant text-sm sm:text-base mt-2">See why tailor shops and boutiques are modernizing their operations.</p>
                </div>

                <div class="overflow-x-auto rounded-2xl border border-white/[0.08] shadow-xl bg-surface-card">
                    <table class="w-full text-left text-sm text-on-surface-variant">
                        <thead class="bg-background text-xs uppercase text-white border-b border-white/[0.08]">
                            <tr>
                                <th class="py-4 px-6 font-semibold">Workflow Operation</th>
                                <th class="py-4 px-6 text-red-400 font-semibold">Traditional Notebook</th>
                                <th class="py-4 px-6 text-primary font-bold">With DarziDesk TMS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/[0.05]">
                            <tr>
                                <td class="py-4 px-6 font-semibold text-white">Customer Measurements</td>
                                <td class="py-4 px-6 text-on-surface-muted flex items-center gap-2">
                                    <span class="material-symbols-outlined text-red-400 text-sm">remove_circle_outline</span>
                                    <span>Paper cards get lost, torn, or misplaced</span>
                                </td>
                                <td class="py-4 px-6 text-emerald-400 font-medium">
                                    <span class="material-symbols-outlined text-emerald-400 text-sm inline-block align-middle mr-1">check_circle</span>
                                    <span>Saved permanently in digital vault</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6 font-semibold text-white">Finding Past Fitting Records</td>
                                <td class="py-4 px-6 text-on-surface-muted flex items-center gap-2">
                                    <span class="material-symbols-outlined text-red-400 text-sm">remove_circle_outline</span>
                                    <span>Flipping through hundreds of register pages</span>
                                </td>
                                <td class="py-4 px-6 text-emerald-400 font-medium">
                                    <span class="material-symbols-outlined text-emerald-400 text-sm inline-block align-middle mr-1">check_circle</span>
                                    <span>1-second search by name or mobile</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6 font-semibold text-white">Delivery Commitments</td>
                                <td class="py-4 px-6 text-on-surface-muted flex items-center gap-2">
                                    <span class="material-symbols-outlined text-red-400 text-sm">remove_circle_outline</span>
                                    <span>Forgotten dates leading to customer delays</span>
                                </td>
                                <td class="py-4 px-6 text-emerald-400 font-medium">
                                    <span class="material-symbols-outlined text-emerald-400 text-sm inline-block align-middle mr-1">check_circle</span>
                                    <span>Automated delivery calendar and alerts</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6 font-semibold text-white">Advance & Balance Payments</td>
                                <td class="py-4 px-6 text-on-surface-muted flex items-center gap-2">
                                    <span class="material-symbols-outlined text-red-400 text-sm">remove_circle_outline</span>
                                    <span>Payment disputes and forgotten advance slips</span>
                                </td>
                                <td class="py-4 px-6 text-emerald-400 font-medium">
                                    <span class="material-symbols-outlined text-emerald-400 text-sm inline-block align-middle mr-1">check_circle</span>
                                    <span>Clear digital receipts and balance lock</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6 font-semibold text-white">Karigar Coordination</td>
                                <td class="py-4 px-6 text-on-surface-muted flex items-center gap-2">
                                    <span class="material-symbols-outlined text-red-400 text-sm">remove_circle_outline</span>
                                    <span>Verbal instructions and miscommunications</span>
                                </td>
                                <td class="py-4 px-6 text-emerald-400 font-medium">
                                    <span class="material-symbols-outlined text-emerald-400 text-sm inline-block align-middle mr-1">check_circle</span>
                                    <span>Visual kanban board and job cards</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6 font-semibold text-white">Financial Visibility</td>
                                <td class="py-4 px-6 text-on-surface-muted flex items-center gap-2">
                                    <span class="material-symbols-outlined text-red-400 text-sm">remove_circle_outline</span>
                                    <span>No real overview of monthly net profit</span>
                                </td>
                                <td class="py-4 px-6 text-emerald-400 font-medium">
                                    <span class="material-symbols-outlined text-emerald-400 text-sm inline-block align-middle mr-1">check_circle</span>
                                    <span>Real-time revenue, expense and P&L reports</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- 8. REAL CUSTOMER TESTIMONIALS -->
        <section class="py-20 bg-background border-b border-white/[0.06]" id="testimonials">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Verified Feedback</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Trusted by Tailors & Boutique Owners</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="card-modern rounded-2xl p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex text-primary mb-4">
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            </div>
                            <p class="text-xs sm:text-sm text-on-surface-variant italic mb-6 leading-relaxed">
                                "Earlier we managed everything in 4 thick registers. Finding customer measurements took 10 minutes. Now with DarziDesk, I type the mobile number and measurement opens in 1 second."
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Mukesh Sharma</p>
                            <p class="text-xs text-primary font-medium">Royal Stitch Tailors, Jaipur</p>
                        </div>
                    </div>

                    <div class="card-modern rounded-2xl p-8 border-primary/40 shadow-xl flex flex-col justify-between">
                        <div>
                            <div class="flex text-primary mb-4">
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            </div>
                            <p class="text-xs sm:text-sm text-on-surface-variant italic mb-6 leading-relaxed">
                                "In wedding season, our boutique handles 100+ blouses and lehengas. Sending automated WhatsApp updates when dresses are ready saved our staff 2 hours of phone calling every day."
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Pooja Chawla</p>
                            <p class="text-xs text-primary font-medium">Aura Couture Boutique, Delhi NCR</p>
                        </div>
                    </div>

                    <div class="card-modern rounded-2xl p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex text-primary mb-4">
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            </div>
                            <p class="text-xs sm:text-sm text-on-surface-variant italic mb-6 leading-relaxed">
                                "The worker payroll calculation based on completed pieces solved all arguments with my karigars. Tracking advance deposits also stopped all customer payment confusion."
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Irfan Ansari</p>
                            <p class="text-xs text-primary font-medium">Master Fit Sartorials, Lucknow</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 9. PRICING PREVIEW ON HOMEPAGE -->
        <section class="py-20 bg-surface border-b border-white/[0.06]" id="pricing">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Transparent SaaS Plans</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">Simple Plans for Every Shop Size</h2>
                <p class="text-on-surface-variant text-sm max-w-xl mx-auto mb-12">Start with a 14-day free trial. No credit card required.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto text-left">
                    
                    <!-- Starter -->
                    <div class="card-modern rounded-2xl p-8 flex flex-col">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">Solo Tailors</span>
                        <h3 class="text-xl font-bold text-white mt-1">Starter</h3>
                        <div class="my-6">
                            <span class="text-3xl sm:text-4xl font-extrabold text-white">₹0</span>
                            <span class="text-xs text-on-surface-variant">/ 14 Days Free</span>
                            <p class="text-xs text-emerald-400 mt-1 font-medium">Then ₹499/month</p>
                        </div>
                        <ul class="space-y-3 text-xs text-on-surface-variant mb-8 flex-1">
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary text-sm">check</span> 3 Staff / Workers</li>
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary text-sm">check</span> 150 Customer Profiles</li>
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary text-sm">check</span> Digital Measurement Vault</li>
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary text-sm">check</span> Android & iOS Mobile Apps</li>
                        </ul>
                        <a href="{{ route('register') }}" class="w-full btn-outline-gold py-3 rounded-xl text-center font-bold text-xs">Start Free Trial</a>
                    </div>

                    <!-- Boutique Pro -->
                    <div class="card-modern rounded-2xl p-8 border-2 border-primary shadow-2xl relative flex flex-col bg-surface-card">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-primary text-on-primary text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                            Most Popular
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">Boutiques & Studios</span>
                        <h3 class="text-xl font-bold text-white mt-1">Boutique Pro</h3>
                        <div class="my-6">
                            <span class="text-3xl sm:text-4xl font-extrabold text-primary">₹999</span>
                            <span class="text-xs text-on-surface-variant">/ month</span>
                            <p class="text-xs text-primary mt-1 font-medium">₹799/mo on Annual Plan</p>
                        </div>
                        <ul class="space-y-3 text-xs text-on-surface-variant mb-8 flex-1">
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary text-sm">check</span> 15 Staff / Karigars</li>
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary text-sm">check</span> 2,500 Customer Profiles</li>
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary text-sm">check</span> Production Kanban & Stages</li>
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary text-sm">check</span> WhatsApp Bills & Receipts</li>
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary text-sm">check</span> Worker Piece-Rate Pay</li>
                        </ul>
                        <a href="{{ route('register') }}" class="w-full btn-gold py-3 rounded-xl text-center font-bold text-xs">Start Free Trial</a>
                    </div>

                    <!-- Master Studio -->
                    <div class="card-modern rounded-2xl p-8 flex flex-col">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">Multi-Branch Units</span>
                        <h3 class="text-xl font-bold text-white mt-1">Master Studio</h3>
                        <div class="my-6">
                            <span class="text-3xl sm:text-4xl font-extrabold text-white">₹2,499</span>
                            <span class="text-xs text-on-surface-variant">/ month</span>
                            <p class="text-xs text-on-surface-variant mt-1 font-medium">Unlimited Capacity</p>
                        </div>
                        <ul class="space-y-3 text-xs text-on-surface-variant mb-8 flex-1">
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary text-sm">check</span> Unlimited Staff & Workers</li>
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary text-sm">check</span> Unlimited Customers & Orders</li>
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary text-sm">check</span> Multi-Branch Governance</li>
                            <li class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary text-sm">check</span> Dedicated WhatsApp Manager</li>
                        </ul>
                        <a href="{{ route('register') }}" class="w-full btn-outline-gold py-3 rounded-xl text-center font-bold text-xs">Start Free Trial</a>
                    </div>

                </div>

                <div class="mt-8">
                    <a href="{{ route('pricing.public') }}" class="text-primary font-semibold text-xs hover:underline inline-flex items-center gap-1">
                        View Full Feature Comparison Table <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- 10. MOBILE APPS DOWNLOAD & QR CODE -->
        <section class="py-16 bg-background border-b border-white/[0.06]" id="mobile-apps">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="card-modern rounded-2xl p-8 sm:p-12 flex flex-col lg:flex-row items-center justify-between gap-8">
                    <div class="max-w-xl text-left">
                        <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Cross-Platform Accessibility</span>
                        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3">Download DarziDesk Mobile App</h2>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed mb-6">
                            Take measurements, check order status, create bills, and manage karigars straight from your mobile phone.
                        </p>
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="https://play.google.com/store/apps/details?id=com.darzidesk.app&hl=en" target="_blank" class="inline-block hover:opacity-85 transition-opacity">
                                <img src="{{ asset('assets/images/google_play_badge.svg') }}" alt="Get it on Google Play" class="h-11 w-auto">
                            </a>
                            <a href="https://apps.apple.com/us/app/darzidesk/id6796700050" target="_blank" class="inline-block hover:opacity-85 transition-opacity">
                                <img src="{{ asset('assets/images/app_store_badge.svg') }}" alt="Download on the App Store" class="h-11 w-auto">
                            </a>
                        </div>
                    </div>

                    <!-- QR Code Card -->
                    <div class="bg-background rounded-xl p-5 border border-white/[0.08] text-center shrink-0">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data=https://darzidesk.shop" alt="Scan to download DarziDesk app" loading="lazy" class="w-28 h-28 mx-auto rounded-lg mb-2.5">
                        <p class="text-xs font-bold text-white">Scan to Download</p>
                        <p class="text-[10px] text-on-surface-muted">Android & iOS</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 11. SAAS FAQS -->
        <section class="py-20 bg-surface border-b border-white/[0.06]" id="faq-section">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Help & Answers</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Frequently Asked Questions</h2>
                </div>

                <div class="space-y-3">
                    
                    <details class="card-modern rounded-xl group" open>
                        <summary class="p-5 cursor-pointer select-none flex items-center justify-between gap-3 list-none [&::-webkit-details-marker]:hidden">
                            <span class="flex items-center gap-2 text-sm sm:text-base font-bold text-white">
                                <span class="material-symbols-outlined text-primary text-base">help</span>
                                Is DarziDesk suitable for small tailoring shops?
                            </span>
                            <span class="material-symbols-outlined text-on-surface-muted text-lg transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <p class="px-5 pb-5 text-xs sm:text-sm text-on-surface-variant leading-relaxed pl-11">
                            Yes. DarziDesk is designed for shops of all sizes — from single-worker neighborhood tailor shops to high-end multi-branch designer boutiques.
                        </p>
                    </details>

                    <details class="card-modern rounded-xl group">
                        <summary class="p-5 cursor-pointer select-none flex items-center justify-between gap-3 list-none [&::-webkit-details-marker]:hidden">
                            <span class="flex items-center gap-2 text-sm sm:text-base font-bold text-white">
                                <span class="material-symbols-outlined text-primary text-base">help</span>
                                Can I manage ladies' tailoring orders like Blouses and Lehengas?
                            </span>
                            <span class="material-symbols-outlined text-on-surface-muted text-lg transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <p class="px-5 pb-5 text-xs sm:text-sm text-on-surface-variant leading-relaxed pl-11">
                            Yes, DarziDesk comes pre-loaded with templates for Blouses (Katori, Princess cut, Sabyasachi cut), Salwar Suits, Kurtis, Lehengas, Gowns, and Western wear.
                        </p>
                    </details>

                    <details class="card-modern rounded-xl group">
                        <summary class="p-5 cursor-pointer select-none flex items-center justify-between gap-3 list-none [&::-webkit-details-marker]:hidden">
                            <span class="flex items-center gap-2 text-sm sm:text-base font-bold text-white">
                                <span class="material-symbols-outlined text-primary text-base">help</span>
                                Can I save customer measurements and reuse them later?
                            </span>
                            <span class="material-symbols-outlined text-on-surface-muted text-lg transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <p class="px-5 pb-5 text-xs sm:text-sm text-on-surface-variant leading-relaxed pl-11">
                            Yes. You can search any customer by name or phone number and their exact measurement history will open in 1 second.
                        </p>
                    </details>

                    <details class="card-modern rounded-xl group">
                        <summary class="p-5 cursor-pointer select-none flex items-center justify-between gap-3 list-none [&::-webkit-details-marker]:hidden">
                            <span class="flex items-center gap-2 text-sm sm:text-base font-bold text-white">
                                <span class="material-symbols-outlined text-primary text-base">help</span>
                                Can I track advance cash deposits and pending balances?
                            </span>
                            <span class="material-symbols-outlined text-on-surface-muted text-lg transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <p class="px-5 pb-5 text-xs sm:text-sm text-on-surface-variant leading-relaxed pl-11">
                            Yes. DarziDesk logs advance payments at order booking and calculates the exact remaining balance due on delivery. You can send receipt bills on WhatsApp instantly.
                        </p>
                    </details>

                    <details class="card-modern rounded-xl group">
                        <summary class="p-5 cursor-pointer select-none flex items-center justify-between gap-3 list-none [&::-webkit-details-marker]:hidden">
                            <span class="flex items-center gap-2 text-sm sm:text-base font-bold text-white">
                                <span class="material-symbols-outlined text-primary text-base">help</span>
                                Can I manage multiple workers and karigars?
                            </span>
                            <span class="material-symbols-outlined text-on-surface-muted text-lg transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <p class="px-5 pb-5 text-xs sm:text-sm text-on-surface-variant leading-relaxed pl-11">
                            Yes. You can assign specific garments to master cutters and stitching tailors, track stages on a visual kanban board, and compute piece-rate pay.
                        </p>
                    </details>

                    <details class="card-modern rounded-xl group">
                        <summary class="p-5 cursor-pointer select-none flex items-center justify-between gap-3 list-none [&::-webkit-details-marker]:hidden">
                            <span class="flex items-center gap-2 text-sm sm:text-base font-bold text-white">
                                <span class="material-symbols-outlined text-primary text-base">help</span>
                                Does it work on Android and iPhone?
                            </span>
                            <span class="material-symbols-outlined text-on-surface-muted text-lg transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <p class="px-5 pb-5 text-xs sm:text-sm text-on-surface-variant leading-relaxed pl-11">
                            Yes. Native DarziDesk apps are live on Google Play Store and Apple App Store, plus you can login on any laptop or desktop web browser.
                        </p>
                    </details>

                    <details class="card-modern rounded-xl group">
                        <summary class="p-5 cursor-pointer select-none flex items-center justify-between gap-3 list-none [&::-webkit-details-marker]:hidden">
                            <span class="flex items-center gap-2 text-sm sm:text-base font-bold text-white">
                                <span class="material-symbols-outlined text-primary text-base">help</span>
                                Is my customer data secure?
                            </span>
                            <span class="material-symbols-outlined text-on-surface-muted text-lg transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <p class="px-5 pb-5 text-xs sm:text-sm text-on-surface-variant leading-relaxed pl-11">
                            100%. All customer measurements and billing records are stored in encrypted cloud storage with automatic daily backups.
                        </p>
                    </details>

                    <details class="card-modern rounded-xl group">
                        <summary class="p-5 cursor-pointer select-none flex items-center justify-between gap-3 list-none [&::-webkit-details-marker]:hidden">
                            <span class="flex items-center gap-2 text-sm sm:text-base font-bold text-white">
                                <span class="material-symbols-outlined text-primary text-base">help</span>
                                Do you provide onboarding support to migrate from notebooks?
                            </span>
                            <span class="material-symbols-outlined text-on-surface-muted text-lg transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <p class="px-5 pb-5 text-xs sm:text-sm text-on-surface-variant leading-relaxed pl-11">
                            Yes. Our team provides free setup assistance and WhatsApp support to help you get started comfortably.
                        </p>
                    </details>

                </div>
            </div>
        </section>

        <!-- 12. FINAL CALL TO ACTION -->
        <section class="py-20 bg-surface-card border-b border-white/[0.06] text-center">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl sm:text-4xl font-extrabold text-white mb-3">Start Managing Your Shop Smarter Today</h2>
                <p class="text-sm sm:text-base text-on-surface-variant max-w-lg mx-auto mb-8">
                    Join hundreds of tailor shops and boutiques across India. Sign up in under 60 seconds.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="btn-gold px-8 py-3.5 rounded-xl text-sm font-bold w-full sm:w-auto">
                        Start 14-Day Free Trial
                    </a>
                    <button onclick="document.getElementById('demo-modal').classList.remove('hidden')" class="btn-outline-gold px-8 py-3.5 rounded-xl text-sm font-semibold w-full sm:w-auto flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-base">calendar_month</span>
                        <span>Book a Free Demo</span>
                    </button>
                    <a href="https://wa.me/919536824061?text=Hi%20DarziDesk%2C%20I%20want%20to%20start%20my%20free%20trial" target="_blank" class="px-6 py-3.5 rounded-xl bg-[#25D366] text-white font-bold text-sm hover:bg-[#20ba59] transition-all flex items-center justify-center gap-2 w-full sm:w-auto">
                        <span class="material-symbols-outlined text-base">chat</span>
                        <span>Chat on WhatsApp</span>
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- Global SaaS Footer -->
    @include('layouts.saas_footer')

    <!-- Book Demo Modal (No Emojis) -->
    <div id="demo-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
        <div class="bg-surface rounded-2xl p-6 sm:p-8 max-w-md w-full border border-white/[0.1] shadow-2xl relative">
            <button onclick="document.getElementById('demo-modal').classList.add('hidden')" class="absolute top-4 right-4 text-on-surface-muted hover:text-white">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
            <h3 class="text-xl font-bold text-white mb-1">Book Your Free Live Demo</h3>
            <p class="text-xs text-on-surface-variant mb-6">See how DarziDesk works for your shop in a quick 10-minute demo.</p>
            
            <form action="{{ route('demo.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant mb-1">Your Full Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Ramesh Tailor" class="w-full bg-background border border-white/[0.1] rounded-xl px-3.5 py-2.5 text-sm text-white focus:border-primary">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-on-surface-variant mb-1">Mobile / WhatsApp *</label>
                        <input type="tel" name="mobile" required placeholder="9876543210" class="w-full bg-background border border-white/[0.1] rounded-xl px-3.5 py-2.5 text-sm text-white focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-on-surface-variant mb-1">City *</label>
                        <input type="text" name="city" placeholder="e.g. Jaipur" class="w-full bg-background border border-white/[0.1] rounded-xl px-3.5 py-2.5 text-sm text-white focus:border-primary">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-on-surface-variant mb-1">Business Name</label>
                        <input type="text" name="business_name" placeholder="Shop Name" class="w-full bg-background border border-white/[0.1] rounded-xl px-3.5 py-2.5 text-sm text-white focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-on-surface-variant mb-1">Number of Workers</label>
                        <select name="workers_count" class="w-full bg-background border border-white/[0.1] rounded-xl px-3.5 py-2.5 text-sm text-white focus:border-primary">
                            <option value="1-2">1 to 2</option>
                            <option value="3-5" selected>3 to 5</option>
                            <option value="6-10">6 to 10</option>
                            <option value="10+">10+</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="w-full btn-gold py-3 rounded-xl font-bold text-sm mt-2 flex items-center justify-center gap-2">
                    <span>Schedule Free Demo</span>
                    <span class="material-symbols-outlined text-sm">send</span>
                </button>
                <p class="text-[11px] text-center text-on-surface-muted">Free 1-on-1 Consultation. Zero spam guaranteed.</p>
            </form>
        </div>
    </div>

    <!-- Demo Form Success Toast -->
    @if(session('success'))
    <div id="success-toast" class="fixed top-24 left-1/2 -translate-x-1/2 z-[60] bg-emerald-500/95 backdrop-blur-sm text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 animate-bounce max-w-md">
        <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        <div>
            <p class="text-sm font-bold">{{ session('success') }}</p>
            <p class="text-xs opacity-80">We will contact you within 24 hours.</p>
        </div>
        <button onclick="document.getElementById('success-toast').remove()" class="ml-auto text-white/70 hover:text-white" aria-label="Dismiss notification">
            <span class="material-symbols-outlined text-lg">close</span>
        </button>
    </div>
    <script>setTimeout(() => { const t = document.getElementById('success-toast'); if(t) t.remove(); }, 8000);</script>
    @endif
    </div>

    <!-- Tab Switching Script -->
    <script>
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('block'));
            
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            
            const targetContent = document.getElementById('tab-content-' + tabId);
            if (targetContent) {
                targetContent.classList.remove('hidden');
                targetContent.classList.add('block');
            }
            
            const targetBtn = document.querySelector(`[data-tab="${tabId}"]`);
            if (targetBtn) {
                targetBtn.classList.add('active');
            }
        }
    </script>
</body>
</html>
