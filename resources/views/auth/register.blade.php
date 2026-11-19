@extends('layouts.auth')

@section('title', 'Criar conta')
@section('heading', 'Crie seu acesso')
@section('subheading', 'Comece a organizar seus atendimentos em poucos minutos.')

@section('auth-content')
    <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
        @csrf
        <div>
            <label for="name" class="auth-label">Nome</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Seu nome completo" class="auth-input">
        </div>
        <div>
            <label for="email" class="auth-label">E-mail profissional</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" placeholder="voce@empresa.com" class="auth-input">
        </div>
        <div>
            <label for="password" class="auth-label">Senha</label>
            <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="Crie uma senha segura" class="auth-input">
        </div>
        <div>
            <label for="password_confirmation" class="auth-label">Confirmar senha</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Repita sua senha" class="auth-input">
        </div>
        <button type="submit" class="auth-button">Criar minha conta <span aria-hidden="true">→</span></button>
    </form>
@endsection

@section('auth-footer')
    Já tem uma conta?
    <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700">Entrar</a>
@endsection
