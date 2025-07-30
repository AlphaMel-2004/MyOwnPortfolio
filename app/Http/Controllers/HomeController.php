<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function portfolio()
    {
        // Static data for now – can later pull from a DB
        $projects = [
            [
                'title' => 'NetGuardian App',
                'description' => 'A mobile-first emergency reporting system for barangays with a radar map and real-time alerts.',
                'image' => 'netguardian.png',
                'tags' => ['Mobile', 'Laravel', 'Tailwind']
            ],
            [
                'title' => 'Grading System UI',
                'description' => 'Frontend for an automated grading system with role-based dashboards and dynamic subject mapping.',
                'image' => 'grading.png',
                'tags' => ['Bootstrap', 'Laravel', 'Alpine']
            ],
            [
                'title' => 'Portfolio Site',
                'description' => 'This very portfolio – built with Laravel, Bootstrap, Alpine.js and dark UI principles.',
                'image' => 'portfolio.png',
                'tags' => ['UI/UX', 'Laravel', 'Bootstrap']
            ],
        ];

        return view('portfolio', compact('projects'));
    }
}
?>