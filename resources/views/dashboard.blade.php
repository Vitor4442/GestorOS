@extends('layouts.app', ['title' => 'Visão geral'])

@section('content')
<div class="space-y-8">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-indigo-600">Bom trabalho, equipe</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">Visão geral</h1>
            <p class="mt-2 max-w-xl text-sm leading-6 text-slate-500">Tenha clareza do que precisa de atenção hoje e mantenha seus clientes informados.</p>
        </div>
        <a href="{{ route('service-orders.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-700">+ Nova ordem de serviço</a>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total de OS</p><p class="mt-3 text-3xl font-black">{{ $stats['total'] }}</p><p class="mt-2 text-xs font-semibold text-slate-400">todas as ordens</p></div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><p class="text-xs font-bold uppercase tracking-wider text-slate-400">Abertas</p><p class="mt-3 text-3xl font-black text-sky-600">{{ $stats['open'] }}</p><p class="mt-2 text-xs font-semibold text-sky-600">aguardando triagem</p></div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><p class="text-xs font-bold uppercase tracking-wider text-slate-400">Em andamento</p><p class="mt-3 text-3xl font-black text-indigo-600">{{ $stats['in_progress'] }}</p><p class="mt-2 text-xs font-semibold text-indigo-600">com a equipe</p></div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><p class="text-xs font-bold uppercase tracking-wider text-slate-400">Concluídas</p><p class="mt-3 text-3xl font-black text-emerald-600">{{ $stats['completed'] }}</p><p class="mt-2 text-xs font-semibold text-emerald-600">entregues</p></div>
        <div class="rounded-2xl border border-rose-100 bg-rose-50 p-5 shadow-sm"><p class="text-xs font-bold uppercase tracking-wider text-rose-400">Urgentes</p><p class="mt-3 text-3xl font-black text-rose-600">{{ $stats['urgent'] }}</p><p class="mt-2 text-xs font-semibold text-rose-600">precisam de atenção</p></div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1fr_360px]">
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-5 sm:px-6"><div><h2 class="font-black text-slate-950">Ordens recentes</h2><p class="mt-1 text-xs text-slate-400">Acompanhe os últimos atendimentos</p></div><a href="{{ route('service-orders.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Ver todas →</a></div>
            <div class="divide-y divide-slate-100">
                @forelse ($recentOrders as $order)
                    <a href="{{ route('service-orders.show', $order) }}" class="flex items-center justify-between gap-4 px-5 py-4 transition hover:bg-slate-50 sm:px-6"><div class="min-w-0"><div class="flex flex-wrap items-center gap-2"><span class="text-xs font-black text-indigo-600">{{ $order->number }}</span><x-priority-badge :priority="$order->priority" /></div><p class="mt-1 truncate text-sm font-bold text-slate-800">{{ $order->title }}</p><p class="mt-1 text-xs text-slate-400">{{ $order->customer->name }} · {{ $order->created_at->diffForHumans() }}</p></div><x-status-badge :status="$order->status" /></a>
                @empty
                    <div class="px-6 py-12 text-center"><p class="font-bold text-slate-700">Nenhuma ordem cadastrada</p><p class="mt-1 text-sm text-slate-400">Crie a primeira para começar a acompanhar.</p></div>
                @endforelse
            </div>
        </section>
        <section class="rounded-2xl bg-slate-950 p-6 text-white shadow-xl shadow-slate-200"><p class="text-xs font-bold uppercase tracking-[0.16em] text-indigo-300">Fluxo recomendado</p><h2 class="mt-4 text-2xl font-black leading-tight">Do chamado à solução, sem perder o contexto.</h2><div class="mt-7 space-y-5"><div class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-indigo-500 text-xs font-black">1</span><div><p class="text-sm font-bold">Registre o pedido</p><p class="mt-1 text-xs leading-5 text-slate-400">Centralize cliente, problema e prioridade.</p></div></div><div class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-indigo-500 text-xs font-black">2</span><div><p class="text-sm font-bold">Atribua à equipe</p><p class="mt-1 text-xs leading-5 text-slate-400">Cada técnico sabe o que precisa fazer.</p></div></div><div class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-indigo-500 text-xs font-black">3</span><div><p class="text-sm font-bold">Atualize o status</p><p class="mt-1 text-xs leading-5 text-slate-400">O histórico mantém todos alinhados.</p></div></div></div></section>
    </div>
</div>
@endsection
