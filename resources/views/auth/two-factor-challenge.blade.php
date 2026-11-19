@extends('layouts.auth')

@section('title', 'Verificação em duas etapas')
@section('heading', 'Confirme sua identidade')
@section('subheading', 'Digite o código do seu aplicativo autenticador para continuar.')

@section('auth-content')
    <form method="POST" action="{{ route('two-factor.login.store') }}" class="space-y-5">
        @csrf
        <div id="totp-field">
            <label for="code" class="auth-label">Código de autenticação</label>
            <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code" autofocus placeholder="000000" class="auth-input text-center text-2xl font-black tracking-[0.35em]">
        </div>
        <div id="recovery-field" class="hidden">
            <label for="recovery_code" class="auth-label">Código de recuperação</label>
            <input id="recovery_code" name="recovery_code" type="text" autocomplete="off" placeholder="xxxx-xxxx-xxxx" class="auth-input">
        </div>
        <button type="submit" class="auth-button">Verificar e continuar <span aria-hidden="true">→</span></button>
        <button type="button" id="toggle-recovery" class="block w-full text-center text-xs font-bold text-slate-500 hover:text-indigo-600">Usar um código de recuperação</button>
    </form>
    @push('scripts')
        <script>
            document.getElementById('toggle-recovery')?.addEventListener('click', function () {
                document.getElementById('totp-field').classList.toggle('hidden');
                document.getElementById('recovery-field').classList.toggle('hidden');
                this.textContent = document.getElementById('recovery-field').classList.contains('hidden')
                    ? 'Usar um código de recuperação'
                    : 'Usar o código do aplicativo';
            });
        </script>
    @endpush
@endsection

@section('auth-footer')
    A verificação em duas etapas ajuda a manter sua conta protegida.
@endsection
