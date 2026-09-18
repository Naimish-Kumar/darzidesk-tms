<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $blog->title }} - DarziDesk Blog</title>
    <meta name="description" content="{{ $blog->short_description ?? 'Read actionable insights on modern tailor shop management and boutique operations.' }}"/>
    
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

        /* Article Prose High-Contrast Styling */
        .blog-article-content h1,
        .blog-article-content h2,
        .blog-article-content h3,
        .blog-article-content h4 {
            color: #FFFFFF !important;
            font-weight: 800 !important;
            margin-top: 2rem !important;
            margin-bottom: 0.85rem !important;
            line-height: 1.3 !important;
        }
        .blog-article-content h2 {
            font-size: 1.65rem !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 0.5rem;
        }
        .blog-article-content h3 {
            font-size: 1.35rem !important;
        }
        .blog-article-content p {
            color: #CBD5E1 !important;
            font-size: 1.05rem !important;
            line-height: 1.85 !important;
            margin-bottom: 1.4rem !important;
        }
        .blog-article-content ul {
            list-style-type: disc !important;
            padding-left: 1.5rem !important;
            margin-bottom: 1.5rem !important;
            color: #CBD5E1 !important;
        }
        .blog-article-content ol {
            list-style-type: decimal !important;
            padding-left: 1.5rem !important;
            margin-bottom: 1.5rem !important;
            color: #CBD5E1 !important;
        }
        .blog-article-content li {
            margin-bottom: 0.6rem !important;
            line-height: 1.75 !important;
            color: #CBD5E1 !important;
        }
        .blog-article-content strong,
        .blog-article-content b {
            color: #FFFFFF !important;
            font-weight: 700 !important;
        }
        .blog-article-content a {
            color: #E5A93C !important;
            text-decoration: underline !important;
            font-weight: 600 !important;
        }
        .blog-article-content blockquote {
            border-left: 4px solid #E5A93C !important;
            background: #0E1C30 !important;
            padding: 1rem 1.25rem !important;
            border-radius: 0 0.75rem 0.75rem 0 !important;
            color: #F8FAFC !important;
            margin: 1.5rem 0 !important;
            font-style: italic !important;
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

    <main class="pt-28 pb-20 flex-1">
        <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-on-surface-muted mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <a href="{{ route('blog.index') }}" class="hover:text-primary transition-colors">Blog</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span class="text-on-surface-variant truncate max-w-xs">{{ $blog->title }}</span>
            </nav>

            <!-- Article Header -->
            <div class="mb-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-muted border border-primary/20 text-primary text-xs font-bold uppercase tracking-wider mb-4">
                    <span>{{ $blog->created_at->format('M d, Y') }}</span>
                    <span>•</span>
                    <span>5 min read</span>
                </div>
                
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight tracking-tight mb-6">
                    {{ $blog->title }}
                </h1>

                @if(!empty($blog->short_description))
                    <p class="text-base sm:text-xl text-on-surface-variant leading-relaxed">
                        {{ $blog->short_description }}
                    </p>
                @endif
            </div>

            <!-- Featured Image -->
            @if($blog->image)
                <div class="mb-10 rounded-2xl overflow-hidden border border-white/[0.08] shadow-2xl">
                    <img src="{{ asset(Storage::url('upload/'.$blog->image)) }}" class="w-full h-auto object-cover" alt="{{ $blog->title }}">
                </div>
            @endif

            <hr class="border-white/[0.08] my-8">

            <!-- Article Content Body -->
            <div class="blog-article-content">
                {!! $blog->content !!}
            </div>

            <!-- Modern SaaS CTA Card -->
            <div class="card-modern rounded-3xl p-8 sm:p-10 border border-primary/30 bg-gradient-to-br from-surface-card via-surface to-surface-card mt-16 text-center relative overflow-hidden shadow-2xl">
                <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 max-w-2xl mx-auto">
                    <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Modernize Your Tailoring Operations</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">Run Your Tailoring Business Smarter with DarziDesk</h3>
                    <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed mb-6">
                        Join hundreds of tailor shops and designer boutiques in India using DarziDesk to track measurements, streamline karigars, and send instant WhatsApp bills.
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

        </article>
    </main>

    <!-- Global SaaS Footer -->
    @include('layouts.saas_footer')

</body>
</html>
