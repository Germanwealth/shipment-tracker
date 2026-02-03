<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Nuelcargo - Global Shipping & Logistics Solutions'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .nuelcargo-blue { color: #003d82; }
        .nuelcargo-orange { color: #ff8c00; }
        .bg-nuelcargo-blue { background-color: #003d82; }
        .bg-nuelcargo-orange { background-color: #ff8c00; }
        .hover-lift:hover { transform: translateY(-4px); transition: all 0.3s ease; }
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
                    <div class="font-bold text-xl nuelcargo-blue">Nuelcargo</div>
                    <div class="text-xs text-gray-500">Global Shipping</div>
                </div>
            </a>
            
            <div class="hidden md:flex items-center space-x-8">
                <a href="/#home" class="text-gray-700 hover:text-nuelcargo-blue font-medium transition">Home</a>
                <a href="/#services" class="text-gray-700 hover:text-nuelcargo-blue font-medium transition">Services</a>
                <a href="/#about" class="text-gray-700 hover:text-nuelcargo-blue font-medium transition">About</a>
                <a href="/" class="bg-nuelcargo-blue text-white px-6 py-2 rounded-lg hover:bg-nuelcargo-orange transition font-medium">Track Shipment</a>
            </div>
            
            <button class="md:hidden text-gray-700">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </nav>
    </header>

    <?php echo $__env->yieldContent('content'); ?>

    <!-- Footer -->
    <footer class="bg-nuelcargo-blue text-white mt-20">
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="font-bold text-xl mb-2">Nuelcargo</div>
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
                        <i class="fas fa-phone mr-2"></i>+1 (562) 555-0000
                    </p>
                    <p class="text-sm text-gray-300 mt-2">
                        <i class="fas fa-envelope mr-2"></i>support@nuelcargo.com
                    </p>
                </div>
            </div>
            
            <div class="border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-300">
                <p>&copy; 2026 Nuelcargo. All rights reserved.</p>
                <div class="space-x-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH /home/codecps/Desktop/tracker/resources/views/layouts/public.blade.php ENDPATH**/ ?>