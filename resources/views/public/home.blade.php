@extends('layouts.public')

@section('title', 'Nuelcargo Logistics - Global Shipping & Logistics Solutions')

@section('content')

<!-- Hero Section -->
<section id="home" class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-20">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 mb-10 md:mb-0">
            <h1 class="text-5xl font-bold mb-4">Your Global Logistics Partner</h1>
            <p class="text-xl text-gray-100 mb-8">Reliable, secure, and affordable shipping solutions to over 150 countries. Track your shipments in real-time.</p>
            <div class="flex space-x-4">
                <a href="#track" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-bold transition">Track Now</a>
                <a href="#services" class="border-2 border-white hover:bg-white hover:text-blue-900 text-white px-8 py-3 rounded-lg font-bold transition">Learn More</a>
            </div>
        </div>
        <div class="md:w-1/2">
            <div class="relative">
                <img src="{{ asset('shipping.webp') }}" alt="Nuelcargo Logistics Shipping Container" class="w-full h-auto rounded-lg drop-shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- Quick Track Section -->
<section id="track" class="bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-2xl">
        <h2 class="text-3xl font-bold text-center mb-8 nuelcargo-blue">Track Your Shipment</h2>
        <form action="/track" method="GET" class="bg-white p-8 rounded-lg shadow-lg">
            <div class="flex flex-col md:flex-row gap-3">
                <input type="text" name="code" placeholder="Enter tracking code (e.g., TRK-ABC123)" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" required>
                <button type="submit" class="bg-nuelcargo-blue hover:bg-blue-800 text-white px-8 py-3 rounded-lg font-bold transition">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-20">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-4 nuelcargo-blue">Our Services</h2>
        <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Comprehensive logistics solutions tailored to your business needs</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Service 1 -->
            <div class="bg-white rounded-lg shadow-lg p-8 hover-lift">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-box text-2xl nuelcargo-blue"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 nuelcargo-blue">Express Parcel Delivery</h3>
                <p class="text-gray-600">Fast door-to-door shipping for packages and e-commerce orders with real-time tracking</p>
            </div>
            
            <!-- Service 2 -->
            <div class="bg-white rounded-lg shadow-lg p-8 hover-lift">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-ship text-2xl nuelcargo-blue"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 nuelcargo-blue">Freight Forwarding</h3>
                <p class="text-gray-600">Air, ocean, and multimodal transport for commercial cargo with consolidation services</p>
            </div>
            
            <!-- Service 3 -->
            <div class="bg-white rounded-lg shadow-lg p-8 hover-lift">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-file-check text-2xl nuelcargo-blue"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 nuelcargo-blue">Customs Clearance</h3>
                <p class="text-gray-600">Expert handling of import/export documentation and regulatory compliance</p>
            </div>
            
            <!-- Service 4 -->
            <div class="bg-white rounded-lg shadow-lg p-8 hover-lift">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-warehouse text-2xl nuelcargo-blue"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 nuelcargo-blue">Warehousing</h3>
                <p class="text-gray-600">Secure storage with inventory management and last-mile delivery options</p>
            </div>
            
            <!-- Service 5 -->
            <div class="bg-white rounded-lg shadow-lg p-8 hover-lift">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-thermometer-half text-2xl nuelcargo-blue"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 nuelcargo-blue">Specialized Cargo</h3>
                <p class="text-gray-600">Temperature-controlled, hazardous materials, and heavy equipment shipping</p>
            </div>
            
            <!-- Service 6 -->
            <div class="bg-white rounded-lg shadow-lg p-8 hover-lift">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-chart-line text-2xl nuelcargo-blue"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 nuelcargo-blue">Supply Chain Consulting</h3>
                <p class="text-gray-600">End-to-end optimization and cost analysis for scaling internationally</p>
            </div>
        </div>
    </div>
</section>

