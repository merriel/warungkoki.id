<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoyaltyController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $userid = $user->id;

        
        return view('content.loyalty.index', compact('userid'));

    }
}
