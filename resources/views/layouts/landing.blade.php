<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>DarziDesk | High-End Bespoke Tailoring Marketplace & TMS</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700;800&amp;family=JetBrains+Mono:wght@400;500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "primary": "#D9A441",
                    "primary-container": "#F4C861",
                    "on-primary": "#03111F",
                    "on-primary-fixed-variant": "#00504e",
                    "secondary-fixed-dim": "#b7caca",
                    "invoice-unpaid": "#ef4444",
                    "surface-container-low": "#07192A",
                    "production-pending": "#94a3b8",
                    "on-background": "#FFFFFF",
                    "outline-variant": "#29435D",
                    "tertiary-fixed-dim": "#b8cac9",
                    "secondary-fixed": "#d3e6e6",
                    "background": "#03111F",
                    "on-primary-container": "#03111F",
                    "secondary": "#F4C861",
                    "on-surface-variant": "#D8E0E8",
                    "primary-fixed": "#F4C861",
                    "on-primary-fixed": "#03111F",
                    "surface": "#0B2239",
                    "alert-low-stock": "#F59E0B",
                    "tertiary-container": "#92a3a2",
                    "on-surface": "#FFFFFF",
                    "inverse-on-surface": "#03111F",
                    "surface-dim": "#0B2239",
                    "error": "#ef4444",
                    "on-tertiary-fixed": "#0e1e1e",
                    "on-secondary": "#03111F",
                    "on-tertiary-container": "#2a3a39",
                    "surface-bright": "#03111F",
                    "on-tertiary-fixed-variant": "#3a4a49",
                    "inverse-primary": "#F4C861",
                    "surface-background": "#03111F",
                    "surface-tint": "#D9A441",
                    "inverse-surface": "#0B2239",
                    "on-secondary-fixed": "#0d1e1e",
                    "surface-container": "#0B2239",
                    "tertiary": "#516161",
                    "surface-container-highest": "#102B45",
                    "surface-variant": "#102B45",
                    "surface-container-high": "#102B45",
                    "outline": "#29435D",
                    "on-secondary-fixed-variant": "#394a4a",
                    "on-secondary-container": "#F4C861",
                    "on-error": "#ffffff",
                    "secondary-container": "rgba(217, 164, 65, 0.15)",
                    "production-stitching": "#8b5cf6",
                    "error-container": "#ffdad6",
                    "tertiary-fixed": "#d4e6e5",
                    "production-cutting": "#3b82f6",
                    "on-tertiary": "#ffffff",
                    "on-error-container": "#93000a",
                    "surface-container-lowest": "#03111F",
                    "primary-fixed-dim": "#F4C861",
                    "production-ready": "#10b981"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "gutter": "24px",
                    "container-max": "1440px",
                    "stack-xs": "4px",
                    "stack-md": "16px",
                    "margin-tablet": "32px",
                    "stack-xl": "48px",
                    "stack-lg": "24px",
                    "margin-desktop": "64px",
                    "stack-sm": "8px"
            },
            "fontFamily": {
                    "headline-md": ["Hanken Grotesk"],
                    "headline-lg": ["Hanken Grotesk"],
                    "body-md": ["Hanken Grotesk"],
                    "display-md": ["Hanken Grotesk"],
                    "title-lg": ["Hanken Grotesk"],
                    "data-mono": ["JetBrains Mono"],
                    "display-lg": ["Hanken Grotesk"],
                    "title-md": ["Hanken Grotesk"],
                    "label-md": ["Hanken Grotesk"],
                    "body-sm": ["Hanken Grotesk"],
                    "body-lg": ["Hanken Grotesk"]
            },
            "fontSize": {
                    "headline-md": ["2rem", { "lineHeight": "2.5rem" }],
                    "body-sm": ["0.875rem", { "lineHeight": "1.25rem" }],
                    "display-lg": ["3.5rem", { "lineHeight": "4rem" }],
                    "display-md": ["2.75rem", { "lineHeight": "3.25rem" }],
                    "title-md": ["1rem", { "lineHeight": "1.5rem" }],
                    "title-lg": ["1.25rem", { "lineHeight": "1.75rem" }],
                    "label-md": ["0.75rem", { "lineHeight": "1rem" }],
                    "body-md": ["1rem", { "lineHeight": "1.5rem" }],
                    "body-lg": ["1.125rem", { "lineHeight": "1.75rem" }],
                    "headline-lg": ["2.25rem", { "lineHeight": "2.75rem" }]
            }
          }
        }
      }
    </script>
    <style>
        .hero-gradient {
            background: linear-gradient(to right, rgba(3, 17, 31, 0.95), rgba(3, 17, 31, 0.75));
        }
        .glass-card {
            background: rgba(11, 34, 57, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(41, 67, 93, 0.6);
        }
        .luxury-card {
            background: linear-gradient(145deg, #0B2239 0%, #07192A 100%);
            border: 1px solid #29435D;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
        }
        .luxury-card:hover {
            border-color: #D9A441;
            box-shadow: 0 20px 40px -10px rgba(217, 164, 65, 0.25);
            transform: translateY(-6px);
        }
    </style>
    <link href="{{ asset('css/custom.css') }}?v={{ file_exists(public_path('css/custom.css')) ? filemtime(public_path('css/custom.css')) : time() }}" rel="stylesheet">
</head>
<body class="bg-background text-on-surface font-body-md selection:bg-primary-container selection:text-on-primary-container">

<!-- Navigation Bar -->
<header class="fixed top-0 w-full bg-background/90 backdrop-blur-md border-b border-outline-variant/60 shadow-lg z-50">
<nav class="flex justify-between items-center px-gutter py-4 w-full max-w-container-max mx-auto">
<div class="flex items-center gap-stack-xl">
<a href="{{ route('home') }}">
    <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" style="height: 42px; width: auto; max-width: 220px; object-fit: contain;">
</a>
<div class="hidden lg:flex items-center gap-6">
<a class="text-on-surface-variant font-title-md hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
<a class="text-on-surface-variant font-title-md hover:text-primary transition-colors" href="{{ route('about.us') }}">About Us</a>
<a class="text-on-surface-variant font-title-md hover:text-primary transition-colors" href="{{ route('privacy.policy') }}">Privacy Policy</a>
<a class="text-on-surface-variant font-title-md hover:text-primary transition-colors" href="{{ route('terms.conditions') }}">Terms & Services</a>
<a class="text-on-surface-variant font-title-md hover:text-primary transition-colors" href="{{ route('blog.index') }}">Blog</a>
@php
    $dynamicHeaderPages = \App\Models\Page::where('enabled', 1)->get();
@endphp
@foreach($dynamicHeaderPages as $dynHeaderPage)
    @if(!in_array($dynHeaderPage->slug, ['about_us', 'privacy_policy', 'terms_conditions', 'delete_account']))
        <a class="text-on-surface-variant font-title-md hover:text-primary transition-colors" href="{{ route('page', $dynHeaderPage->slug) }}">{{ $dynHeaderPage->title }}</a>
    @endif
@endforeach
</div>
</div>
<!-- Standardized Top Buttons -->
<div class="flex items-center gap-4">
<a href="{{ route('login') }}" class="btn-gold-outline">Partner Login</a>
<a href="{{ route('register') }}" class="btn-gold">Get Started</a>
</div>
</nav>
</header>

<main class="pt-20">
<!-- Hero Section -->
<section class="relative min-h-[720px] flex items-center overflow-hidden">
<div class="absolute inset-0 z-0">
<img class="w-full h-full object-cover" alt="Master tailor crafting bespoke suit" src="{{ asset('assets/images/hero_tailor_atelier.jpg') }}"/>
<div class="absolute inset-0 hero-gradient"></div>
</div>
<div class="relative z-10 w-full max-w-container-max mx-auto px-gutter grid grid-cols-1 lg:grid-cols-12 gap-gutter py-12">
<div class="lg:col-span-8 flex flex-col gap-6">
<span class="inline-block px-4 py-1.5 rounded-full bg-primary-container/20 text-primary-container border border-primary-container/40 w-fit font-label-md tracking-widest uppercase font-bold">The Artisan Standard</span>
<h1 class="font-display-lg text-display-lg text-white max-w-2xl leading-tight font-extrabold">Tailored Precision for the Modern Silhouette.</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl leading-relaxed">Connect with the world's finest master tailors. From bespoke Savile Row suits to intricate traditional heritage wear.</p>
<form id="hero-search-form" action="#nearby-tailors" method="GET" class="mt-4 glass-card p-3 rounded-full flex flex-col md:flex-row items-stretch md:items-center shadow-2xl max-w-2xl gap-3 md:gap-0">
<div class="flex-1 flex items-center px-6 gap-3 py-2 md:py-0">
<span class="material-symbols-outlined text-primary text-2xl">search</span>
<input id="search-keyword-input" name="search" value="{{ request('search') }}" class="w-full bg-transparent border-none focus:ring-0 font-body-md placeholder:text-on-surface-variant/70 text-white" placeholder="Bespoke Tuxedo, Suit, Alteration..." type="text"/>
</div>
<div class="hidden md:block h-8 w-[1px] bg-outline-variant"></div>
<div class="flex-1 flex items-center px-6 gap-3 py-2 md:py-0">
<span class="material-symbols-outlined text-primary text-2xl">location_on</span>
<input id="search-location-input" name="location" value="{{ request('location') }}" class="w-full bg-transparent border-none focus:ring-0 font-body-md placeholder:text-on-surface-variant/70 text-white" placeholder="London, Mayfair, Milan..." type="text"/>
</div>
<button type="submit" id="search-submit-button" class="btn-gold btn-lg">Find Tailor</button>
</form>
</div>
</div>
</section>

<!-- Nearby Tailors (Luxury Grid) -->
<section class="py-margin-desktop bg-background" id="nearby-tailors">
<div class="max-w-container-max mx-auto px-gutter">
<div class="flex justify-between items-end mb-10">
<div>
<span class="text-primary font-bold text-sm uppercase tracking-widest block mb-1">Curated Marketplace</span>
<h2 class="font-headline-lg text-headline-lg text-white font-extrabold mb-2" id="nearby-tailors-title">Nearby Tailors</h2>
<p class="text-on-surface-variant font-body-md" id="nearby-tailors-subtitle">Expert artisans in your current location.</p>
</div>
<button id="view-all-tailors-btn" type="button" class="text-primary font-bold text-base flex items-center gap-2 hover:underline">View All <span class="material-symbols-outlined">arrow_forward</span></button>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8" id="tailors-grid">
<!-- Card 1 -->
<a href="{{ route('tailor.detail', 1) }}" class="tailor-card luxury-card rounded-3xl overflow-hidden block transition-all group" data-name="Savile & Row Atelier" data-location="Mayfair, London" data-tags="Bespoke Suits Tuxedos Savile Row Mayfair London">
<div class="overflow-hidden h-56 relative">
<img alt="Savile & Row Studio" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" src="{{ asset('assets/images/hero_tailor_atelier.jpg') }}"/>
<div class="absolute inset-0 bg-gradient-to-t from-[#0B2239] via-transparent to-transparent opacity-90"></div>
<div class="absolute top-4 right-4 bg-primary/90 backdrop-blur-md text-on-primary px-3 py-1 rounded-full text-xs font-extrabold flex items-center gap-1 shadow-md">
<span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
<span>4.9</span>
</div>
</div>
<div class="p-6">
<h3 class="font-title-lg text-xl text-white font-bold group-hover:text-primary transition-colors mb-1">Savile &amp; Row Atelier</h3>
<p class="text-on-surface-variant font-body-sm mb-4 flex items-center gap-1.5"><span class="material-symbols-outlined text-sm text-primary">location_on</span> Mayfair, London</p>
<div class="flex flex-wrap gap-2 pt-2 border-t border-outline-variant/50">
<span class="px-3.5 py-1 bg-secondary-container text-primary border border-primary/30 rounded-full text-xs font-bold">Bespoke Suits</span>
<span class="px-3.5 py-1 bg-secondary-container text-primary border border-primary/30 rounded-full text-xs font-bold">Tuxedos</span>
</div>
</div>
</a>

<!-- Card 2 -->
<a href="{{ route('tailor.detail', 2) }}" class="tailor-card luxury-card rounded-3xl overflow-hidden block transition-all group" data-name="The Stitch Lab Studio" data-location="Soho, London" data-tags="Modern Cut Alterations Stitch Lab Soho London">
<div class="overflow-hidden h-56 relative">
<img alt="The Stitch Lab Studio" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" src="https://images.unsplash.com/photo-1594938298603-c8148c4dae35?auto=format&fit=crop&w=800&q=80"/>
<div class="absolute inset-0 bg-gradient-to-t from-[#0B2239] via-transparent to-transparent opacity-90"></div>
<div class="absolute top-4 right-4 bg-primary/90 backdrop-blur-md text-on-primary px-3 py-1 rounded-full text-xs font-extrabold flex items-center gap-1 shadow-md">
<span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
<span>4.8</span>
</div>
</div>
<div class="p-6">
<h3 class="font-title-lg text-xl text-white font-bold group-hover:text-primary transition-colors mb-1">The Stitch Lab Studio</h3>
<p class="text-on-surface-variant font-body-sm mb-4 flex items-center gap-1.5"><span class="material-symbols-outlined text-sm text-primary">location_on</span> Soho, London</p>
<div class="flex flex-wrap gap-2 pt-2 border-t border-outline-variant/50">
<span class="px-3.5 py-1 bg-secondary-container text-primary border border-primary/30 rounded-full text-xs font-bold">Modern Cut</span>
<span class="px-3.5 py-1 bg-secondary-container text-primary border border-primary/30 rounded-full text-xs font-bold">Alterations</span>
</div>
</div>
</a>

<!-- Card 3 -->
<a href="{{ route('tailor.detail', 3) }}" class="tailor-card luxury-card rounded-3xl overflow-hidden block transition-all group" data-name="Heritage Threads Atelier" data-location="Kensington, London" data-tags="Traditional Silk Royal Sherwanis Bandhgala Suits Heritage Threads Kensington London">
<div class="overflow-hidden h-56 relative">
<img alt="Heritage Threads Studio" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=800&q=80"/>
<div class="absolute inset-0 bg-gradient-to-t from-[#0B2239] via-transparent to-transparent opacity-90"></div>
<div class="absolute top-4 right-4 bg-primary/90 backdrop-blur-md text-on-primary px-3 py-1 rounded-full text-xs font-extrabold flex items-center gap-1 shadow-md">
<span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
<span>5.0</span>
</div>
</div>
<div class="p-6">
<h3 class="font-title-lg text-xl text-white font-bold group-hover:text-primary transition-colors mb-1">Heritage Threads Atelier</h3>
<p class="text-on-surface-variant font-body-sm mb-4 flex items-center gap-1.5"><span class="material-symbols-outlined text-sm text-primary">location_on</span> Kensington, London</p>
<div class="flex flex-wrap gap-2 pt-2 border-t border-outline-variant/50">
<span class="px-3.5 py-1 bg-secondary-container text-primary border border-primary/30 rounded-full text-xs font-bold">Traditional Silk</span>
<span class="px-3.5 py-1 bg-secondary-container text-primary border border-primary/30 rounded-full text-xs font-bold">Sherwanis</span>
</div>
</div>
</a>

<!-- Card 4 -->
<a href="{{ route('tailor.detail', 4) }}" class="tailor-card luxury-card rounded-3xl overflow-hidden block transition-all group" data-name="Milano Bespoke Sartoria" data-location="Milan, Italy" data-tags="Italian Suit Cashmere Blazer Double Breasted Sartoria Milan Italy">
<div class="overflow-hidden h-56 relative">
<img alt="Milano Bespoke Sartoria" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" src="https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?auto=format&fit=crop&w=800&q=80"/>
<div class="absolute inset-0 bg-gradient-to-t from-[#0B2239] via-transparent to-transparent opacity-90"></div>
<div class="absolute top-4 right-4 bg-primary/90 backdrop-blur-md text-on-primary px-3 py-1 rounded-full text-xs font-extrabold flex items-center gap-1 shadow-md">
<span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
<span>4.9</span>
</div>
</div>
<div class="p-6">
<h3 class="font-title-lg text-xl text-white font-bold group-hover:text-primary transition-colors mb-1">Milano Sartoria</h3>
<p class="text-on-surface-variant font-body-sm mb-4 flex items-center gap-1.5"><span class="material-symbols-outlined text-sm text-primary">location_on</span> Via Montenapoleone, Milan</p>
<div class="flex flex-wrap gap-2 pt-2 border-t border-outline-variant/50">
<span class="px-3.5 py-1 bg-secondary-container text-primary border border-primary/30 rounded-full text-xs font-bold">Italian Cut</span>
<span class="px-3.5 py-1 bg-secondary-container text-primary border border-primary/30 rounded-full text-xs font-bold">Cashmere</span>
</div>
</div>
</a>

<!-- Card 5 -->
<a href="{{ route('tailor.detail', 5) }}" class="tailor-card luxury-card rounded-3xl overflow-hidden block transition-all group" data-name="Fifth Avenue Tailoring House" data-location="New York, USA" data-tags="Tuxedo Wedding Suit Formal Gowns New York USA">
<div class="overflow-hidden h-56 relative">
<img alt="Fifth Avenue Tailoring House" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" src="https://images.unsplash.com/photo-1548883354-7622d03aca27?auto=format&fit=crop&w=800&q=80"/>
<div class="absolute inset-0 bg-gradient-to-t from-[#0B2239] via-transparent to-transparent opacity-90"></div>
<div class="absolute top-4 right-4 bg-primary/90 backdrop-blur-md text-on-primary px-3 py-1 rounded-full text-xs font-extrabold flex items-center gap-1 shadow-md">
<span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
<span>4.9</span>
</div>
</div>
<div class="p-6">
<h3 class="font-title-lg text-xl text-white font-bold group-hover:text-primary transition-colors mb-1">Fifth Avenue Tailoring</h3>
<p class="text-on-surface-variant font-body-sm mb-4 flex items-center gap-1.5"><span class="material-symbols-outlined text-sm text-primary">location_on</span> Manhattan, New York</p>
<div class="flex flex-wrap gap-2 pt-2 border-t border-outline-variant/50">
<span class="px-3.5 py-1 bg-secondary-container text-primary border border-primary/30 rounded-full text-xs font-bold">Black Tie</span>
<span class="px-3.5 py-1 bg-secondary-container text-primary border border-primary/30 rounded-full text-xs font-bold">Monogramming</span>
</div>
</div>
</a>

<!-- Card 6 -->
<a href="{{ route('tailor.detail', 6) }}" class="tailor-card luxury-card rounded-3xl overflow-hidden block transition-all group" data-name="Ginza Master Cutters" data-location="Tokyo, Japan" data-tags="Minimalist Precision Japanese Cutters Ginza Tokyo Japan">
<div class="overflow-hidden h-56 relative">
<img alt="Ginza Master Cutters" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" src="https://images.unsplash.com/photo-1617137968427-85924c800a22?auto=format&fit=crop&w=800&q=80"/>
<div class="absolute inset-0 bg-gradient-to-t from-[#0B2239] via-transparent to-transparent opacity-90"></div>
<div class="absolute top-4 right-4 bg-primary/90 backdrop-blur-md text-on-primary px-3 py-1 rounded-full text-xs font-extrabold flex items-center gap-1 shadow-md">
<span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
<span>5.0</span>
</div>
</div>
<div class="p-6">
<h3 class="font-title-lg text-xl text-white font-bold group-hover:text-primary transition-colors mb-1">Ginza Master Cutters</h3>
<p class="text-on-surface-variant font-body-sm mb-4 flex items-center gap-1.5"><span class="material-symbols-outlined text-sm text-primary">location_on</span> Ginza, Tokyo</p>
<div class="flex flex-wrap gap-2 pt-2 border-t border-outline-variant/50">
<span class="px-3.5 py-1 bg-secondary-container text-primary border border-primary/30 rounded-full text-xs font-bold">Minimalist Fit</span>
<span class="px-3.5 py-1 bg-secondary-container text-primary border border-primary/30 rounded-full text-xs font-bold">Indigo Dye</span>
</div>
</div>
</a>
</div>

<div id="no-tailors-found" class="hidden text-center py-16 px-6 bg-surface rounded-3xl border border-outline-variant col-span-1 md:col-span-3 my-6">
<span class="material-symbols-outlined text-6xl text-primary mb-3">search_off</span>
<h3 class="font-title-lg text-2xl text-white font-bold mb-2">No tailors match your search</h3>
<p class="text-on-surface-variant font-body-md mb-6 max-w-md mx-auto">Try searching for terms like "Suits", "Milan", "Mayfair" or clear your search filters.</p>
<button type="button" id="reset-search-btn" class="btn-gold">Clear Search Filters</button>
</div>
</div>
</section>

<!-- Stats Section -->
<section class="py-14 bg-surface-container-highest border-y border-outline-variant">
<div class="max-w-container-max mx-auto px-gutter grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
<div class="flex flex-col">
<span class="font-display-md text-4xl font-extrabold text-primary">12,480+</span>
<span class="font-label-md text-xs text-on-surface-variant uppercase tracking-widest mt-1">Suits Delivered</span>
</div>
<div class="flex flex-col border-l border-outline-variant">
<span class="font-display-md text-4xl font-extrabold text-primary">4.9/5</span>
<span class="font-label-md text-xs text-on-surface-variant uppercase tracking-widest mt-1">Master Rating</span>
</div>
<div class="flex flex-col border-l border-outline-variant">
<span class="font-display-md text-4xl font-extrabold text-primary">150+</span>
<span class="font-label-md text-xs text-on-surface-variant uppercase tracking-widest mt-1">Heritage Mills</span>
</div>
<div class="flex flex-col border-l border-outline-variant">
<span class="font-display-md text-4xl font-extrabold text-primary">100%</span>
<span class="font-label-md text-xs text-on-surface-variant uppercase tracking-widest mt-1">Fit Guarantee</span>
</div>
</div>
</section>

<!-- The Darzi Process Section -->
<section class="py-margin-desktop bg-background">
<div class="max-w-container-max mx-auto px-gutter text-center">
<span class="text-primary font-bold text-sm uppercase tracking-widest block mb-1">Step-By-Step Journey</span>
<h2 class="font-headline-lg text-headline-lg text-white font-extrabold mb-12">The Darzi Process</h2>
<div class="grid grid-cols-1 md:grid-cols-4 gap-8">
<div class="luxury-card p-8 rounded-3xl flex flex-col items-center">
<div class="w-20 h-20 rounded-2xl bg-secondary-container border border-primary/30 flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-primary text-4xl">forum</span>
</div>
<h3 class="font-title-lg text-xl text-white font-bold mb-2">01. Consultation</h3>
<p class="text-on-surface-variant font-body-sm">Discuss your sartorial vision and style preferences with a master consultant.</p>
</div>
<div class="luxury-card p-8 rounded-3xl flex flex-col items-center">
<div class="w-20 h-20 rounded-2xl bg-secondary-container border border-primary/30 flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-primary text-4xl">straighten</span>
</div>
<h3 class="font-title-lg text-xl text-white font-bold mb-2">02. Measurement</h3>
<p class="text-on-surface-variant font-body-sm">Precise body measurements taken physically in atelier or via our 3D vision portal.</p>
</div>
<div class="luxury-card p-8 rounded-3xl flex flex-col items-center">
<div class="w-20 h-20 rounded-2xl bg-secondary-container border border-primary/30 flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-primary text-4xl">content_cut</span>
</div>
<h3 class="font-title-lg text-xl text-white font-bold mb-2">03. Crafting</h3>
<p class="text-on-surface-variant font-body-sm">Hand-stitched precision and canvas construction using time-honored techniques.</p>
</div>
<div class="luxury-card p-8 rounded-3xl flex flex-col items-center">
<div class="w-20 h-20 rounded-2xl bg-secondary-container border border-primary/30 flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-primary text-4xl">local_shipping</span>
</div>
<h3 class="font-title-lg text-xl text-white font-bold mb-2">04. Delivery</h3>
<p class="text-on-surface-variant font-body-sm">White-glove delivery with guaranteed fitting adjustments included free.</p>
</div>
</div>
</div>
</section>

<!-- DarziDesk TMS Core Modules & Functionalities Showcase Section -->
<section class="py-margin-desktop bg-surface" id="tms-modules">
<div class="max-w-container-max mx-auto px-gutter">
<div class="text-center mb-16">
<span class="text-primary font-bold text-sm uppercase tracking-widest block mb-2">Enterprise TMS Architecture</span>
<h2 class="font-headline-lg text-3xl md:text-5xl text-white font-extrabold mb-4">All-In-One Tailor Management System</h2>
<p class="text-on-surface-variant font-body-lg max-w-3xl mx-auto leading-relaxed">Purpose-built for custom tailors, luxury sartorias, and multi-branch garment boutiques to streamline end-to-end atelier operations.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
<!-- Module 1 -->
<div class="luxury-card p-8 rounded-3xl flex flex-col group">
<div class="w-16 h-16 rounded-2xl bg-secondary-container border border-primary/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-primary text-3xl">square_foot</span>
</div>
<h3 class="font-title-lg text-xl text-white font-bold mb-3 group-hover:text-primary transition-colors">Measurement Vault</h3>
<p class="text-on-surface-variant font-body-sm leading-relaxed mb-6">Store unlimited anatomical measurement profiles per client. Quick-add garment specifications (Lapels, Pleats, Vents) with instant cm to inch unit conversions.</p>
<div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-outline-variant/40">
<span class="px-3 py-1 bg-background text-primary border border-primary/30 rounded-full text-xs font-bold">Unit Converter</span>
<span class="px-3 py-1 bg-background text-primary border border-primary/30 rounded-full text-xs font-bold">Garment Specs</span>
</div>
</div>

<!-- Module 2 -->
<div class="luxury-card p-8 rounded-3xl flex flex-col group">
<div class="w-16 h-16 rounded-2xl bg-secondary-container border border-primary/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-primary text-3xl">developer_board</span>
</div>
<h3 class="font-title-lg text-xl text-white font-bold mb-3 group-hover:text-primary transition-colors">Production Kanban</h3>
<p class="text-on-surface-variant font-body-sm leading-relaxed mb-6">Assign tailors, master cutters, and hand-finishers to order stages (Pending, Cutting, Basting, Ready). Track real-time bottleneck alerts and piece-rate worker pay.</p>
<div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-outline-variant/40">
<span class="px-3 py-1 bg-background text-primary border border-primary/30 rounded-full text-xs font-bold">Worker Assign</span>
<span class="px-3 py-1 bg-background text-primary border border-primary/30 rounded-full text-xs font-bold">Stage Tracking</span>
</div>
</div>

<!-- Module 3 -->
<div class="luxury-card p-8 rounded-3xl flex flex-col group">
<div class="w-16 h-16 rounded-2xl bg-secondary-container border border-primary/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-primary text-3xl">point_of_sale</span>
</div>
<h3 class="font-title-lg text-xl text-white font-bold mb-3 group-hover:text-primary transition-colors">POS & Smart Invoicing</h3>
<p class="text-on-surface-variant font-body-sm leading-relaxed mb-6">Process fast POS transactions with advance deposit split payments. Generate branded digital tax invoices and dispatch instant digital customer receipts.</p>
<div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-outline-variant/40">
<span class="px-3 py-1 bg-background text-primary border border-primary/30 rounded-full text-xs font-bold">Advance Deposit</span>
<span class="px-3 py-1 bg-background text-primary border border-primary/30 rounded-full text-xs font-bold">Tax Invoices</span>
</div>
</div>

<!-- Module 4 -->
<div class="luxury-card p-8 rounded-3xl flex flex-col group">
<div class="w-16 h-16 rounded-2xl bg-secondary-container border border-primary/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-primary text-3xl">inventory_2</span>
</div>
<h3 class="font-title-lg text-xl text-white font-bold mb-3 group-hover:text-primary transition-colors">Fabric & Cloth Stock</h3>
<p class="text-on-surface-variant font-body-sm leading-relaxed mb-6">Track fabric roll inventory in meters/yards with automated low-stock threshold warnings. Manage fabric categories, suiting wools, lining silks, and supplier logs.</p>
<div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-outline-variant/40">
<span class="px-3 py-1 bg-background text-primary border border-primary/30 rounded-full text-xs font-bold">Stock Alerts</span>
<span class="px-3 py-1 bg-background text-primary border border-primary/30 rounded-full text-xs font-bold">Meterage Logs</span>
</div>
</div>

<!-- Module 5 -->
<div class="luxury-card p-8 rounded-3xl flex flex-col group">
<div class="w-16 h-16 rounded-2xl bg-secondary-container border border-primary/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-primary text-3xl">analytics</span>
</div>
<h3 class="font-title-lg text-xl text-white font-bold mb-3 group-hover:text-primary transition-colors">Financial Analytics & P&L</h3>
<p class="text-on-surface-variant font-body-sm leading-relaxed mb-6">Gain 360° visibility into store profitability. Generate automated yearly profit & loss reports, track overhead expenses, and analyze revenue by garment type.</p>
<div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-outline-variant/40">
<span class="px-3 py-1 bg-background text-primary border border-primary/30 rounded-full text-xs font-bold">Yearly P&L</span>
<span class="px-3 py-1 bg-background text-primary border border-primary/30 rounded-full text-xs font-bold">Expense Log</span>
</div>
</div>

<!-- Module 6 -->
<div class="luxury-card p-8 rounded-3xl flex flex-col group">
<div class="w-16 h-16 rounded-2xl bg-secondary-container border border-primary/30 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-primary text-3xl">domain</span>
</div>
<h3 class="font-title-lg text-xl text-white font-bold mb-3 group-hover:text-primary transition-colors">Multi-Store Governance</h3>
<p class="text-on-surface-variant font-body-sm leading-relaxed mb-6">Granular security access control for Super Admins, Store Owners, Managers, and Tailoring Staff. Manage multiple branch locations with isolated data roles.</p>
<div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-outline-variant/40">
<span class="px-3 py-1 bg-background text-primary border border-primary/30 rounded-full text-xs font-bold">Role Access</span>
<span class="px-3 py-1 bg-background text-primary border border-primary/30 rounded-full text-xs font-bold">Multi-Branch</span>
</div>
</div>
</div>

<!-- Extra Advanced Features Section (New Highlight Grid) -->
<div class="mt-12 text-center mb-10">
<span class="text-primary font-bold text-sm uppercase tracking-widest block mb-2">Automated Studio Workflows</span>
<h3 class="font-headline-lg text-2xl md:text-4xl text-white font-bold">Advanced Tailoring Capabilities</h3>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
<!-- Feature 7 -->
<div class="luxury-card p-8 rounded-3xl flex flex-col group">
<div class="w-14 h-14 rounded-2xl bg-secondary-container flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-primary text-3xl">chat_apps</span>
</div>
<h4 class="font-title-lg text-lg text-white font-bold mb-2 group-hover:text-primary transition-colors">SMS &amp; WhatsApp Alerts</h4>
<p class="text-on-surface-variant font-body-sm">Send automated notifications to clients when garments reach trial fittings or ready-for-pickup stages.</p>
</div>

<!-- Feature 8 -->
<div class="luxury-card p-8 rounded-3xl flex flex-col group">
<div class="w-14 h-14 rounded-2xl bg-secondary-container flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-primary text-3xl">qr_code_scanner</span>
</div>
<h4 class="font-title-lg text-lg text-white font-bold mb-2 group-hover:text-primary transition-colors">QR Code Hanger Tagging</h4>
<p class="text-on-surface-variant font-body-sm">Print barcode/QR tags for garment hangers. Cutters scan tags to advance order status in seconds.</p>
</div>

<!-- Feature 9 -->
<div class="luxury-card p-8 rounded-3xl flex flex-col group">
<div class="w-14 h-14 rounded-2xl bg-secondary-container flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-primary text-3xl">payments</span>
</div>
<h4 class="font-title-lg text-lg text-white font-bold mb-2 group-hover:text-primary transition-colors">Worker Payroll &amp; Piece-Rate</h4>
<p class="text-on-surface-variant font-body-sm">Calculate artisan labor payouts based on finished jackets, trousers, or embroidery work automatically.</p>
</div>

<!-- Feature 10 -->
<div class="luxury-card p-8 rounded-3xl flex flex-col group">
<div class="w-14 h-14 rounded-2xl bg-secondary-container flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-primary text-3xl">style</span>
</div>
<h4 class="font-title-lg text-lg text-white font-bold mb-2 group-hover:text-primary transition-colors">Pre-Built Style Catalogs</h4>
<p class="text-on-surface-variant font-body-sm">Pre-loaded style configurations for 2-piece suits, 3-piece tuxedos, Sherwanis, Nehru jackets, and shirts.</p>
</div>

<!-- Feature 11 -->
<div class="luxury-card p-8 rounded-3xl flex flex-col group">
<div class="w-14 h-14 rounded-2xl bg-secondary-container flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-primary text-3xl">event_available</span>
</div>
<h4 class="font-title-lg text-lg text-white font-bold mb-2 group-hover:text-primary transition-colors">Client Fitting Scheduler</h4>
<p class="text-on-surface-variant font-body-sm">Allow VIP clients to schedule trial fittings or master tailor consultations online with automated reminders.</p>
</div>

<!-- Feature 12 -->
<div class="luxury-card p-8 rounded-3xl flex flex-col group">
<div class="w-14 h-14 rounded-2xl bg-secondary-container flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-primary text-3xl">currency_exchange</span>
</div>
<h4 class="font-title-lg text-lg text-white font-bold mb-2 group-hover:text-primary transition-colors">Multi-Currency &amp; Tax Engine</h4>
<p class="text-on-surface-variant font-body-sm">Support for global currencies (GBP, USD, EUR, INR) and customizable VAT, GST, and tax rules.</p>
</div>
</div>

<!-- TMS Advantage Banner -->
<div class="luxury-card rounded-3xl p-8 md:p-12 border border-primary/40 relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-8">
<div class="max-w-2xl text-left">
<span class="px-4 py-1.5 rounded-full bg-primary/20 text-primary border border-primary/40 font-label-md uppercase tracking-wider font-bold mb-4 inline-block">The Darzi Advantage</span>
<h3 class="font-headline-lg text-2xl md:text-3xl text-white font-bold mb-3">Transform Your Atelier Operations Today</h3>
<p class="text-on-surface-variant font-body-md">Eliminate paper measurement cards, order miscommunications, and lost fabric inventory. DarziDesk keeps your entire tailoring team synchronized.</p>
</div>
<div class="flex gap-4 shrink-0">
<a href="{{ route('register') }}" class="btn-gold btn-lg">Schedule Demo</a>
</div>
</div>
</div>
</section>

<!-- Frequently Asked Questions (Interactive Accordion) -->
<section class="py-margin-desktop bg-background" id="faq-section">
<div class="max-w-container-max mx-auto px-gutter max-w-3xl">
<div class="text-center mb-12">
<span class="text-primary font-bold text-sm uppercase tracking-widest block mb-1">Need Clarification?</span>
<h2 class="font-headline-lg text-headline-lg text-white font-extrabold mb-3">Frequently Asked Questions</h2>
<p class="text-on-surface-variant font-body-md">Click any question below to expand the answer.</p>
</div>
<div class="space-y-4" id="faq-accordion">

<div class="bg-surface rounded-2xl border border-outline-variant overflow-hidden transition-all faq-item">
<button class="w-full px-6 py-5 flex justify-between items-center text-left font-title-lg text-white hover:text-primary transition-colors faq-trigger" type="button">
<span class="font-bold text-base md:text-lg">How do digital body measurements work?</span>
<span class="material-symbols-outlined text-primary transition-transform duration-300 faq-icon">expand_more</span>
</button>
<div class="px-6 pb-6 text-on-surface-variant font-body-md leading-relaxed hidden faq-answer border-t border-outline-variant/40 pt-4">
Our 3D computer-vision measurement engine analyzes two full-length photos taken from your smartphone camera. With over 99.4% precision accuracy, it computes 45+ body metrics to build your personalized digital fitting profile.
</div>
</div>

<div class="bg-surface rounded-2xl border border-outline-variant overflow-hidden transition-all faq-item">
<button class="w-full px-6 py-5 flex justify-between items-center text-left font-title-lg text-white hover:text-primary transition-colors faq-trigger" type="button">
<span class="font-bold text-base md:text-lg">What is the typical turnaround time for a bespoke suit?</span>
<span class="material-symbols-outlined text-primary transition-transform duration-300 faq-icon">expand_more</span>
</button>
<div class="px-6 pb-6 text-on-surface-variant font-body-md leading-relaxed hidden faq-answer border-t border-outline-variant/40 pt-4">
Standard bespoke production takes between 2 to 3 weeks, including pattern drafting, basting fitting, and hand finishing. Priority express tailoring is available for urgent events.
</div>
</div>

<div class="bg-surface rounded-2xl border border-outline-variant overflow-hidden transition-all faq-item">
<button class="w-full px-6 py-5 flex justify-between items-center text-left font-title-lg text-white hover:text-primary transition-colors faq-trigger" type="button">
<span class="font-bold text-base md:text-lg">Can I provide my own custom fabric (CMT Service)?</span>
<span class="material-symbols-outlined text-primary transition-transform duration-300 faq-icon">expand_more</span>
</button>
<div class="px-6 pb-6 text-on-surface-variant font-body-md leading-relaxed hidden faq-answer border-t border-outline-variant/40 pt-4">
Yes! Our partner ateliers offer Cut, Make & Trim (CMT) services for client-provided fabric. We inspect the weave density, thread count, and drape prior to cutting.
</div>
</div>

<div class="bg-surface rounded-2xl border border-outline-variant overflow-hidden transition-all faq-item">
<button class="w-full px-6 py-5 flex justify-between items-center text-left font-title-lg text-white hover:text-primary transition-colors faq-trigger" type="button">
<span class="font-bold text-base md:text-lg">What happens if my garment needs additional adjustments?</span>
<span class="material-symbols-outlined text-primary transition-transform duration-300 faq-icon">expand_more</span>
</button>
<div class="px-6 pb-6 text-on-surface-variant font-body-md leading-relaxed hidden faq-answer border-t border-outline-variant/40 pt-4">
Every order includes our 100% Perfect Fit Guarantee. If any alteration is needed within 30 days of receipt, our partner ateliers will adjust your garment free of charge.
</div>
</div>

</div>
</div>
</section>

<!-- Final CTA Banner -->
<section class="relative py-20 bg-surface-container border-y border-outline-variant overflow-hidden">
<div class="relative z-10 max-w-container-max mx-auto px-gutter text-center">
<h2 class="font-display-md text-3xl md:text-4xl text-white font-extrabold mb-4">Ready to define your signature style?</h2>
<p class="text-on-surface-variant font-body-lg max-w-2xl mx-auto mb-8">Join thousands of discerning professionals who trust DarziDesk for bespoke tailoring management.</p>
<div class="flex flex-col sm:flex-row items-center justify-center gap-4">
<a href="{{ route('register') }}" class="btn-gold btn-lg w-full sm:w-auto">Start Bespoke Journey</a>
<a href="#nearby-tailors" class="btn-gold-outline btn-lg w-full sm:w-auto">Explore Artisans</a>
</div>
</div>
</section>
</main>

<!-- Footer -->
<footer class="w-full py-16 bg-background border-t border-outline-variant">
<div class="grid grid-cols-1 md:grid-cols-4 gap-8 px-gutter max-w-container-max mx-auto">
<div class="flex flex-col gap-4">
<a href="{{ route('home') }}">
    <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" style="height: 42px; width: auto; max-width: 240px; object-fit: contain;">
</a>
<p class="text-on-surface-variant font-body-sm max-w-xs leading-relaxed">Connecting the world's most talented tailoring artisans with the modern connoisseur. Precision, redefined.</p>
</div>
<div class="flex flex-col gap-3">
<span class="font-title-md text-primary font-bold text-lg">Services</span>
<a class="text-on-surface-variant font-body-sm hover:text-primary transition-colors" href="#">Bespoke Suits</a>
<a class="text-on-surface-variant font-body-sm hover:text-primary transition-colors" href="#">Alterations</a>
<a class="text-on-surface-variant font-body-sm hover:text-primary transition-colors" href="#">Fabric Library</a>
</div>
<div class="flex flex-col gap-3">
<span class="font-title-md text-primary font-bold text-lg">Company & Legal</span>
<a class="text-on-surface-variant font-body-sm hover:text-primary transition-colors" href="{{ route('about.us') }}">About Us</a>
<a class="text-on-surface-variant font-body-sm hover:text-primary transition-colors" href="{{ route('privacy.policy') }}">Privacy Policy</a>
<a class="text-on-surface-variant font-body-sm hover:text-primary transition-colors" href="{{ route('terms.conditions') }}">Terms & Services</a>
</div>
<div class="flex flex-col gap-3">
<span class="font-title-md text-primary font-bold text-lg">Support</span>
<a class="text-on-surface-variant font-body-sm hover:text-primary transition-colors" href="{{ route('delete.account') }}">Play Console Data Policy</a>
<a class="text-on-surface-variant font-body-sm hover:text-primary transition-colors" href="{{ route('blog.index') }}">Blog & News</a>

<div class="mt-4 p-4 rounded-2xl bg-surface border border-outline-variant">
<p class="font-label-md text-primary font-bold mb-2">Subscribe to Artisan Journal</p>
<div class="flex gap-2">
<input class="w-full bg-surface-container-high border-outline-variant text-white placeholder:text-on-surface-variant rounded-xl px-3 py-2 text-sm focus:ring-1 focus:ring-primary" placeholder="Email" type="email"/>
<button class="bg-primary text-on-primary font-bold p-2 rounded-xl hover:bg-primary-container transition-colors flex items-center justify-center">
<span class="material-symbols-outlined text-sm">send</span>
</button>
</div>
</div>
</div>
</div>
<div class="max-w-container-max mx-auto px-gutter mt-12 pt-6 border-t border-outline-variant flex flex-col md:flex-row justify-between items-center gap-4">
<p class="font-body-sm text-on-surface-variant">© {{ date('Y') }} DarziDesk. Precision Tailoring SaaS.</p>
<div class="flex items-center gap-6">
<span class="font-body-sm text-on-surface-variant">English (UK)</span>
<span class="font-body-sm text-on-surface-variant">GBP (£)</span>
</div>
</div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Accordion Toggle Logic
    const faqTriggers = document.querySelectorAll('.faq-trigger');
    faqTriggers.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const item = this.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const icon = item.querySelector('.faq-icon');
            const isHidden = answer.classList.contains('hidden');

            // Close other active answers
            document.querySelectorAll('.faq-answer').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.faq-icon').forEach(el => el.style.transform = 'rotate(0deg)');

            if (isHidden) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });

    // Search Bar Filtering Logic
    const searchForm = document.getElementById('hero-search-form');
    const keywordInput = document.getElementById('search-keyword-input');
    const locationInput = document.getElementById('search-location-input');
    const tailorCards = document.querySelectorAll('.tailor-card');
    const noResultsDiv = document.getElementById('no-tailors-found');
    const subtitle = document.getElementById('nearby-tailors-subtitle');
    const resetBtn = document.getElementById('reset-search-btn');
    const viewAllBtn = document.getElementById('view-all-tailors-btn');

    function performSearch(shouldScroll = false) {
        const keyword = (keywordInput ? keywordInput.value : '').toLowerCase().trim();
        const location = (locationInput ? locationInput.value : '').toLowerCase().trim();
        
        let visibleCount = 0;

        tailorCards.forEach(card => {
            const name = (card.getAttribute('data-name') || '').toLowerCase();
            const cardLoc = (card.getAttribute('data-location') || '').toLowerCase();
            const tags = (card.getAttribute('data-tags') || '').toLowerCase();

            const matchKeyword = !keyword || name.includes(keyword) || tags.includes(keyword) || cardLoc.includes(keyword);
            const matchLocation = !location || cardLoc.includes(location) || name.includes(location) || tags.includes(location);

            if (matchKeyword && matchLocation) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noResultsDiv) {
            if (visibleCount === 0) {
                noResultsDiv.classList.remove('hidden');
            } else {
                noResultsDiv.classList.add('hidden');
            }
        }

        if (subtitle) {
            if (keyword || location) {
                subtitle.textContent = `Found ${visibleCount} tailor atelier${visibleCount === 1 ? '' : 's'} matching your search criteria.`;
            } else {
                subtitle.textContent = 'Expert artisans in your current location.';
            }
        }

        if (shouldScroll) {
            const target = document.getElementById('nearby-tailors');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }

    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            performSearch(true);
        });
    }

    if (keywordInput) {
        keywordInput.addEventListener('input', function() {
            performSearch(false);
        });
    }

    if (locationInput) {
        locationInput.addEventListener('input', function() {
            performSearch(false);
        });
    }

    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            if (keywordInput) keywordInput.value = '';
            if (locationInput) locationInput.value = '';
            performSearch(false);
        });
    }

    if (viewAllBtn) {
        viewAllBtn.addEventListener('click', function() {
            if (keywordInput) keywordInput.value = '';
            if (locationInput) locationInput.value = '';
            performSearch(true);
        });
    }
});
</script>
</body>
</html>
