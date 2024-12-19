<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tool;
use App\Models\ToolPart;
use App\Models\Submission;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalTools = Tool::count();
        $totalParts = ToolPart::count();
        $totalSubmissions = Submission::count();

        return view('admin.dashboard', compact('totalTools', 'totalParts', 'totalSubmissions'));
    }
    // Show login form
    public function login()
    {
        return view('admin.login');
    }
    

    // Handle login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            // Check if the user is an admin
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();
            return redirect()->route('admin.login')->withErrors(['email' => 'Access denied.']);
        }

        return redirect()->route('admin.login')->withErrors(['email' => 'Invalid credentials.']);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}

