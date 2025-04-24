<?php

namespace App\Http\Controllers;

use App\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function index()
    {
        return view('hospitals.index', ['hospitals' => Hospital::all()]);
    }

    public function create()
    {
        return view('hospitals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
        ]);

        Hospital::create($request->all());
        return redirect()->route('hospitals.index')->with('success', 'Hospital added successfully.');
    }
}
