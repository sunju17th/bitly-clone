<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ShortLink - Rút gọn link miễn phí</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans text-gray-800 bg-white">

    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="/" class="flex items-center gap-2">
                    <div class="bg-indigo-600 text-white p-1.5 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-900">ShortLink</span>
                </a>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-medium text-gray-600 hover:text-indigo-600 transition">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">Đăng xuất</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="font-medium text-gray-600 hover:text-indigo-600 transition">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-full text-sm font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 transition transform">Bắt đầu ngay</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full z-[-1]">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-50 rounded-full blur-3xl opacity-50 mix-blend-multiply"></div>
            <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-purple-50 rounded-full blur-3xl opacity-50 mix-blend-multiply"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 mb-6 leading-tight">
                Rút gọn link, <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">mở rộng tầm với.</span>
            </h1>
            <p class="mt-4 text-xl text-gray-500 mb-10 max-w-2xl mx-auto">
                Công cụ tối ưu giúp bạn quản lý đường dẫn, theo dõi lượt click và nâng cao hiệu quả thương hiệu.
            </p>

            <div class="max-w-3xl mx-auto bg-white p-2 rounded-2xl shadow-xl border border-gray-100 transform transition hover:scale-[1.01]">
                <form action="{{ route('shorten') }}" method="POST" class="flex flex-col md:flex-row gap-2">
                    @csrf
                    <input type="text" name="original_url" 
                           class="flex-1 border-none focus:ring-0 text-lg px-4 py-3 rounded-xl text-gray-800 placeholder-gray-400" 
                           placeholder="Dán link dài của bạn vào đây..." required>
                    <button type="submit" class="bg-indigo-600 text-white font-bold text-lg px-8 py-3 rounded-xl hover:bg-indigo-700 transition shadow-md">
                        Rút gọn
                    </button>
                </form>
            </div>

            @if (session('success'))
                <div class="mt-8 p-6 bg-green-50 border border-green-200 rounded-2xl inline-block shadow-sm animate-fade-in-up text-center">
                    <p class="text-green-800 font-medium mb-2">🎉 Link rút gọn của bạn:</p>
                    

                    <div class="flex items-center justify-center gap-3 bg-white px-4 py-2 rounded-lg border border-green-100 mb-4">
                        <a href="{{ Str::after(session('success'), ': ') }}" target="_blank" class="text-2xl font-bold text-indigo-600 hover:underline">
                            {{ Str::after(session('success'), ': ') }}
                        </a>
                    </div>


                    <div class="flex flex-col items-center justify-center bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                        <p class="text-xs text-gray-400 mb-2">Quét mã để truy cập nhanh</p>
                        {!! QrCode::size(150)->generate(Str::after(session('success'), ': ')) !!}
                    </div>
                </div>
            @endif

            <div class="mt-12 flex justify-center gap-8 text-gray-400 grayscale opacity-60">
                <span class="text-xl font-bold">Google</span>
                <span class="text-xl font-bold">Facebook</span>
                <span class="text-xl font-bold">Amazon</span>
                <span class="text-xl font-bold">Netflix</span>
            </div>
        </div>
    </div>

</body>
</html>