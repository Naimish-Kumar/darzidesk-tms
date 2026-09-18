@php
    $settings = settings();
@endphp
<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>About Us - DarziDesk | Leading Tailoring & Boutique Management Software</title>
    <meta name="description" content="Learn about DarziDesk's mission to digitize bespoke tailor shops, custom fashion designers, and boutiques across India with smart TMS technology."/>
    <meta name="keywords" content="about darzidesk, tailoring software company, boutique management software india, darzi software contact"/>
    
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
            background: #0E1C30;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-modern:hover {
            border-color: rgba(229, 169, 60, 0.45);
            transform: translateY(-3px);
            box-shadow: 0 16px 32px -8px rgba(0, 0, 0, 0.6);
        }
    </style>
</head>
<body class="bg-background text-on-surface font-sans antialiased min-h-screen flex flex-col justify-between">

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
                    <a href="{{ route('home') }}#who-its-for" class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium">Solutions</a>
                    <a href="{{ route('pricing.public') }}" class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium">Pricing</a>
                    <a href="{{ route('blog.index') }}" class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium">Blog</a>
                    <a href="{{ route('about.us') }}" class="text-primary font-bold text-sm">About Us</a>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="hidden sm:inline-flex px-4 py-2 rounded-xl text-sm font-semibold text-on-surface hover:text-primary transition-colors">Login</a>
                <a href="{{ route('register') }}" class="btn-gold px-4 py-2 rounded-xl text-sm font-bold">Start Free Trial</a>
                <button onclick="document.getElementById('about-mobile-nav').classList.toggle('hidden')" class="lg:hidden p-2 rounded-xl text-on-surface hover:text-primary transition-colors" aria-label="Toggle navigation menu">
                    <span class="material-symbols-outlined text-2xl">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div id="about-mobile-nav" class="hidden lg:hidden bg-surface border-t border-white/[0.06]">
            <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col gap-1">
                <a href="{{ route('home') }}" class="py-3 px-4 rounded-xl text-sm font-medium text-on-surface-variant hover:text-primary hover:bg-white/[0.04] transition-all">Home</a>
                <a href="{{ route('home') }}#features" class="py-3 px-4 rounded-xl text-sm font-medium text-on-surface-variant hover:text-primary hover:bg-white/[0.04] transition-all">Features</a>
                <a href="{{ route('pricing.public') }}" class="py-3 px-4 rounded-xl text-sm font-medium text-on-surface-variant hover:text-primary hover:bg-white/[0.04] transition-all">Pricing</a>
                <a href="{{ route('blog.index') }}" class="py-3 px-4 rounded-xl text-sm font-medium text-on-surface-variant hover:text-primary hover:bg-white/[0.04] transition-all">Blog</a>
                <a href="{{ route('about.us') }}" class="py-3 px-4 rounded-xl text-sm font-bold text-primary bg-primary-muted">About Us</a>
                <div class="border-t border-white/[0.06] mt-2 pt-3 flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="py-3 px-4 rounded-xl text-sm font-semibold text-on-surface text-center border border-white/[0.1] hover:border-primary/40 transition-all">Login</a>
                    <a href="{{ route('register') }}" class="btn-gold py-3 px-4 rounded-xl text-sm font-bold text-center">Start Free Trial</a>
                </div>
            </div>
        </div>
    </header>

    <main class="pt-24 flex-1">
        <!-- Hero Section -->
        <section class="py-16 lg:py-20 text-center max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 hero-mesh">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/[0.04] border border-white/[0.08] mb-6">
                <span class="material-symbols-outlined text-primary text-base">straighten</span>
                <span class="text-primary font-bold text-xs uppercase tracking-widest">Craftsmanship Meets Technology</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-white leading-tight mb-4 tracking-tight">
                Empowering India's Bespoke Tailors
            </h1>
            <p class="text-base sm:text-lg text-on-surface-variant max-w-2xl mx-auto leading-relaxed">
                DarziDesk is a premier Tailoring Management System (TMS) engineered specifically to digitize boutique workflows, master measurement records, karigar assignments, and order tracking.
            </p>
        </section>

        <!-- Stat Grid -->
        <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 mb-16">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="card-modern rounded-2xl p-8 text-center bg-surface-card">
                    <span class="text-4xl font-extrabold text-primary font-mono block mb-2">500+</span>
                    <span class="text-xs uppercase tracking-wider text-white font-bold">Active Boutiques & Studios</span>
                </div>
                <div class="card-modern rounded-2xl p-8 text-center bg-surface-card">
                    <span class="text-4xl font-extrabold text-primary font-mono block mb-2">50,000+</span>
                    <span class="text-xs uppercase tracking-wider text-white font-bold">Custom Orders Processed</span>
                </div>
                <div class="card-modern rounded-2xl p-8 text-center bg-surface-card">
                    <span class="text-4xl font-extrabold text-primary font-mono block mb-2">99.8%</span>
                    <span class="text-xs uppercase tracking-wider text-white font-bold">Fitting Accuracy Rate</span>
                </div>
            </div>
        </section>

        <!-- Mission & Story -->
        <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
            <div class="card-modern rounded-3xl p-8 sm:p-12 border border-white/[0.08]">
                <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Why We Built DarziDesk</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-6">Our Mission</h2>
                <div class="space-y-4 text-sm sm:text-base text-on-surface-variant leading-relaxed">
                    <p>
                        For generations, tailoring has been an integral art form defined by precision, personal care, and meticulous craftsmanship. However, traditional paper measurement registers, misplaced order slips, and manual worker tracking often lead to delays, confusion, and costly fitting errors.
                    </p>
                    <p>
                        DarziDesk bridges traditional artistry with modern digital efficiency. We provide boutique owners, master tailors, cutters, and clients with a unified cloud-native platform to manage every order seamlessly from fabric receipt to final delivery.
                    </p>
                </div>

                <!-- Core Capabilities -->
                <h3 class="text-xl font-bold text-white mt-12 mb-6">Core Capabilities</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-surface rounded-2xl p-6 border border-white/[0.06]">
                        <div class="w-10 h-10 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-xl">straighten</span>
                        </div>
                        <h4 class="text-base font-bold text-white mb-2">Digital Measurement Vault</h4>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Store comprehensive customer body measurements, posture notes, and style references permanently. Access instantly for repeat orders.
                        </p>
                    </div>

                    <div class="bg-surface rounded-2xl p-6 border border-white/[0.06]">
                        <div class="w-10 h-10 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-xl">view_kanban</span>
                        </div>
                        <h4 class="text-base font-bold text-white mb-2">Production Kanban Pipeline</h4>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Track every garment status step-by-step: Cutting, Stitching, Embroidery, Trial Fitting, Quality Check, and Delivery.
                        </p>
                    </div>

                    <div class="bg-surface rounded-2xl p-6 border border-white/[0.06]">
                        <div class="w-10 h-10 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-xl">chat</span>
                        </div>
                        <h4 class="text-base font-bold text-white mb-2">Automated Customer Alerts</h4>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Keep customers informed with automatic WhatsApp updates for delivery dates, trial fittings, and payment receipts.
                        </p>
                    </div>

                    <div class="bg-surface rounded-2xl p-6 border border-white/[0.06]">
                        <div class="w-10 h-10 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-xl">point_of_sale</span>
                        </div>
                        <h4 class="text-base font-bold text-white mb-2">POS, Invoicing & QR Receipts</h4>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Generate GST invoices, thermal cloth tags, and digital QR tracking receipts for transparent self-service order lookup.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Details & Social Media Section -->
        <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mb-20" id="contact-details">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Reach Out & Follow</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-white">Contact & Support Details</h2>
                <p class="text-xs sm:text-sm text-on-surface-variant mt-2">Have a question or need a personalized demo for your shop? We are here to help!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Email Contact Card -->
                <div class="card-modern rounded-2xl p-6 flex flex-col items-center text-center">
                    <div class="w-12 h-12 rounded-xl bg-primary-muted text-primary flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-2xl">mail</span>
                    </div>
                    <h3 class="text-base font-bold text-white mb-1">Email Support</h3>
                    <p class="text-xs text-on-surface-variant mb-4">For sales, support & feedback</p>
                    <div class="mt-auto space-y-1">
                        <a href="mailto:support@darzidesk.shop" class="block text-xs font-semibold text-primary hover:underline">support@darzidesk.shop</a>
                        <a href="mailto:info@darzidesk.shop" class="block text-xs text-on-surface-variant hover:text-white">info@darzidesk.shop</a>
                    </div>
                </div>

                <!-- Phone / WhatsApp Card -->
                <div class="card-modern rounded-2xl p-6 flex flex-col items-center text-center">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-2xl">call</span>
                    </div>
                    <h3 class="text-base font-bold text-white mb-1">WhatsApp & Call</h3>
                    <p class="text-xs text-on-surface-variant mb-4">Mon - Sat, 9:00 AM - 8:00 PM IST</p>
                    <div class="mt-auto">
                        <a href="https://wa.me/919536824061" target="_blank" class="text-xs font-mono font-bold text-emerald-400 hover:underline block">
                            +91 95368 24061
                        </a>
                    </div>
                </div>

                <!-- Facebook Page Card -->
                <div class="card-modern rounded-2xl p-6 flex flex-col items-center text-center group">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-white mb-1">Facebook Page</h3>
                    <p class="text-xs text-on-surface-variant mb-4">Follow us for updates & tailoring tips</p>
                    <div class="mt-auto w-full">
                        <a href="https://www.facebook.com/profile.php?id=61589959355817" target="_blank" rel="noopener noreferrer" class="btn-outline-gold py-2 px-4 rounded-xl text-xs font-semibold block text-center">
                            Visit Page
                        </a>
                    </div>
                </div>

                <!-- Instagram Account Card -->
                <div class="card-modern rounded-2xl p-6 flex flex-col items-center text-center group">
                    <div class="w-12 h-12 rounded-xl bg-pink-500/10 text-pink-400 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-white mb-1">Instagram</h3>
                    <p class="text-xs text-on-surface-variant mb-4">@darzidesk.shop for reels & stories</p>
                    <div class="mt-auto w-full">
                        <a href="https://www.instagram.com/darzidesk.shop?stkn=MTRjbzUwOHhieWkyMA==" target="_blank" rel="noopener noreferrer" class="btn-outline-gold py-2 px-4 rounded-xl text-xs font-semibold block text-center">
                            Follow @darzidesk.shop
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final Call to Action -->
        <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
            <div class="card-modern rounded-3xl p-8 sm:p-12 border border-primary/30 bg-gradient-to-br from-surface-card via-surface to-surface-card text-center relative overflow-hidden shadow-2xl">
                <div class="absolute -right-20 -bottom-20 w-72 h-72 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 max-w-2xl mx-auto">
                    <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Modernize Today</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">Ready to Transform Your Tailoring Business?</h3>
                    <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed mb-6">
                        Start your 14-day free trial today. No credit card required. Setup takes less than 2 minutes.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                        <a href="{{ route('register') }}" class="btn-gold px-8 py-3.5 rounded-xl text-sm font-bold w-full sm:w-auto">
                            Start 14-Day Free Trial
                        </a>
                        <a href="{{ route('pricing.public') }}" class="btn-outline-gold px-6 py-3.5 rounded-xl text-sm font-semibold w-full sm:w-auto">
                            View Pricing Plans
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Global SaaS Footer -->
    @include('layouts.saas_footer')

</body>
</html>
