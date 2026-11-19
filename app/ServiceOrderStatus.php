<?php

namespace App;

enum ServiceOrderStatus: string
{
    case Open = 'open';
    case InProgress = 'in_progress';
    case WaitingParts = 'waiting_parts';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Open => 'Aberta',
            self::InProgress => 'Em andamento',
            self::WaitingParts => 'Aguardando peça',
            self::Completed => 'Concluída',
            self::Cancelled => 'Cancelada',
        };
    }
}
