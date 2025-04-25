<?php

namespace App\Http\Controllers;

use App\Hospital;
use Illuminate\Http\Request;
use DataTables;

class HospitalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Hospital::select(['id', 'name', 'aname', 'location', 'phone', 'email', 'whatsapp', 'address', 'gmap', 'level', 'facebook', 'instagram','twitter','linkedin', 'logo-primary', 'logo-secondary']);
            // dd($data);
            return DataTables::of($data)->make(true);
        }

        return view('hospitals.index');  // yajra Datatable will call it from frontend , ['hospitals' => Hospital::all()] 
    }

    public function create()
    {
        return view('hospitals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email',
            'logo-primary' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'logo-secondary' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // $data = $request->only(['name', 'email', 'location', 'level']);
        $data = $request->all();


        if ($request->hasFile('logo-primary')) {
            $data['logo-primary'] = $request->file('logo-primary')->store('logo-primary', 'public');
        }

        if ($request->hasFile('logo-secondary')) {
            $data['logo-secondary'] = $request->file('logo-secondary')->store('logo-secondary', 'public');
        }

        Hospital::create($data);

        return redirect()->route('hospitals.index')->with('success', 'Hospital added successfully.');
    }

    public function destroy($id)
    {
        $employee = Hospital::findOrFail($id);
        $employee->delete();

        return response()->json(['success' => 'Employee deleted successfully']);
    }


}
