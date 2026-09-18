<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Blog - Tailoring Business Tips, Guides & Software Insights | DarziDesk</title>
    <meta name="description" content="Discover actionable tips, digital strategies, customer measurement management techniques, and business growth insights for modern tailors and boutiques in India."/>
    <meta name="keywords" content="tailoring blog, tailor business guide, boutique management tips, digital measurement book, tailoring software india"/>
    
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
                    <a href="{{ route('blog.index') }}" class="text-primary font-bold text-sm">Blog</a>
                    <a href="{{ route('about.us') }}" class="text-on-surface-variant hover:text-primary transition-colors text-sm font-medium">About Us</a>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-on-surface hover:text-primary transition-colors">Login</a>
                <a href="{{ route('register') }}" class="btn-gold px-4 py-2 rounded-xl text-sm font-bold">Start Free Trial</a>
            </div>
        </div>
    </header>

    <main class="pt-24 flex-1">
        <!-- Blog Hero Section -->
        <section class="py-16 text-center max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 hero-mesh">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/[0.04] border border-white/[0.08] mb-6">
                <span class="material-symbols-outlined text-primary text-base">menu_book</span>
                <span class="text-primary font-bold text-xs uppercase tracking-widest">Tailoring Industry Knowledge</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-white leading-tight mb-4 tracking-tight">
                DarziDesk Knowledge & Insights
            </h1>
            <p class="text-base sm:text-lg text-on-surface-variant max-w-2xl mx-auto leading-relaxed">
                Practical guides, digital strategies, and business advice to run and grow your tailoring shop and boutique.
            </p>
        </section>

        <!-- Blog Posts Grid -->
        <section class="pb-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @forelse ($blogs as $blog)
                    <article class="card-modern rounded-2xl p-6 sm:p-7 flex flex-col group">
                        @if($blog->image)
                            <a href="{{ route('blog.show', $blog->slug) }}" class="block overflow-hidden rounded-xl mb-5 border border-white/[0.08] aspect-video">
                                <img src="{{ asset(Storage::url('upload/'.$blog->image)) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $blog->title }}">
                            </a>
                        @endif

                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-primary text-xs font-semibold uppercase tracking-wider">
                                {{ $blog->created_at->format('M d, Y') }}
                            </span>
                            <span class="text-on-surface-muted text-xs">•</span>
                            <span class="text-on-surface-muted text-xs font-medium">4 min read</span>
                        </div>

                        <h2 class="text-lg sm:text-xl font-bold text-white group-hover:text-primary transition-colors leading-snug mb-3">
                            <a href="{{ route('blog.show', $blog->slug) }}">
                                {{ $blog->title }}
                            </a>
                        </h2>

                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed mb-6 line-clamp-3 flex-1">
                            {{ $blog->short_description }}
                        </p>

                        <div class="pt-4 border-t border-white/[0.06] mt-auto">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-primary hover:text-primary-hover group-hover:translate-x-1 transition-all">
                                <span>Read Full Article</span>
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-16 bg-surface rounded-2xl border border-white/[0.06]">
                        <span class="material-symbols-outlined text-4xl text-on-surface-muted mb-2">article</span>
                        <p class="text-base text-on-surface-variant font-medium">No blog articles published yet.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <!-- Global SaaS Footer -->
    @include('layouts.saas_footer')

</body>
</html>
