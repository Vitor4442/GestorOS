@extends('layouts.auth')

@section('title', 'Entrar')
@section('heading', 'Bem-vindo de volta')
@section('subheading', 'Acesse sua conta para acompanhar a operação da sua equipe.')

@section('auth-content')
    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="auth-label">E-mail</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="voce@empresa.com" class="auth-input">
        </div>
        <div>
            <div class="flex items-center justify-between gap-3">
                <label for="password" class="auth-label">Senha</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Esqueci minha senha</a>
                @endif
            </div>
            <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Digite sua senha" class="auth-input">
        </div>
        <label class="flex items-center gap-3 text-sm font-semibold text-slate-600">
            <input name="remember" type="checkbox" value="1" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            Lembrar de mim neste dispositivo
        </label>
        <button type="submit" class="auth-button">Entrar na plataforma <span aria-hidden="true">→</span></button>
    </form>
@endsection

@section('auth-footer')
    Ainda não tem uma conta?
    @if (Route::has('register'))
        <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-700">Criar conta</a>
    @endif
@endsection
