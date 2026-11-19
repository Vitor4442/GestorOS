@extends('layouts.auth')

@section('title', 'Recuperar senha')
@section('heading', 'Recupere seu acesso')
@section('subheading', 'Informe seu e-mail e enviaremos um link para criar uma nova senha.')

@section('auth-content')
    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="auth-label">E-mail cadastrado</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="voce@empresa.com" class="auth-input">
        </div>
        <button type="submit" class="auth-button">Enviar link de recuperação <span aria-hidden="true">→</span></button>
    </form>
@endsection

@section('auth-footer')
    Lembrou da senha?
    <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700">Voltar para o login</a>
@endsection
