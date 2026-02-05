<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nuelcargo Logistics - Global Shipping & Logistics Solutions')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .nuelcargo-blue { color: #003d82; }
        .nuelcargo-orange { color: #ff8c00; }
        .bg-nuelcargo-blue { background-color: #003d82; }
        .bg-nuelcargo-orange { background-color: #ff8c00; }
        .hover-lift:hover { transform: translateY(-4px); transition: all 0.3s ease; }
        .whatsapp-float {
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: 56px;
            height: 56px;
            border-radius: 9999px;
            background: #25D366;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 24px rgba(0,0,0,0.18);
            z-index: 60;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .whatsapp-float:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.22);
        }
        .whatsapp-float span {
            position: absolute;
            right: 70px;
            white-space: nowrap;
            background: #0f172a;
            color: #ffffff;
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 9999px;
            opacity: 0;
            transform: translateX(6px);
            pointer-events: none;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }
        .whatsapp-float:hover span {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-white">
    <!-- Header/Navigation -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-nuelcargo-blue rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10l8-4M3 12a9 9 0 0118 0m0 0a9 9 0 01-18 0m0 0a9 9 0 0118 0"></path>
                    </svg>
                </div>
                <div>
                    <div class="font-bold text-xl nuelcargo-blue">Nuelcargo Logistics</div>
                    <div class="text-xs text-gray-500">Global Shipping</div>
                </div>
            </a>
            
            <div class="hidden md:flex items-center space-x-8">
                <a href="/#home" class="text-gray-700 hover:text-nuelcargo-blue font-medium transition">Home</a>
                <a href="/#services" class="text-gray-700 hover:text-nuelcargo-blue font-medium transition">Services</a>
                <a href="/#about" class="text-gray-700 hover:text-nuelcargo-blue font-medium transition">About</a>
                <a href="/" class="bg-nuelcargo-blue text-white px-6 py-2 rounded-lg hover:bg-nuelcargo-orange transition font-medium">Track Shipment</a>
            </div>
            
            <button id="mobile-menu-toggle" type="button" class="md:hidden text-gray-700" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </nav>
        <div id="mobile-menu" class="md:hidden hidden border-t border-gray-100 bg-white shadow-md">
            <div class="px-4 py-4 space-y-3">
                <a href="/#home" class="block text-gray-700 hover:text-nuelcargo-blue font-medium transition">Home</a>
                <a href="/#services" class="block text-gray-700 hover:text-nuelcargo-blue font-medium transition">Services</a>
                <a href="/#about" class="block text-gray-700 hover:text-nuelcargo-blue font-medium transition">About</a>
                <a href="/" class="block bg-nuelcargo-blue text-white px-4 py-2 rounded-lg hover:bg-nuelcargo-orange transition font-medium text-center">Track Shipment</a>
            </div>
        </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-nuelcargo-blue text-white mt-20">
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="font-bold text-xl mb-2">Nuelcargo Logistics</div>
                    <p class="text-gray-300 text-sm">Global shipping and logistics solutions for businesses and individuals.</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-300 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white transition"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-bold mb-4">Services</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-white transition">Express Delivery</a></li>
                        <li><a href="#" class="hover:text-white transition">Freight Forwarding</a></li>
                        <li><a href="#" class="hover:text-white transition">Customs Clearance</a></li>
                        <li><a href="#" class="hover:text-white transition">Warehousing</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold mb-4">Company</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Careers</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold mb-4">Contact</h4>
                    <p class="text-sm text-gray-300">
                        <i class="fas fa-map-marker-alt mr-2"></i>Long Beach, California, USA
                    </p>
                    <p class="text-sm text-gray-300 mt-2">
                        <i class="fas fa-phone mr-2"></i>+1 (617) 680-6930
                    </p>
                    <p class="text-sm text-gray-300 mt-2">
                        <i class="fas fa-envelope mr-2"></i>support@nuellogistics.com
                    </p>
                </div>
            </div>
            
            <div class="border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-300">
                <p>&copy; 2026 Nuelcargo Logistics. All rights reserved.</p>
                <div class="space-x-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('mobile-menu-toggle');
            const menu = document.getElementById('mobile-menu');
            if (!toggle || !menu) return;

            toggle.addEventListener('click', (event) => {
                event.preventDefault();
                const isHidden = menu.classList.toggle('hidden');
                toggle.setAttribute('aria-expanded', isHidden ? 'false' : 'true');
            });

            menu.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => {
                    if (!menu.classList.contains('hidden')) {
                        menu.classList.add('hidden');
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                });
            });
        });
    </script>

    <a href="https://wa.me/16176806930" class="whatsapp-float" aria-label="Chat with customer service on WhatsApp" target="_blank" rel="noopener noreferrer">
        <i class="fab fa-whatsapp text-2xl"></i>
        <span>WhatsApp Chat</span>
    </a>
</body>
</html>
