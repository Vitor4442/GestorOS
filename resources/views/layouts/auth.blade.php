<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Acessar') · GestorOS</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-slate-50 text-slate-950 antialiased">
    <div class="min-h-screen lg:grid lg:grid-cols-[1.05fr_0.95fr]">
        <aside class="relative hidden overflow-hidden bg-slate-950 px-10 py-12 text-white lg:flex lg:flex-col lg:justify-between xl:px-16">
            <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-indigo-600/20 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-24 h-96 w-96 rounded-full bg-violet-500/10 blur-3xl"></div>
            <a href="{{ route('dashboard') }}" class="relative flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-500 text-xl font-black shadow-xl shadow-indigo-950">G</span>
                <span class="text-xl font-black tracking-tight">Gestor<span class="text-indigo-400">OS</span></span>
            </a>
            <div class="relative max-w-xl">
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-indigo-300">Operação sem ruído</p>
                <h2 class="mt-5 text-5xl font-black leading-[1.05] tracking-tight xl:text-6xl">Sua equipe no controle de cada atendimento.</h2>
                <p class="mt-6 max-w-md text-base leading-7 text-slate-400">Centralize clientes, ordens de serviço e o histórico de cada decisão em um só lugar.</p>
                <div class="mt-10 flex flex-wrap gap-3 text-xs font-bold text-slate-300">
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-2">Acompanhamento em tempo real</span>
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-2">Histórico completo</span>
                </div>
            </div>
            <p class="relative text-xs font-semibold text-slate-500">© {{ date('Y') }} GestorOS · Gestão de serviços</p>
        </aside>

        <main class="flex min-h-screen items-center justify-center px-5 py-8 sm:px-8">
            <div class="w-full max-w-md">
                <a href="{{ route('dashboard') }}" class="mb-10 flex items-center justify-center gap-2 lg:hidden">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 font-black text-white">G</span>
                    <span class="font-black tracking-tight">Gestor<span class="text-indigo-600">OS</span></span>
                </a>

                <div class="mb-8">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-indigo-600">GestorOS</p>
                    <h1 class="mt-3 text-3xl font-black tracking-tight text-slate-950">@yield('heading')</h1>
                    <p class="mt-2 text-sm leading-6 text-slate-500">@yield('subheading')</p>
                </div>

                @if (session('status'))
                    <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                        <p class="font-bold">Não foi possível continuar.</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                @yield('auth-content')

                <div class="mt-8 text-center text-sm text-slate-500">
                    @yield('auth-footer')
                </div>
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html>
