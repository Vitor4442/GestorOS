<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Painel' }} · GestorOS</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-slate-50 text-slate-950 antialiased">
    <div class="min-h-screen lg:flex">
        <aside class="hidden w-72 shrink-0 border-r border-slate-200 bg-white lg:flex lg:flex-col">
            <div class="flex h-20 items-center gap-3 border-b border-slate-100 px-7">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-600 text-lg font-bold text-white shadow-lg shadow-indigo-200">G</div>
                <div>
                    <p class="text-lg font-bold tracking-tight text-slate-950">Gestor<span class="text-indigo-600">OS</span></p>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Operação simples</p>
                </div>
            </div>
            <nav class="flex-1 space-y-1 px-4 py-6">
                <p class="px-3 pb-3 text-[11px] font-bold uppercase tracking-[0.16em] text-slate-400">Workspace</p>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="text-lg">⌂</span> Visão geral
                </a>
                <a href="{{ route('service-orders.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('service-orders.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="text-lg">▣</span> Ordens de serviço
                </a>
                <a href="{{ route('customers.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('customers.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="text-lg">♙</span> Clientes
                </a>
            </nav>
            <div class="m-4 rounded-2xl bg-slate-950 p-4 text-white">
                <p class="text-sm font-semibold">Tudo sob controle</p>
                <p class="mt-1 text-xs leading-5 text-slate-400">Acompanhe cada atendimento do chamado à conclusão.</p>
            </div>
        </aside>

        <main class="min-w-0 flex-1">
            <header class="flex h-20 items-center justify-between border-b border-slate-200 bg-white px-5 sm:px-8">
                <div class="flex items-center gap-3 lg:hidden">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 font-bold text-white">G</div>
                    <span class="font-bold">Gestor<span class="text-indigo-600">OS</span></span>
                </div>
                <div class="hidden lg:block">
                    <p class="text-sm font-medium text-slate-400">{{ now()->translatedFormat('l, d \d\e F \d\e Y') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden text-right sm:block">
                        <p class="text-sm font-bold text-slate-800">Gestor OS</p>
                        <p class="text-xs text-slate-400">Equipe de operações</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700">GO</div>
                </div>
            </header>

            <div class="border-b border-slate-200 bg-white px-5 py-3 lg:hidden">
                <nav class="flex gap-2 overflow-x-auto">
                    <a href="{{ route('dashboard') }}" class="whitespace-nowrap rounded-lg px-3 py-2 text-xs font-bold {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500' }}">Visão geral</a>
                    <a href="{{ route('service-orders.index') }}" class="whitespace-nowrap rounded-lg px-3 py-2 text-xs font-bold {{ request()->routeIs('service-orders.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500' }}">Ordens de serviço</a>
                    <a href="{{ route('customers.index') }}" class="whitespace-nowrap rounded-lg px-3 py-2 text-xs font-bold {{ request()->routeIs('customers.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500' }}">Clientes</a>
                </nav>
            </div>

            <div class="mx-auto max-w-[1600px] p-5 sm:p-8">
                @if (session('success'))
                    <div class="mb-6 flex items-center justify-between rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                        <span>{{ session('success') }}</span><span class="text-emerald-500">✓</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                        <p class="font-bold">Confira os dados informados:</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
