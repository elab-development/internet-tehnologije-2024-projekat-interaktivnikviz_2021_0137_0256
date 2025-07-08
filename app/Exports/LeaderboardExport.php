<?php

namespace App\Exports;

use App\Models\Leaderboard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaderboardExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Leaderboard::with('user')
            ->whereHas('user')
            ->get()
            ->map(function ($record) {
                \Log::info('Exporting user', ['id' => $record->user->id ?? null]);
                return [
                    'username' => $record->user->username ?? 'NEPOZNATO',
                    'email' => $record->user->email ?? 'NEPOZNATO',
                    'points' => $record->points,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Username',
            'Email',
            'Points',
        ];
    }
}
