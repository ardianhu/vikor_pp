<?php

namespace App\Http\Controllers;

use App\Models\VikorResultHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index($limit = 5)
    {
        // Fetch the top pesantren with the best VIKOR scores (lowest scores)
        $topPesantren = VikorResultHistory::select('pesantren_id', DB::raw('AVG(vikor_score) as avg_score'))
            ->groupBy('pesantren_id')
            ->orderBy('avg_score', 'asc') // Order by average score (lowest is best)
            ->limit($limit)
            ->get();

        // Optionally, you can eager load related pesantren data
        $topPesantren->load('pesantren');
        // dd($topPesantren);
        return view('dashboard', compact('topPesantren'));
    }
}
