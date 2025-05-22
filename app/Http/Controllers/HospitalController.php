<?php

namespace App\Http\Controllers;

use App\Hospital;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;



class HospitalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Hospital::select(['id', 'name', 'aname', 'location', 'phone', 'phone2', 'email', 'whatsapp', 'address', 'gmap', 'level', 'facebook', 'instagram','twitter','linkedin', 'intro_heading', 'intro', 'logo_primary', 'logo_secondary', 'about_bg']);
            return DataTables::of($data)->make(true);
        }

        return view('hospitals.index');  // yajra Datatable will call it from frontend , ['hospitals' => Hospital::all()] 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email',
            'intro_heading' =>'required|string|max:255',
            'intro' =>'required|string',
            'address' => 'required|string',
            'logo_primary' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'logo_secondary' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'about_bg' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->all();


        if ($request->hasFile('logo_primary')) {
            $data['logo_primary'] = $request->file('logo_primary')->store('logo_primary', 'public');
        }

        if ($request->hasFile('logo_secondary')) {
            $data['logo_secondary'] = $request->file('logo_secondary')->store('logo_secondary', 'public');
        }

        if ($request->hasFile('about_bg')) {
            $data['about_bg'] = $request->file('about_bg')->store('about_bg', 'public');
        }

        Hospital::create($data);

        return redirect()->route('hospitals.index')->with('success', 'Hospital added successfully.');
    }


    public function edit($id)
    {
        $hospital = Hospital::findOrFail($id);
        return view('hospitals.edit', compact('hospital'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'address' => 'required|string',
            'level' => 'required',
            'intro_heading' =>'required|string|max:255',
            'intro' =>'required|string',
            'address' => 'required|string',
            'logo-primary' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'logo-secondary' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'about_bg' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $hospital = Hospital::findOrFail($id);

        $hospital->name = $request->name;
        $hospital->aname = $request->aname;
        $hospital->location = $request->location;
        $hospital->phone = $request->phone;
        $hospital->phone2 = $request->phone2;
        $hospital->email = $request->email;
        $hospital->whatsapp = $request->whatsapp;
        $hospital->address = $request->address;
        $hospital->gmap = $request->gmap;
        $hospital->level = $request->level;
        $hospital->facebook = $request->facebook;
        $hospital->instagram = $request->instagram;
        $hospital->twitter = $request->twitter;
        $hospital->linkedin = $request->linkedin;
        $hospital->intro_heading = $request->intro_heading;
        $hospital->intro = $request->intro;

        if ($request->hasFile('logo-primary')) {
            // Delete old file if exists
            if ($hospital->logo_primary && Storage::exists($hospital->logo_primary)) {
                Storage::delete($hospital->logo_primary);
            }
            $hospital->logo_primary = $request->file('logo-primary')->store('hospitals');
        }

        if ($request->hasFile('logo-secondary')) {
            if ($hospital->logo_secondary && Storage::exists($hospital->logo_secondary)) {
                Storage::delete($hospital->logo_secondary);
            }
            $hospital->logo_secondary = $request->file('logo-secondary')->store('hospitals');
        }

        if ($request->hasFile('about_bg')) {
            if ($hospital->about_bg && Storage::exists($hospital->about_bg)) {
                Storage::delete($hospital->about_bg);
            }
            $hospital->about_bg = $request->file('about_bg')->store('about_bg', 'public');
        }

        $hospital->save();

        return redirect()->route('hospitals.index')->with('success', 'Hospital updated successfully.');
    }


    public function destroy($id)
    {
        $employee = Hospital::findOrFail($id);
        $employee->delete();

        return response()->json(['success' => 'Employee deleted successfully']);
    }


}
