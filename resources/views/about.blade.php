    <style>
        .logo-spin-wrap { perspective: 600px; }
        .logo-spin { transition: transform 0.7s ease; }
        .logo-spin-wrap:hover .logo-spin { transform: rotateY(360deg); }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('About TERESA') }}
        </h2>
    </x-slot>

        <!-- Hero Banner -->
    <div class="relative overflow-hidden bg-gradient-to-br from-primary-900 via-primary-700 to-primary-500">
        <div class="absolute -top-10 -left-10 w-64 h-64 bg-accent-400/30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-16 -right-10 w-72 h-72 bg-primary-300/20 rounded-full blur-3xl"></div>

        <div class="relative max-w-3xl mx-auto px-6 py-16">
            <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl shadow-2xl shadow-primary-900/30 px-8 py-12 text-center">
                                <div class="w-16 h-16 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center mx-auto mb-5 logo-spin-wrap">
                    <img src="{{ asset('GROUP3-LOGO.png') }}" alt="TERESA logo" class="w-11 h-11 object-contain logo-spin">
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold text-white mb-4">Technology-Enabled Resource for<br>Economic and Sales Advancement</h1>
                <p class="text-primary-100 text-lg max-w-2xl mx-auto">
                    Connecting farmers and buyers in San Jose, Camarines Sur — directly, fairly, and transparently.
                </p>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- About TERESA -->
            <div class="bg-white shadow-sm rounded-lg p-8">
                <h3 class="text-xl font-bold text-primary-700 mb-4">About TERESA</h3>
                <p class="text-gray-600 leading-relaxed">
                    TERESA, or Technology-Enabled Resource for Economic and Sales Advancement, is a web-based
                    e-commerce and agricultural information platform designed to connect farmers and consumers in
                    San Jose, Camarines Sur. It provides a digital marketplace where farmers can showcase and sell
                    their agricultural products while allowing consumers to conveniently discover and purchase local produce.
                </p>
            </div>

            <!-- Our Purpose -->
            <div class="bg-white shadow-sm rounded-lg p-8">
                <h3 class="text-xl font-bold text-primary-700 mb-4">Our Purpose</h3>
                <p class="text-gray-600 leading-relaxed">
                    In San Jose, Camarines Sur, many farmers still depend on traditional selling and intermediaries,
                    limiting their access to fair prices, buyers, and reliable market information. TERESA was created
                    to address this gap by providing a municipality-focused digital marketplace that connects farmers
                    and buyers directly, while giving farmers greater control over their prices and selling decisions.
                    Developed in partnership with the Municipal Agriculture Office, TERESA also provides market
                    insights and agricultural advisories to help farmers make more informed decisions. Through direct
                    communication, flexible offers, and ratings and reviews, TERESA aims to create a more transparent,
                    accessible, and empowering agricultural marketplace for the local community.
                </p>
            </div>

            <!-- Mission & Vision -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm rounded-lg p-8">
                    <div class="w-11 h-11 rounded-lg bg-primary-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="8" />
                            <circle cx="12" cy="12" r="4" />
                            <circle cx="12" cy="12" r="0.5" fill="currentColor" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary-700 mb-3">Our Mission</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        TERESA aims to empower local farmers by giving them direct access to buyers, greater control
                        over their selling decisions, and reliable market information. It seeks to create a more
                        transparent, accessible, and informed agricultural marketplace that benefits both farmers
                        and consumers in San Jose, Camarines Sur.
                    </p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-8">
                    <div class="w-11 h-11 rounded-lg bg-primary-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary-700 mb-3">Our Vision</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        TERESA aims to grow into a trusted digital agricultural platform that strengthens connections
                        between local farmers, buyers, and the Municipal Agriculture Office. In the future, it hopes
                        to expand its market analytics, advisories, and digital services to support more informed
                        decisions, better market opportunities, and a more sustainable local agricultural community.
                    </p>
                </div>
            </div>

            <!-- What TERESA Offers -->
            <div class="bg-white shadow-sm rounded-lg p-8">
                <h3 class="text-lg font-bold text-primary-700 mb-1">What TERESA Offers</h3>
                <p class="text-sm text-gray-500 mb-6">Everything you need in one place.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">

                    <div class="border border-gray-200 rounded-lg p-5 hover:border-primary-600 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-1.5 text-sm">Agricultural Marketplace</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">A digital marketplace where farmers can showcase and sell their products directly to consumers.</p>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-5 hover:border-primary-600 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-1.5 text-sm">Market Analytics</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Market trends and insights to help farmers and buyers understand demand and pricing.</p>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-5 hover:border-primary-600 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-3 3-5 6-5 9a5 5 0 0010 0c0-3-2-6-5-9z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-1.5 text-sm">Agriculturist Advisories</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Tips, recommendations, and advisories from the Municipal Agriculture Office.</p>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-5 hover:border-primary-600 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-1.5 text-sm">Buyer–Seller Communication</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Message directly, ask questions, and coordinate transactions with ease.</p>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-5 hover:border-primary-600 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.562.562 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-1.5 text-sm">Ratings and Reviews</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Builds trust by letting buyers rate and review completed transactions.</p>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-5 hover:border-primary-600 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-1.5 text-sm">Farmer-Set Pricing / Bidding</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Farmers set their own prices and can evaluate or respond to buyer offers.</p>
                    </div>

                </div>
            </div>

            <!-- Who We Serve -->
            <div class="bg-white shadow-sm rounded-lg p-8">
                <h3 class="text-lg font-bold text-primary-700 mb-6">Who We Serve</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="text-center p-6 rounded-lg bg-gray-50">
                        <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-1 text-sm">Farmers</h4>
                        <p class="text-xs text-gray-500">Sell agricultural products directly</p>
                    </div>
                    <div class="text-center p-6 rounded-lg bg-gray-50">
                        <div class="w-12 h-12 rounded-full bg-accent-100 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-1 text-sm">Consumers / Buyers</h4>
                        <p class="text-xs text-gray-500">Discover and purchase local products</p>
                    </div>
                    <div class="text-center p-6 rounded-lg bg-gray-50">
                        <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-1 text-sm">Municipal Agriculture Office</h4>
                        <p class="text-xs text-gray-500">Advisories and market monitoring</p>
                    </div>
                </div>
            </div>

                        <!-- Our Goal -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary-900 via-primary-700 to-primary-500">
                <div class="absolute -top-8 right-10 w-48 h-48 bg-accent-400/25 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-10 -left-8 w-56 h-56 bg-primary-300/20 rounded-full blur-3xl"></div>

                <div class="relative bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl m-2 p-10 text-center shadow-inner">
                    <h3 class="text-lg font-bold text-white mb-3">Our Goal</h3>
                    <p class="text-primary-50 text-lg max-w-2xl mx-auto">
                        To empower farmers, connect communities, and create better opportunities through accessible digital agricultural services.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>