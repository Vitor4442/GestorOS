@extends('layouts.auth')

@section('title', 'Nova senha')
@section('heading', 'Escolha uma nova senha')
@section('subheading', 'Use uma senha forte para proteger o acesso à sua operação.')

@section('auth-content')
    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ request()->route('token') }}">
        <div>
            <label for="email" class="auth-label">E-mail</label>
            <input id="email" name="email" type="email" value="{{ old('email', request()->email) }}" required autofocus autocomplete="email" class="auth-input">
        </div>
        <div>
            <label for="password" class="auth-label">Nova senha</label>
            <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="Digite sua nova senha" class="auth-input">
        </div>
        <div>
            <label for="password_confirmation" class="auth-label">Confirmar nova senha</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Repita sua nova senha" class="auth-input">
        </div>
        <button type="submit" class="auth-button">Salvar nova senha <span aria-hidden="true">→</span></button>
    </form>
@endsection

@section('auth-footer')
    <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700">Voltar para o login</a>
@endsection
