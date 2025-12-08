<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Election;
use App\Models\Faculty;
use Carbon\Carbon;

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
        // System Uptime
        // ---------------------
        $systemUptime = $this->getSystemUptime();

        // ---------------------
        // Recent Activities
        // ---------------------
        $recentActivities = collect();

        // 1. Last 2 users added
        $users = User::latest()->take(2)->get();
        foreach ($users as $user) {
            $recentActivities->push((object)[
                'message' => "New user added: {$user->name}",
                'timeAgo' => $user->created_at->diffForHumans(),
                'icon'    => 'fa-user-plus',
                'color'   => '#3498db'
            ]);
        }

        // 2. Last election created
        $lastElection = Election::latest()->first();
        if ($lastElection) {
            $creator = $lastElection->creator ?? null; // requires creator() relation in Election model
            $recentActivities->push((object)[
                'message' => "Election \"{$lastElection->title}\" created" . ($creator ? " by {$creator->name}" : ''),
                'timeAgo' => $lastElection->created_at->diffForHumans(),
                'icon'    => 'fa-vote-yea',
                'color'   => '#e67e22'
            ]);
        }

        // 3. Student import or creation
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

        // ---------------------
        // Analytics Data
        // ---------------------
        $analyticsLabels = [];
        $analyticsData   = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $label = $month->format('M Y');
            $count = User::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $analyticsLabels[] = $label;
            $analyticsData[]   = $count;
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeStudents',
            'activeElections',
            'facultyCount',
            'resultCount',
            'systemUptime',
            'recentActivities',
            'analyticsLabels',
            'analyticsData'
        ));
    }

    private function getSystemUptime()
{
    $uptime = 'N/A';

    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        // Windows: use PowerShell instead of wmic
        $output = [];
        exec('powershell -command "(get-date) - (gcim Win32_OperatingSystem).LastBootUpTime"', $output);
        if (!empty($output[0])) {
            $uptime = trim($output[0]);
        }
    } else {
        // Linux / Mac
        $output = [];
        exec('uptime -p', $output);
        if (!empty($output[0])) {
            $uptime = trim($output[0]);
        } else {
            // fallback: /proc/uptime (Linux only)
            if (file_exists('/proc/uptime')) {
                $uptimeSeconds = (int) explode(' ', file_get_contents('/proc/uptime'))[0];
                $days    = floor($uptimeSeconds / 86400);
                $hours   = floor(($uptimeSeconds % 86400) / 3600);
                $minutes = floor(($uptimeSeconds % 3600) / 60);
                $uptime  = "{$days} days, {$hours} hours, {$minutes} minutes";
            }
        }
    }

    return $uptime;
}
}
