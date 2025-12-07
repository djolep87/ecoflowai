<!DOCTYPE html>
<html lang="sr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Digitalni sistem za upravljanje otpadom</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .gradient-mesh {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-white antialiased">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass-effect border-b border-gray-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">EcoFlow</span>
                </div>
                <div class="flex items-center space-x-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-emerald-600 font-medium transition-colors duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-emerald-600 font-medium transition-colors duration-200">
                            Prijava
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-2.5 rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all duration-200">
                                Registracija
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center pt-20 overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-teal-50">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float" style="animation-delay: 4s;"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="text-center lg:text-left animate-fade-in-up">
                    <div class="inline-block mb-6 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                        🚀 Digitalna transformacija
                    </div>
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-gray-900 mb-6 leading-tight">
                        Digitalni sistem za<br>
                        <span class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 bg-clip-text text-transparent">
                            upravljanje otpadom
                        </span>
                    </h1>
                    <p class="text-xl md:text-2xl text-gray-600 mb-10 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Prati otpad, prijavi preuzimanje i vodi kompletnu dokumentaciju na jednom mestu.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ Route::has('register') ? route('register') : '#' }}" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 overflow-hidden">
                            <span class="relative z-10">Počni odmah</span>
                            <svg class="relative z-10 w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            <div class="absolute inset-0 bg-gradient-to-r from-teal-600 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        <a href="#kako-funkcionise" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-gray-700 bg-white rounded-2xl shadow-lg hover:shadow-xl border-2 border-gray-200 hover:border-emerald-300 transition-all duration-300">
                            Saznaj više
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="mt-16 grid grid-cols-3 gap-8 max-w-md mx-auto lg:mx-0">
                        <div class="text-center lg:text-left">
                            <div class="text-3xl font-bold text-emerald-600">100%</div>
                            <div class="text-sm text-gray-600 mt-1">Digitalno</div>
                        </div>
                        <div class="text-center lg:text-left">
                            <div class="text-3xl font-bold text-teal-600">24/7</div>
                            <div class="text-sm text-gray-600 mt-1">Dostupno</div>
                        </div>
                        <div class="text-center lg:text-left">
                            <div class="text-3xl font-bold text-cyan-600">0</div>
                            <div class="text-sm text-gray-600 mt-1">Papira</div>
                        </div>
                    </div>
                </div>
                
                <!-- Visual Design - Cards with Central Input -->
                <div class="relative">
                    <!-- Mobile/Tablet View -->
                    <div class="lg:hidden space-y-6">
                        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl flex items-center justify-center shadow-lg mb-4">
                                <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none">
                                    <path d="M0 8C0 8 4 4 12 4C20 4 24 8 24 8V0H0V8Z" fill="#60A5FA"/>
                                    <path d="M0 24V8C0 8 4 12 12 12C20 12 24 8 24 8V24H0Z" fill="#10B981"/>
                                    <circle cx="18" cy="6" r="2" fill="#FCD34D"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Eko sistem</h3>
                            <p class="text-gray-600 text-sm">Odgovorno upravljanje otpadom</p>
                        </div>
                        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-4 flex items-center space-x-4">
                            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-emerald-600" viewBox="0 0 24 24" fill="none">
                                    <path d="M0 8C0 8 4 4 12 4C20 4 24 8 24 8V0H0V8Z" fill="#60A5FA"/>
                                    <path d="M0 24V8C0 8 4 12 12 12C20 12 24 8 24 8V24H0Z" fill="#10B981"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <input 
                                    type="text" 
                                    value="Eko upravljanje otpadom" 
                                    readonly
                                    class="w-full text-base font-semibold text-gray-900 bg-transparent border-none outline-none cursor-default"
                                />
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Brzo</h3>
                            <p class="text-gray-600 text-sm">Jednostavno i efikasno</p>
                        </div>
                    </div>
                    
                    <!-- Desktop View -->
                    <div class="hidden lg:block relative w-full h-[500px] flex items-center justify-center">
                        <!-- Translucent Background Shapes -->
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-64 h-64 bg-emerald-200/40 rounded-3xl blur-2xl -z-10"></div>
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-64 h-64 bg-teal-200/40 rounded-3xl blur-2xl -z-10"></div>
                        
                        <!-- Left Card -->
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-64 h-80 bg-white rounded-3xl shadow-2xl border border-gray-100 p-6 z-10 animate-float" style="animation-delay: 0s;">
                            <div class="w-16 h-16 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl flex items-center justify-center shadow-lg mb-4">
                                <!-- Eco Icon - Hill with Sky -->
                                <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="none">
                                    <!-- Sky -->
                                    <path d="M0 8C0 8 4 4 12 4C20 4 24 8 24 8V0H0V8Z" fill="#60A5FA"/>
                                    <!-- Hill -->
                                    <path d="M0 24V8C0 8 4 12 12 12C20 12 24 8 24 8V24H0Z" fill="#10B981"/>
                                    <!-- Sun -->
                                    <circle cx="18" cy="6" r="2" fill="#FCD34D"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Eko sistem</h3>
                            <p class="text-gray-600 text-sm">Odgovorno upravljanje otpadom</p>
                        </div>
                        
                        <!-- Right Card -->
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-64 h-80 bg-white rounded-3xl shadow-2xl border border-gray-100 p-6 z-10 animate-float" style="animation-delay: 2s;">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg mb-4">
                                <!-- Speed Icon - Arrow -->
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Brzo</h3>
                            <p class="text-gray-600 text-sm">Jednostavno i efikasno</p>
                        </div>
                        
                        <!-- Central Input/Search Bar -->
                        <div class="absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 w-[600px] z-20">
                            <div class="bg-white rounded-2xl shadow-2xl border-2 border-gray-100 p-4 flex items-center space-x-4">
                                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <!-- Small Eco Icon -->
                                    <svg class="w-6 h-6 text-emerald-600" viewBox="0 0 24 24" fill="none">
                                        <path d="M0 8C0 8 4 4 12 4C20 4 24 8 24 8V0H0V8Z" fill="#60A5FA"/>
                                        <path d="M0 24V8C0 8 4 12 12 12C20 12 24 8 24 8V24H0Z" fill="#10B981"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <input 
                                        type="text" 
                                        value="Eko upravljanje otpadom" 
                                        readonly
                                        class="w-full text-lg font-semibold text-gray-900 bg-transparent border-none outline-none cursor-default"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Three Main Steps -->
    <section id="kako-funkcionise" class="py-24 bg-white relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-emerald-50/50 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">
                    Kako funkcioniše proces
                    <span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">upravljanja otpadom</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Jednostavan proces u tri koraka za efikasno upravljanje otpadom
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                <!-- Step 1 -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl opacity-0 group-hover:opacity-100 blur transition duration-300"></div>
                    <div class="relative bg-gradient-to-br from-emerald-50 via-white to-teal-50 rounded-3xl p-10 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-emerald-100">
                        <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="absolute top-6 right-6 w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 font-bold text-xl">
                            1
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Evidencija otpada</h3>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            Beleži nastanak otpada i vodi evidenciju bez papira.
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-3xl opacity-0 group-hover:opacity-100 blur transition duration-300"></div>
                    <div class="relative bg-gradient-to-br from-blue-50 via-white to-cyan-50 rounded-3xl p-10 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-blue-100">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </div>
                        <div class="absolute top-6 right-6 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xl">
                            2
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Zahtev za preuzimanje</h3>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            Pošalji operateru zahtev jednim klikom.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl opacity-0 group-hover:opacity-100 blur transition duration-300"></div>
                    <div class="relative bg-gradient-to-br from-purple-50 via-white to-pink-50 rounded-3xl p-10 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-purple-100">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="absolute top-6 right-6 w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold text-xl">
                            3
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Dokumentacija</h3>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            Automatski generiši dokumentaciju i prati status.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-24 bg-gradient-to-b from-gray-50 via-white to-emerald-50 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgb(16, 185, 129) 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">
                    Glavne prednosti korišćenja
                    <span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">sistema</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Zašto odabrati naš digitalni sistem za upravljanje otpadom
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Benefit 1 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Ušteda vremena</h3>
                    <p class="text-gray-600 leading-relaxed">Automatsizuj procese i uštedi dragoceno vreme za vaš tim.</p>
                </div>

                <!-- Benefit 2 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Nema više papira</h3>
                    <p class="text-gray-600 leading-relaxed">Potpuno digitalna dokumentacija bez potrebe za fizičkim papirima.</p>
                </div>

                <!-- Benefit 3 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Svi podaci na jednom mestu</h3>
                    <p class="text-gray-600 leading-relaxed">Centralizovana baza podataka za lak pristup svim informacijama.</p>
                </div>

                <!-- Benefit 4 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Lakše poštovanje zakona</h3>
                    <p class="text-gray-600 leading-relaxed">Automatski generiši izveštaje u skladu sa važećim propisima.</p>
                </div>

                <!-- Benefit 5 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Precizna evidencija i praćenje statusa</h3>
                    <p class="text-gray-600 leading-relaxed">Realno vreme praćenja statusa otpada i kompletan istorijat.</p>
                </div>

                <!-- Benefit 6 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Brza i efikasna komunikacija</h3>
                    <p class="text-gray-600 leading-relaxed">Direktna komunikacija sa operaterima za preuzimanje otpada.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6">
                Spremni da počnete?
            </h2>
            <p class="text-xl text-emerald-50 mb-10 max-w-2xl mx-auto">
                Pridružite se kompanijama koje već koriste naš sistem za efikasno upravljanje otpadom.
            </p>
            <a href="{{ Route::has('register') ? route('register') : '#' }}" class="inline-flex items-center justify-center px-10 py-5 text-lg font-bold text-emerald-600 bg-white rounded-2xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300">
                Registruj se besplatno
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-2">
                    <div class="flex items-center space-x-2 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-white">EcoFlow</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed max-w-md">
                        Digitalni sistem za upravljanje otpadom - jednostavno, efikasno i ekološki odgovorno.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-bold text-lg mb-6">Brzi linkovi</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors duration-200">O nama</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors duration-200">Kontakt</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors duration-200">Pomoć</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors duration-200">Dokumentacija</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold text-lg mb-6">Kontakt</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>info@ecoflow.rs</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>+381 11 123 4567</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} EcoFlow. Sva prava zadržana.</p>
            </div>
        </div>
    </footer>
</body>
</html>
