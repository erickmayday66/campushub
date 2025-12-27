<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Election;
use App\Models\Faculty;

class DashboardController extends Controller
{
    public function index()
    {
        // ---------------------
        // Counts
        // ---------------------
        $totalUsers      = User::count();
        $activeStudents  = Student::count();
        $activeElections = Election::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->count();
        $facultyCount    = Faculty::count();
        $resultCount     = Election::count(); // total elections conducted

        // ---------------------
        // Recent Activities (limited items)
        // ---------------------
        $recentActivities = collect();

        // Last 2 users added
        $users = User::latest()->take(2)->get();
        foreach ($users as $user) {
            $recentActivities->push((object)[
                'message' => "New user added: {$user->name}",
                'timeAgo' => $user->created_at->diffForHumans(),
                'icon'    => 'fa-user-plus',
                'color'   => '#3498db'
            ]);
        }

        // Last election created
        $lastElection = Election::latest()->first();
        if ($lastElection) {
            $creator = $lastElection->creator ?? null;
            $recentActivities->push((object)[
                'message' => "Election \"{$lastElection->title}\" created" . ($creator ? " by {$creator->name}" : ''),
                'timeAgo' => $lastElection->created_at->diffForHumans(),
                'icon'    => 'fa-vote-yea',
                'color'   => '#e67e22'
            ]);
        }

        // Last student added or imported
        $lastStudent = Student::latest()->first();
        if ($lastStudent) {
            if ($lastStudent->imported_by_excel ?? false) {
                $recentActivities->push((object)[
                    'message' => "Bulk import of students completed",
                    'timeAgo' => $lastStudent->created_at->diffForHumans(),
                    'icon'    => 'fa-users',
                    'color'   => '#2ecc71'
                ]);
            } else {
                $recentActivities->push((object)[
                    'message' => "New student added: {$lastStudent->name}",
                    'timeAgo' => $lastStudent->created_at->diffForHumans(),
                    'icon'    => 'fa-user-graduate',
                    'color'   => '#2ecc71'
                ]);
            }
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeStudents',
            'activeElections',
            'facultyCount',
            'resultCount',
            'recentActivities'
        ));
    }
}
