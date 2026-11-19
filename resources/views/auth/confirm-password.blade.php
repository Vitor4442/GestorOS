@extends('layouts.auth')

@section('title', 'Confirmar senha')
@section('heading', 'Confirme sua senha')
@section('subheading', 'Por segurança, confirme sua senha antes de continuar para esta área.')

@section('auth-content')
    <form method="POST" action="{{ route('password.confirm.store') }}" class="space-y-5">
        @csrf
        <div>
            <label for="password" class="auth-label">Senha atual</label>
            <input id="password" name="password" type="password" required autofocus autocomplete="current-password" placeholder="Digite sua senha atual" class="auth-input">
        </div>
        <button type="submit" class="auth-button">Confirmar senha <span aria-hidden="true">→</span></button>
    </form>
@endsection

@section('auth-footer')
    Você será redirecionado de volta após a confirmação.
@endsection
