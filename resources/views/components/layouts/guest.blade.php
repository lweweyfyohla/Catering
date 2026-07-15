<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'CaterSource' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f6f7fb] font-sans antialiased text-slate-800">
    <div class="min-h-screen flex flex-col lg:flex-row items-center justify-center gap-10 px-6 py-10 lg:px-16">
        <div class="hidden lg:flex flex-col max-w-sm">
            <div class="flex items-center gap-2 mb-8">
                <div class="h-9 w-9 rounded-lg bg-brand-500 flex items-center justify-center text-white font-bold">C</div>
                <span class="text-lg font-semibold text-slate-900">CaterSource</span>
            </div>
            <h1 class="text-3xl font-bold text-slate-900 leading-tight">
                {{ $heading ?? 'Faster sourcing. Smarter procurement. Better catering.' }}
            </h1>
            <p class="mt-3 text-slate-500">{{ $subheading ?? 'Connect with trusted catering suppliers.' }}</p>
            <div class="mt-10 rounded-2xl bg-white shadow-sm border border-slate-100 p-8 flex items-center justify-center">
                <svg viewBox="0 0 200 160" class="w-full h-40 text-brand-400" fill="none">
                    <rect x="20" y="20" width="90" height="120" rx="8" fill="currentColor" opacity="0.15"/>
                    <rect x="45" y="10" width="90" height="120" rx="8" fill="currentColor" opacity="0.35"/>
                    <circle cx="150" cy="120" r="22" fill="currentColor" opacity="0.5"/>
                    <path d="M60 60h50M60 80h50M60 100h30" stroke="currentColor" stroke-width="4" stroke-linecap="round" opacity="0.6"/>
                </svg>
            </div>
        </div>

        <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
