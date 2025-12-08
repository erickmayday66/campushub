<?php

namespace App\Http\Controllers;
use App\Models\Election;
use App\Models\Candidate;

use Illuminate\Http\Request;

class AdminResultController extends Controller
{
    public function index()
    {
        $elections = Election::latest()->get();
        return view('admin.results.index', compact('elections'));
    }

    public function show(Election $election)
    {
        $candidates = $election->candidates()->withCount('votes')->get();

        return view('admin.results.show', compact('election', 'candidates'));
    }
}
