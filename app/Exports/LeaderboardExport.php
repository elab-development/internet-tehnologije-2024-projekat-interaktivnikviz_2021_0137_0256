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
            ->get()
            ->map(function ($record) {
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