<!-- Carriers Partnership Section -->
<section class="bg-gray-900 text-white py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Our Global Partnerships</h2>
        <p class="text-center text-gray-300 mb-12">We partner with industry leaders to deliver your shipments worldwide</p>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 items-center">
            <div class="bg-white rounded-lg p-4 flex items-center justify-center h-24">
                <img src="{{ asset('partners/dhl logo.png') }}" alt="DHL" class="w-full h-12 md:h-14 object-contain" loading="lazy">
            </div>
            <div class="bg-white rounded-lg p-4 flex items-center justify-center h-24">
                <img src="{{ asset('partners/fedex logo.webp') }}" alt="FedEx" class="w-full h-12 md:h-14 object-contain" loading="lazy">
            </div>
            <div class="bg-white rounded-lg p-4 flex items-center justify-center h-24">
                <img src="{{ asset('partners/ups-logo.jpg') }}" alt="UPS" class="w-full h-12 md:h-14 object-contain" loading="lazy">
            </div>
            <div class="bg-white rounded-lg p-4 flex items-center justify-center h-24">
                <img src="{{ asset('partners/usps logo.png') }}" alt="USPS" class="w-full h-12 md:h-14 object-contain" loading="lazy">
            </div>
            <div class="bg-white rounded-lg p-4 flex items-center justify-center h-24">
                <img src="{{ asset('partners/dpd.png') }}" alt="DPD" class="w-full h-12 md:h-14 object-contain" loading="lazy">
            </div>
            <div class="bg-white rounded-lg p-4 flex items-center justify-center h-24">
                <img src="{{ asset('partners/TNT_Express_Logo.svg.png') }}" alt="TNT" class="w-full h-12 md:h-14 object-contain" loading="lazy">
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Nuelcargo Logistics -->
<section id="about" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12 nuelcargo-blue">Why Choose Nuelcargo Logistics?</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="flex space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-globe text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-2 nuelcargo-blue">Global Network</h3>
                    <p class="text-gray-600">Strategic partnerships with leading carriers and agents in over 150 countries</p>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-mobile-alt text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-2 nuelcargo-blue">Technology-Driven</h3>
                    <p class="text-gray-600">User-friendly booking system, AI route optimization, and real-time tracking</p>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-headset text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-2 nuelcargo-blue">24/7 Support</h3>
                    <p class="text-gray-600">Dedicated account managers and multilingual support available round the clock</p>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-award text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-2 nuelcargo-blue">Excellence</h3>
                    <p class="text-gray-600">Licensed, insured operations with ISO-aligned quality and proven on-time delivery</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Company Section -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-4xl font-bold mb-6 nuelcargo-blue">About Nuelcargo Logistics</h2>
                <p class="text-gray-600 mb-4">Nuelcargo Logistics is a dynamic, online and offshore shipping and logistics company headquartered in Long Beach, California. We specialize in seamless, reliable conveyance of goods worldwide.</p>
                <p class="text-gray-600 mb-4">As a fully digital-enabled shipping provider, we operate an intuitive platform that allows customers to book, track, and manage shipments in real time from anywhere in the world.</p>
                <p class="text-gray-600 mb-6">We act as a versatile logistics intermediary and consolidator, delivering goods on behalf of major global carriers including DHL Express, FedEx, UPS, USPS, DPD, TNT, and many others.</p>
                <a href="#" class="bg-nuelcargo-blue hover:bg-blue-800 text-white px-8 py-3 rounded-lg font-bold transition inline-block">
                    Contact Us Today
                </a>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 flex items-center justify-center h-96 overflow-hidden">
                <img src="{{ asset('shipping2.webp') }}" alt="Global Network Shipping" class="w-full h-full object-cover rounded-lg">
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-nuelcargo-blue text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Ship?</h2>
        <p class="text-xl mb-8 text-gray-100">Start tracking your shipment or contact us for a quote today</p>
        <div class="flex flex-col md:flex-row gap-4 justify-center">
            <a href="/" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-bold transition">
                Track Shipment
            </a>
            <a href="mailto:support@nuellogistics.com" class="border-2 border-white hover:bg-white hover:text-blue-900 text-white px-8 py-3 rounded-lg font-bold transition">
                Get a Quote
            </a>
        </div>
    </div>
</section>

<!-- Inquiry Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg p-8 md:p-10">
            <h2 class="text-3xl font-bold nuelcargo-blue text-center mb-3">Have a Question?</h2>
            <p class="text-gray-600 text-center mb-8">Send us your enquiry or comment and our team will respond promptly.</p>

            @if (session('inquiry_success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                    {{ session('inquiry_success') }}
                </div>
            @endif

            <form action="{{ route('inquiry.send') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="inquiry-name" class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                    <input id="inquiry-name" name="name" type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Your full name">
                </div>
                <div>
                    <label for="inquiry-email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input id="inquiry-email" name="email" type="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="you@example.com">
                </div>
                <div>
                    <label for="inquiry-message" class="block text-sm font-semibold text-gray-700 mb-2">Comment or Question</label>
                    <textarea id="inquiry-message" name="message" rows="5" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Tell us how we can help"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-nuelcargo-blue hover:bg-blue-800 text-white px-10 py-3 rounded-lg font-bold transition">
                        Submit Enquiry
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
