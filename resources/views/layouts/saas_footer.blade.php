<!-- Modern SaaS Footer -->
<footer class="w-full bg-background border-t border-outline-variant text-on-surface-variant text-sm py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Footer Links Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
            <!-- Brand Column -->
            <div class="lg:col-span-2 flex flex-col gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" class="h-10 w-auto max-w-[200px] object-contain">
                </a>
                <p class="text-xs text-on-surface-variant max-w-sm leading-relaxed">
                    India's leading cloud-based Tailoring Shop & Boutique Management Software (TMS). Manage customer measurements, production stages, karigar assignments, and billing from one simple app.
                </p>
                <div class="flex items-center gap-3 pt-2">
                    <a href="https://play.google.com/store/apps/details?id=com.darzidesk.app&hl=en" target="_blank" class="inline-block hover:opacity-85 transition-opacity">
                        <img src="{{ asset('assets/images/google_play_badge.svg') }}" alt="Get it on Google Play" class="h-10 w-auto">
                    </a>
                    <a href="https://apps.apple.com/us/app/darzidesk/id6796700050" target="_blank" class="inline-block hover:opacity-85 transition-opacity">
                        <img src="{{ asset('assets/images/app_store_badge.svg') }}" alt="Download on the App Store" class="h-10 w-auto">
                    </a>
                </div>
                <div class="pt-2 text-xs text-on-surface-variant/80 flex flex-col gap-1.5">
                    <div>
                        <span class="font-semibold text-white">Email:</span>
                        <a href="mailto:support@darzidesk.shop" class="text-primary hover:underline ml-1">support@darzidesk.shop</a>
                    </div>
                    <div>
                        <span class="font-semibold text-white">WhatsApp & Phone:</span>
                        <a href="https://wa.me/919536824061" class="text-primary hover:underline font-mono ml-1">+91 95368 24061</a> (Mon-Sat, 9AM-8PM IST)
                    </div>
                    <!-- Social Links -->
                    <div class="flex items-center gap-3 pt-1.5">
                        <a href="https://www.facebook.com/profile.php?id=61589959355817" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-surface-card border border-white/[0.08] flex items-center justify-center text-on-surface-variant hover:text-primary hover:border-primary/40 transition-all" aria-label="Facebook">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/darzidesk.shop?stkn=MTRjbzUwOHhieWkyMA==" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-surface-card border border-white/[0.08] flex items-center justify-center text-on-surface-variant hover:text-primary hover:border-primary/40 transition-all" aria-label="Instagram">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product Links -->
            <div class="flex flex-col gap-3">
                <span class="text-white font-bold text-sm tracking-wider uppercase">Product</span>
                <a href="{{ route('home') }}#features" class="hover:text-primary transition-colors text-xs">Features Overview</a>
                <a href="{{ route('pricing.public') }}" class="hover:text-primary transition-colors text-xs">Pricing & Plans</a>
                <a href="{{ route('home') }}#how-it-works" class="hover:text-primary transition-colors text-xs">How It Works</a>
                <a href="{{ route('home') }}#comparison" class="hover:text-primary transition-colors text-xs">Notebook vs DarziDesk</a>
                <a href="{{ route('home') }}#mobile-apps" class="hover:text-primary transition-colors text-xs">Mobile Apps (Android/iOS)</a>
                <a href="{{ route('home') }}#faq-section" class="hover:text-primary transition-colors text-xs">SaaS FAQ</a>
            </div>

            <!-- Solutions Links -->
            <div class="flex flex-col gap-3">
                <span class="text-white font-bold text-sm tracking-wider uppercase">Solutions</span>
                <a href="{{ url('tailoring-shop-management-software') }}" class="hover:text-primary transition-colors text-xs">Tailor Shop Management</a>
                <a href="{{ url('boutique-management-software') }}" class="hover:text-primary transition-colors text-xs">Boutique Management</a>
                <a href="{{ url('ladies-tailor-management-software') }}" class="hover:text-primary transition-colors text-xs">Ladies Tailor Software</a>
                <a href="{{ url('mens-tailor-management-software') }}" class="hover:text-primary transition-colors text-xs">Men's Tailor Software</a>
                <a href="{{ url('tailor-measurement-management') }}" class="hover:text-primary transition-colors text-xs">Digital Measurement Book</a>
                <a href="{{ url('tailoring-billing-software') }}" class="hover:text-primary transition-colors text-xs">Tailoring Billing & POS</a>
                <a href="{{ url('tailoring-order-management') }}" class="hover:text-primary transition-colors text-xs">Order Tracking & Kanban</a>
                <a href="{{ url('tailoring-software-india') }}" class="hover:text-primary transition-colors text-xs">Tailoring Software India</a>
            </div>

            <!-- Company & Legal -->
            <div class="flex flex-col gap-3">
                <span class="text-white font-bold text-sm tracking-wider uppercase">Company & Legal</span>
                <a href="{{ route('about.us') }}" class="hover:text-primary transition-colors text-xs">About DarziDesk</a>
                <a href="{{ route('blog.index') }}" class="hover:text-primary transition-colors text-xs">Tailoring Business Blog</a>
                <a href="{{ route('privacy.policy') }}" class="hover:text-primary transition-colors text-xs">Privacy Policy</a>
                <a href="{{ route('terms.conditions') }}" class="hover:text-primary transition-colors text-xs">Terms & Conditions</a>
                <a href="{{ route('delete.account') }}" class="hover:text-primary transition-colors text-xs">Data Safety & Account Deletion</a>
                <a href="{{ route('login') }}" class="hover:text-primary transition-colors text-xs font-bold text-primary">Shop Owner Login</a>
            </div>
        </div>

        <!-- Bottom Copyright -->
        <div class="mt-8 pt-6 border-t border-outline-variant/60 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-on-surface-variant">
            <p>© {{ date('Y') }} DarziDesk. All Rights Reserved. Tailoring Management Software (TMS).</p>
            <div class="flex items-center gap-6">
                <span>Engineered for Tailors, Boutiques & Master Cutters</span>
            </div>
        </div>
    </div>
</footer>
