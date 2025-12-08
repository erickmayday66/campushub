<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Election;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\Student;
use Carbon\Carbon;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // Count ongoing elections
        $activeElections = Election::where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->count();

        // Count all candidates
        $totalCandidates = Candidate::count();

        // Count votes only in currently active elections
        $totalVotes = Vote::whereHas('election', function ($query) use ($now) {
            $query->where('start_date', '<=', $now)
                  ->where('end_date', '>=', $now);
        })->count();

        // Calculate participation rate (votes / total students)
        $totalStudents = Student::count();
        $participationRate = $totalStudents > 0
            ? round(($totalVotes / $totalStudents) * 100, 2)
            : 0;

        return view('manager.dashboard', compact(
            'activeElections',
            'totalCandidates',
            'totalVotes',
            'participationRate'
        ));
    }
}
