<?php

namespace App\Http\Controllers;
use App\Models\Location;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only apply auth middleware to routes that need authentication
        // Remove or comment this line to make the index method accessible without auth
        // $this->middleware('auth');
        
        // If you want to keep some routes protected, specify them explicitly:
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch active locations for the search form
        $locations = Location::where('status', 'active')->get();
        return view('home', compact('locations'));
    }
}