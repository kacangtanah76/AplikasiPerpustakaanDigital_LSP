<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        // Get loan statistics for users
        $activeLoanCount = 0;
        $returnedLoanCount = 0;
        $lostLoanCount = 0;

        if ($user->role === 'user') {
            $activeLoanCount = PeminjamanBuku::where('user_id', $user->id)
                ->where('status', 'dipinjam')
                ->count();
            
            $returnedLoanCount = PeminjamanBuku::where('user_id', $user->id)
                ->where('status', 'dikembalikan')
                ->count();
            
            $lostLoanCount = PeminjamanBuku::where('user_id', $user->id)
                ->where('status', 'hilang')
                ->count();
        }

        return view('dashboard', compact(
            'activeLoanCount',
            'returnedLoanCount',
            'lostLoanCount'
        ));
    }
}
