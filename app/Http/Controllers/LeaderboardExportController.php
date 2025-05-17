<?php
namespace App\Http\Controllers;

use App\Exports\LeaderboardExport;
use Maatwebsite\Excel\Facades\Excel;

class LeaderboardExportController extends Controller
{
    public function export()
    {
        return Excel::download(new LeaderboardExport, 'leaderboard.xlsx');
    }
}
