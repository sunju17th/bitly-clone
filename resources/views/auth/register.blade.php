<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký - ShortLink</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <div class="flex min-h-screen">
        
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 md:px-24 py-12">
            <div class="mb-8">
                <a href="/" class="flex items-center gap-2 mb-6">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                    <span class="font-bold text-2xl text-gray-900">ShortLink</span>
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Tạo tài khoản mới</h1>
                <p class="text-gray-500">Bắt đầu quản lý đường dẫn của bạn hoàn toàn miễn phí.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Họ và Tên</label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Ví dụ: Nguyễn Văn A">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="email@example.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Ít nhất 8 ký tự">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Nhập lại Mật khẩu</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required 
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Khớp với mật khẩu trên">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 shadow-lg transition transform active:scale-95">
                    Đăng ký ngay
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-gray-600">
                Đã có tài khoản? 
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800">Đăng nhập tại đây</a>
            </div>
        </div>

        <div class="hidden lg:flex w-1/2 bg-indigo-50 items-center justify-center relative overflow-hidden">
            <div class="absolute w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob top-10 right-10"></div>
            <div class="absolute w-96 h-96 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000 bottom-10 left-10"></div>
            
            <div class="relative z-10 text-center px-12">
                <img src="https://static.semrush.com/blog/uploads/media/d1/a0/d1a00d61b8421ac42c3b859d4d582056/extra.png" alt="Register Illustration" class="w-3/4 mx-auto mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Bắt đầu hành trình của bạn</h2>
                <p class="text-gray-600">Tham gia cùng hàng ngàn người dùng khác đang tối ưu hóa liên kết của họ mỗi ngày.</p>
            </div>
        </div>
    </div>
</body>
</html>